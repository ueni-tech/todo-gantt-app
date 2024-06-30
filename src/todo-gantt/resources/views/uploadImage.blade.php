<x-app-layout>
  <div class="h-screen pt-[64px]">
    <div class="mt-4 px-12">
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
            <input type="file" id="fileInput" style="display: none;" />
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
    </div>
  </div>

  <div class="upload-imge-modal hidden">
    <div class="upload-imge-modal-outer fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50"></div>
    <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      const dropZone = document.getElementById('dropZone');
      const fileInput = document.getElementById('fileInput');
      const uploadImageModal = document.querySelector('.upload-imge-modal');

      // ドラッグオーバーイベント
      dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = 'green';
      });

      // ドラッグリーブイベント
      dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#ccc';
      });

      // ドロップイベント
      dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#ccc';

        const files = e.dataTransfer.files;
        if (files.length > 0) {
          handleFiles(files);
        }

        console.log('drop!!');
        uploadImageModal.style.display = 'block';
      });

      // ドロップゾーンクリックイベント
      dropZone.addEventListener('click', (e) => {
        fileInput.click();
      });

      // ファイルインプット変更イベント
      fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        if (files.length > 0) {
          handleFiles(files);
        }
      });

      function handleFiles(files) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = (e) => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100%';
            img.style.height = 'auto';
            dropZone.innerHTML = '';
            dropZone.appendChild(img);
          };
          reader.readAsDataURL(file);
        } else {
          alert('画像ファイルを選択してください');
        }
      }
    });
  </script>
</x-app-layout>
