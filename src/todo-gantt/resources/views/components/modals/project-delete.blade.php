<div class="hidden transition" :class="{'hidden': !projectDeleteModalOpened}">
  <div @click="toggleProjectDeleteModal()" class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50 z-[1]"></div>
  <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[2]">
    <div class="flex justify-between items-center">
      <h3 class="text-lg font-medium">プロジェクトの削除</h3>
      <button @click="toggleProjectDeleteModal()" class="text-lg">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="mt-3">
      <div class="flex flex-col">
        <form x-data="{ isDisabled: false }" @submit="isDisabled = true" action="{{route('projects.destroy', $project)}}" method="POST">
          @csrf
          @method('delete')
          <div class="flex flex-col">
            <label for="project-name">プロジェクト名</label>
            <p>{{$project->name}}</p>
            @error('name')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <button type="submit" :disabled="isDisabled" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end">作成</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
