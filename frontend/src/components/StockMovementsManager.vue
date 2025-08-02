<!-- src/components/StockMovementsManager.vue -->
<template>
  <div class="movements-container">
    <h1>Historial de Movimientos de Stock</h1>

    <button @click="openCreateModal" class="btn btn-primary">
      Registrar Nuevo Movimiento
    </button>

    <div v-if="loading" class="loading-spinner">Cargando...</div>
    <div v-if="error" class="error-message">{{ error }}</div>

    <table v-if="!loading && stockMovements.length > 0" class="movements-table">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Tipo</th>
          <th>Cantidad</th>
          <th>Fecha</th>
          <th>Nota</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="movement in stockMovements" :key="movement.id">
          <td>{{ movement.product.name }}</td>
          <td>
            <span
              :class="
                movement['movement type'] === 'entrada'
                  ? 'type-entry'
                  : 'type-exit'
              "
            >
              {{ movement["movement type"] }}
            </span>
          </td>
          <td>{{ movement.quantity }}</td>
          <td>{{ movement.movement_date }}</td>
          <td>{{ movement.note }}</td>
          <td class="actions">
            <button @click="openEditModal(movement)" class="btn btn-edit">
              Editar
            </button>
            <button @click="handleDelete(movement.id)" class="btn btn-delete">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="!loading && stockMovements.length === 0 && !error">
      No hay movimientos de stock registrados.
    </p>

    <!-- Modal para Crear/Editar Movimiento -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2>{{ isEditing ? "Editar Movimiento" : "Registrar Movimiento" }}</h2>
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="product-select">Producto</label>
            <select
              id="product-select"
              v-model="movementForm.product_id"
              required
            >
              <option :value="null" disabled>
                -- Selecciona un producto --
              </option>
              <option
                v-for="product in products"
                :key="product.id"
                :value="product.id"
              >
                {{ product.name }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="movement-type">Tipo de Movimiento</label>
            <select
              id="movement-type"
              v-model="movementForm.movement_type"
              required
            >
              <option value="entrada">Entrada</option>
              <option value="saida">Salida</option>
            </select>
          </div>

          <div class="form-group">
            <label for="quantity">Cantidad</label>
            <input
              type="number"
              id="quantity"
              v-model="movementForm.quantity"
              required
              min="1"
            />
          </div>

          <div class="form-group">
            <label for="note">Nota (Opcional)</label>
            <textarea id="note" v-model="movementForm.note" rows="3"></textarea>
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

// Estado principal
const stockMovements = ref([]);
const products = ref([]); // Necesitamos la lista de productos para el <select>
const loading = ref(true);
const error = ref(null);

// Estado del modal y formulario
const showModal = ref(false);
const isEditing = ref(false);
const movementForm = ref({
  id: null,
  product_id: null,
  quantity: 1,
  movement_type: "entrada",
  note: "",
});

// --- FUNCIONES DE OBTENCIÓN DE DATOS ---
const fetchStockMovements = async () => {
  try {
    const response = await apiClient.get("/stock-movements");
    // Tu API devuelve { "Stock Movements": [...] }
    stockMovements.value = response.data["Stock Movements"] || [];
  } catch (e) {
    error.value =
      e.response?.data?.Message || "No se pudieron cargar los movimientos.";
    stockMovements.value = []; // Limpiamos por si acaso
  }
};

const fetchProducts = async () => {
  try {
    const response = await apiClient.get("/products");
    // Recordando que la API de productos devuelve { "Products": [...] }
    products.value = response.data.Products || [];
  } catch (e) {
    console.error("No se pudieron cargar los productos para el formulario:", e);
  }
};

// --- FUNCIONES CRUD ---
const handleSubmit = async () => {
  const payload = { ...movementForm.value };
  delete payload.id; // No enviamos el ID en el cuerpo del request

  try {
    if (isEditing.value) {
      await apiClient.put(`/stock-movements/${movementForm.value.id}`, payload);
    } else {
      await apiClient.post("/stock-movements", payload);
    }
    closeModal();
    await fetchStockMovements();
  } catch (e) {
    console.error("Error al guardar el movimiento:", e);
    alert("Error al guardar el movimiento. Verifique los datos.");
  }
};

const handleDelete = async (id) => {
  if (
    window.confirm(
      "¿Estás seguro de que quieres eliminar este movimiento? Esta acción no se puede deshacer."
    )
  ) {
    try {
      await apiClient.delete(`/stock-movements/${id}`);
      await fetchStockMovements();
    } catch (e) {
      console.error("Error al eliminar el movimiento:", e);
      alert("Error al eliminar el movimiento.");
    }
  }
};

// --- FUNCIONES DEL MODAL ---
const openCreateModal = () => {
  isEditing.value = false;
  movementForm.value = {
    id: null,
    product_id: null,
    quantity: 1,
    movement_type: "entrada",
    note: "",
  };
  showModal.value = true;
};

const openEditModal = (movement) => {
  isEditing.value = true;
  // Mapeamos los datos del movimiento al formulario
  movementForm.value = {
    id: movement.id,
    product_id: movement.product.id, // Obtenemos el ID del objeto anidado
    quantity: movement.quantity,
    movement_type: movement["movement type"], // Usamos corchetes por el espacio
    note: movement.note,
  };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

// --- CICLO DE VIDA ---
onMounted(async () => {
  loading.value = true;
  await Promise.all([fetchStockMovements(), fetchProducts()]);
  loading.value = false;
});
</script>

<style scoped>
/* Estilos muy similares a los componentes anteriores para mantener la consistencia */
.movements-container {
  max-width: 1200px;
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
.movements-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
.movements-table th,
.movements-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
  vertical-align: middle;
}
.movements-table th {
  background-color: var(--color-grey-light);
  color: var(--color-blue);
}
.type-entry {
  color: #2e7d32; /* Verde */
  font-weight: bold;
}
.type-exit {
  color: #d32f2f; /* Rojo */
  font-weight: bold;
}

.actions {
  display: flex;
  gap: 10px;
}
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
.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid var(--color-grey-medium);
  border-radius: 5px;
  box-sizing: border-box; /* Importante para que el padding no afecte el ancho */
}
.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}
</style>
