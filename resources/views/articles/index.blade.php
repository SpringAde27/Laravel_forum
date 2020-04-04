@extends('layouts.app')

@section('content')
  @php 
    $viewName = 'articles.index';
  @endphp

  <div class="container">
    <div class="page-header">
      <h1>{{ trans('forum.title') }}
        <small> / <a href="{{ route('articles.index') }}">{{ trans('forum.articles.index') }}</a></small>
      </h1>
    </div>

    <div class="text-right action__article">
      <a href="{{ route('articles.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i>
        {{ trans('forum.articles.create') }}
      </a>
      <!-- 정렬 -->
      <div class="btn-group sort__article">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-sort"></i>
          {{ trans('forum.articles.sort') }}
          <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
          @foreach(config('project.sorting') as $column => $text)
            <li class="dropdown-item {!! request()->input("sort") == $column ? "active" : "" !!}">
              {!! link_for_sort($column, $text) !!}
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="row container__article">
      <div class="col-md-3 sidebar__article">
        <aside class="my-4">
          @include('articles.partial.search')
          @include('tags.partial.index')
        </aside>
      </div>
            
      <div class="col-md-8 offset-md-1 list__article">
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