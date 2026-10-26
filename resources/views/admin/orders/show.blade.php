@extends('layouts.admin')

@section('title', 'Đơn hàng #' . $order->id . ' - Quản trị')

@section('content')
<section>
  <div class="admin-content" style="max-width:900px">
    <h1 class="admin-title">Đơn hàng #{{ $order->id }}</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
      </div>
    @endif

    <div class="row mb-4">
      <div class="col-md-6">
        <p class="mb-1"><strong>Khách hàng:</strong> {{ $order->user->name ?? '—' }} ({{ $order->user->email ?? '' }})</p>
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

    @if ($order->status !== 'cancelled')
      <form action="{{ route('admin.orders.status', $order) }}" method="post" class="d-flex flex-wrap gap-2 align-items-center mb-3">
        @csrf
        @method('PATCH')
        <label for="status" class="form-label mb-0">Đổi trạng thái:</label>
        <select id="status" name="status" class="form-select w-auto">
          @foreach (\App\Models\Order::STATUSES as $key => $label)
            <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-dark text-uppercase"
                onclick="if (document.getElementById('status').value === 'cancelled') return confirm('Hủy đơn sẽ hoàn lại tồn kho và không thể đổi lại. Tiếp tục?')">Cập nhật</button>
      </form>
    @else
      <p class="text-muted">Đơn đã hủy nên không thể đổi trạng thái.</p>
    @endif

    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark text-uppercase">Danh sách đơn</a>
  </div>
</section>
@endsection
