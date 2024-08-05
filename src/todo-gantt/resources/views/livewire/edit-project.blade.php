<div>
  <div class="flex items-center gap-3">
    @if($editing)
    <form x-data="{ isDisabled: false }" @submit="isDisabled = true" action="{{route('projects.update', $project)}}" method="POST">
      @csrf
      @method('put')
      <div class="flex items-center gap-2 mb-2">
        <input type="text" class="input w-full text-sm font-medium p-1" name="project_name" wire:model="name" wire:blur="toggleEditing">
        <button type="submit" :disabled="isDisabled" class="text-sm opacity-50 hover:opacity-100" onclick="this.disabled=true; this.form.submit();">
          <i class="fa-solid fa-check"></i>
        </button>
      </div>
    </form>
    @else
    <h2 class="w-full text-base font-medium mb-2 overflow-x-auto scroll-box whitespace-nowrap">{{$name}}</h2>
    <button class="text-sm opacity-50 hover:opacity-100" wire:click="toggleEditing">
      <i class="fa-solid fa-pen-to-square"></i>
    </button>
    @endif
    <div>
      <livewire:delete-project :project="$project" />
    </div>
  </div>

  <div class="flex justify-start items-center gap-1">
    <p class="text-sm">ステータス</p>
    <form action="{{route('projects.update-status', $project)}}" method="POST" id="statusForm">
      @csrf
      @method('PATCH')
      <select name="status" class="text-xs py-1 pl-2 pr-7 rounded border-none">
        <option value="incomplete" {{$project->status_name === 'incomplete' ? 'selected' : ''}}>進行中</option>
        <option value="pending" {{$project->status_name === 'pending' ? 'selected' : ''}}>保留</option>
        <option value="completed" {{$project->status_name === 'completed' ? 'selected' : ''}}>完了</option>
      </select>
      <button type="submit" class="text-xs bg-gray-500 text-white p-1 rounded shadow-sm">変更</button>
    </form>
  </div>
</div>

<script>

</script>

@script
<script>
  $wire.on('focus-input', () => {
    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        const input = document.querySelector('.input');
        if (input) {
          input.focus();
          observer.disconnect();
        }
      });
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
  });
</script>
@endscript
