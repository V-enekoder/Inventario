// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";

// 1. IMPORTA LOS LAYOUTS Y LAS VISTAS
import MainLayout from "@/layouts/MainLayout.vue";
import AuthLayout from "@/layouts/AuthLayout.vue";

import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
import ProductsView from "@/views/ProductsView.vue";
import CategoriesView from "@/views/CategoriesView.vue";
import SuppliersView from "@/views/SuppliersView.vue";
import StockMovementsView from "@/views/StockMovementsView.vue";
import UsersView from "@/views/UsersView.vue";

// 2. DEFINE LA ESTRUCTURA DE RUTAS CORRECTA
const routes = [
  // Grupo de rutas privadas que usan el MainLayout (la navbar principal)
  {
    path: "/",
    component: MainLayout,
    meta: { requiresAuth: true }, // Todas las rutas hijas requerirán autenticación
    children: [
      { path: "", name: "Home", component: HomeView },
      { path: "products", name: "Products", component: ProductsView },
      { path: "categories", name: "Categories", component: CategoriesView },
      { path: "suppliers", name: "Suppliers", component: SuppliersView },
      {
        path: "stock-movements",
        name: "StockMovements",
        component: StockMovementsView,
      },
      {
        path: "users",
        name: "Users",
        component: UsersView,
        meta: { requiresAdmin: true }, // Esta ruta hija, además, requiere ser admin
      },
    ],
  },

  // Grupo de rutas públicas que usan el AuthLayout (simple, para login/registro)
  {
    path: "/auth",
    component: AuthLayout,
    children: [
      { path: "login", name: "Login", component: LoginView },
      // Aquí podrías añadir en el futuro:
      // { path: 'register', name: 'Register', component: RegisterView },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

// 3. CONFIGURA EL GUARDIA DE NAVEGACIÓN GLOBAL
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  const isAuthenticated = authStore.isAuthenticated;
  const isAdmin = authStore.isAdmin;

  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
  const requiresAdmin = to.matched.some((record) => record.meta.requiresAdmin);

  // Caso 1: La ruta requiere autenticación pero el usuario no está logueado
  if (requiresAuth && !isAuthenticated) {
    next({ path: "/auth/login" }); // Lo mandamos al login
    return;
  }

  // Caso 2: La ruta requiere ser admin pero el usuario no lo es
  if (requiresAdmin && !isAdmin) {
    next({ name: "Home" }); // Lo mandamos al Home (o a una página de "No autorizado")
    return;
  }

  // Caso 3: El usuario está logueado e intenta ir a la página de login
  if (to.path === "/auth/login" && isAuthenticated) {
    next({ name: "Home" }); // Lo mandamos al Home
    return;
  }

  // Si no se cumple ninguna condición, permite la navegación
  next();
});

export default router;
