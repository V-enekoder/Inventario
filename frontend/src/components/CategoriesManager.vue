<!-- src/components/CategoriesManager.vue -->
<template>
  <div class="categories-container">
    <h1>Gestión de Categorías</h1>

    <!-- Botón para abrir el modal de creación -->
    <button @click="openCreateModal" class="btn btn-primary">
      Crear Nueva Categoría
    </button>

    <!-- Indicador de Carga -->
    <div v-if="loading" class="loading-spinner">Cargando...</div>

    <!-- Mensaje de Error -->
    <div v-if="error" class="error-message">{{ error }}</div>

    <!-- Tabla de Categorías -->
    <table v-if="!loading && categories.length > 0" class="categories-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories" :key="category.id">
          <td>{{ category.id }}</td>
          <td>{{ category.name }}</td>
          <td class="actions">
            <button @click="openEditModal(category)" class="btn btn-edit">
              Editar
            </button>
            <button @click="handleDelete(category.id)" class="btn btn-delete">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Mensaje si no hay categorías -->
    <p v-if="!loading && categories.length === 0 && !error">
      No se han encontrado categorías.
    </p>

    <!-- Modal para Crear/Editar Categoría -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2>{{ isEditing ? "Editar Categoría" : "Crear Nueva Categoría" }}</h2>
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="category-name">Nombre de la Categoría</label>
            <input
              type="text"
              id="category-name"
              v-model="categoryForm.name"
              required
              placeholder="Ej: Equipamentos Médicos"
            />
          </div>
          <div class="modal-actions">
            <button type="button" @click="closeModal" class="btn btn-secondary">
              Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
              {{ isEditing ? "Actualizar" : "Guardar" }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import apiClient from "@/services/api";

// Estado reactivo del componente
const categories = ref([]);
const loading = ref(true);
const error = ref(null);

const showModal = ref(false);
const isEditing = ref(false);
const categoryForm = ref({
  id: null,
  name: "",
});

// --- FUNCIONES CRUD ---

// 1. LEER (READ) - Obtener todas las categorías
const fetchCategories = async () => {
  loading.value = true;
  error.value = null;
  try {
    const response = await apiClient.get("/categories");
    // Tu API devuelve { "categories": [...] }
    categories.value = response.data.categories || [];
  } catch (e) {
    console.error("Error fetching categories:", e);
    error.value = "No se pudieron cargar las categorías.";
  } finally {
    loading.value = false;
  }
};

// 2. CREAR/ACTUALIZAR (CREATE/UPDATE) - Manejador del formulario
const handleSubmit = async () => {
  if (isEditing.value) {
    // Lógica de Actualización
    try {
      await apiClient.put(`/categories/${categoryForm.value.id}`, {
        name: categoryForm.value.name,
      });
      closeModal();
      await fetchCategories(); // Recargar la lista
    } catch (e) {
      console.error("Error updating category:", e);
      alert("Error al actualizar la categoría.");
    }
  } else {
    // Lógica de Creación
    try {
      await apiClient.post("/categories", { name: categoryForm.value.name });
      closeModal();
      await fetchCategories(); // Recargar la lista
    } catch (e) {
      console.error("Error creating category:", e);
      alert("Error al crear la categoría.");
    }
  }
};

// 3. BORRAR (DELETE) - Eliminar una categoría
const handleDelete = async (id) => {
  if (window.confirm("¿Estás seguro de que quieres eliminar esta categoría?")) {
    try {
      await apiClient.delete(`/categories/${id}`);
      await fetchCategories(); // Recargar la lista para reflejar el cambio
    } catch (e) {
      console.error("Error deleting category:", e);
      alert("Error al eliminar la categoría.");
    }
  }
};

// --- FUNCIONES DEL MODAL ---
const openCreateModal = () => {
  isEditing.value = false;
  categoryForm.value = { id: null, name: "" };
  showModal.value = true;
};

const openEditModal = (category) => {
  isEditing.value = true;
  categoryForm.value = { ...category }; // Copiamos la categoría al formulario
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

// Cargar las categorías cuando el componente se monta
onMounted(fetchCategories);
</script>

<style scoped>
/* Usando variables globales definidas en App.vue */
.categories-container {
  max-width: 900px;
  margin: 20px auto;
  padding: 20px;
  background-color: var(--color-white);
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h1 {
  color: var(--color-blue);
  text-align: center;
  margin-bottom: 25px;
}

/* Tabla */
.categories-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.categories-table th,
.categories-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

.categories-table th {
  background-color: var(--color-grey-light);
  color: var(--color-blue);
  font-weight: bold;
}

.categories-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.categories-table tr:hover {
  background-color: var(--color-yellow);
  color: var(--color-blue);
}

.actions {
  display: flex;
  gap: 10px;
  justify-content: center;
}

/* Botones */
.btn {
  padding: 8px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
  transition: opacity 0.2s;
}
.btn:hover {
  opacity: 0.85;
}
.btn-primary {
  background-color: var(--color-blue);
  color: white;
}
.btn-edit {
  background-color: #29b6f6; /* Un azul más claro */
  color: white;
}
.btn-delete {
  background-color: #ef5350; /* Rojo */
  color: white;
}
.btn-secondary {
  background-color: var(--color-grey-medium);
  color: white;
}

/* Modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal-content {
  background: white;
  padding: 30px;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
}
.form-group {
  margin-bottom: 20px;
}
.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: var(--color-blue);
}
.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid var(--color-grey-medium);
  border-radius: 5px;
}
.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}
</style>
