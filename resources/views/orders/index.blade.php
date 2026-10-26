@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - Kaira Fashion')

@section('content')
<section class="py-5">
  <div class="container">
    <h1 class="section-title text-center mt-4 mb-4">Đơn hàng của tôi</h1>

    <div class="table-responsive">
      <table class="table table-bordered align-middle bg-white">
        <thead class="table-light">
          <tr>
            <th>Mã đơn</th>
            <th>Ngày đặt</th>
            <th class="text-center">Số mặt hàng</th>
            <th class="text-end">Tổng tiền</th>
            <th class="text-center">Trạng thái</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $order)
            <tr>
              <td>#{{ $order->id }}</td>
              <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
              <td class="text-center">{{ $order->items_count }}</td>
              <td class="text-end">{{ number_format($order->total, 0, ',', '.') }}₫</td>
              <td class="text-center"><span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span></td>
              <td class="text-center"><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-dark">Chi tiết</a></td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted">Bạn chưa có đơn hàng nào.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center">{{ $orders->links() }}</div>
  </div>
</section>
@endsection
