@extends('layouts.app')

@section('title', 'Thanh toán - Kaira Fashion')

@section('content')
<section class="py-5">
  <div class="container">
    <h1 class="section-title text-center mt-4 mb-5">Thanh toán</h1>

    <div class="row g-5">
      <div class="col-lg-7">
        <h5 class="text-uppercase mb-3">Thông tin giao hàng</h5>

        @if ($errors->any())
          <div class="alert alert-danger">
            @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
          </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="shipping_name" class="form-label">Họ tên người nhận <span class="text-danger">*</span></label>
            <input type="text" id="shipping_name" name="shipping_name" maxlength="100"
                   value="{{ old('shipping_name', auth()->user()->name) }}"
                   class="form-control @error('shipping_name') is-invalid @enderror" required>
          </div>
          <div class="mb-3">
            <label for="shipping_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
            <input type="text" id="shipping_phone" name="shipping_phone" placeholder="0901234567"
                   value="{{ old('shipping_phone') }}"
                   class="form-control @error('shipping_phone') is-invalid @enderror" required>
          </div>
          <div class="mb-3">
            @include('checkout._address-picker')
            <label for="shipping_address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
            <textarea id="shipping_address" name="shipping_address" rows="3" maxlength="255"
                      class="form-control @error('shipping_address') is-invalid @enderror" required>{{ old('shipping_address') }}</textarea>
          </div>
          <p class="text-muted small">Thanh toán khi nhận hàng (COD).</p>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark text-uppercase">Đặt hàng</button>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark text-uppercase">Quay lại giỏ</a>
          </div>
        </form>
      </div>

      <div class="col-lg-5">
        <h5 class="text-uppercase mb-3">Đơn hàng của bạn</h5>
        <ul class="list-group mb-3">
          @foreach ($items as $item)
            <li class="list-group-item d-flex justify-content-between">
              <span>{{ $item['product']->name }} × {{ $item['qty'] }}</span>
              <span>{{ number_format($item['subtotal'], 0, ',', '.') }}₫</span>
            </li>
          @endforeach
          <li class="list-group-item d-flex justify-content-between fw-bold">
            <span>Tổng cộng</span>
            <span>{{ number_format($total, 0, ',', '.') }}₫</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
  <script src="{{ asset('js/address-picker.js') }}" defer></script>
@endpush
