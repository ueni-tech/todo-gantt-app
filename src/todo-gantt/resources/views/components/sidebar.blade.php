<div>
  <div class="fixed min-h-screen top-[64px] left-0 bg-primary-500 w-16 pt-2">
    <div class="flex flex-col justify-start items-center gap-4">
      @foreach($teams as $team)
      @if($team->id == auth()->user()->selected_team_id)
      <a href="{{route('teams.change', $team)}}" class="w-12 h-12 flex justify-center items-center bg-gray-400 rounded-lg overflow-hidden border-2 p-[2px] border-white">
        @if(!$team->image_name)
        <img src="https://ui-avatars.com/api/?name={{$team->name}}&background=999&color=eee&bold=true&length=1" alt="">
        @else
        <img src="{{asset('/storage/team_images/' . $team->image_name)}}" alt="">
        @endif
      </a>
      @else
      <a href="{{route('teams.change', $team)}}" class="w-12 h-12 flex justify-center items-center bg-gray-400 rounded-lg overflow-hidden">
        @if(!$team->image_name)
        <img src="https://ui-avatars.com/api/?name={{$team->name}}&background=999&color=eee&bold=true&length=1" alt="">
        @else
        <img src="{{asset('/storage/team_images/' . $team->image_name)}}" alt="">
        @endif
      </a>
      @endif
      @endforeach
      <button @click="toggleTeamStoreModal()" class="w-12 h-12 aspect-square bg-gray-500 rounded-lg overflow-hidden border-2 border-gray-500">
        <span class="text-white text-3xl flex justify-center items-center w-full h-full">
          <i class="fa-solid fa-plus"></i>
        </span>
      </button>
    </div>
  </div>
</div>