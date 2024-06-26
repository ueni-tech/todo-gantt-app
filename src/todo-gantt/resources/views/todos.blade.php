<x-app-layout>
  <div>

    <x-sidebar :teams="$teams" />
    <div class="ml-16 h-screen pt-[64px]">
      @if($current_team)
      <div class="ml-6 mt-4 flex items-baseline gap-3">
        <h2 class="text-lg font-semibold">{{$current_team->name}}</h2>
        <button class="text-sm opacity-50 hover:opacity-100" @click="toggleTeamEditModal()"><i class="fa-solid fa-pen-to-square"></i></button>
      </div>
      @endif
      <div class="w-[95%] mx-auto py-4 flex justify-items-start gap-3 overflow-x-auto">
        @foreach($projects as $project)
        <div class="w-56 h-full py-2 px-4 bg-zinc-300 rounded">
          <livewire:edit-project :project="$project" />
          <x-tasks :project="$project" />
        </div>
        @endforeach

        <button @click="toggleProjectStoreModal()" class="w-8 h-8 aspect-square bg-gray-500 rounded overflow-hidden border-2 border-gray-500">
          <span class="text-white text-xl flex justify-center items-center w-full h-full">
            <i class="fa-solid fa-plus"></i>
          </span>
        </button>

      </div>
    </div>
  </div>
</x-app-layout>
