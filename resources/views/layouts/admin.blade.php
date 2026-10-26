<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Quản trị') - Kaira Fashion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  @stack('styles')
</head>
<body class="admin-body">

  {{-- Thanh trên cùng (chỉ hiện trên điện thoại/tablet) --}}
  <header class="admin-topbar d-lg-none">
    <button type="button" class="btn btn-outline-light btn-sm" id="adminMenuBtn" aria-label="Mở menu quản trị">
      <i class="bi bi-list fs-5"></i>
    </button>
    <span class="fw-semibold">Quản trị Kaira Fashion</span>
  </header>

  <div class="admin-backdrop" id="adminBackdrop"></div>

  {{-- Menu bên trái --}}
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-brand">
      <div class="admin-brand-name">KAIRA FASHION</div>
      <div class="admin-brand-sub">QUẢN TRỊ VIÊN</div>
    </div>

    <nav class="admin-menu">
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door"></i> Tổng quan
      </a>
      <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i> Đơn hàng
      </a>
      <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.index', 'admin.products.edit') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Sản phẩm
      </a>
      <a href="{{ route('admin.products.create') }}" class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
      </a>
      <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <i class="bi bi-tags"></i> Danh mục
      </a>
    </nav>

    <div class="admin-sidebar-footer">
      <div class="small mb-2"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</div>
      <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light w-100 mb-2">
        <i class="bi bi-shop"></i> Xem cửa hàng
      </a>
      <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-sm btn-light w-100"><i class="bi bi-box-arrow-right"></i> Đăng xuất</button>
      </form>
    </div>
  </aside>

  {{-- Nội dung --}}
  <div class="admin-main">
    <main class="admin-page">
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script>
    // Mở/đóng menu bên trái trên điện thoại
    (function () {
      var sidebar = document.getElementById('adminSidebar');
      var backdrop = document.getElementById('adminBackdrop');
      var btn = document.getElementById('adminMenuBtn');
      function toggle(open) {
        sidebar.classList.toggle('open', open);
        backdrop.classList.toggle('show', open);
      }
      if (btn) btn.addEventListener('click', function () { toggle(!sidebar.classList.contains('open')); });
      backdrop.addEventListener('click', function () { toggle(false); });
    })();
  </script>
  @stack('scripts')
</body>
</html>
