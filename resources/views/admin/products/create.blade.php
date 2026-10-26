@extends('layouts.admin')

@section('title', 'Thêm sản phẩm')

@section('content')
<section>
  <div class="admin-content" style="max-width:720px">
    <h1 class="admin-title">Thêm sản phẩm</h1>
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      @include('admin.products._form', ['submit' => 'Lưu'])
    </form>
  </div>
</section>
@endsection
