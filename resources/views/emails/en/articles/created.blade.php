<h1>
  [ {{ $article->title }} ]
  <small>
    {{ $article->user->name }}posted a new post.
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
  This email was sent by {{ config('project.url') }}.
</footer>