<x-app-layout>
  <div x-data="{ activeTab: 'incomplete' }">
    <x-sidebar :teams="$teams" />
    <div class="ml-16 h-screen pt-[64px]">
      @if($current_team)
      <div class="ml-6 mt-4 flex items-baseline gap-3">
        <h2 class="text-lg font-semibold">{{$current_team->name}}</h2>
        <button class="text-sm opacity-50 hover:opacity-100" @click="toggleTeamEditModal()"><i class="fa-solid fa-pen-to-square"></i></button>
      </div>

      <div class="w-[95%] mx-auto py-4 overflow-x-auto hidden-scrollbar hidden-scrollbar::-webkit-scrollbar" x-cloak>
        <div class="flex border-b mb-4">
          @foreach(['incomplete', 'pending', 'completed'] as $status)
          <button @click="activeTab = '{{ $status }}'" :class="{ 'border-b-2 border-blue-500': activeTab === '{{ $status }}' }" class="px-4 py-2">
            @if($status === 'incomplete')
            進行中
            @elseif($status === 'pending')
            保留
            @else
            完了
            @endif
          </button>
          @endforeach
        </div>

        @foreach(['incomplete', 'pending', 'completed'] as $status)
        <div x-show="activeTab === '{{ $status }}'" class="flex justify-items-start gap-3 overflow-x-auto">
          @foreach($projects->where('status_name', $status) as $project)
          <div class="w-56 h-full py-2 px-4 bg-zinc-300 rounded">
            <livewire:edit-project :project="$project" />
            <x-tasks :project="$project" />
          </div>
          @endforeach
          @if($status === 'incomplete')
          <button @click="toggleProjectStoreModal()" class="w-8 h-8 aspect-square bg-gray-500 rounded overflow-hidden border-2 border-gray-500 flex-shrink-0">
            <span class="text-white text-xl flex justify-center items-center w-full h-full">
              <i class="fa-solid fa-plus"></i>
            </span>
          </button>
          @endif
        </div>
        @endforeach


      </div>
      @endif
    </div>
  </div>
</x-app-layout>
