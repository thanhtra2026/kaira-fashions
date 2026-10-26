@extends('layouts.app')

@section('title', 'Đăng ký - Kaira Fashion')

@section('content')
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <h1 class="section-title text-center mt-4 mb-4">Đăng ký</h1>

        <form action="{{ route('register') }}" method="post" novalidate>
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label">Họ tên</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror" required autofocus>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu (tối thiểu 6 ký tự)</label>
            <input type="password" id="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-control" required>
          </div>

          <button type="submit" class="btn btn-dark text-uppercase w-100">Tạo tài khoản</button>
        </form>

        <p class="text-center mt-4">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
      </div>
    </div>
  </div>
</section>
@endsection
