import { fileURLToPath, URL } from 'url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
const path = require('path')

// https://vitejs.dev/config/
export default defineConfig({
  base: '',
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  //  build: {
  //   lib: {
  //     entry: path.resolve(__dirname, './src/main.js'),
  //     name: 'MyLib',
  //     fileName: (format) => `my-lib.${format}.js`
  //   },
  // }
  // build:{
  //  rollupOptions: {
  //     output: {
  //       entryFileNames: `assets/[name].js`,
  //       chunkFileNames: `assets/[name].js`,
  //       assetFileNames: `assets/[name].[ext]`
  //     }
  //   },
  // },
})
