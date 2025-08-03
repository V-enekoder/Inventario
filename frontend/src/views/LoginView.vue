<!-- src/views/LoginView.vue -->
<template>
  <div class="login-container">
    <div class="login-box">
      <h1>Iniciar Sesión</h1>
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" required />
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" id="password" v-model="password" required />
        </div>
        <p v-if="error" class="error-message">{{ error }}</p>
        <button type="submit" class="btn-login">Ingresar</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const email = ref("");
const password = ref("");
const error = ref(null);

const handleLogin = async () => {
  error.value = null;
  const success = await authStore.login({
    email: email.value,
    password: password.value,
  });

  if (!success) {
    error.value = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
  }
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
}
.login-box {
  width: 100%;
  max-width: 400px;
  padding: 40px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
h1 {
  text-align: center;
  color: var(--color-blue);
}
.form-group {
  margin-bottom: 20px;
}
.form-group label {
  display: block;
  margin-bottom: 5px;
}
.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
.btn-login {
  width: 100%;
  padding: 15px;
  border: none;
  border-radius: 4px;
  background-color: var(--color-blue);
  color: white;
  font-size: 16px;
  cursor: pointer;
}
.error-message {
  color: red;
  text-align: center;
  margin-bottom: 15px;
}
</style>
