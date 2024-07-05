<x-app-layout>
  <div class="h-screen pt-[64px]">
    <div class="mt-4 px-12">
      <form action="{{route('upload-image.update', $team)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h3 class="text-lg font-medium">チームアイコンの編集</h3>
        <div class="flex justify-start items-start gap-24 mt-6">
          <div>
            <h4>現在のアイコン</h4>
            <div class="w-72 mt-3">
              @if($team->image_name)
              <img class="w-full" src="{{ asset('storage/team_images/'.$team->image_name) }}" alt="チームアイコン">
              @else
              <img class="w-full" src="https://ui-avatars.com/api/?name={{$team->name}}&background=999&color=eee&bold=true&length=1" alt="">
              @endif
            </div>
          </div>
          <div>
            <h4>変更後のアイコン</h4>
            <div class="mt-3">
              <input type="file" id="fileInput" style="display: none;" name="image_name" />
              <div id="dropZone" class="w-72 h-72 flex justify-center items-center border-2 border-gray-300 border-dashed rounded-lg cursor-pointer">
                ここをクリック<br>または<br>画像をドロップ
              </div>
            </div>
          </div>
        </div>
        <div class="flex justify-start items-center gap-4 mt-6">
          <button type="submit" class="bg-primary-500 text-white text-base px-2 py-1 rounded shadow-md">更新</button>
          <a class="text-gray-500" href="{{ route('index')}}">戻る</a>
        </div>
      </form>
    </div>
  </div>

  <div class="upload-imge-modal hidden">
    <div class="upload-imge-modal-close fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50"></div>
    <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
      <div class="uploadFile w-[80vw] h-[80vh]">
        <img id="image" src="" alt="">
      </div>
      <div class="flex justify-center items-center gap-4 mt-4">
        <button class="crop-btn bg-primary-500 text-white text-base px-2 py-1 rounded shadow-md">トリミング</button>
        <button class="upload-imge-modal-close bg-gray-500 text-white text-base px-2 py-1 rounded shadow-md">キャンセル</button>
      </div>
    </div>

    @push('scripts')
    @vite(['resources/js/cropper.js'])
    @endpush
</x-app-layout>