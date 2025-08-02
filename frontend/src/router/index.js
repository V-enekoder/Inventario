// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import ProductsView from "../views/ProductsView.vue";
import CategoriesView from "../views/CategoriesView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/products", // <-- AÑADE LA RUTA
    name: "products",
    component: ProductsView,
  },
  {
    path: "/categories", // <-- AÑADE LA RUTA
    name: "categories",
    component: CategoriesView,
  },
  // ... otras rutas como 'about'
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
