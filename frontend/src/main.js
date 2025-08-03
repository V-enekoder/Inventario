import { createApp } from "vue";
import { createPinia } from "pinia"; // <-- Importa Pinia
import App from "./App.vue";
import router from "./router";

const app = createApp(App);

app.use(createPinia()); // <-- Usa Pinia
app.use(router);

app.mount("#app");
