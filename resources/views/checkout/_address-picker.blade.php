<details class="border rounded p-3 mb-3" data-address-picker
         data-provinces-url="{{ route('address.provinces') }}"
         data-wards-url="{{ route('address.wards', ['province' => '__PROVINCE__']) }}">
  <summary class="fw-semibold">Chọn tỉnh/thành phố, phường/xã</summary>
  <p class="small text-muted mt-2 mb-3">Chọn địa phương để điền nhanh địa chỉ. Bạn cũng có thể nhập toàn bộ địa chỉ trực tiếp bên dưới.</p>
  <div class="row g-3">
    <div class="col-md-6">
      <label for="address_province" class="form-label">Tỉnh/thành phố</label>
      <select id="address_province" class="form-select" data-province disabled>
        <option value="">Chọn tỉnh/thành phố</option>
      </select>
    </div>
    <div class="col-md-6">
      <label for="address_ward" class="form-label">Phường/xã</label>
      <select id="address_ward" class="form-select" data-ward disabled>
        <option value="">Chọn phường/xã</option>
      </select>
    </div>
    <div class="col-12">
      <label for="address_street" class="form-label">Số nhà, tên đường</label>
      <input type="text" id="address_street" class="form-control" maxlength="200"
             placeholder="Ví dụ: 12 Nguyễn Văn Bảo" data-street>
    </div>
    <div class="col-12">
      <button type="button" class="btn btn-outline-dark btn-sm" data-apply-address disabled>Điền địa chỉ</button>
      <button type="button" class="btn btn-link btn-sm" data-retry-address hidden>Thử tải lại</button>
      <p class="small text-muted mt-2 mb-0" role="status" aria-live="polite" data-address-status></p>
    </div>
  </div>
</details>
