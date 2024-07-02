import Cropper from 'cropperjs';

document.addEventListener('DOMContentLoaded', function () {
  const image = document.getElementById('image');
  const cropper = new Cropper(image);
});
