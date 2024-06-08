<div>
    <ul class="todo-list-height overflow-y-auto flex flex-col gap-3 hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
        @foreach($tasks as $task)
        {{--
        <li>
            <button @click="toggleTaskEditModal()" class="w-full p-2 bg-neutral-100 rounded flex items-center gap-1">
                <span class="opacity-30 hover:opacity-100">
                    <i class="fa-regular fa-square-check"></i>
                </span>
                <span class="text-sm text-neutral-600 truncate">{{$task->name}}</span>
                <span class="opacity-30  text-xs hover:opacity-100 hover:text-red-500">
                    <i class="fa-regular fa-trash-can"></i>
                </span>
            </button>
        </li>
        --}}
        <livewire:task :task="$task" :key="$task->id" />
        @endforeach
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
