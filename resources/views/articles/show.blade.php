@extends('layouts.app')

@section('content')
<div class="container">
  <div class="page-header">
    <h4>
      <a href="{{ route('articles.index') }}">
        포럼
      </a>
      <small>
        / {{ $article->title }}
      </small>
    </h4>
  </div>

  <article data-id="{{ $article->id }}" class="p-2 my-4">
    @include('articles.partial.article', compact('article'))

    <p>{!! markdown($article->content) !!}</p>
  </article>

  <div class="text-center">
    @can('update', $article)
      <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary">
        <i class="fa fa-pencil"></i>
        글 수정
      </a>
    @endcan
    
    @can('delete', $article)
    <button class="btn btn-danger button__delete">
      <i class="fa fa-trash-o"></i>
      글 삭제
    </button>
    @endcan
    
    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">
      <i class="fa fa-list"></i>
      글 목록
    </a>
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