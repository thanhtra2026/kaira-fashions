@extends('layouts.admin')

@section('title', 'Sửa danh mục')

@section('content')
<section>
  <div class="admin-content" style="max-width:640px">
    <h1 class="admin-title">Sửa danh mục</h1>
    <form action="{{ route('admin.categories.update', $category) }}" method="post">
      @csrf
      @method('PUT')
      @include('admin.categories._form', ['submit' => 'Cập nhật'])
    </form>
  </div>
</section>
@endsection
