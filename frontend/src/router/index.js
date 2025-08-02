// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import ProductsView from "../views/ProductsView.vue";
import CategoriesView from "../views/CategoriesView.vue";
import SuppliersView from "../views/SuppliersView.vue";
import StockMovementsView from "../views/StockMovementsView.vue";

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
  {
    path: "/suppliers", // <-- AÑADE ESTA RUTA
    name: "suppliers",
    component: SuppliersView,
  },
  {
    path: "/stock-movements", // <-- AÑADE ESTA RUTA
    name: "stock-movements",
    component: StockMovementsView,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
