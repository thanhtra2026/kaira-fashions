{{-- Thanh thông báo nhỏ phía trên (kiểu các trang thời trang như Uniqlo, Canifa, Coolmate) --}}
<div class="top-bar text-center">
  Thanh toán khi nhận hàng (COD) &nbsp;·&nbsp; Giao hàng toàn quốc &nbsp;·&nbsp; Hủy đơn dễ dàng khi đơn đang chờ xác nhận
</div>

{{-- Header: logo bên trái, menu chính ở giữa, tài khoản và giỏ hàng bên phải (từ 1200px trở lên).
     Màn hình nhỏ hơn: gọn thành nút menu, số giỏ hàng luôn hiện ngoài thanh. --}}
<nav class="navbar navbar-expand-xl site-header text-uppercase">
  <div class="container-fluid px-3 px-xl-4">

    <a class="navbar-brand site-logo" href="{{ route('home') }}">Kaira Fashion</a>

    @php $cartCount = \App\Support\Cart::count(); @endphp

    <a href="{{ route('cart.index') }}" class="d-xl-none ms-auto me-3 text-dark text-decoration-none small">
      Giỏ
      <span class="badge bg-dark rounded-pill js-cart-count {{ $cartCount > 0 ? '' : 'd-none' }}">{{ $cartCount }}</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Mở menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Đóng"></button>
      </div>

      <div class="offcanvas-body align-items-xl-center">

        <ul class="navbar-nav mx-xl-auto gap-1 gap-xl-4">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Sản phẩm</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('danh-muc/nam') ? 'active' : '' }}" href="{{ route('categories.show', 'nam') }}">Nam</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('danh-muc/nu') ? 'active' : '' }}" href="{{ route('categories.show', 'nu') }}">Nữ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('danh-muc/tre-em') ? 'active' : '' }}" href="{{ route('categories.show', 'tre-em') }}">Trẻ em</a>
          </li>
        </ul>

        <ul class="navbar-nav nav-user ms-xl-auto align-items-xl-center gap-1 gap-xl-4">
          @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Đăng ký</a></li>
          @endguest
          @auth
            @if (auth()->user()->is_admin)
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Quản trị</a></li>
            @else
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Đơn hàng</a></li>
            @endif
            <li class="nav-item"><span class="navbar-text nav-greeting d-xl-none d-xxl-block">Xin chào, {{ auth()->user()->name }}</span></li>
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="post" class="d-inline">
                @csrf
                <button type="submit" class="nav-link p-0 border-0 bg-transparent text-uppercase">Đăng xuất</button>
              </form>
            </li>
          @endauth
          <li class="nav-item d-none d-xl-block">
            <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
              Giỏ hàng
              <span class="badge bg-dark rounded-pill js-cart-count {{ $cartCount > 0 ? '' : 'd-none' }}">{{ $cartCount }}</span>
            </a>
          </li>
        </ul>

      </div>
    </div>
  </div>
</nav>
