<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    // Danh sách + tìm kiếm theo tên + phân trang
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('q', ''));

        $categories = Category::withCount('products')
            ->when($keyword !== '', fn ($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'keyword'));
    }

    public function create()
    {
        return view('admin.categories.create', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        Category::create([
            'name' => $data['name'],
            'slug' => $this->uniqueSlug($data['name']),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Đã thêm danh mục mới.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate($this->rules($category->id), $this->messages());

        // Chỉ đổi slug khi đổi tên, để không làm hỏng đường dẫn cũ nếu tên giữ nguyên
        $slug = $category->name === $data['name']
            ? $category->slug
            : $this->uniqueSlug($data['name'], $category->id);

        $category->update(['name' => $data['name'], 'slug' => $slug]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Đã cập nhật danh mục.');
    }

    public function destroy(Category $category)
    {
        // Bảng products xóa theo danh mục (cascade) nên chặn xóa khi còn sản phẩm
        if ($category->products()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', "Không thể xóa danh mục \"{$category->name}\" vì còn sản phẩm. Hãy chuyển hoặc xóa sản phẩm trước.");
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Đã xóa danh mục.');
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($ignoreId)],
        ];
    }

    private function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.max'      => 'Tên danh mục tối đa 100 ký tự.',
            'name.unique'   => 'Tên danh mục này đã tồn tại.',
        ];
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'danh-muc';
        $slug = $base;
        $i = 2;

        while (Category::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
