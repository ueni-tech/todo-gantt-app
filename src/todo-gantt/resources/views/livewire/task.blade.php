<div>
  <button wire:click="toggleTaskEditModal" class="w-full p-2 bg-neutral-100 rounded">

    <div class="flex justify-between items-center gap-1">
      <div class="flex justify-start items-center gap-2 overflow-x-hidden">
        @if(!$completed)
        <span wire:click.stop="toggleCompleted" class="opacity-30 hover:opacity-100">
          <i class="fa-regular fa-square"></i>
        </span>
        <div class="overflow-x-hidden text-start">
          @if($task->start_date || $task->end_date)
          <div class="text-xs text-neutral-900 truncate">
            {{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->formatLocalized('%-m/%-d') : '' }} ～
            {{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->formatLocalized('%-m/%-d') : '' }}
          </div>
          @endif
          <div class="text-sm text-neutral-600 truncate">{{$task->name}}</div>
        </div>
        @else
        <span wire:click.stop="toggleCompleted" class="opacity-30 hover:opacity-100">
          <i class="fa-regular fa-check-square"></i>
        </span>
        <div class="overflow-x-hidden text-start">
          @if($task->start_date || $task->end_date)
          <div class="text-xs text-neutral-400 truncate line-through">
            {{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->formatLocalized('%-m/%-d') : '' }} ～
            {{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->formatLocalized('%-m/%-d') : '' }}
          </div>
          @endif
          <div class="text-sm text-neutral-400 line-through truncate">{{$task->name}}</div>
        </div>
        @endif
      </div>
      <span wire:click.stop="toggleTaskDeleteModal" class="opacity-30  text-xs hover:opacity-100 hover:text-red-500">
        <i class="fa-regular fa-trash-can"></i>
      </span>
    </div>
  </button>

  @if($showEditModal)
  <div class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50 z-[1]" wire:click="toggleTaskEditModal"></div>
  <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50">
    <div class="flex justify-between items-center">
      <h3 class="text-lg font-medium">タスクの編集</h3>
      <button class="text-lg" wire:click="toggleTaskEditModal">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="mt-3">
      <div>
        <form x-data="{ isDisabled: false }" @submit="isDisabled = true" action="{{route('tasks.update', $task)}}" method="POST">
          @csrf
          @method('put')
          <div class="flex flex-col">
            <label for="task-name">タスク名</label>
            <input id="task-name" type="text" name="task_name" wire:model.live.debounce.150ms="task_name">
            @error('task_name')
            <p class="text-red-500 text-xs">{{$message}}</p>
            @enderror
          </div>
          <div class="flex flex-col">
            <label for="task-start-date">開始日</label>
            <input id="task-start-date" type="date" name="start_date" wire:model.live="start_date">
            @error('start_date')
            <p class="text-red-500 text-xs">{{$message}}</p>
            @enderror
          </div>
          <div class="flex flex-col">
            <label for="task-end-date">終了日</label>
            <input id="task-end-date" type="date" name="end_date" wire:model.live="end_date">
            @error('end_date')
            <p class="text-red-500 text-xs">{{$message}}</p>
            @enderror
          </div>
          <div class="flex flex-col">
            <label for="task-note">メモ</label>
            <textarea id="task-note" name="note" wire:model.live="note"></textarea>
            @error('note')
            <p class="text-red-500 text-xs">{{$message}}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            @if($task_name && !$errors->any())
            <button type="submit" :disabled="isDisabled" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end" onclick="this.disabled=true; this.form.submit();">更新</button>
            @else
            <button type="submit" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end opacity-30" disabled>更新</button>
            @endif
          </div>
        </form>
      </div>
    </div>
    @endif

    @if($showDeleteModal)
    <div class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50 z-[1]" wire:click="toggleTaskDeleteModal"></div>
    <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50">
      <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium">タスクの削除</h3>
        <button class="text-lg" wire:click="toggleTaskDeleteModal">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="mt-3">
        <div>
          <form x-data="{ isDisabled: false }" @submit="isDisabled = true" action="{{route('tasks.destroy', $task)}}" method="POST">
            @csrf
            @method('delete')
            <div class="flex flex-col">
              <p class="max-w-60 overflow-x-auto text-nowrap font-semibold">{{$task->name}}</p>
              @error('name')
              <span class="text-red-500 text-xs">{{ $message }}</span>
              @enderror
              <div class="flex justify-between items-center gap-5">
                <p class="text-sm mt-3">このタスクを削除しますか？</p>
                <button type="submit" :disabled="isDisabled" class="bg-red-500 text-white text-sm mt-3 p-1 rounded self-end">削除</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endif
  </div>
