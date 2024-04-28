<x-app-layout>
  <x-sidebar />
  <div class="ml-16 pt-[64px]">
    <div class="w-full">
      <div class="w-11/12 mx-auto py-6 flex flex-wrap gap-x-3 gap-y-6">
        <div class="w-[24%] h-64 py-2 px-4 bg-zinc-300 rounded">
          <h2 class="text-base font-medium pb-2">プロジェクト名</h2>
          <ul class="flex flex-col gap-3 h-[85%] overflow-y-auto hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
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
  </div>
</x-app-layout>