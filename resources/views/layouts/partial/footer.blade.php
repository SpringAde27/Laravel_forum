<footer class="page-footer font-small navbar">
  <div class="container">
    <div class="footer-copyright py-3"> &copy; {{ date('Y') }}
      <a href="{{ config('project.url') }}">
        {{ config('project.name') }}
      </a>
    </div>

    <ul class="d-inline-flex list-inline pull-right mb-0">
      <li class=""><i class="fa fa-language"></i></li>
      @foreach (config('project.locales') as $locale => $language)
      <li {!! ($locale == $currentLocale ) ? 'class="active"' : '' !!}>
        <a href="{{ route('locale', ['locale' => $locale, 'return' => urlencode($currentUrl)]) }}">
          {{ $language }}
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</footer>