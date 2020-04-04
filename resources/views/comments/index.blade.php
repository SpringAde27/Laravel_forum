<div class="page-header">
  <h4>{{ trans('forum.comments.title') }}</h4>
</div>

<div class="form__new__comment">
  @if($currentUser)
    @include('comments.partial.create')
  @else
    @include('comments.partial.login')
  @endif
</div>

<div class="list__comment">
  @forelse($comments as $comment)
    @include('comments.partial.comment', [
      'parentId' => $comment->id,
      'isReply' => false,
      'hasChild' => $comment->replies->count(),
      'isTrashed' => $comment->trashed()
    ])
  @empty
  @endforelse
</div>

@section('script')
  @parent
  <script>
    $('.media__create__comment').not('.media__create__comment:first').hide();
    $('.media__edit__comment').hide();

    // 댓글 삭제 요청을 처리한다.
    $('.btn__delete__comment').on('click', function(e) {
      var commentId = $(this).closest('.item__comment').data('id'),
          articleId = $('#item__article').data('id');

      if (confirm('삭제할까요?')) {
        $.ajax({
          type: 'POST',
          url: "/comments/" + commentId,
          data: {
            _method: 'DELETE'
          },
        }).then(function(data, status) {
          if(data.replies.length === 0) {
            $('#comment_' + commentId).fadeOut(1000, function () { $(this).remove(); });
          } else {  
            $('#comment_' + commentId)
              .find('.content__comment')
              .first()
              .addClass('text-danger')
              .fadeIn(1000, function () {
                $(this).text('삭제된 댓글입니다.');
              });
            $('#comment_' + commentId).find('.content__comment').first().next().remove();
          }
        });
      }
    });

    // 대댓글 폼을 토글한다.
    $('.btn__reply__comment').on('click', function(e) {
      var el__create = $(this).closest('.item__comment').find('.media__create__comment').first(),
          el__edit = $(this).closest('.item__comment').find('.media__edit__comment').first();

      el__edit.hide('fast');
      el__create.toggle('fast').end().find('textarea').focus();
    });

    // 댓글 수정 폼을 토글한다.
    $('.btn__edit__comment').on('click', function(e) {
      var el__create = $(this).closest('.item__comment').find('.media__create__comment').first(),
          el__edit = $(this).closest('.item__comment').find('.media__edit__comment').first();

      el__create.hide('fast');
      el__edit.toggle('fast').end().find('textarea').first().focus();
    });

    // 투표
    $('.btn__vote__comment').on('click', function(e) {
      var self = $(this),
          commentId = self.closest('.item__comment').data('id');

      $.ajax({
        type: 'POST',
        url: '/comments/' + commentId + '/votes',
        data: {
          vote: self.data('vote')
        }
      }).then(function (data) {
        self.find('span').html(data.value).fadeIn();
        self.attr('disabled', 'disabled');
        self.siblings().next('.btn__vote__comment').attr('disabled', 'disabled');
        self.siblings().prev('.btn__vote__comment').attr('disabled', 'disabled');
      });
    });
  </script>
@endsection