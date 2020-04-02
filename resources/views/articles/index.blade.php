@extends('layouts.app')

@section('content')
<div class="container">
  <div class="page-header">
    <h1>포럼<small> / 글 목록</small></h1>
  </div>

  <div class="text-right">
    <a href="{{ route('articles.create') }}" class="btn btn-primary">
      <i class="fa fa-plus-circle"></i>
      글쓰기
    </a>
  </div>

  <article class="p-2 my-4">
    @forelse($articles as $article)
      @include('articles.partial.article', compact('article'))
    @empty
      <p class="text-center text-danger">
        글이 없습니다.
      </p>
    @endforelse
  </article>
</div>

@if ($articles->count())
  <article class="text-center" style="display: flex; justify-content: center;">
    {{-- page를 제외한 나머지 쿼리 스트링 유지 --}}
    {!! $articles->appends(Request::except('page'))->render() !!}
  </article>
@endif
@endsection