@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('content')
<section>
  <div class="admin-content" style="max-width:640px">
    <h1 class="admin-title">Thêm danh mục</h1>
    <form action="{{ route('admin.categories.store') }}" method="post">
      @csrf
      @include('admin.categories._form', ['submit' => 'Lưu'])
    </form>
  </div>
</section>
@endsection
