import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/cropper.js',
        'resources/sass/frappgantt.scss',
        'resources/js/frappgantt.js',
      ],
      refresh: true,
    }),
  ],
  server: {
    host: true,
    hmr: {
      host: 'localhost'
    },
    watch: {
      usePolling: true
    }
  }
});
