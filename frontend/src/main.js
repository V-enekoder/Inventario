// src/main.js (VERSIÓN CORRECTA)

import { createApp } from "vue";
import App from "./App.vue";
import router from "./router"; // <-- PASO 1: Importa tu router

// PASO 2: Usa el router en la aplicación ANTES de montarla
createApp(App).use(router).mount("#app");
