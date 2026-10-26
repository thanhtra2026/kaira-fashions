@extends('layouts.app')

@section('title', 'Giỏ hàng - Kaira Fashion')

@section('content')
<section class="py-5">
  <div class="container">
    <h1 class="section-title text-center mt-4 mb-4">Giỏ hàng</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
      </div>
    @endif

    @if (empty($items))
      <div class="text-center py-5">
        <p class="mb-4">Giỏ hàng của bạn đang trống.</p>
        <a href="{{ route('products.index') }}" class="btn btn-dark text-uppercase">Tiếp tục mua sắm</a>
      </div>
    @else
      <div class="table-responsive">
        <table class="table align-middle bg-white">
          <thead class="table-light">
            <tr>
              <th style="width:90px">Ảnh</th>
              <th>Sản phẩm</th>
              <th class="text-end">Đơn giá</th>
              <th style="width:190px" class="text-center">Số lượng</th>
              <th class="text-end">Thành tiền</th>
              <th style="width:80px"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
              @php $p = $item['product']; @endphp
              <tr>
                <td>
                  <img src="{{ $p->image ? asset($p->image) : asset('kaira/images/product-item-1.jpg') }}"
                       alt="{{ $p->name }}" style="width:64px;height:80px;object-fit:cover;">
                </td>
                <td>
                  <a href="{{ route('products.show', $p->slug) }}" class="text-dark">{{ $p->name }}</a>
                  @if ($item['over'])
                    <div class="text-danger small">Chỉ còn {{ $p->stock }} sản phẩm trong kho.</div>
                  @endif
                </td>
                <td class="text-end">{{ number_format($p->price, 0, ',', '.') }}₫</td>
                <td class="text-center">
                  <form action="{{ route('cart.update', $p) }}" method="post" class="d-flex gap-1 justify-content-center">
                    @csrf
                    @method('PATCH')
                    <input type="number" name="quantity" value="{{ $item['qty'] }}" min="1" max="99"
                           class="form-control form-control-sm" style="width:70px" aria-label="Số lượng">
                    <button type="submit" class="btn btn-sm btn-outline-dark">Cập nhật</button>
                  </form>
                </td>
                <td class="text-end">{{ number_format($item['subtotal'], 0, ',', '.') }}₫</td>
                <td class="text-end">
                  <form action="{{ route('cart.remove', $p) }}" method="post"
                        onsubmit="return confirm('Bỏ sản phẩm này khỏi giỏ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="4" class="text-end text-uppercase">Tổng cộng</th>
              <th class="text-end fs-5">{{ number_format($total, 0, ',', '.') }}₫</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="d-flex flex-wrap justify-content-between gap-2">
        <a href="{{ route('products.index') }}" class="btn btn-outline-dark text-uppercase">Tiếp tục mua sắm</a>
        @auth
          <a href="{{ route('checkout.show') }}" class="btn btn-dark text-uppercase">Thanh toán</a>
        @else
          <a href="{{ route('checkout.show') }}" class="btn btn-dark text-uppercase">Đăng nhập để thanh toán</a>
        @endauth
      </div>
    @endif
  </div>
</section>
@endsection
