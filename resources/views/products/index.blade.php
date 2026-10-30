@extends('layouts.app')
 
@section('title', ($category->name ?? 'Tất cả sản phẩm') . ' - Kaira Fashion')
 
@section('content')
<section class="py-5">
  <div class="container">
    <h1 class="section-title text-center mt-4">{{ $category ? 'Thời trang ' . mb_strtolower($category->name) : 'Tất cả sản phẩm' }}</h1>
 
    {{-- Lọc theo danh mục --}}
    <div class="d-flex flex-wrap justify-content-center gap-2 my-4">
      <a href="{{ route('products.index') }}" class="btn {{ $category ? 'btn-outline-dark' : 'btn-dark' }} text-uppercase">Tất cả</a>
      @foreach ($categories as $cat)
        <a href="{{ route('categories.show', $cat->slug) }}"
           class="btn {{ $category && $category->id === $cat->id ? 'btn-dark' : 'btn-outline-dark' }} text-uppercase">{{ $cat->name }}</a>
      @endforeach
    </div>
 
    {{-- Tìm kiếm + lọc khoảng giá + sắp xếp --}}
    @php
      $formAction = $category ? route('categories.show', $category->slug) : route('products.index');
      $hasFilter  = $keyword !== '' || $min !== null || $max !== null || $sort !== 'newest';
    @endphp
 
    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif
 
    <form action="{{ $formAction }}" method="get" class="row g-2 align-items-end mb-4">
      <div class="col-md-4">
        <label for="q" class="form-label">Từ khóa</label>
        <input type="text" id="q" name="q" value="{{ $keyword }}" class="form-control" placeholder="Tên sản phẩm...">
      </div>
      <div class="col-6 col-md-2">
        <label for="min_price" class="form-label">Giá từ (₫)</label>
        <input type="number" id="min_price" name="min_price" value="{{ $min }}" min="0" step="1000" class="form-control">
      </div>
      <div class="col-6 col-md-2">
        <label for="max_price" class="form-label">Giá đến (₫)</label>
        <input type="number" id="max_price" name="max_price" value="{{ $max }}" min="0" step="1000" class="form-control">
      </div>
      <div class="col-md-2">
        <label for="sort" class="form-label">Sắp xếp</label>
        <select id="sort" name="sort" class="form-select">
          <option value="newest" @selected($sort === 'newest')>Mới nhất</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Giá tăng dần</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Giá giảm dần</option>
        </select>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-dark text-uppercase flex-fill">Lọc</button>
        @if ($hasFilter)
          <a href="{{ $formAction }}" class="btn btn-outline-dark text-uppercase">Xóa</a>
        @endif
      </div>
    </form>
 
    <p class="text-muted">Tìm thấy {{ $products->total() }} sản phẩm</p>
 
    <div class="row">
      @forelse ($products as $product)
        <div class="col-12 col-sm-6 col-lg-4 mb-5">
          <div class="product-item image-zoom-effect link-effect">
            <div class="image-holder">
              <a href="{{ route('products.show', $product->slug) }}">
                <img src="{{ $product->image ? asset($product->image) : asset('kaira/images/product-item-' . (($loop->index % 10) + 1) . '.jpg') }}"
                     alt="{{ $product->name }}" class="product-image img-fluid"
                     style="width:100%; aspect-ratio:3/4; object-fit:cover;">
              </a>
            </div>
            <div class="product-content">
              <h5 class="text-uppercase fs-5 mt-3">
                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
              </h5>
              <span>{{ number_format($product->price, 0, ',', '.') }}₫</span>
              @include('partials.add-to-cart', ['product' => $product])
            </div>
          </div>
        </div>
      @empty
        <p class="text-center">Không tìm thấy sản phẩm phù hợp.</p>
      @endforelse
    </div>
 
    <div class="d-flex justify-content-center">{{ $products->links() }}</div>
  </div>
</section>
@endsection