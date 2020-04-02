<div class="media">
  @include('users.partial.avatar', ['user' => $article->user])

  <div class="media-body pl-3">
    <h4 class="media-heading">
      <a href="{{ route('articles.show', $article->id) }}">
        {{ $article->title }}
      </a>
    </h4>

    <p class="text-muted meta__article">
      <a href="{{ gravatar_profile_url($article->user->email) }}" target="_blank">
        <i class="fa fa-user"></i> {{ $article->user->name }}
      </a>
      <small>
        / {{ $article->created_at->diffForHumans() }}
        • 조회수 {{ $article->view_count }}

        @if ($article->comment_count > 0)
          • 댓글 {{ $article->comment_count }}
        @endif
      </small>
    </p>

    @if ($viewName === 'articles.index')
      @include('tags.partial.list', ['tags' => $article->tags])
    @endif

    @if ($viewName === 'articles.show')
      @include('attachments.partial.list', ['attachments' => $article->attachments, 'isAuthor' => $article->user])
    @endif
  </div>
</div>