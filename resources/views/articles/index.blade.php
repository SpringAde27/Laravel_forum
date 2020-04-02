@extends('layouts.app')

@section('content')
  @php 
    $viewName = 'articles.index';
  @endphp

  <div class="container">
    <div class="page-header">
      <h1>포럼
        <small> / <a href="{{ route('articles.index') }}">글 목록</a></small>
      </h1>
    </div>

    <div class="text-right">
      <a href="{{ route('articles.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i>
        글쓰기
      </a>
    </div>

    <div class="row container__article">
      <div class="col-md-2 sidebar__article">
        <aside>
          @include('tags.partial.index')
        </aside>
      </div>
      
      <div class="col-md-9 offset-md-1 list__article">
        <article class="p-2 my-4">
          @forelse($articles as $article)
            @include('articles.partial.article', compact('article'))
          @empty
            <p class="text-center text-danger">
              글이 없습니다.
            </p>
          @endforelse
        </article>

        @if ($articles->count())
          <article class="text-center" style="display: flex; justify-content: center;">
            {{-- page를 제외한 나머지 쿼리 스트링 유지 --}}
            {!! $articles->appends(Request::except('page'))->render() !!}
          </article>
        @endif
      </div>
    </div>
  </div>
@endsection