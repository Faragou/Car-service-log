import { createApp } from 'vue'
import '@/index.css'
import Toast, { POSITION } from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import App from './App.vue'
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";


const app = createApp(App);


app.use(Toast, {
    position: POSITION.TOP_RIGHT,
    timeout: 5000,
});
app.mount('#app')
