(function () {
  'use strict';

  const picker = document.querySelector('[data-address-picker]');
  if (!picker) return;

  const province = picker.querySelector('[data-province]');
  const ward = picker.querySelector('[data-ward]');
  const street = picker.querySelector('[data-street]');
  const apply = picker.querySelector('[data-apply-address]');
  const retry = picker.querySelector('[data-retry-address]');
  const status = picker.querySelector('[data-address-status]');
  const address = document.getElementById('shipping_address');
  let loaded = false;
  let loading = false;
  let wardRequest = 0;
  let pendingWard;

  function message(text, error, canRetry) {
    status.textContent = text;
    status.classList.toggle('text-danger', !!error);
    status.classList.toggle('text-muted', !error);
    retry.hidden = !canRetry;
  }

  function reset(select, placeholder) {
    select.replaceChildren(new Option(placeholder, ''));
    select.disabled = true;
  }

  function fill(select, items, placeholder) {
    reset(select, placeholder);
    items.forEach(item => select.add(new Option(item.name, String(item.code))));
    select.disabled = false;
  }

  function ready() {
    apply.disabled = !(province.value && ward.value && street.value.trim());
  }

  async function getList(url, signal) {
    const controller = new AbortController();
    const abort = () => controller.abort();
    if (signal && signal.aborted) controller.abort();
    else if (signal) signal.addEventListener('abort', abort, { once: true });
    const timer = setTimeout(abort, 8000);
    try {
      const response = await fetch(url, {
        headers: { Accept: 'application/json' },
        credentials: 'same-origin',
        signal: controller.signal,
      });
      if (!response.ok || response.redirected) throw new Error('Lookup unavailable');
      const body = await response.json();
      if (!Array.isArray(body.data) || !body.data.length || !body.data.every(item =>
        Number.isInteger(item.code) && typeof item.name === 'string' && item.name.trim())) {
        throw new Error('Invalid address list');
      }
      return body.data;
    } catch (error) {
      if (signal && signal.aborted) throw error;
      throw new Error('Lookup unavailable');
    } finally {
      clearTimeout(timer);
      if (signal) signal.removeEventListener('abort', abort);
    }
  }

  async function loadProvinces() {
    if (loading || loaded) return;
    loading = true;
    retry.hidden = true;
    message('Đang tải tỉnh/thành phố…');
    try {
      const items = await getList(picker.dataset.provincesUrl);
      fill(province, items, 'Chọn tỉnh/thành phố');
      loaded = true;
      message('Chọn tỉnh/thành phố để tải phường/xã.');
    } catch (error) {
      message('Chưa tải được địa phương. Bạn có thể nhập địa chỉ đầy đủ bên dưới hoặc thử lại.', true, true);
    } finally {
      loading = false;
    }
  }

  async function loadWards() {
    const requestId = ++wardRequest;
    if (pendingWard) pendingWard.abort();
    reset(ward, 'Chọn phường/xã');
    ready();
    if (!province.value) {
      message('Chọn tỉnh/thành phố để tải phường/xã.');
      return;
    }

    const code = province.value;
    pendingWard = new AbortController();
    message('Đang tải phường/xã…');
    try {
      const url = picker.dataset.wardsUrl.replace('__PROVINCE__', encodeURIComponent(code));
      const items = await getList(url, pendingWard.signal);
      if (requestId !== wardRequest || province.value !== code) return;
      fill(ward, items, 'Chọn phường/xã');
      message('Nhập số nhà, tên đường rồi bấm “Điền địa chỉ”.');
    } catch (error) {
      if (requestId !== wardRequest || error.name === 'AbortError') return;
      message('Chưa tải được phường/xã. Bạn có thể nhập địa chỉ đầy đủ bên dưới hoặc thử lại.', true, true);
    }
  }

  picker.addEventListener('toggle', function () {
    if (picker.open) loadProvinces();
  });
  province.addEventListener('change', loadWards);
  ward.addEventListener('change', ready);
  street.addEventListener('input', ready);
  retry.addEventListener('click', function () {
    if (loaded && province.value) loadWards();
    else loadProvinces();
  });
  apply.addEventListener('click', function () {
    ready();
    if (apply.disabled) return;
    const value = [street.value.trim(), ward.selectedOptions[0].text, province.selectedOptions[0].text].join(', ');
    if (value.length > address.maxLength) {
      message('Địa chỉ quá dài. Vui lòng rút gọn số nhà, tên đường hoặc nhập trực tiếp bên dưới.', true);
      return;
    }
    address.value = value;
    address.dispatchEvent(new Event('input', { bubbles: true }));
    address.dispatchEvent(new Event('change', { bubbles: true }));
    message('Đã điền địa chỉ. Bạn có thể chỉnh lại trước khi đặt hàng.');
    address.focus();
  });
  if (picker.open) loadProvinces();
}());
