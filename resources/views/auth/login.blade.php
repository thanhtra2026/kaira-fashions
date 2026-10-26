@extends('layouts.app')

@section('title', 'Đăng nhập - Kaira Fashion')

@section('content')
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <h1 class="section-title text-center mt-4 mb-4">Đăng nhập</h1>

        <form action="{{ route('login') }}" method="post" novalidate>
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" id="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
          </div>

          <button type="submit" class="btn btn-dark text-uppercase w-100">Đăng nhập</button>
        </form>

        <p class="text-center mt-4">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
      </div>
    </div>
  </div>
</section>
@endsection
