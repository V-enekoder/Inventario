<!-- src/components/UsersManager.vue (Versión Simplificada) -->
<template>
  <div class="users-container">
    <h1>Administración de Usuarios</h1>

    <!-- Indicadores de estado -->
    <div v-if="loading">Cargando usuarios...</div>
    <div v-if="error" class="error-message">{{ error }}</div>

    <!-- Tabla de Usuarios Simplificada -->
    <table v-if="!loading && users.length > 0" class="users-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <!-- Eliminamos las columnas de Roles y Acciones de Admin -->
        </tr>
      </thead>
      <tbody>
        <!-- Iteramos sobre los usuarios y mostramos solo los datos que tenemos -->
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Mensaje si no hay usuarios -->
    <p v-if="!loading && users.length === 0 && !error">
      No se han encontrado usuarios.
    </p>
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
  error.value = null; // Resetea el error en cada intento
  try {
    const response = await apiClient.get("/users");
    // La API devuelve { "data": [...] }, así que accedemos a response.data.data
    users.value = response.data.data || [];
  } catch (e) {
    console.error("Error fetching users:", e);
    error.value = "Error al cargar los usuarios. Revisa la consola.";
  } finally {
    loading.value = false;
  }
};

// Se ejecuta cuando el componente se monta en la página
onMounted(fetchUsers);

// --- HEMOS ELIMINADO LAS FUNCIONES RELACIONADAS A ROLES ---
// Ya no necesitamos isUserAdmin, assignRole, ni revokeRole.
</script>

<style scoped>
/* Los estilos pueden permanecer igual, son genéricos para la tabla */
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
  text-align: left;
}
.users-table th {
  background-color: #f4f4f4;
  font-weight: bold;
}
.error-message {
  color: red;
  margin-top: 15px;
}
</style>
