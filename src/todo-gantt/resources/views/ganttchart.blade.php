<x-app-layout>
  <x-sidebar :teams="$teams" />
  <div class="ml-16 pt-[64px] overflow-auto">
    <div id="gantt-container">
      <div id="task-list"></div>
      <div id="gantt"></div>
    </div>

    @push('styles')
    @vite(['resources/css/frappgantt.css'])
    @endpush
    
    @push('scripts')
    @vite(['resources/js/frappgantt.js'])
    @endpush
  </div>
</x-app-layout>
