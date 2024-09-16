<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')

  <!-- Toastr.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

  <!-- Styles -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">


</head>

<body class="basic-font tracking-wide">
  <div class="min-h-screen bg-gray-100" x-data="{
  teamStoreModalOpened: false,
  teamEditModalOpened: false,
  projectStoreModalOpened: false,
  toggleTeamStoreModal() { this.teamStoreModalOpened = !this.teamStoreModalOpened },
  toggleTeamEditModal() { this.teamEditModalOpened = !this.teamEditModalOpened },
  toggleProjectStoreModal() { this.projectStoreModalOpened = !this.projectStoreModalOpened }
}">
    <livewire:layout.navigation />

    <!-- Page Heading -->
    @if (isset($header))
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
    </header>
    @endif

    <!-- Page Content -->
    <main>
      {{ $slot }}
    </main>

    <livewire:modals.team-store />

    @if($selectedTeam)
    <livewire:modals.team-edit :selectedTeam="$selectedTeam" />
    @endif

    <livewire:modals.project-store />

  </div>

  @stack('scripts')
  <script src="https://kit.fontawesome.com/891a71c277.js" crossorigin="anonymous"></script>

  <!-- Toastr.js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jdenticon@3.1.1/dist/jdenticon.min.js" integrity="sha384-l0/0sn63N3mskDgRYJZA6Mogihu0VY3CusdLMiwpJ9LFPklOARUcOiWEIGGmFELx" crossorigin="anonymous"></script>
  <script src="{{asset('/js/main.js')}}"></script>
  @include('layouts.flash-message')

  <script>
    window.addEventListener('clearBrowserHistory', event => {
      window.history.pushState(null, '', '/login');
    });
  </script>
</body>

</html>
