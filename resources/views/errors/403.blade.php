@extends('layouts.app')

@section('title', 'Không có quyền truy cập')

@section('content')
<section class="py-5">
  <div class="container text-center py-5">
    <p class="display-1 fw-light mb-0" style="font-family: var(--heading-font);">403</p>
    <h1 class="section-title mb-3">Bạn không có quyền truy cập</h1>
    <p class="mb-4">Trang này chỉ dành cho quản trị viên. Nếu bạn cần quản lý cửa hàng, hãy đăng nhập bằng tài khoản Admin.</p>
    <a href="{{ route('home') }}" class="btn btn-dark text-uppercase">Về trang chủ</a>
  </div>
</section>
@endsection
