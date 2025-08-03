<!-- src/components/UsersManager.vue -->
<template>
  <div class="users-container">
    <h1>Administración de Usuarios</h1>
    <div v-if="loading">Cargando...</div>
    <div v-if="error">{{ error }}</div>
    <table v-if="users.length > 0" class="users-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Roles</th>
          <th>Acciones de Admin</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
            <span v-for="role in user.roles" :key="role.id" class="role-badge">
              {{ role.name }}
            </span>
            <span v-if="!user.roles.length" class="role-badge-none"
              >Sin rol</span
            >
          </td>
          <td>
            <button
              v-if="!isUserAdmin(user)"
              @click="assignRole(user.id)"
              class="btn btn-assign"
            >
              Asignar Admin
            </button>
            <button
              v-if="isUserAdmin(user)"
              @click="revokeRole(user.id)"
              class="btn btn-revoke"
            >
              Revocar Admin
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import apiClient from "@/services/api";

const users = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchUsers = async () => {
  loading.value = true;
  try {
    const response = await apiClient.get("/users");
    // Tu API devuelve un array directamente en este caso
    users.value = response.data;
  } catch (e) {
    error.value = "Error al cargar los usuarios.";
  } finally {
    loading.value = false;
  }
};

const isUserAdmin = (user) => {
  return user.roles.some((role) => role.name === "admin");
};

const assignRole = async (userId) => {
  try {
    await apiClient.put(`/users/${userId}/assign-admin-role`);
    await fetchUsers(); // Recargar la lista para ver el cambio
  } catch (e) {
    alert("Error al asignar el rol.");
  }
};

const revokeRole = async (userId) => {
  try {
    await apiClient.put(`/users/${userId}/revoke-admin-role`);
    await fetchUsers(); // Recargar la lista
  } catch (e) {
    alert("Error al revocar el rol.");
  }
};

onMounted(fetchUsers);
</script>

<style scoped>
.users-container {
  max-width: 1000px;
  margin: auto;
  padding: 20px;
}
.users-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
.users-table th,
.users-table td {
  border: 1px solid #ddd;
  padding: 12px;
}
.users-table th {
  background-color: #f4f4f4;
}
.role-badge {
  background-color: var(--color-blue);
  color: white;
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 0.8em;
}
.role-badge-none {
  background-color: #ccc;
  color: #333; /* ... */
}
.btn {
  /* estilos comunes de botón */
}
.btn-assign {
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 4px;
}
.btn-revoke {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 4px;
}
</style>
