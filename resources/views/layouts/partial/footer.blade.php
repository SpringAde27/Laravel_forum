<footer class="page-footer font-small navbar">
  <div class="container">
    <div class="footer-copyright py-3"> &copy; {{ date('Y') }}
      <a href="{{ config('project.url') }}">
        {{ config('project.name') }}
      </a>
    </div>

    <ul class="d-inline-flex list-inline pull-right mb-0">
      <li class=""><i class="fa fa-language"></i></li>
      <li class="active px-2">한국어</li>
      <li class="">English</li>
    </ul>
  </div>
</footer>