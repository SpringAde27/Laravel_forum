<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- SEO -->
  <meta name="description" content="{{ config('project.description') }}">

  <!-- Facebook Meta -->
  <meta property="og:title" content="{{ config('project.name') }}">
  <meta property="og:image" content="">
  <meta property="og:type" content="Website">
  <meta property="og:author" content="">

  <!-- Google Meta -->
  <meta itemprop="name" content="">
  <meta itemprop="description" content="{{ config('project.description') }}">
  <meta itemprop="image" content="">
  <meta itemprop="author" content=""/>

  <!-- Twitter Meta-->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="">
  <meta name="twitter:title" content="{{ config('project.name') }}">
  <meta name="twitter:description" content="{{ config('project.description') }}">
  <meta name="twitter:image" content="">
  <meta name="twitter:domain" content="{{ config('project.url') }}">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('project.name', 'Laravel') }}</title>

  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" /> --}}

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  
  @yield('style')
  
  <script>
    window.Laravel = <?php echo 
      json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
  </script>
</head>

<body>
  <div id="app">
    @include('layouts.partial.navigation')

    <main class="py-4">
        @include('flash::message')
        @yield('content')
    </main>

    @include('layouts.partial.footer')
  </div>

  <!-- scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
  <script>
    window.addEventListener('load', function() {
      $('div.alert').not('.alert-important').delay(1000).fadeOut(300);
    });
  </script>
  @yield('script')
</body>
</html>