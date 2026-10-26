@extends('layouts.app')

@section('title', $product->name . ' - Kaira Fashion')

@section('content')
<section class="py-5">
  <div class="container">
    <nav class="mb-4 small">
      <a href="{{ route('home') }}">Trang chủ</a> /
      <a href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a> /
      {{ $product->name }}
    </nav>

    <div class="row align-items-center">
      <div class="col-md-6">
        <img src="{{ $product->image ? asset($product->image) : asset('kaira/images/product-item-1.jpg') }}"
             alt="{{ $product->name }}" class="img-fluid">
      </div>
      <div class="col-md-6 p-5">
        <h2 class="text-uppercase">{{ $product->name }}</h2>
        <h4 class="my-3">{{ number_format($product->price, 0, ',', '.') }}₫</h4>
        <p>{{ $product->description }}</p>
        <p class="text-muted">Còn lại: {{ $product->stock }} sản phẩm</p>
        @if ($product->stock > 0)
          <form action="{{ route('cart.add', $product) }}" method="post" data-ajax-cart class="d-flex gap-2 align-items-center">
            @csrf
            <input type="number" name="quantity" value="1" min="1" max="{{ min($product->stock, 99) }}"
                   class="form-control" style="width:90px" aria-label="Số lượng">
            <button type="submit" class="btn btn-dark text-uppercase">Thêm vào giỏ</button>
          </form>
          @error('quantity')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        @else
          <button class="btn btn-secondary text-uppercase" disabled>Hết hàng</button>
        @endif
      </div>
    </div>

    @if ($related->isNotEmpty())
      <h4 class="text-uppercase mt-5 mb-3">Sản phẩm cùng danh mục</h4>
      <div class="row">
        @foreach ($related as $item)
          <div class="col-md-4">
            <h5 class="text-uppercase fs-5"><a href="{{ route('products.show', $item->slug) }}">{{ $item->name }}</a></h5>
            <span>{{ number_format($item->price, 0, ',', '.') }}₫</span>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
