@if ($isTrashed and !$hasChild)
  <!-- // 1. 삭제된 댓글 && 자식 댓글도 없다. 아무것도 출력할 필요가 없다. -->
@elseif ($isTrashed and $hasChild)
  <!-- // 2. 삭제된 댓글이지만 자식 댓글이 있다. '삭제되었습니다'라고 표시, 자식 댓글 출력한다. -->
  <div class="media item__comment {{ $isReply ? 'sub' : 'top' }}" data-id= "{{ $comment->id }}" id="comment_{{ $comment->id }}">
    @include('users.partial.avatar', ['user' => $comment->user, 'size' => 32])

    <div class="media-body pl-3">
      <h6 class="media-heading">
        <p class="text-muted">
          <a href="{{ gravatar_profile_url($comment->user->email) }}" target="_blank">
            {{ $comment->user->name }}
          </a>
          <small>
            / {{ $article->created_at->diffForHumans() }}
          </small>
        </p>
      </h6>

      <div class="text-danger content__comment">
        삭제된 댓글입니다.
      </div>

      <div class="action__comment">
        {{-- @can('update', $comment)
          <button class="btn btn-sm btn-outline-dark btn__delete__comment">댓글 삭제</button>
          <button class="btn btn-sm btn-outline-dark btn__edit__comment">댓글 수정</button>
        @endcan

        @if ($currentUser)
          <button class="btn btn-sm btn-outline-dark btn__reply__comment">
            답글 쓰기
          </button>
        @endif --}}
      </div>

      @if($currentUser)
        @include('comments.partial.create', ['parentId' => $comment->id])
      @endif

      @forelse ($comment->replies as $reply)
        @include('comments.partial.comment', [
          'comment' => $reply,
          'isReply' => true,
          'hasChild' => $reply->replies->count(),
          'isTrashed' => $reply->trashed(),
        ])
      @empty
      @endforelse
    </div>
  </div>
@else
  <!-- // 3. 살아 있는 댓글이다. 자신을 출력하고, 자식 댓글도 계속 출력한다. -->
  <div class="media item__comment {{ $isReply ? 'sub' : 'top' }} py-3" data-id= "{{ $comment->id }}" id="comment_{{ $comment->id }}">
    @include('users.partial.avatar', ['user' => $comment->user, 'size' => 32])

    <div class="media-body pl-3">
      <h6 class="media-heading">
        <p class="text-muted">
          <a href="{{ gravatar_profile_url($comment->user->email) }}" target="_blank">
            {{ $comment->user->name }}
          </a>
          <small>
            / {{ $article->created_at->diffForHumans() }}
          </small>
        </p>
      </h6>

      <div class="content__comment">
        {!! markdown($comment->content) !!}
      </div>

      <div class="action__comment">
        {{-- 권한이 있는 사용자만 사용 --}}
        @can('update', $comment)
          <button class="btn btn-sm btn-outline-dark btn__delete__comment">댓글 삭제</button>
          <button class="btn btn-sm btn-outline-dark btn__edit__comment">댓글 수정</button>
        @endcan

        {{-- 로그인한 사용자만 사용 --}}
        @if ($currentUser)
          <button class="btn btn-sm btn-outline-dark btn__reply__comment">
            답글 쓰기
          </button>
        @endif
      </div>

      {{-- 댓글 작성 폼 --}}
      @if($currentUser)
        @include('comments.partial.create', ['parentId' => $comment->id])
      @endif

      @can('update', $comment)
        @include('comments.partial.edit')
      @endcan

      @forelse ($comment->replies as $reply)
        @include('comments.partial.comment', [
          'comment' => $reply,
          'isReply' => true,
          'hasChild' => $reply->replies->count(),
          'isTrashed' => $reply->trashed(),
        ])
      @empty
      @endforelse
    </div>
  </div>
@endif