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

  <!-- Toastr.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

  <!-- Styles -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">


</head>

<body class="basic-font tracking-wide">
  <div class="min-h-screen bg-gray-100" x-data="{
    ...teamStoreModal(),
    ...teamEditModal(),
    ...projectStoreModal(),
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
    <x-modals.team-edit :selectedTeam="$selectedTeam" />
    @endif

    <x-modals.project-store />

  </div>

  <script src="https://kit.fontawesome.com/891a71c277.js" crossorigin="anonymous"></script>

  <!-- Toastr.js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  @include('layouts.flash-message')

  <script>
    const teamStoreModal = () => {
      return {
        teamStoreModalOpened: false,
        toggleTeamStoreModal() {
          this.teamStoreModalOpened = !this.teamStoreModalOpened
        },
      }
    }

    const teamEditModal = () => {
      return {
        teamEditModalOpened: false,
        toggleTeamEditModal() {
          this.teamEditModalOpened = !this.teamEditModalOpened
        },
      }
    }

    const projectStoreModal = () => {
      return {
        projectStoreModalOpened: false,
        toggleProjectStoreModal() {
          this.projectStoreModalOpened = !this.projectStoreModalOpened
        },
      }
    }
  </script>
</body>

</html>
