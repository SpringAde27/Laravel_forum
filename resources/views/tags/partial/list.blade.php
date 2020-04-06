@if ($tags->count())
  <ul class="list-inline tags__article">
    <li class="d-inline-block">
      <i class="fa fa-tags"></i>
    </li>
    @foreach ($tags as $tag)
    <li class="d-inline-block">
      <a href="{{ route('tags.articles.index', $tag->slug) }}" class="badge badge-primary">
        {{ $tag->{$currentLocale} }}
      </a>
    </li>
    @endforeach
  </ul>
@endif