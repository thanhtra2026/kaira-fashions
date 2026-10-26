{{-- Nút "Thêm vào giỏ" dùng chung (AJAX nhờ thuộc tính data-ajax-cart; nếu JS tắt thì vẫn gửi form bình thường) --}}
@if ($product->stock > 0)
  <form action="{{ route('cart.add', $product) }}" method="post" data-ajax-cart class="mt-2">
    @csrf
    <button type="submit" class="btn btn-outline-dark btn-sm text-uppercase">Thêm vào giỏ</button>
  </form>
@else
  <div class="mt-2"><span class="badge bg-secondary">Hết hàng</span></div>
@endif
