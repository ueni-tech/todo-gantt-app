<div class="hidden transition" :class="{'hidden': !teamEditModalOpened}">
  <div @click="toggleTeamEditModal()" class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50"></div>
  <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
    <div class="flex justify-between items-center">
      <h3 class="text-lg font-medium">チームの編集</h3>
      <button @click="toggleTeamEditModal()" class="text-lg">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="mt-3">
      <div class="flex flex-col">
        <form action="{{route('teams.update', $selectedTeam)}}" method="POST">
          @csrf
          @method('PUT')
          <div class="flex flex-col">
            <label for="team-name">チーム名</label>
            <input id="team-name" type="text" name="team_name" value="{{$selectedTeam->name}}">
            @error('name')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <button type="submit" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end">更新</button>
          </div>
        </form>
        <div class="mb-6"></div>
        <livewire:delete-team :selectedTeam="$selectedTeam" />
      </div>
    </div>
  </div>
</div>
