<x-app-layout>
  <div class="ml-16 h-screen pt-[64px]">
    @if($team->image_name)
    <img src="{{ asset('storage/team_images/'.$team->image_name) }}" alt="チームアイコン">
    @else
    <img src="https://ui-avatars.com/api/?name={{$team->name}}&background=999&color=eee&bold=true&length=1" alt="">
    @endif
    <a href="{{ route('index')}}">戻る</a>
  </div>
</x-app-layout>