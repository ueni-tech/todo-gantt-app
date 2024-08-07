import Cropper from 'cropperjs';

document.addEventListener('DOMContentLoaded', (event) => {
  const dropZone = document.getElementById('dropZone');
  const fileInput = document.getElementById('fileInput');
  const hiddenInput = document.getElementById('hiddenInput');
  const uploadImageModal = document.querySelector('.upload-imge-modal');
  const uploadImageModalClose = document.querySelectorAll('.upload-imge-modal-close');
  const cropBtn = document.querySelector('.crop-btn');
  let cropper;

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = 'green';
  });

  dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = '#ccc';
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = '#ccc';

    const files = e.dataTransfer.files;
    if (files.length > 0) {
      handleFiles(files);
    }
  });

  dropZone.addEventListener('click', (e) => {
    fileInput.click();
  });

  fileInput.addEventListener('change', (e) => {
    const files = e.target.files;
    if (files.length > 0) {
      handleFiles(files);
    }
  });

  uploadImageModalClose.forEach((element) => {
    element.addEventListener('click', () => {
      uploadImageModal.style.display = 'none';
    });
  });

  function handleFiles(files) {
    const file = files[0];
    if (file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = (e) => {
        let image = document.getElementById('image');
        image.src = e.target.result;
        image.style.width = '100%';
        image.style.height = 'auto';

        if (cropper) {
          cropper.destroy();
        }
        cropper = new Cropper(image, {
          aspectRatio: 1,
          viewMode: 2,
          dragMode: 'move',
        });

        uploadImageModal.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      alert('画像ファイルを選択してください');
    }
  }

  cropBtn.addEventListener('click', () => {
    const canvas = cropper.getCroppedCanvas();
    canvas.toBlob(function (blob) {
      const url = URL.createObjectURL(blob);
      const reader = new FileReader();
      reader.readAsDataURL(blob);
      reader.onloadend = function () {
        const base64data = reader.result;
        hiddenInput.value = base64data;
      }
      const img = document.createElement('img');
      img.src = url;
      img.style.width = '100%';
      img.style.height = 'auto';
      dropZone.innerHTML = '';
      dropZone.appendChild(img);

      cropper.destroy();
    });


    uploadImageModal.style.display = 'none';
  });

});
