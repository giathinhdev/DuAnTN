import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.jsx',
      ],
      refresh: true,
    }),
    react(),
  ],
  server: {
    host: 'localhost',
    port: 3000,
  },
  resolve: {
    alias: {
      '@': '/resources/js',
    },
  },
  publicDir: 'public',
});