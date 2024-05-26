<div class="flex items-baseline gap-3">
    @if(!$editing)
    <h2 class="text-base font-medium mb-2">{{$name}}</h2>
    @else
    <input type="text" class="w-full text-sm font-medium p-1 mb-2" wire:model="name" wire:blur="toggleEditing">
    @endif
    <button class="text-sm opacity-50 hover:opacity-100" wire:click="toggleEditing">
        <i class="fa-solid fa-pen-to-square"></i>
    </button>
</div>
