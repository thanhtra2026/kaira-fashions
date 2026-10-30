<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AddressLookupTest extends TestCase
{
    use RefreshDatabase;

    private const API = 'https://provinces.open-api.vn/api/v2';

    protected function beforeRefreshingDatabase(): void
    {
        // Always override the project's MySQL settings before RefreshDatabase runs.
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.url' => null,
            'cache.default' => 'array',
            'session.driver' => 'array',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        config(['cache.default' => 'array']);
        Cache::flush();
        Http::preventStrayRequests();
    }

    private function customer(): User
    {
        return User::factory()->create();
    }

    public function test_guests_cannot_use_address_endpoints(): void
    {
        $this->getJson('/dia-chi/tinh-thanh')->assertUnauthorized();
        Http::assertNothingSent();
    }

    public function test_province_response_is_filtered_and_cached(): void
    {
        Http::fake([self::API . '/p/' => Http::response([
            ['code' => 79, 'name' => 'Thành phố Hồ Chí Minh', 'phone_code' => 28],
        ])]);

        $this->actingAs($this->customer());
        for ($i = 0; $i < 2; $i++) {
            $this->getJson('/dia-chi/tinh-thanh')->assertOk()->assertExactJson([
                'data' => [['code' => 79, 'name' => 'Thành phố Hồ Chí Minh']],
            ]);
        }
        Http::assertSentCount(1);
    }

    public function test_wards_belong_to_requested_province(): void
    {
        Http::fake([self::API . '/p/79*' => Http::response([
            'code' => 79,
            'wards' => [['code' => 26734, 'name' => 'Phường Bến Thành', 'province_code' => 79]],
        ])]);

        $this->actingAs($this->customer())
            ->getJson('/dia-chi/tinh-thanh/79/phuong-xa')
            ->assertOk()->assertExactJson([
                'data' => [['code' => 26734, 'name' => 'Phường Bến Thành']],
            ]);

        Http::assertSent(fn ($request) => $request['depth'] === 2);
    }

    public function test_invalid_codes_do_not_reach_upstream(): void
    {
        $this->actingAs($this->customer());
        foreach (['0', '999', 'abc', '-1'] as $code) {
            $this->getJson("/dia-chi/tinh-thanh/{$code}/phuong-xa")->assertNotFound();
        }
        Http::assertNothingSent();
    }

    public function test_upstream_errors_are_not_cached_and_can_be_retried(): void
    {
        Http::fake([self::API . '/p/' => Http::sequence()
            ->pushStatus(503)
            ->push([['code' => 79, 'name' => 'Thành phố Hồ Chí Minh']])]);

        $this->actingAs($this->customer());
        $this->getJson('/dia-chi/tinh-thanh')->assertStatus(503)->assertHeader('Retry-After', '60');
        $this->getJson('/dia-chi/tinh-thanh')->assertOk();
        Http::assertSentCount(2);
    }

    public function test_connection_failure_returns_a_manual_entry_message(): void
    {
        Http::fake([self::API . '/p/' => Http::failedConnection()]);

        $this->actingAs($this->customer())->getJson('/dia-chi/tinh-thanh')
            ->assertStatus(503)->assertJsonPath('message',
                'Chưa tải được danh sách địa phương. Bạn vẫn có thể nhập địa chỉ đầy đủ bên dưới.');
    }

    public function test_malformed_json_and_duplicate_codes_are_rejected(): void
    {
        Http::fake([self::API . '/p/' => Http::sequence()
            ->push('<html>Unavailable</html>', 200, ['Content-Type' => 'text/html'])
            ->push([['code' => 79, 'name' => 'A'], ['code' => 79, 'name' => 'B']])]);

        $this->actingAs($this->customer());
        $this->getJson('/dia-chi/tinh-thanh')->assertStatus(503);
        $this->getJson('/dia-chi/tinh-thanh')->assertStatus(503);
    }

    public function test_wards_from_another_province_are_rejected(): void
    {
        Http::fake([self::API . '/p/79*' => Http::response([
            'code' => 79, 'wards' => [['code' => 1, 'name' => 'Sai tỉnh', 'province_code' => 1]],
        ])]);
        $this->actingAs($this->customer())
            ->getJson('/dia-chi/tinh-thanh/79/phuong-xa')->assertStatus(503);
    }

    public function test_unknown_province_returns_not_found(): void
    {
        Http::fake([self::API . '/p/99*' => Http::response([], 404)]);
        $this->actingAs($this->customer())
            ->getJson('/dia-chi/tinh-thanh/99/phuong-xa')->assertNotFound();
    }

    public function test_checkout_shows_picker_without_calling_upstream_on_page_load(): void
    {
        $category = Category::create(['name' => 'Áo', 'slug' => 'ao']);
        $product = Product::create([
            'category_id' => $category->id, 'name' => 'Áo mẫu', 'slug' => 'ao-mau',
            'price' => 150000, 'stock' => 5,
        ]);

        $this->actingAs($this->customer())->withSession(['cart' => [$product->id => 1]])
            ->get('/thanh-toan')->assertOk()
            ->assertSee('data-address-picker', false)
            ->assertSee('js/address-picker.js')
            ->assertSee('name="shipping_address"', false);
        Http::assertNothingSent();
    }

    public function test_customer_can_still_order_with_manual_address_when_api_is_down(): void
    {
        Http::fake([self::API . '/*' => Http::response([], 503)]);
        $user = $this->customer();
        $category = Category::create(['name' => 'Áo', 'slug' => 'ao']);
        $product = Product::create([
            'category_id' => $category->id, 'name' => 'Áo mẫu', 'slug' => 'ao-mau',
            'price' => 150000, 'stock' => 5,
        ]);

        $this->actingAs($user)->withSession(['cart' => [$product->id => 1]])
            ->post('/thanh-toan', [
                'shipping_name' => 'Khách thử', 'shipping_phone' => '0901234567',
                'shipping_address' => '12 Đường A, Phường B, Thành phố C',
            ])->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id, 'shipping_address' => '12 Đường A, Phường B, Thành phố C',
            'total' => 150000,
        ]);
        $this->assertSame(4, $product->fresh()->stock);
        Http::assertNothingSent();
    }
}
