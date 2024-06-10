<x-app-layout>
  <div x-data="{
    todoModalOpened : false,
    toggleTodoModal(){this.todoModalOpened = !this.todoModalOpened},
  }">

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
          <ul class="todo-list-height overflow-y-auto flex flex-col gap-3 hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
            <li>
              <button @click="toggleTodoModal()" class="w-full p-2 bg-neutral-100 rounded flex items-center gap-1">
                <span class="opacity-30 hover:opacity-100">
                  <i class="fa-regular fa-square-check"></i>
                </span>
                <span class="text-sm text-neutral-600 truncate">タスク名タスク名タスク名タスク名</span>
                <span class="opacity-30  text-xs hover:opacity-100 hover:text-red-500">
                  <i class="fa-regular fa-trash-can"></i>
                </span>
              </button>
            </li>

            <li>
              <div class="flex justify-between items-center">
                <a href="" class="block bg-gray-500 w-8 aspect-square rounded">
                  <span class=" text-white text-xl flex justify-center items-center w-full h-full">
                    <i class="fa-solid fa-plus"></i>
                  </span>
                </a>
                <livewire:delete-project :project="$project" />
              </div>
            </li>
          </ul>
        </div>
        @endforeach

        <button @click="toggleProjectStoreModal()" class="w-8 h-8 aspect-square bg-gray-500 rounded overflow-hidden border-2 border-gray-500">
          <span class="text-white text-xl flex justify-center items-center w-full h-full">
            <i class="fa-solid fa-plus"></i>
          </span>
        </button>

      </div>
      <div class="hidden transition" :class="{'hidden': !todoModalOpened}">
        <div @click="toggleTodoModal()" class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50"></div>
        <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium">タスクの編集</h3>
            <button @click="toggleTodoModal()" class="text-lg">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
          <div class="mt-3">
            <livewire:Pages.edit-todo />
          </div>
        </div>
      </div>

    </div>
  </div>
</x-app-layout>
