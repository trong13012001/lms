import { createApp } from 'vue';
import upload from './components/upload.vue'

const app = createApp();

app.component('upload-file', upload)

app.mount('#lms-app')
