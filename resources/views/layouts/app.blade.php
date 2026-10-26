<!DOCTYPE html>
<html lang="vi">

<head>
  <title>@yield('title', 'Kaira Fashion - Thời trang nam, nữ, trẻ em')</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="format-detection" content="telephone=no">
  <meta name="author" content="Kaira Fashion">
  <meta name="keywords" content="thời trang, quần áo, cửa hàng">
  <meta name="description" content="Kaira Fashion - website bán quần áo thời trang">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="{{ asset('kaira/css/vendor.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
  <link rel="stylesheet" type="text/css" href="{{ asset('kaira/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;700&family=Playfair+Display:wght@400;500;600&display=swap"
    rel="stylesheet">
  {{-- Kaira dùng font Marcellus/Jost chưa đủ dấu tiếng Việt -> đổi sang font có đủ dấu --}}
  <style>
    :root {
      --heading-font: "Playfair Display", "Times New Roman", serif;
      --bs-body-font-family: "Be Vietnam Pro", Arial, sans-serif;
    }
    body { font-family: var(--bs-body-font-family); }
  </style>
  @stack('styles')
  <style>
  :root {
    --heading-font: 'Playfair Display', serif;
    --body-font: 'Be Vietnam Pro', sans-serif;
  }
  body, p, a, button, input, textarea, select, li, span {
    font-family: 'Be Vietnam Pro', sans-serif !important;
  }
  h1, h2, h3, h4, h5, h6,
  .display-1, .display-2, .display-3, .display-4, .display-5, .display-6 {
    font-family: 'Playfair Display', serif !important;
  }
  /* Hai cột ngang chiều cao, ảnh phủ kín cột */
  .row.align-items-center { align-items: stretch !important; }
  .row > [class*="col"] > img,
  .image-holder img { width: 100%; height: 100%; object-fit: cover; }
  footer h5, footer h6, footer .widget-title { white-space: nowrap; }
  footer img { max-height: 24px; width: auto; height: auto; object-fit: contain; }
  footer .shipping, footer .payment,
  footer [class*="ship"], footer [class*="pay"] {
    display: inline-flex; align-items: center; gap: 12px; margin-right: 32px;
  }
 footer h5, footer h6, footer .widget-title {
  font-family: 'Be Vietnam Pro', sans-serif !important;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}
</style>
</head>

<body class="@yield('body_class', 'homepage')">
  @include('partials.svg-sprite')

  @include('partials.header')

  @include('partials.flash')

  @yield('content')

  @include('partials.footer')

  {{-- Thông báo nhỏ (toast) dùng cho thêm giỏ hàng bằng AJAX --}}
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1100">
    <div id="cart-toast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="cart-toast-body"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Đóng"></button>
      </div>
    </div>
  </div>

  <script src="{{ asset('kaira/js/jquery.min.js') }}"></script>
  <script src="{{ asset('kaira/js/plugins.js') }}"></script>
  <script src="{{ asset('kaira/js/SmoothScroll.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="{{ asset('kaira/js/script.min.js') }}"></script>
  <script src="{{ asset('js/cart-ajax.js') }}"></script>
  @stack('scripts')
</body>

</html>
