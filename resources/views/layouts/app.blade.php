
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

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
        crossorigin="anonymous"
    >

    <!-- CSS giao diện Kaira -->
    <link rel="stylesheet" href="{{ asset('kaira/css/vendor.css') }}">

    <!-- Swiper CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    >

    <!-- CSS chính -->
    <link rel="stylesheet" href="{{ asset('kaira/style.css') }}">

    <!-- CSS tùy chỉnh -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    <!-- Thiết lập font chữ chung -->
    <style>
        :root {
            --heading-font: "Playfair Display", "Times New Roman", serif;
            --body-font: "Be Vietnam Pro", Arial, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--body-font);
            overflow-x: hidden;
        }

        p,
        a,
        button,
        input,
        textarea,
        select,
        li,
        span {
            font-family: var(--body-font);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .display-1,
        .display-2,
        .display-3,
        .display-4,
        .display-5,
        .display-6 {
            font-family: var(--heading-font);
        }

        img {
            max-width: 100%;
        }

        /* Không ép tất cả hình ảnh trên website cùng chiều cao */
        .row.align-items-center {
            align-items: center;
        }

        .row > [class*="col"] > img {
            max-width: 100%;
            height: auto;
        }

        /* Footer */
        footer h5,
        footer h6,
        footer .widget-title {
            font-family: var(--body-font);
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: normal;
        }

        footer img {
            max-width: 100%;
            max-height: 24px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        footer .shipping,
        footer .payment,
        footer [class*="ship"],
        footer [class*="pay"] {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-right: 32px;
        }

        /* Đảm bảo website không bị tràn ngang */
        .container {
            max-width: 1320px;
        }

        /* Ảnh không bị biến dạng */
        .product-image {
            max-width: 100%;
        }

        /* Responsive */
        @media (max-width: 767.98px) {
            .container {
                max-width: 100%;
            }

            footer .shipping,
            footer .payment,
            footer [class*="ship"],
            footer [class*="pay"] {
                margin-right: 12px;
            }
        }
    </style>

    @stack('styles')

</head>

<body class="@yield('body_class', 'homepage')">

    <!-- SVG Sprite -->
    @include('partials.svg-sprite')

    <!-- Header -->
    @include('partials.header')

    <!-- Thông báo -->
    @include('partials.flash')

    <!-- Nội dung từng trang -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Thông báo thêm giỏ hàng -->
    <div
        class="toast-container position-fixed top-0 end-0 p-3"
        style="z-index: 1100;"
    >
        <div
            id="cart-toast"
            class="toast align-items-center text-bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            <div class="d-flex">

                <div
                    class="toast-body"
                    id="cart-toast-body"
                ></div>

                <button
                    type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                    aria-label="Đóng"
                ></button>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('kaira/js/jquery.min.js') }}"></script>

    <!-- Plugin -->
    <script src="{{ asset('kaira/js/plugins.js') }}"></script>

    <!-- Smooth Scroll -->
    <script src="{{ asset('kaira/js/SmoothScroll.js') }}"></script>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"
    ></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- JS giao diện Kaira -->
    <script src="{{ asset('kaira/js/script.min.js') }}"></script>

    <!-- JS giỏ hàng AJAX -->
    <script src="{{ asset('js/cart-ajax.js') }}"></script>

    @stack('scripts')

</body>
</html>
