@extends('layouts.admin')

@section('title', 'Tổng quan')

@section('content')
<h1 class="admin-title">Tổng quan</h1>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="admin-card stat-card">
      <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
      <div>
        <div class="stat-value">{{ number_format($revenue, 0, ',', '.') }}₫</div>
        <div class="stat-label">Doanh thu (không tính đơn hủy)</div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-reset">
      <div class="admin-card stat-card">
        <div class="stat-icon"><i class="bi bi-receipt"></i></div>
        <div>
          <div class="stat-value">{{ $orderCount }}</div>
          <div class="stat-label">Đơn hàng ({{ $pendingCount }} chờ xác nhận)</div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-xl-3">
    <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-reset">
      <div class="admin-card stat-card">
        <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
        <div>
          <div class="stat-value">{{ $productCount }}</div>
          <div class="stat-label">Sản phẩm</div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-xl-3">
    <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-reset">
      <div class="admin-card stat-card">
        <div class="stat-icon"><i class="bi bi-tags"></i></div>
        <div>
          <div class="stat-value">{{ $categoryCount }}</div>
          <div class="stat-label">Danh mục</div>
        </div>
      </div>
    </a>
  </div>
</div>

<div class="row g-3">
  <div class="col-xl-8">
    <div class="admin-card">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="admin-card-title mb-0">Đơn hàng mới nhất</div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-dark">Xem tất cả</a>
      </div>
      <div class="table-responsive border-0">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th>
              <th class="text-end">Tổng tiền</th><th class="text-center">Trạng thái</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recentOrders as $order)
              <tr>
                <td><a href="{{ route('admin.orders.show', $order) }}" class="fw-semibold text-decoration-none">#{{ $order->id }}</a></td>
                <td>{{ $order->user->name ?? '—' }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-end">{{ number_format($order->total, 0, ',', '.') }}₫</td>
                <td class="text-center"><span class="badge {{ $order->status_class }}">{{ $order->status_label }}</span></td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-muted">Chưa có đơn hàng nào.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="admin-card">
      <div class="admin-card-title">Sản phẩm sắp hết hàng</div>
      @forelse ($lowStock as $product)
        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
          <a href="{{ route('admin.products.edit', $product) }}" class="text-decoration-none text-reset">{{ $product->name }}</a>
          <span class="badge {{ $product->stock === 0 ? 'bg-danger' : 'bg-warning text-dark' }}">
            {{ $product->stock === 0 ? 'Hết hàng' : 'Còn ' . $product->stock }}
          </span>
        </div>
      @empty
        <p class="text-muted mb-0">Tất cả sản phẩm còn đủ hàng.</p>
      @endforelse
    </div>
  </div>
</div>
@endsection
