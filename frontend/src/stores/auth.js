// src/stores/auth.js
import { defineStore } from "pinia";
import apiClient from "@/services/api";
import router from "@/router";

export const useAuthStore = defineStore("auth", {
  // Estado inicial
  state: () => ({
    user: JSON.parse(localStorage.getItem("user")) || null,
    roles: JSON.parse(localStorage.getItem("userRoles")) || [],
    token: localStorage.getItem("authToken") || null,
  }),

  // Getters (propiedades computadas)
  getters: {
    isAuthenticated: (state) => !!state.token,
    isAdmin: (state) => state.roles.includes("admin"),
  },

  // Actions (métodos)
  actions: {
    async login(credentials) {
      try {
        const response = await apiClient.post("/users/login", credentials);
        const { user, roles, token } = response.data;

        // Guarda todo en el estado y en localStorage
        this.user = user;
        this.roles = roles;
        this.token = token;

        localStorage.setItem("user", JSON.stringify(user));
        localStorage.setItem("userRoles", JSON.stringify(roles));
        localStorage.setItem("authToken", token);

        // Redirige al usuario a la página de inicio o a un dashboard
        await router.push("/");
        return true;
      } catch (error) {
        console.error("Login failed:", error);
        // Limpia el estado en caso de error
        this.logout();
        return false;
      }
    },

    logout() {
      // Limpia el estado y localStorage
      this.user = null;
      this.roles = [];
      this.token = null;

      localStorage.removeItem("user");
      localStorage.removeItem("userRoles");
      localStorage.removeItem("authToken");

      // Redirige al login
      router.push("/login");
    },
  },
});
