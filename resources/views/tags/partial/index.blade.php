@section('style')
  <style>
    .txt-active {
      color : red !important;
    }
  </style>
@endsection

<p class="lead">
  <i class="fa fa-tags"></i>
  태그
</p>

<ul class="list-group">
  @foreach($allTags as $tag)
    <li class="d-flex justify-content-between align-items-center py-1 ">
      <a href="{{ route('tags.articles.index', $tag->slug) }}" class="{!! Str::contains(request()->path(), $tag->slug) ? 'text-danger' : '' !!}">
        {{ $tag->name }}
      </a>
      @if ($count = $tag->articles->count())
        <span class="badge badge-primary badge-pill">{{ $count }}</span>
      @endif
    </li>
  @endforeach
</ul>