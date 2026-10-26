@extends('layouts.app')

@section('title', 'Không tìm thấy trang')

@section('content')
<section class="py-5">
  <div class="container text-center py-5">
    <p class="display-1 fw-light mb-0" style="font-family: var(--heading-font);">404</p>
    <h1 class="section-title mb-3">Không tìm thấy trang</h1>
    <p class="mb-4">Đường dẫn không tồn tại hoặc sản phẩm đã bị gỡ.</p>
    <a href="{{ route('products.index') }}" class="btn btn-dark text-uppercase">Xem sản phẩm</a>
  </div>
</section>
@endsection
