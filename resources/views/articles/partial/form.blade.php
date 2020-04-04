<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
  <label for="title">{{ trans('forum.articles.form_title') }}</label>
  <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="form-control"/>
  {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
  <label for="tags">{{ trans('forum.articles.form_tags') }}</label>
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
  <label for="content">{{ trans('forum.articles.form_content') }}</label>
  <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $article->content) }}</textarea>
  {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group">
  <div class="checkbox">
    <label>
    <input type="checkbox" name="notification" value="{{ old('notification', $article->notification) }}">
      {{ trans('forum.articles.notify_me') }}
    </label>
  </div>
</div>

{{-- <div class="form-group {{ $errors->has('files') ? 'has-error' : '' }}">
  <label for="files">파일</label>
  <input type="file" name="files[]" id="files" class="form-control-file border rounded" multiple="multiple"/>
  {!! $errors->first('files.0', '<span class="form-error">:message</span>') !!}
</div> --}}

<div class="form-group">
  <label for="my-dropzone">{{ trans('forum.articles.form_files') }}
    <small class="text-muted">
      <i class="fa fa-chevron-up"></i>
      {{ trans('forum.articles.close_files') }}
    </small>
    <small class="text-muted" style="display: none;">
      <i class="fa fa-chevron-down"></i>
      {{ trans('forum.articles.open_files') }}
    </small>
  </label>

  <div id="my-dropzone" class="dropzone"></div>
</div>

@section('script')
  @parent
  <script>    
    var form = $('form').last(),
      dropzone  = $('div.dropzone'),
      dzControl = $('label[for=my-dropzone] > small');

    /* Dropzone */
    Dropzone.autoDiscover = false;

    // 드롭존 인스턴스 생성
    var myDropzone = new Dropzone('div#my-dropzone', {
      url: '/attachments',
      paramName: 'files',
      maxFilesize: 3,
      acceptedFiles: '.{{ implode(',.', config('project.mimes')) }}',
      uploadMultiple: true,
      params: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        article_id: '{{ $article->id }}'
      },
      dictDefaultMessage: '<div class="text-center text-muted">' +
        "<h2>{{ trans('forum.articles.dz_drop') }}</h2>" +
        "<p>{{ trans('forum.articles.dz_click') }}</p></div>",
      dictFileTooBig: "{{ trans('forum.articles.dz_toobig') }}",
      dictInvalidFileType: '{{ trans('forum.articles.dz_filetyle', ['accepted' => implode(',', config('project.mimes'))]) }}',
      addRemoveLinks: true
    });

    // 파일 업로드 성공 이벤트 리스너
    myDropzone.on('successmultiple', function(file, data) {
      for (var i= 0,len=data.length; i<len; i++) {
        // 'attachments[]' 숨은 필드 추가 메서드
        handleFormElement(data[i].id);

        // 성공한 파일 애트리뷰트를 파일 인스턴스에 추가
        file[i]._id = data[i].id;
        file[i]._name = data[i].filename;
        file[i]._url = data[i].url;

        // 이미 파일일 경우 handleContent() 호출
        if (/^image/.test(data[i].mime)) {
          handleContent('content', data[i].url);
        }
      }
    });

    // 파일 삭제 이벤트 리스너
    myDropzone.on('removedfile', function(file) {
      // 사용자가 이미지를 삭제하면 UI의 DOM 레벨에서 사라진다.
      // 서버에서도 삭제해야 하므로 Ajax 요청한다.
      $.ajax({
        type: 'DELETE',
        url: '/attachments/' + file._id
      }).then(function(data) {
        handleFormElement(data.id, true);

        if (/^image/.test(data.mime)) {
          handleContent('content', data.url, true);
        }
      })
    });

    // 'attachments[]' 숨은 필드를 만들거나 제거
    var handleFormElement = function(id, remove) {
      if (remove) {
        $('input[name="attachments[]"][value="'+id+'"]').remove();

        return;
      }

      $('<input>', {
        type: 'hidden',
        name: 'attachments[]',
        class: "attachments",
        value: id
      }).appendTo(form);
    }

    // 컨텐트 영역의 캐럿 위치에 이미지 마크다운을 삽입
    var handleContent = function(objId, imgUrl, remove) {
      var caretPos = document.getElementById(objId).selectionStart;
      var content = $('#' + objId).val();
      var imgMarkdown = '![](' + imgUrl + ')';

      if (remove) {
        $('#' + objId).val(
          content.replace(imgMarkdown, '')
        );

        return;
      }

      $('#' + objId).val(
        content.substring(0, caretPos) +
        imgMarkdown + '\n' +
        content.substring(caretPos)
      );
    };

    // 드롭존의 가시성을 토글
    dzControl.on('click', function(e) {
      dropzone.fadeToggle(200);
      dzControl.fadeToggle(0);
    });

    /* select2 */
    $('#tags').select2({
      placeholder: '{{ trans('forum.articles.s2_select') }}',
      maximumSelectionLength: 3
    });
  </script>
@stop