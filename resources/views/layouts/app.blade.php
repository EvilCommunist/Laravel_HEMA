<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="{{ asset('assets/goldgrif.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pageTitle ?? 'Золотой Грифон' }}</title>
  
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adaptive.css') }}">
  @stack('styles')
</head>
<body>
  @include('partials.header')
  
  <main>
    @yield('content')
  </main>
  
  @include('partials.footer')
  
  @stack('scripts')
</body>
</html>