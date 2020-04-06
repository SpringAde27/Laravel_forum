@section('style')
  <style>
    .txt-active {
      color : red !important;
    }
  </style>
@endsection

<p class="lead mt-3">
  <i class="fa fa-tags"></i>
  {{ trans('forum.tags.title') }}
</p>

<ul class="list-group">
  @foreach($allTags as $tag)
    <li class="d-flex justify-content-between align-items-center py-1 ">
      <a href="{{ route('tags.articles.index', $tag->slug) }}" class="{!! Str::contains(request()->path(), $tag->slug) ? 'text-danger' : '' !!}">
        {{ $tag->{$currentLocale} }}
      </a>
      @if ($count = $tag->articles->count())
        <span class="badge badge-primary badge-pill">{{ $count }}</span>
      @endif
    </li>
  @endforeach
</ul>