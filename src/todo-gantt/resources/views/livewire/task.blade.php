<div>
    <button wire:click="toggleTaskEditModal" class="w-full p-2 bg-neutral-100 rounded flex justify-between items-center gap-1">
        <div>
            <span class="opacity-30 hover:opacity-100">
                <i class="fa-regular fa-square-check"></i>
            </span>
            <span class="text-sm text-neutral-600 truncate">{{$task->name}}</span>
        </div>
        <span class="opacity-30  text-xs hover:opacity-100 hover:text-red-500">
            <i class="fa-regular fa-trash-can"></i>
        </span>
    </button>

    @if($showModal)
    <div class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50" wire:click="toggleTaskEditModal"></div>
    <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium">タスクの編集</h3>
            <button class="text-lg" wire:click="toggleTaskEditModal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="mt-3">
            <div>
                <form action="{{route('tasks.update', $task)}}" method="POST">
                    @csrf
                    @method('put')
                    <div class="flex flex-col">
                        <label for="task-name">タスク名</label>
                        <input id="task-name" type="text" name="name" value="{{$task->name}}">
                    </div>
                    <div class="flex flex-col">
                        <label for="task-start-date">開始日</label>
                        <input id="task-start-date" type="date" name="start_date" value="{{$task->start_date}}" >
                    </div>
                    <div class="flex flex-col">
                        <label for="task-end-date">終了日</label>
                        <input id="task-end-date" type="date" name="end_date" value="{{$task->end_date}}">
                    </div>
                    <div class="flex flex-col">
                        <label for="task-note">メモ</label>
                        <textarea id="task-note" name="note">{{$task->note}}</textarea>
                    </div>
                    @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white text-sm mt-3 p-1 rounded self-end">更新</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
