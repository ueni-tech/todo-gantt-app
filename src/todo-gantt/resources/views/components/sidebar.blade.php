<div>
  <div class="fixed min-h-screen top-[64px] left-0 bg-primary-500 w-16 pt-2">
    <div class="flex flex-col justify-start items-center gap-4">
      @foreach($teams as $team)
      <a href="{{route('teams.change', $team)}}" class="w-3/4 rounded-lg overflow-hidden border-2 border-gray-500">
        <img src="{{ asset('img/team_icon_01.jpg') }}" alt="">
      </a>
      @endforeach
      <button @click="toggleTeamStoreModal()" class="w-3/4 aspect-square bg-gray-500 rounded-lg overflow-hidden border-2 border-gray-500">
        <span class="text-white text-3xl flex justify-center items-center w-full h-full">
          <i class="fa-solid fa-plus"></i>
        </span>
      </button>
    </div>
  </div>
</div>
