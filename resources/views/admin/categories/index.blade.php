@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<section>
  <div class="admin-content">
    <h1 class="admin-title">Quản lý danh mục</h1>

    <div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
      <form action="{{ route('admin.categories.index') }}" method="get" class="d-flex gap-2">
        <input type="text" name="q" value="{{ $keyword }}" class="form-control" placeholder="Tìm theo tên danh mục...">
        <button type="submit" class="btn btn-dark text-uppercase">Tìm</button>
        @if ($keyword !== '')
          <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark text-uppercase">Xóa</a>
        @endif
      </form>
      <a href="{{ route('admin.categories.create') }}" class="btn btn-dark text-uppercase">+ Thêm danh mục</a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered align-middle bg-white">
        <thead class="table-light">
          <tr>
            <th style="width:70px">#</th>
            <th>Tên danh mục</th>
            <th>Đường dẫn (slug)</th>
            <th class="text-center">Số sản phẩm</th>
            <th style="width:170px" class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td>{{ $category->name }}</td>
              <td class="text-muted">{{ $category->slug }}</td>
              <td class="text-center">{{ $category->products_count }}</td>
              <td class="text-center">
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-dark">Sửa</a>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="post" class="d-inline"
                      onsubmit="return confirm('Xóa danh mục &quot;{{ $category->name }}&quot;?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted">Không có danh mục nào.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center">{{ $categories->links() }}</div>
  </div>
</section>
@endsection
