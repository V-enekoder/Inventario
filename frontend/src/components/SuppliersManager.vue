<!-- src/components/SuppliersManager.vue -->
<template>
  <div class="suppliers-container">
    <h1>Gestión de Proveedores</h1>

    <button @click="openCreateModal" class="btn btn-primary">
      Añadir Nuevo Proveedor
    </button>

    <div v-if="loading" class="loading-spinner">Cargando...</div>
    <div v-if="error" class="error-message">{{ error }}</div>

    <table v-if="!loading && suppliers.length > 0" class="suppliers-table">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Contacto Principal</th>
          <th>Teléfono</th>
          <th>Dirección</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="supplier in suppliers" :key="supplier.id">
          <td>{{ supplier.name }}</td>
          <td>{{ supplier.contact }}</td>
          <td>{{ supplier.phone }}</td>
          <td>{{ supplier.address }}</td>
          <td class="actions">
            <button @click="openEditModal(supplier)" class="btn btn-edit">
              Editar
            </button>
            <button @click="handleDelete(supplier.id)" class="btn btn-delete">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="!loading && suppliers.length === 0 && !error">
      No se han encontrado proveedores.
    </p>

    <!-- Modal para Crear/Editar Proveedor -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2>{{ isEditing ? "Editar Proveedor" : "Crear Nuevo Proveedor" }}</h2>
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="supplier-name">Nombre del Proveedor</label>
            <input
              type="text"
              id="supplier-name"
              v-model="supplierForm.name"
              required
            />
          </div>
          <div class="form-group">
            <label for="supplier-contact">Nombre de Contacto</label>
            <input
              type="text"
              id="supplier-contact"
              v-model="supplierForm.contact"
              required
            />
          </div>
          <div class="form-group">
            <label for="supplier-phone">Teléfono</label>
            <input
              type="text"
              id="supplier-phone"
              v-model="supplierForm.phone"
              required
            />
          </div>
          <div class="form-group">
            <label for="supplier-address">Dirección</label>
            <input
              type="text"
              id="supplier-address"
              v-model="supplierForm.address"
              required
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

const suppliers = ref([]);
const loading = ref(true);
const error = ref(null);

const showModal = ref(false);
const isEditing = ref(false);
const supplierForm = ref({
  id: null,
  name: "",
  contact: "",
  phone: "",
  address: "",
});

// 1. LEER (READ)
const fetchSuppliers = async () => {
  loading.value = true;
  error.value = null;
  try {
    const response = await apiClient.get("/suppliers");
    // Tu API devuelve { "Suppliers": [...] }
    suppliers.value = response.data.Suppliers || [];
  } catch (e) {
    console.error("Error fetching suppliers:", e);
    // Tu API devuelve un 'Message' en caso de error 404
    error.value =
      e.response?.data?.Message || "No se pudieron cargar los proveedores.";
  } finally {
    loading.value = false;
  }
};

// 2. CREAR/ACTUALIZAR (CREATE/UPDATE)
const handleSubmit = async () => {
  const payload = {
    name: supplierForm.value.name,
    contact: supplierForm.value.contact,
    phone: supplierForm.value.phone,
    address: supplierForm.value.address,
  };

  try {
    if (isEditing.value) {
      await apiClient.put(`/suppliers/${supplierForm.value.id}`, payload);
    } else {
      await apiClient.post("/suppliers", payload);
    }
    closeModal();
    await fetchSuppliers();
  } catch (e) {
    console.error("Error submitting form:", e);
    alert("Error al guardar el proveedor. Revisa los datos.");
  }
};

// 3. BORRAR (DELETE)
const handleDelete = async (id) => {
  if (window.confirm("¿Estás seguro de que quieres eliminar este proveedor?")) {
    try {
      await apiClient.delete(`/suppliers/${id}`);
      await fetchSuppliers();
    } catch (e) {
      console.error("Error deleting supplier:", e);
      alert("Error al eliminar el proveedor.");
    }
  }
};

// --- FUNCIONES DEL MODAL ---
const openCreateModal = () => {
  isEditing.value = false;
  supplierForm.value = {
    id: null,
    name: "",
    contact: "",
    phone: "",
    address: "",
  };
  showModal.value = true;
};

const openEditModal = (supplier) => {
  isEditing.value = true;
  supplierForm.value = { ...supplier };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

onMounted(fetchSuppliers);
</script>

<style scoped>
/* Estos estilos son casi idénticos a los de Categorías, se pueden reutilizar */
.suppliers-container {
  max-width: 1100px;
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
.suppliers-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
.suppliers-table th,
.suppliers-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}
.suppliers-table th {
  background-color: var(--color-grey-light);
  color: var(--color-blue);
  font-weight: bold;
}
.suppliers-table tr:hover {
  background-color: var(--color-yellow);
  color: var(--color-blue);
}

.actions {
  display: flex;
  gap: 10px;
}

/* Botones y Modal (reutilizando estilos visuales) */
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
  background-color: #29b6f6;
  color: white;
}
.btn-delete {
  background-color: #ef5350;
  color: white;
}
.btn-secondary {
  background-color: var(--color-grey-medium);
  color: white;
}

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
  width: calc(100% - 22px); /* Ajuste por padding y borde */
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
