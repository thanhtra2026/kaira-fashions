@if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
  </div>
@endif

<div class="mb-3">
  <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
  <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
         class="form-control @error('name') is-invalid @enderror" maxlength="100" required>
  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  <div class="form-text">Đường dẫn (slug) được tạo tự động từ tên.</div>
</div>

<div class="d-flex gap-2">
  <button type="submit" class="btn btn-dark text-uppercase">{{ $submit }}</button>
  <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark text-uppercase">Hủy</a>
</div>
