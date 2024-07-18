<div class="flex items-baseline gap-3">
  @if($editing)
  <form action="{{route('projects.update', $project)}}" method="POST">
    @csrf
    @method('put')
    <div class="flex items-center gap-2 mb-2">
      <input type="text" class="input w-full text-sm font-medium p-1" name="project_name" wire:model="name" wire:blur="toggleEditing">
      <button type="submit" onclick="isDisabled()" class="text-sm opacity-50 hover:opacity-100" onclick="this.disabled=true; this.form.submit();">
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
</div>

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
