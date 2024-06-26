<div>
    <button wire:click="toggleTaskStoreModal" class="w-8 h-8 aspect-square bg-gray-500 rounded overflow-hidden border-2 border-gray-500">
        <span class="text-white text-xl flex justify-center items-center w-full h-full">
            <i class="fa-solid fa-plus"></i>
        </span>
    </button>

    @if($showModal)
    <div class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50" wire:click="toggleTaskStoreModal"></div>
    <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium">タスクの作成</h3>
            <button class="text-lg" wire:click="toggleTaskStoreModal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="mt-3">
            <div>
                <form action="{{route('tasks.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div class="flex flex-col">
                        <label for="task-name">タスク名</label>
                        <input id="task-name" type="text" name="name">
                    </div>
                    <div class="flex flex-col">
                        <label for="task-start-date">開始日</label>
                        <input id="task-start-date" type="date" name="start_date">
                    </div>
                    <div class="flex flex-col">
                        <label for="task-end-date">終了日</label>
                        <input id="task-end-date" type="date" name="end_date">
                    </div>
                    <div class="flex flex-col">
                        <label for="task-note">メモ</label>
                        <textarea id="task-note" name="note"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white text-sm mt-3 p-1 rounded self-end">更新</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
