/**
 * Thêm vào giỏ hàng bằng AJAX (Fetch API).
 * Form nào có thuộc tính data-ajax-cart sẽ được gửi nền, không tải lại trang;
 * sau đó cập nhật số trên header (#cart-count) và hiện thông báo nhỏ (toast).
 */
(function () {
  function showToast(message, type) {
    var el = document.getElementById('cart-toast');
    if (!el || typeof bootstrap === 'undefined') { alert(message); return; }
    el.className = 'toast align-items-center border-0 text-bg-' + (type || 'success');
    document.getElementById('cart-toast-body').textContent = message;
    bootstrap.Toast.getOrCreateInstance(el, { delay: 3000 }).show();
  }

  function updateBadge(count) {
    // Có thể có nhiều nơi hiển thị số giỏ hàng (thanh trên điện thoại + menu) -> cập nhật tất cả
    document.querySelectorAll('.js-cart-count').forEach(function (badge) {
      badge.textContent = count;
      badge.classList.toggle('d-none', count < 1);
    });
  }

  document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!form.matches || !form.matches('form[data-ajax-cart]')) return;

    e.preventDefault();
    var btn = form.querySelector('button[type="submit"]');
    if (btn) btn.disabled = true;

    fetch(form.action, {
      method: 'POST',
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: new FormData(form), // đã gồm _token (CSRF)
      credentials: 'same-origin'
    })
      .then(function (res) {
        if (res.status === 419) { window.location.reload(); return null; } // hết phiên làm việc
        return res.json().then(function (data) { return { ok: res.ok, data: data }; });
      })
      .then(function (r) {
        if (!r) return;
        var data = r.data || {};
        var msg = data.message;
        if (!msg && data.errors) { msg = Object.values(data.errors)[0][0]; }
        showToast(msg || 'Có lỗi xảy ra, vui lòng thử lại.', r.ok ? (data.type || 'success') : 'danger');
        if (typeof data.count === 'number') updateBadge(data.count);
      })
      .catch(function () {
        form.submit(); // lỗi mạng/JS: quay về cách gửi form bình thường
      })
      .finally(function () {
        if (btn) btn.disabled = false;
      });
  });
})();
