@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')

@section('content')
<section>
  <div class="admin-content" style="max-width:720px">
    <h1 class="admin-title">Sửa sản phẩm</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('admin.products._form', ['submit' => 'Cập nhật'])
    </form>
  </div>
</section>
@endsection
