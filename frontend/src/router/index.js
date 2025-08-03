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

// src/router/index.js
/*import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import ProductsView from "../views/ProductsView.vue";
import CategoriesView from "../views/CategoriesView.vue";
import SuppliersView from "../views/SuppliersView.vue";
import StockMovementsView from "../views/StockMovementsView.vue";
import UsersView from "@/views/UsersView.vue";
import LoginView from "@/views/LoginView.vue";

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
  {
    path: "/users",
    name: "users",
    component: UsersView,
    meta: { requiresAdmin: true }, // <-- Metadato para proteger la ruta
  },
  {
    path: "/login", // <-- 2. ¿Existe la ruta?
    name: "login",
    component: LoginView, // <-- 3. ¿Está asignada al componente correcto?
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

import { useAuthStore } from "@/stores/auth";

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  // Si la ruta requiere ser admin y el usuario no lo es...
  if (to.meta.requiresAdmin && !authStore.isAdmin) {
    // ...redirige al login.
    next({ name: "login" });
  } else {
    // De lo contrario, permite el acceso.
    next();
  }
});

export default router;
*/
/*
// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
//import { useAuthStore } from "@/stores/auth";

// Importa los LAYOUTS
import AuthLayout from "@/layouts/AuthLayout.vue";
import MainLayout from "@/layouts/MainLayout.vue";

// Importa las VISTAS
import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
import ProductsView from "@/views/ProductsView.vue";
import CategoriesView from "@/views/CategoriesView.vue";
import SuppliersView from "@/views/SuppliersView.vue";
import StockMovementsView from "@/views/StockMovementsView.vue";
import UsersView from "@/views/UsersView.vue";
// ... importa tus otras vistas (CategoriesView, SuppliersView, etc.)

const routes = [
  // Rutas públicas con el layout de autenticación
  {
    path: "/auth",
    component: AuthLayout,
    children: [
      { path: "/login", name: "Login", component: LoginView },
      { path: "", name: "Home", component: HomeView },
      { path: "/products", name: "Products", component: ProductsView },
      { path: "/suppliers", name: "Suppliers", component: SuppliersView },
      { path: "/categories", name: "Categories", component: CategoriesView },
      { path: "", name: "Home", component: HomeView },
      { path: "/users", name: "Users", component: UsersView },
      {
        path: "/stock-movements",
        name: "Stock Movements",
        component: StockMovementsView,
      },
      // Aquí podrías añadir /register, /forgot-password, etc.
    ],
  },
  // Rutas privadas con el layout principal
  {
    path: "/",
    component: MainLayout,
    meta: { requiresAuth: true }, // <-- ¡IMPORTANTE!
    children: [
      // ... define tus otras rutas privadas aquí
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

// Guardia de navegación global
/*router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);

  if (requiresAuth && !authStore.isAuthenticated) {
    // Si la ruta requiere autenticación y no estamos logueados, vamos al login
    next({ name: "Login" });
  } else if (to.name === "Login" && authStore.isAuthenticated) {
    // Si ya estamos logueados y vamos al login, nos redirige a Home
    next({ name: "Home" });
  } else {
    // En cualquier otro caso, permite la navegación
    next();
  }
});

export default router;
*/
