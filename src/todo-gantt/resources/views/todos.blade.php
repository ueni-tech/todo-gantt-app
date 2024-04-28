@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endpush

<x-app-layout>
  <x-sidebar />
  <div class="ml-16 h-screen pt-[64px]">
      <div class="w-[95%] h-full mx-auto py-6 flex justify-items-start gap-3 overflow-x-auto">
        <div class="w-56 h-full py-2 px-4 bg-zinc-300 rounded">
          <h2 class="text-base font-medium pb-2">プロジェクト名</h2>
          <ul class="todo-list-height overflow-y-auto flex flex-col gap-3 hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
            <li>
              <button class="w-full p-2 bg-neutral-100 rounded flex items-center gap-1">
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
              <button class="w-full p-2 bg-neutral-100 rounded flex items-center gap-1">
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
              <button class="w-full p-2 bg-neutral-100 rounded flex items-center gap-1">
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
              <button class="w-full p-2 bg-neutral-100 rounded flex items-center gap-1">
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
              <button class="w-full p-2 bg-neutral-100 rounded flex items-center gap-1">
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
              <button class="w-full p-2 bg-neutral-100 rounded flex items-center gap-1">
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
              <a href="" class="block bg-gray-500 w-9 aspect-square rounded">
                <span class=" text-white text-2xl flex justify-center items-center w-full h-full">
                  <i class="fa-solid fa-plus"></i>
                </span>
              </a>
            </li>
          </ul>
        </div>
        

      </div>
  </div>
</x-app-layout>