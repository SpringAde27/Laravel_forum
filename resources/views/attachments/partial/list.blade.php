@if ($attachments->count())
  <ul class="list-unstyled attachments__article">
    @foreach ($attachments as $attachment)
      <li id="attachment_{{$attachment->id}}">
        <i class="fa fa-paperclip"></i>
        <a href="{{ $attachment->url }}">
          {{ $attachment->filename }} ({{ $attachment->bytes }})
        </a>

        @if (auth()->user()->isAdmin() or $currentUser == $isAuthor)
          <button data-id= "{{ $attachment->id }}" class="btn btn-secondary btn-sm btn__delete__attachment" style="padding: 0rem 0.3rem;">
            x
          </button>

          {{-- <form action="{{ route('attachments.destroy', $attachment->id) }}" method="post" style="display: inline;">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <button type="submit">x</button>
          </form> --}}
        @endif
      </li>      
    @endforeach
  </ul>
@endif

@section('script')
  @parent
  <script>
    $('.btn__delete__attachment').on('click', function(e) {
      var attachmentId = $(this).data('id');

      if (confirm('삭제할까요?')) {
        $.ajax({
          type: 'POST',
          url: "/attachments/" + attachmentId,
          data: {
            _method: 'DELETE'
          },
        }).then(function(data) {
          if(data.status === 'ok') {
            $('#attachment_' + attachmentId).fadeOut(200, function () { $(this).remove(); });
          }
        });
      }
    });
  </script>    
@endsection