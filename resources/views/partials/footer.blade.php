<footer class="site-footer mt-5">
  <div class="container">
    <div class="row g-4 py-5">

      {{-- Giới thiệu + liên hệ --}}
      <div class="col-lg-4">
        <a href="{{ route('home') }}" class="footer-brand">Kaira Fashion</a>
        <p class="mt-3 mb-4">Thời trang nam, nữ và trẻ em: chất liệu thoải mái, kiểu dáng hiện đại, giá hợp lý cho mọi phong cách.</p>
        {{-- Thông tin mẫu: nhóm thay bằng thông tin thật --}}
        <ul class="list-unstyled footer-contact mb-0">
          <li><span>Email</span> <a href="mailto:support@kairafashion.test">support@kairafashion.test</a></li>
          <li><span>Điện thoại</span> <a href="tel:0900000000">0900 000 000</a></li>
        </ul>
      </div>

      {{-- Mua sắm --}}
      <div class="col-6 col-lg-2 offset-lg-1">
        <h6 class="footer-title">Mua sắm</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="{{ route('products.index') }}">Tất cả sản phẩm</a></li>
          <li><a href="{{ route('categories.show', 'nam') }}">Thời trang nam</a></li>
          <li><a href="{{ route('categories.show', 'nu') }}">Thời trang nữ</a></li>
          <li><a href="{{ route('categories.show', 'tre-em') }}">Thời trang trẻ em</a></li>
        </ul>
      </div>

      {{-- Tài khoản --}}
      <div class="col-6 col-lg-2">
        <h6 class="footer-title">Tài khoản</h6>
        <ul class="list-unstyled footer-links">
          @auth
            @if (auth()->user()->is_admin)
              <li><a href="{{ route('admin.dashboard') }}">Quản trị</a></li>
            @else
              <li><a href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
            @endif
          @else
            <li><a href="{{ route('login') }}">Đăng nhập</a></li>
            <li><a href="{{ route('register') }}">Đăng ký</a></li>
          @endauth
          <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
        </ul>
      </div>

      {{-- Chính sách mua hàng (đúng với chức năng website hiện có) --}}
      <div class="col-lg-3">
        <h6 class="footer-title">Mua hàng</h6>
        <ul class="list-unstyled footer-links footer-info">
          <li>Thanh toán khi nhận hàng (COD)</li>
          <li>Giao hàng toàn quốc</li>
          <li>Hủy đơn khi đang chờ xác nhận</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
      <span>© {{ date('Y') }} Kaira Fashion. Đồ án môn Lập trình mã nguồn mở.</span>
      {{-- GIỮ NGUYÊN link ghi công template theo giấy phép của TemplatesJungle --}}
      <span>Giao diện: <a href="https://templatesjungle.com" target="_blank" rel="noopener">TemplatesJungle</a>
        - Phân phối bởi <a href="https://themewagon.com" target="_blank" rel="noopener">ThemeWagon</a></span>
    </div>
  </div>
</footer>
