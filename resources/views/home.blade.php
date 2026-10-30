@extends('layouts.app')
 
@section('title', 'Kaira Fashion - Trang chủ')
 
@section('content')
{{-- Trang chủ: banner và danh mục là nội dung tĩnh (đã nối link);
     "Hàng mới về" và "Sản phẩm bán chạy" lấy từ database qua HomeController.
     Nút "Thêm vào giỏ" (href="#") là chỗ giữ chỗ cho giỏ hàng (Trà). --}}
  <section id="billboard" class="bg-light py-5">
    <div class="container">
      <div class="row justify-content-center">
        <h1 class="section-title text-center mt-4" data-aos="fade-up">Bộ sưu tập mới</h1>
        <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
          <p>Khám phá những thiết kế mới nhất của mùa này: chất liệu mềm mại, form dáng hiện đại và dễ phối đồ cho mọi dịp.</p>
        </div>
      </div>
      <div class="row">
        <div class="swiper main-swiper py-4" data-aos="fade-up" data-aos-delay="600">
          <div class="swiper-wrapper d-flex border-animation-left">
            <div class="swiper-slide">
              <div class="banner-item image-zoom-effect">
                <div class="image-holder">
                  <a href="{{ route('products.index') }}">
                    <img src="{{ asset('kaira/images/banner-image-6.jpg') }}" alt="product" class="img-fluid">
                  </a>
                </div>
                <div class="banner-content py-4">
                  <h5 class="element-title text-uppercase">
                    <a href="{{ route('products.index') }}" class="item-anchor">Áo khoác thời trang</a>
                  </h5>
                  <p>Thiết kế mới, chất liệu thoải mái, phù hợp mặc hằng ngày.</p>
                  <div class="btn-left">
                    <a href="{{ route('products.index') }}" class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Xem ngay</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="banner-item image-zoom-effect">
                <div class="image-holder">
                  <a href="{{ route('products.index') }}">
                    <img src="{{ asset('kaira/images/banner-image-1.jpg') }}" alt="product" class="img-fluid">
                  </a>
                </div>
                <div class="banner-content py-4">
                  <h5 class="element-title text-uppercase">
                    <a href="{{ route('products.index') }}" class="item-anchor">Áo len mềm mại</a>
                  </h5>
                  <p>Thiết kế mới, chất liệu thoải mái, phù hợp mặc hằng ngày.</p>
                  <div class="btn-left">
                    <a href="{{ route('products.index') }}" class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Xem ngay</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="banner-item image-zoom-effect">
                <div class="image-holder">
                  <a href="{{ route('products.index') }}">
                    <img src="{{ asset('kaira/images/banner-image-2.jpg') }}" alt="product" class="img-fluid">
                  </a>
                </div>
                <div class="banner-content py-4">
                  <h5 class="element-title text-uppercase">
                    <a href="{{ route('products.index') }}" class="item-anchor">Áo sơ mi thanh lịch</a>
                  </h5>
                  <p>Thiết kế mới, chất liệu thoải mái, phù hợp mặc hằng ngày.</p>
                  <div class="btn-left">
                    <a href="{{ route('products.index') }}" class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Xem ngay</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="banner-item image-zoom-effect">
                <div class="image-holder">
                  <a href="{{ route('products.index') }}">
                    <img src="{{ asset('kaira/images/banner-image-3.jpg') }}" alt="product" class="img-fluid">
                  </a>
                </div>
                <div class="banner-content py-4">
                  <h5 class="element-title text-uppercase">
                    <a href="{{ route('products.index') }}" class="item-anchor">Đầm liền thân nữ tính</a>
                  </h5>
                  <p>Thiết kế mới, chất liệu thoải mái, phù hợp mặc hằng ngày.</p>
                  <div class="btn-left">
                    <a href="{{ route('products.index') }}" class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Xem ngay</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="banner-item image-zoom-effect">
                <div class="image-holder">
                  <a href="{{ route('products.index') }}">
                    <img src="{{ asset('kaira/images/banner-image-4.jpg') }}" alt="product" class="img-fluid">
                  </a>
                </div>
                <div class="banner-content py-4">
                  <h5 class="element-title text-uppercase">
                    <a href="{{ route('products.index') }}" class="item-anchor">Áo len dáng ngắn</a>
                  </h5>
                  <p>Thiết kế mới, chất liệu thoải mái, phù hợp mặc hằng ngày.</p>
                  <div class="btn-left">
                    <a href="{{ route('products.index') }}" class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Xem ngay</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="banner-item image-zoom-effect">
                <div class="image-holder">
                  <a href="{{ route('products.index') }}">
                    <img src="{{ asset('kaira/images/banner-image-5.jpg') }}" alt="product" class="img-fluid">
                  </a>
                </div>
                <div class="banner-content py-4">
                  <h5 class="element-title text-uppercase">
                    <a href="{{ route('products.index') }}" class="item-anchor">Set đồ năng động</a>
                  </h5>
                  <p>Thiết kế mới, chất liệu thoải mái, phù hợp mặc hằng ngày.</p>
                  <div class="btn-left">
                    <a href="{{ route('products.index') }}" class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Xem ngay</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
        <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
            <use xlink:href="#arrow-left"></use>
          </svg></div>
        <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
            <use xlink:href="#arrow-right"></use>
          </svg></div>
      </div>
    </div>
  </section>
 
  <section class="features py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="0">
          <div class="py-5">
            <svg width="38" height="38" viewBox="0 0 24 24">
              <use xlink:href="#calendar"></use>
            </svg>
            <h4 class="element-title text-capitalize my-3">Tư vấn tận tình</h4>
            <p>Hỗ trợ chọn size và phối đồ qua điện thoại hoặc email.</p>
          </div>
        </div>
        <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="300">
          <div class="py-5">
            <svg width="38" height="38" viewBox="0 0 24 24">
              <use xlink:href="#shopping-bag"></use>
            </svg>
            <h4 class="element-title text-capitalize my-3">Thanh toán khi nhận hàng</h4>
            <p>Kiểm tra sản phẩm rồi mới thanh toán (COD), an tâm khi mua.</p>
          </div>
        </div>
        <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="600">
          <div class="py-5">
            <svg width="38" height="38" viewBox="0 0 24 24">
              <use xlink:href="#gift"></use>
            </svg>
            <h4 class="element-title text-capitalize my-3">Đóng gói cẩn thận</h4>
            <p>Sản phẩm được gói gọn gàng, sẵn sàng làm quà tặng.</p>
          </div>
        </div>
        <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="900">
          <div class="py-5">
            <svg width="38" height="38" viewBox="0 0 24 24">
              <use xlink:href="#arrow-cycle"></use>
            </svg>
            <h4 class="element-title text-capitalize my-3">Hủy đơn dễ dàng</h4>
            <p>Tự hủy đơn trong mục Đơn hàng khi đơn đang chờ xác nhận.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
 
  <section class="categories overflow-hidden">
    <div class="container">
      <div class="open-up" data-aos="zoom-out">
        <div class="row">
          <div class="col-md-4">
            <div class="cat-item image-zoom-effect">
              <div class="image-holder">
                <a href="{{ route('categories.show', 'nam') }}">
                  <img src="{{ asset('kaira/images/cat-item1.jpg') }}" alt="Thời trang nam" class="product-image img-fluid">
                </a>
              </div>
              <div class="category-content">
                <div class="product-button">
                  <a href="{{ route('categories.show', 'nam') }}" class="btn btn-common text-uppercase">Thời trang nam</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="cat-item image-zoom-effect">
              <div class="image-holder">
                <a href="{{ route('categories.show', 'nu') }}">
                  <img src="{{ asset('kaira/images/cat-item2.jpg') }}" alt="Thời trang nữ" class="product-image img-fluid">
                </a>
              </div>
              <div class="category-content">
                <div class="product-button">
                  <a href="{{ route('categories.show', 'nu') }}" class="btn btn-common text-uppercase">Thời trang nữ</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="cat-item image-zoom-effect">
              <div class="image-holder">
                <a href="{{ route('categories.show', 'tre-em') }}">
                  <img src="{{ asset('images/products/vay-xoe-be-gai.jpg') }}" alt="Thời trang trẻ em" class="product-image img-fluid">
                </a>
              </div>
              <div class="category-content">
                <div class="product-button">
                  <a href="{{ route('categories.show', 'tre-em') }}" class="btn btn-common text-uppercase">Thời trang trẻ em</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
 
  {{-- HÀNG MỚI VỀ: lấy từ database ($newProducts) --}}
  <section id="new-arrival" class="new-arrival product-carousel py-5 position-relative overflow-hidden">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
        <h4 class="text-uppercase">Hàng mới về</h4>
        <a href="{{ route('products.index') }}" class="btn-link">Xem tất cả sản phẩm</a>
      </div>
      <div class="swiper product-swiper open-up" data-aos="zoom-out">
        <div class="swiper-wrapper d-flex">
          @foreach ($newProducts as $product)
            <div class="swiper-slide">
              <div class="product-item image-zoom-effect link-effect">
                <div class="image-holder position-relative">
                  <a href="{{ route('products.show', $product->slug) }}">
                    <img src="{{ $product->image ? asset($product->image) : asset('kaira/images/product-item-' . $loop->iteration . '.jpg') }}"
                         alt="{{ $product->name }}" class="product-image img-fluid"
                         style="width:100%; aspect-ratio:3/4; object-fit:cover;">
                  </a>
                </div>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                      <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h5>
                  <span>{{ number_format($product->price, 0, ',', '.') }}₫</span>
                  @include('partials.add-to-cart', ['product' => $product])
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="swiper-pagination"></div>
      </div>
      <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-left"></use>
        </svg></div>
      <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-right"></use>
        </svg></div>
    </div>
  </section>
 
  <section class="collection bg-light position-relative py-5">
    <div class="container">
      <div class="row">
        <div class="title-xlarge text-uppercase txt-fx domino">Bộ sưu tập</div>
        <div class="collection-item d-flex flex-wrap my-5">
          <div class="col-md-6 column-container">
            <div class="image-holder">
              <img src="{{ asset('kaira/images/single-image-2.jpg') }}" alt="collection" class="product-image img-fluid">
            </div>
          </div>
          <div class="col-md-6 column-container bg-white">
            <div class="collection-content p-5 m-0 m-md-5">
              <h3 class="element-title text-uppercase">Bộ sưu tập thu đông cổ điển</h3>
              <p>Những thiết kế ấm áp cho mùa lạnh: áo khoác, áo len và phụ kiện dễ phối, giữ form đẹp và thoải mái cả ngày.</p>
              <a href="{{ route('products.index') }}" class="btn btn-dark text-uppercase mt-3">Xem bộ sưu tập</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
 
  {{-- SẢN PHẨM BÁN CHẠY: lấy từ database ($bestSellers) --}}
  <section id="best-sellers" class="best-sellers product-carousel py-5 position-relative overflow-hidden">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
        <h4 class="text-uppercase">Sản phẩm bán chạy</h4>
        <a href="{{ route('products.index') }}" class="btn-link">Xem tất cả sản phẩm</a>
      </div>
      <div class="swiper product-swiper open-up" data-aos="zoom-out">
        <div class="swiper-wrapper d-flex">
          @foreach ($bestSellers as $product)
            <div class="swiper-slide">
              <div class="product-item image-zoom-effect link-effect">
                <div class="image-holder">
                  <a href="{{ route('products.show', $product->slug) }}">
                    <img src="{{ $product->image ? asset($product->image) : asset('kaira/images/product-item-' . $loop->iteration . '.jpg') }}"
                         alt="{{ $product->name }}" class="product-image img-fluid"
                         style="width:100%; aspect-ratio:3/4; object-fit:cover;">
                  </a>
                </div>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                      <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h5>
                  <span>{{ number_format($product->price, 0, ',', '.') }}₫</span>
                  @include('partials.add-to-cart', ['product' => $product])
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="swiper-pagination"></div>
      </div>
      <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-left"></use>
        </svg></div>
      <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-right"></use>
        </svg></div>
    </div>
  </section>
 
@endsection