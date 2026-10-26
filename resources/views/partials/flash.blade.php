@if (session('success'))
  <div class="container mt-3">
    <div class="alert alert-success mb-0" role="alert">{{ session('success') }}</div>
  </div>
@endif
@if (session('error'))
  <div class="container mt-3">
    <div class="alert alert-danger mb-0" role="alert">{{ session('error') }}</div>
  </div>
@endif
