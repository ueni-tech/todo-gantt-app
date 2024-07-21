<div>
    <div>
        <div>
            <input type="checkbox" id="delete-team" wire:click="toggleConfirmDeletion" value="{{$confirmDeletion}}" class="w-3 h-3">
            <label for="delete-team" class="text-xs">チームを削除する</label>
        </div>
        @if($confirmDeletion)
        <div class="flex justify-between items-center mt-2">
            <p class="text-xs text-red-500">この操作は取り消せません</p>
            <form x-data="{ isDisabled: false }" @submit="isDisabled = true" action="{{ route('teams.destroy', $selectedTeam) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" :disabled="isDisabled" class="bg-red-500 text-white text-xs p-1 rounded self-end">削除</button>
            </form>
        </div>
        @endif
    </div>
</div>
