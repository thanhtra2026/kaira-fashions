@if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
  </div>
@endif

<div class="mb-3">
  <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
  <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
    <option value="">-- Chọn danh mục --</option>
    @foreach ($categories as $cat)
      <option value="{{ $cat->id }}" @selected((int) old('category_id', $product->category_id) === $cat->id)>{{ $cat->name }}</option>
    @endforeach
  </select>
  @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
  <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
         class="form-control @error('name') is-invalid @enderror" maxlength="150" required>
  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label for="description" class="form-label">Mô tả</label>
  <textarea id="description" name="description" rows="4" maxlength="2000"
            class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
  @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label for="price" class="form-label">Giá (₫) <span class="text-danger">*</span></label>
    <input type="number" id="price" name="price" min="0" step="1000"
           value="{{ old('price', $product->price !== null ? (int) $product->price : '') }}"
           class="form-control @error('price') is-invalid @enderror" required>
    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6 mb-3">
    <label for="stock" class="form-label">Tồn kho <span class="text-danger">*</span></label>
    <input type="number" id="stock" name="stock" min="0"
           value="{{ old('stock', $product->stock ?? 0) }}"
           class="form-control @error('stock') is-invalid @enderror" required>
    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="mb-3">
  <label for="image" class="form-label">Ảnh sản phẩm (jpg, png, webp - tối đa 2 MB)</label>

  @if ($product->image)
    <div class="mb-2">
      <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
           style="width:120px;height:160px;object-fit:cover;" class="border">
    </div>
  @endif

  <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/webp"
         class="form-control @error('image') is-invalid @enderror">
  @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

  {{-- Xem trước ảnh vừa chọn --}}
  <img id="image-preview" alt="Xem trước" class="border mt-2 d-none"
       style="width:120px;height:160px;object-fit:cover;">

  @if ($product->image)
    <div class="form-check mt-2">
      <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
      <label class="form-check-label" for="remove_image">Xóa ảnh hiện tại</label>
    </div>
    <div class="form-text">Chọn ảnh mới để thay thế ảnh hiện tại.</div>
  @endif
</div>

<div class="d-flex gap-2">
  <button type="submit" class="btn btn-dark text-uppercase">{{ $submit }}</button>
  <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark text-uppercase">Hủy</a>
</div>

@push('scripts')
<script>
  document.getElementById('image').addEventListener('change', function () {
    var preview = document.getElementById('image-preview');
    if (this.files && this.files[0]) {
      preview.src = URL.createObjectURL(this.files[0]);
      preview.classList.remove('d-none');
    } else {
      preview.classList.add('d-none');
    }
  });
</script>
@endpush
