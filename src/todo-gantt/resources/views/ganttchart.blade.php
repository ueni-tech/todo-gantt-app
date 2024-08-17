<x-app-layout>
  <x-sidebar :teams="$teams" />
  <div class="ganttcharts ml-16 pt-[64px] overflow-auto">
    <div class="ganttcharts_container">
      <div class="task-list"></div>
      <div id="gantt" class="gantt"></div>
    </div>

    @push('styles')
    @vite(['resources/sass/frappgantt.scss'])
    @endpush
    
    @push('scripts')
    @vite(['resources/js/frappgantt.js'])
    @endpush
  </div>
</x-app-layout>
