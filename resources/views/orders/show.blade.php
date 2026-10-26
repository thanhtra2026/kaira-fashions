@extends('layouts.app')

@section('title', 'Đơn hàng #' . $order->id . ' - Kaira Fashion')

@section('content')
<section class="py-5">
  <div class="container" style="max-width:900px">
    <h1 class="section-title text-center mt-4 mb-4">Đơn hàng #{{ $order->id }}</h1>

    <div class="row mb-4">
      <div class="col-md-6">
        <p class="mb-1"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p class="mb-1"><strong>Trạng thái:</strong> <span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span></p>
      </div>
      <div class="col-md-6">
        <p class="mb-1"><strong>Người nhận:</strong> {{ $order->shipping_name }}</p>
        <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->shipping_phone }}</p>
        <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table align-middle bg-white">
        <thead class="table-light">
          <tr><th>Sản phẩm</th><th class="text-end">Đơn giá</th><th class="text-center">SL</th><th class="text-end">Thành tiền</th></tr>
        </thead>
        <tbody>
          @foreach ($order->items as $item)
            <tr>
              <td>{{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}</td>
              <td class="text-end">{{ number_format($item->price, 0, ',', '.') }}₫</td>
              <td class="text-center">{{ $item->quantity }}</td>
              <td class="text-end">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end text-uppercase">Tổng cộng</th>
            <th class="text-end fs-5">{{ number_format($order->total, 0, ',', '.') }}₫</th>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="d-flex gap-2">
      <a href="{{ route('orders.index') }}" class="btn btn-outline-dark text-uppercase">Danh sách đơn</a>
      @if ($order->status === 'pending')
        <form action="{{ route('orders.cancel', $order) }}" method="post" onsubmit="return confirm('Hủy đơn hàng này?')">
          @csrf
          <button type="submit" class="btn btn-outline-danger text-uppercase">Hủy đơn</button>
        </form>
      @endif
    </div>
  </div>
</section>
@endsection
