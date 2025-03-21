// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/styles.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    hmr: {
      overlay: false, // Disable error overlay
    },
  },
});
