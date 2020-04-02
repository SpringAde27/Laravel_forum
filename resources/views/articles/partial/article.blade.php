<div class="media">
  @include('users.partial.avatar', ['user' => $article->user])

  <div class="media-body pl-3">
    <h4 class="media-heading">
      <a href="{{ route('articles.show', $article->id) }}">
        {{ $article->title }}
      </a>
    </h4>

    <p class="text-muted">
      <a href="{{ gravatar_profile_url($article->user->email) }}" target="_blank">
        <i class="fa fa-user"></i> {{ $article->user->name }}
      </a>
      <small>
        / {{ $article->created_at->diffForHumans() }}
      </small>
    </p>
  </div>
</div>
