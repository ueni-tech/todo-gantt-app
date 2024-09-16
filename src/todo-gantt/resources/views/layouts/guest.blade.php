<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" href="{{ asset(config('app.favicon')) }}" type="image/x-icon">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

</head>

<body class="font-sans text-gray-900 antialiased">
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-primary-300">
    <div>
      <a href="/" wire:navigate>
        <h1 class="text-4xl font-bold text-emerald-900 bg-neutral-100 py-2 px-3 rounded">Todo-Gannt</h1>
      </a>
    </div>

    <div class="mt-8">
      {{ $slot }}
    </div>

    <div class="mt-8">
      <x-guestLogin />
    </div>
  </div>

  @if(session('just_logged_out'))
  <script>
    window.history.pushState(null, '', '/login');
    window.onpopstate = function() {
      window.location.href = '/login';
    };
  </script>
  @endif
</body>

</html>
