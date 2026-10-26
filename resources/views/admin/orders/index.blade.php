@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<section>
  <div class="admin-content">
    <h1 class="admin-title">Quản lý đơn hàng</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
      </div>
    @endif

    <form action="{{ route('admin.orders.index') }}" method="get" class="d-flex flex-wrap gap-2 mb-3">
      <input type="text" name="q" value="{{ $keyword }}" class="form-control w-auto" placeholder="Mã đơn, tên hoặc SĐT...">
      <select name="status" class="form-select w-auto">
        <option value="">Tất cả trạng thái</option>
        @foreach (\App\Models\Order::STATUSES as $key => $label)
          <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-dark text-uppercase">Lọc</button>
      @if ($keyword !== '' || $status)
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark text-uppercase">Xóa</a>
      @endif
    </form>

    <p class="text-muted">Tìm thấy {{ $orders->total() }} đơn hàng</p>

    <div class="table-responsive">
      <table class="table table-bordered align-middle bg-white">
        <thead class="table-light">
          <tr>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Người nhận</th>
            <th>Ngày đặt</th>
            <th class="text-end">Tổng tiền</th>
            <th class="text-center">Trạng thái</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $order)
            <tr>
              <td>#{{ $order->id }}</td>
              <td>{{ $order->user->name ?? '—' }}</td>
              <td>{{ $order->shipping_name }}<div class="small text-muted">{{ $order->shipping_phone }}</div></td>
              <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
              <td class="text-end">{{ number_format($order->total, 0, ',', '.') }}₫</td>
              <td class="text-center"><span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span></td>
              <td class="text-center"><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark">Chi tiết</a></td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted">Không có đơn hàng nào.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center">{{ $orders->links() }}</div>
  </div>
</section>
@endsection
