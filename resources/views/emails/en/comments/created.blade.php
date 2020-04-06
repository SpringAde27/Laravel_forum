<h1>
  [ {{ $comment->commentable->title }} ]
  <small>This is a comment written by {{ $comment->user->name }}.</small>
</h1>

<hr/>

<p>
  {!! markdown($comment->content) !!}

  <small>
    {{ $comment->created_at->timezone('Asia/Seoul') }}
  </small>
</p>

<hr/>

<footer>
  This email was sent by {{ config('project.url') }}.
</footer>