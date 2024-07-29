<div>
    <button class="opacity-30 text-sm hover:opacity-100 hover:text-red-500" wire:click="confirmDelete">
        <i class="fa-regular fa-trash-can"></i>
    </button>

    @if($showModal)
    <div class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50" wire:click="confirmDelete"></div>
    <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium">プロジェクトの削除</h3>
            <button class="text-lg" wire:click="confirmDelete">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="mt-3">
            <div>
                <form x-data="{ isDisabled: false }" @submit="isDisabled = true" action="{{route('projects.destroy', $project)}}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="flex flex-col">
                        <p class="max-w-60 overflow-x-auto text-nowrap font-semibold">{{$project->name}}</p>
                        @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                        <div class="flex justify-between items-center gap-5">
                            <p class="text-sm mt-3">このプロジェクトを削除しますか？</p>
                            <button type="submit" :disabled="isDisabled" class="bg-red-500 text-white text-sm mt-3 p-1 rounded self-end">削除</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>
