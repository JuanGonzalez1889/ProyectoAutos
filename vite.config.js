import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  server: {
    host: "0.0.0.0",
    port: 5174,
    strictPort: true,
    hmr: {
      host: "localhost",
      protocol: "ws", // Usa WebSocket simple para evitar conflictos de SSL en HMR
    },
  },
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
    }),
  ],
});
