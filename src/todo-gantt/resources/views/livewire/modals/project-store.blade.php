<div class="hidden transition" :class="{'hidden': !projectStoreModalOpened}">
  <div wire:click="resetModal" @click="toggleProjectStoreModal()" class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50 z-[1]"></div>
  <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[2]">
    <div class="flex justify-between items-center">
      <h3 class="text-lg font-medium">プロジェクトの作成</h3>
      <button wire:click="resetModal" @click="toggleProjectStoreModal()" class="text-lg">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="mt-3">
      <div class="flex flex-col">
        <form x-data="{ isDisabled: false }" @submit="isDisabled = true" action="{{route('projects.store')}}" method="POST">
          @csrf
          <div class="flex flex-col">
            <label for="project-name">プロジェクト名</label>
            <input id="project-name" type="text" wire:model.live.debounce.150ms="project_name" name="project_name">
            @if($errors->any())
            @foreach($errors->all() as $error)
            <p class="text-red-500 text-xs">{{$error}}</p>
            @endforeach
            @endif

            @if($project_name && !$errors->any())
            <button type="submit" :disabled="isDisabled" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end">作成</button>
            @else
            <button type="submit" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end opacity-30" disabled>作成</button>
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
