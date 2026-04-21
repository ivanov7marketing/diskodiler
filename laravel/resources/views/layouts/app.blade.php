<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'ДискоДилер')</title>
  <meta name="description" content="@yield('description', '')">
  @if (config('app.prevent_indexing'))
    <meta name="robots" content="noindex,nofollow">
  @else
    @hasSection('robots')
      <meta name="robots" content="@yield('robots')">
    @endif
  @endif
  @hasSection('canonical')
    <link rel="canonical" href="@yield('canonical')">
  @endif
  <link rel="icon" href="{{ asset('assets/img/logo.webp') }}" type="image/webp">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
  @stack('head')
</head>
<body data-page="@yield('page', 'home')">
  <div class="page">
    <div data-shared-header></div>
    @yield('content')
    <div data-shared-footer></div>
  </div>
  <div data-shared-floating></div>
  <div data-shared-modals></div>
  <script>
    window.DISKODILER_PATH_PREFIX = "/";
    window.DISKODILER_LEADS_ENDPOINT = "{{ route('leads.store') }}";
  </script>
  <script src="{{ asset('assets/js/app.js') }}" defer></script>
</body>
</html>
