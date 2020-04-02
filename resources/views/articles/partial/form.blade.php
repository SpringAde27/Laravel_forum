<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
  <label for="title">제목</label>
  <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="form-control"/>
  {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
  <label for="tags">태그</label>
  <select id="tags" name="tags[]" multiple="multiple" size="4" class="form-control">
    @foreach($allTags as $tag)
      <option value="{{ $tag->id }}" {{ $article->tags->contains($tag->id) ? 'selected="selected"' : '' }}>
        {{ $tag->name }}
      </option>
    @endforeach
  </select>
  {!! $errors->first('tags', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
  <label for="content">본문</label>
  <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $article->content) }}</textarea>
  {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('files') ? 'has-error' : '' }}">
  <label for="files">파일</label>
  <input type="file" name="files[]" id="files" class="form-control-file border rounded" multiple="multiple"/>
  {!! $errors->first('files.0', '<span class="form-error">:message</span>') !!}
</div>

@section('script')
  @parent
  <script>
    $("#tags").select2({
      placeholder: '태그를선택하세요(최대3개)',
      maximumSelectionLength: 3
    });
  </script>
@stop