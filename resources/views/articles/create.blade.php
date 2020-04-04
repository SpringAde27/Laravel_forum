@extends('layouts.app')

@section('content')
<div class="container">
  <div class="page-header">
    <h1>{{ trans('forum.title') }} {{ trans('forum.articles.create') }}</h1>
  </div>

  <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
    {!! csrf_field() !!}

    @include('articles.partial.form')

    <div class="form-group text-right">
      <button type="submit" class="btn btn-primary">{{ trans('forum.articles.store') }}</button>
    </div>
  </form>
</div>
@endsection