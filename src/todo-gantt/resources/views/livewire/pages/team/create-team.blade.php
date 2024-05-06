<div>
    <div class="flex flex-col">
        <form wire:submit.prevent="createTeam">
            <div class="flex flex-col">
                <label for="task-name">チーム名</label>
                <input type="text" wire:model.live.debounce="name">
                @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                @if($errors->has('name') || $isButtonDisabled) 
                <button type="submit" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end opacity-50" disabled>作成</button>
                @else
                <button type="submit" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end">作成</button>
                @endif
            </div>
        </form>
    </div>
</div>
