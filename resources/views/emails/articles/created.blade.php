<h1>
  [ {{ $article->title }} ]
  <small>
    {{ $article->user->name }}님이 새글을 등록했습니다.
  </small>
</h1>

<hr/>

<p>
  {!! markdown($article->content) !!}

  <small>
    {{ $article->created_at->timezone('Asia/Seoul') }}
  </small>
</p>

<hr/>

<footer>
  본 메일은 {{ config('project.url') }}에서 보냈습니다.
</footer>