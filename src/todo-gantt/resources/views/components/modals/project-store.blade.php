<div class="hidden transition" :class="{'hidden': !projectStoreModalOpened}">
  <div @click="toggleProjectStoreModal()" class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50"></div>
  <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
    <div class="flex justify-between items-center">
      <h3 class="text-lg font-medium">プロジェクトの作成</h3>
      <button @click="toggleProjectStoreModal()" class="text-lg">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="mt-3">
      <div class="flex flex-col">
        <form action="{{route('projects.store')}}" method="post">
          @csrf
          <div class="flex flex-col">
            <label for="project-name">プロジェクト名</label>
            <input id="project-name" type="text" name="name">
            @error('name')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <button type="submit" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end">作成</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
