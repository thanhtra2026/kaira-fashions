@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('content')
<section>
  <div class="admin-content">
    <h1 class="admin-title">Quản lý sản phẩm</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
      </div>
    @endif

    <div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
      <form action="{{ route('admin.products.index') }}" method="get" class="d-flex flex-wrap gap-2">
        <input type="text" name="q" value="{{ $keyword }}" class="form-control w-auto" placeholder="Tìm theo tên sản phẩm...">
        <select name="category_id" class="form-select w-auto">
          <option value="">Tất cả danh mục</option>
          @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected($categoryId === $cat->id)>{{ $cat->name }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-dark text-uppercase">Lọc</button>
        @if ($keyword !== '' || $categoryId)
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark text-uppercase">Xóa</a>
        @endif
      </form>
      <a href="{{ route('admin.products.create') }}" class="btn btn-dark text-uppercase">+ Thêm sản phẩm</a>
    </div>

    <p class="text-muted">Tìm thấy {{ $products->total() }} sản phẩm</p>

    <div class="table-responsive">
      <table class="table table-bordered align-middle bg-white">
        <thead class="table-light">
          <tr>
            <th style="width:60px">#</th>
            <th style="width:90px">Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th class="text-end">Giá</th>
            <th class="text-center">Tồn kho</th>
            <th style="width:170px" class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>
                @if ($product->image)
                  <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                       style="width:64px;height:80px;object-fit:cover;">
                @else
                  <span class="text-muted small">Chưa có</span>
                @endif
              </td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->category->name ?? '—' }}</td>
              <td class="text-end">{{ number_format($product->price, 0, ',', '.') }}₫</td>
              <td class="text-center">{{ $product->stock }}</td>
              <td class="text-center">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-dark">Sửa</a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="post" class="d-inline"
                      onsubmit="return confirm('Xóa sản phẩm &quot;{{ $product->name }}&quot;?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted">Không có sản phẩm nào.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center">{{ $products->links() }}</div>
  </div>
</section>
@endsection
