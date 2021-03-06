<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
  <div id="app">
    @include('layouts.partial.navigation')

    <div class="d-flex flex-wrap justify-content-center align-content-center" style="height:calc(100vh - 55.05px)" id="app">
      <div class="content">        
        @include('flash::message')

        <div class="title m-b-md">
            Laravel
        </div>

        <div class="links">
          <a href="https://laravel.com/docs">Docs</a>
          <a href="https://laracasts.com">Laracasts</a>
          <a href="https://laravel-news.com">News</a>
          <a href="https://blog.laravel.com">Blog</a>
          <a href="https://nova.laravel.com">Nova</a>
          <a href="https://forge.laravel.com">Forge</a>
          <a href="https://vapor.laravel.com">Vapor</a>
          <a href="https://github.com/laravel/laravel">GitHub</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
  <script>
    window.addEventListener('load', function() {
      $('div.alert').not('.alert-important').delay(1000).fadeOut(300);
    });
  </script>
</body>
</html>
