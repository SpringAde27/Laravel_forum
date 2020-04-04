<form method="get" action="{{ route('articles.index') }}" role="search">
  <input type="text" name="search" class="form-control" placeholder={{ trans('forum.search') }}/>
</form>