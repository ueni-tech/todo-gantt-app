<div class="hidden transition" :class="{'hidden': !teamEditModalOpened}">
  <div wire:click="resetModal" @click="toggleTeamEditModal()" class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50 z-[1]"></div>
  <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[2]">
    <div class="flex justify-between items-center">
      <h3 class="text-lg font-medium">チームの編集</h3>
      <button wire:click="resetModal" @click="toggleTeamEditModal()" class="text-lg">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="mt-3">
      <div class="flex flex-col">

        <div class="flex flex-col">
          <form x-data="{ isDisabled: false }" @submit="isDisabled = true" action="{{route('teams.update', $selectedTeam)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-2">
              <div class="flex flex-col gap-2">
                <label for=" team-name">チーム名</label>
                <input id="team-name" type="text" wire:model.live.debounce.150ms="team_name" name="team_name">
              </div>
              @if($errors->any())
              @foreach($errors->all() as $error)
              <p class="text-red-500 text-xs">{{$error}}</p>
              @endforeach
              @endif
              @if($isTeamNameChanged && $team_name && !$errors->any())
              <button type="submit" :disabled="isDisabled" class="bg-primary-500 text-white text-sm p-1 rounded self-end">更新</button>
              @else
              <button type="submit" class="bg-primary-500 text-white text-sm p-1 rounded self-end opacity-30" disabled>更新</button>
              @endif
            </div>
          </form>

          <div>
            <p>チームアイコン</p>
            <div class="flex justify-start items-baseline gap-5 mt-2">
              <div class="w-16 h-16 flex justify-center items-center">
                @if($selectedTeam->image_name)
                <img class="w-full" src="{{asset('/storage/team_images/' . $selectedTeam->image_name)}}" alt="">
                @else
                <img class="w-full" src="https://ui-avatars.com/api/?name={{$selectedTeam->name}}&background=999&color=eee&bold=true&length=1" alt="">
                @endif
              </div>
              <a class="text-primary-700" href="{{route('upload-image.edit', $selectedTeam)}}">編集</a>
            </div>
          </div>

          <div>
            <p>チームメンバー</p>
            <div class="flex flex-col gap-2 mt-2 ">
              <div class="bg-white rounded p-2 border border-gray-500 h-20 overflow-y-auto">
                @foreach($selectedTeam->users as $user)
                <div class="flex justify-between items-center">
                  <p>{{$user->name}}</p>
                  @if($user->id !== auth()->user()->id)
                  <button type="button" onclick="confirmRemoveUser({{$user->id}})" class="text-red-200 text-xs hover:text-red-500">削除</button>
                  @else
                  <button type="button" onclick="confirmRemoveUser({{$user->id}})" class="text-red-200 text-xs hover:text-red-500">退出</button>
                  @endif
                </div>
                @endforeach
              </div>
            </div>
            <div class="flex flex-col gap-2 mt-2">
              <input type="email" placeholder="メールアドレスから招待" wire:model.live.debounce="mailaddress">
              @foreach($users as $user)
              @if($user->id === auth()->user()->id)
              @continue
              @endif
              <div class="flex justify-between items-center">
                <p>{{$user->name}}</p>
                <button type="button" wire:click="addUserToTeam({{$user->id}})" class="bg-primary-500 text-white text-sm p-1 rounded self-end">招待</button>
              </div>
              @endforeach

              @if($errors->any())
              @foreach($errors->all() as $error)
              <p class="text-red-500 text-xs">{{$error}}</p>
              @endforeach
              @endif
            </div>
          </div>

        </div>
        <div class="mb-6"></div>
        <livewire:delete-team :selectedTeam="$selectedTeam" />
      </div>
    </div>
  </div>
</div>

<script>
  function confirmRemoveUser(user_id) {
    if (confirm('本当に削除しますか？')) {
      Livewire.dispatch('removeUser', {
        user_id: user_id
      })
    }
  }
</script>
