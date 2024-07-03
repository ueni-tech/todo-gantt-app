import Cropper from 'cropperjs';

document.addEventListener('DOMContentLoaded', (event) => {
  const dropZone = document.getElementById('dropZone');
  const fileInput = document.getElementById('fileInput');
  const uploadImageModal = document.querySelector('.upload-imge-modal');
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
        });

        uploadImageModal.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      alert('画像ファイルを選択してください');
    }
  }
});