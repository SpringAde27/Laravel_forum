@extends('layouts.app')

@section('content')
  @php
    $viewName = 'articles.show';
  @endphp

  <div class="container">
    <div class="page-header">
      <h4>
        <a href="{{ route('articles.index') }}">
          {{ trans('forum.title') }}
        </a>
        <small>
          / {{ $article->title }}
        </small>
      </h4>
    </div>

    <div class="row container__article">
      <div class="col-md-3 sidebar__article">
        <aside class="my-4">
          @include('articles.partial.search')
          @include('tags.partial.index')
        </aside>
      </div>

      <div class="col-md-8 offset-md-1 list__article">
        <article data-id="{{ $article->id }}">
          @include('articles.partial.article', compact('article'))
          <p>{!! markdown($article->content) !!}</p>
          @include('tags.partial.list', ['tags' => $article->tags])
        </article>
      
        <div class="text-center">
          @can('update', $article)
            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary">
              <i class="fa fa-pencil"></i>
              {{ trans('forum.articles.edit')}}
            </a>
          @endcan
          
          @can('delete', $article)
          <button class="btn btn-danger button__delete">
            <i class="fa fa-trash-o"></i>
            {{ trans('forum.articles.destroy')}}
          </button>
          @endcan
          
          <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-list"></i>
            {{ trans('forum.articles.index')}}
          </a>
        </div>

        <div class="container__comment">
          @include('comments.index')
        </div>
      </div>
    </div>
  </div>
@stop

@section('script')
  <script>
    // HTML헤더에 넣어둔 CSRF토큰 값을 읽어 모든 Ajax요청헤더에 붙인다.
    $.ajaxSetup({ headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('.button__delete').on('click', function(e) {
      var articleId = $('article').data('id'); // var articleId = '{{ $article->id }}'
      
      if(confirm('게시글을 삭제 합니다.')) {
        $.ajax({
          type : 'DELETE',
          url : '/articles/' + articleId
        }).then(function () {
          window.location.href = '/articles';
        });
      }
    });
  </script>
@endsection