<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
 
class ProductController extends Controller
{
    // Thư mục chứa ảnh do Admin upload (nằm trong public/ nên asset() hiển thị được ngay)
    private const UPLOAD_DIR = 'images/products/uploads';
 
    // Danh sách + tìm kiếm (tên) + lọc danh mục + phân trang
    public function index(Request $request)
    {
        $request->validate([
            'q'           => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer'],
        ]);
 
        $keyword    = trim((string) $request->input('q', ''));
        $categoryId = $request->filled('category_id') ? (int) $request->input('category_id') : null;
 
        $products = Product::with('category')
            ->when($keyword !== '', fn ($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest('id')
            ->paginate(6)
            ->withQueryString();
 
        return view('admin.products.index', [
            'products'   => $products,
            'categories' => Category::orderBy('name')->get(),
            'keyword'    => $keyword,
            'categoryId' => $categoryId,
        ]);
    }
 
    public function create()
    {
        return view('admin.products.create', [
            'product'    => new Product(['stock' => 0]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
 
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());
 
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['image'] = $request->hasFile('image') ? $this->saveImage($request->file('image')) : null;
        unset($data['remove_image']);
 
        Product::create($data);
 
        return redirect()->route('admin.products.index')
            ->with('success', 'Đã thêm sản phẩm mới.');
    }
 
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
 
    public function update(Request $request, Product $product)
    {
        $data = $request->validate($this->rules(), $this->messages());
 
        // Chỉ đổi slug khi đổi tên
        if ($product->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        }
 
        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $data['image'] = $this->saveImage($request->file('image'));
        } elseif ($request->boolean('remove_image')) {
            $this->deleteImage($product->image);
            $data['image'] = null;
        }
        unset($data['remove_image']);
 
        $product->update($data);
 
        return redirect()->route('admin.products.index')
            ->with('success', 'Đã cập nhật sản phẩm.');
    }
 
    public function destroy(Product $product)
    {
        // Không xóa sản phẩm đã nằm trong đơn hàng để giữ lịch sử đơn
        if (OrderItem::where('product_id', $product->id)->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', "Không thể xóa \"{$product->name}\" vì đã có trong đơn hàng.");
        }
 
        $this->deleteImage($product->image);
        $product->delete();
 
        return redirect()->route('admin.products.index')
            ->with('success', 'Đã xóa sản phẩm.');
    }
 
    private function rules(): array
    {
        return [
            'category_id'  => ['required', 'exists:categories,id'],
            'name'         => ['required', 'string', 'max:150'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'price'        => ['required', 'integer', 'min:0', 'max:999999999'],
            'stock'        => ['required', 'integer', 'min:0', 'max:100000'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }
 
    private function messages(): array
    {
        return [
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists'   => 'Danh mục không hợp lệ.',
            'name.required'        => 'Vui lòng nhập tên sản phẩm.',
            'name.max'             => 'Tên sản phẩm tối đa 150 ký tự.',
            'description.max'      => 'Mô tả tối đa 2000 ký tự.',
            'price.required'       => 'Vui lòng nhập giá.',
            'price.integer'        => 'Giá phải là số nguyên (đồng).',
            'price.min'            => 'Giá không được âm.',
            'price.max'            => 'Giá quá lớn.',
            'stock.required'       => 'Vui lòng nhập số lượng tồn.',
            'stock.integer'        => 'Số lượng tồn phải là số nguyên.',
            'stock.min'            => 'Số lượng tồn không được âm.',
            'stock.max'            => 'Số lượng tồn quá lớn.',
            'image.image'          => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes'          => 'Ảnh chỉ nhận định dạng jpg, jpeg, png hoặc webp.',
            'image.max'            => 'Ảnh tối đa 2 MB.',
            'image.uploaded'       => 'Tải ảnh thất bại (có thể ảnh vượt quá giới hạn của máy chủ, hãy thử ảnh dưới 2 MB).',
        ];
    }
 
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'san-pham';
        $slug = $base;
        $i = 2;
 
        while (Product::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }
 
        return $slug;
    }
 
    // Lưu ảnh vào public/images/products/uploads, trả về đường dẫn tương đối để asset() dùng
    private function saveImage($file): string
    {
        $filename = time() . '-' . Str::random(8) . '.' . $file->extension();
        $file->move(public_path(self::UPLOAD_DIR), $filename);
 
        return self::UPLOAD_DIR . '/' . $filename;
    }
 
    // Chỉ xóa ảnh do Admin upload; ảnh mẫu của seeder (images/products/xxx.jpg) được giữ lại
    private function deleteImage(?string $path): void
    {
        if ($path && str_starts_with($path, self::UPLOAD_DIR . '/')) {
            $full = public_path($path);
            if (is_file($full)) {
                @unlink($full);
            }
        }
    }
}
 