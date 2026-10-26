<ul class="nav nav-pills justify-content-center gap-2 mb-4">
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-dark' : 'text-dark border' }}"
       href="{{ route('admin.dashboard') }}">Tổng quan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active bg-dark' : 'text-dark border' }}"
       href="{{ route('admin.categories.index') }}">Danh mục</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active bg-dark' : 'text-dark border' }}"
       href="{{ route('admin.products.index') }}">Sản phẩm</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active bg-dark' : 'text-dark border' }}"
       href="{{ route('admin.orders.index') }}">Đơn hàng</a>
  </li>
</ul>
