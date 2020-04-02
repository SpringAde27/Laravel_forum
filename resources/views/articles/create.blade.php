@extends('layouts.app')

@section('content')
<div class="container">
  <div class="page-header">
    <h1>새 포럼 글쓰기</h1>
  </div>

  <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
    {!! csrf_field() !!}

    @include('articles.partial.form')

    <div class="form-group text-right">
      <button type="submit" class="btn btn-primary">저장하기</button>
    </div>
  </form>
</div>
@endsection