<!-- src/components/ProductList.vue -->
<template>
  <div class="product-list-container">
    <h1>Lista de Productos</h1>

    <div v-if="loading">Cargando productos...</div>
    <div v-if="error" class="error">{{ error }}</div>

    <!-- Contenedor para las tarjetas de producto -->
    <div class="products-grid" v-if="!loading && products.length > 0">
      <!-- Iteramos sobre cada producto para crear una tarjeta -->
      <div v-for="product in products" :key="product.id" class="product-card">
        <h2 class="product-name">{{ product.name }}</h2>

        <p class="product-description">{{ product.description }}</p>

        <ul class="product-details">
          <li><strong>Código de Barras:</strong> {{ product.barcode }}</li>
          <li><strong>Categoría:</strong> {{ product.category.name }}</li>
          <li>
            <strong>Precio de Costo:</strong> ${{ product["cost price"] }}
          </li>
          <li>
            <strong>Precio de Venta:</strong> ${{ product["sale price"] }}
          </li>
          <li><strong>Unidad:</strong> {{ product.unit }}</li>
          <li><strong>Stock Mínimo:</strong> {{ product["Minimum stock"] }}</li>
          <li>
            <strong>Proveedor:</strong> {{ product.supplier.name }}
            <em>({{ product.supplier.contact }})</em>
          </li>
        </ul>
      </div>
    </div>

    <!-- Mensaje si no se encuentran productos -->
    <div v-if="!loading && products.length === 0 && !error">
      No se encontraron productos.
    </div>
  </div>
</template>

<script setup>
// El script no cambia, es el mismo que antes.
import { ref, onMounted } from "vue";
import apiClient from "@/services/api";

const products = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchProducts = async () => {
  try {
    const response = await apiClient.get("/products");
    products.value = response.data.Products || [];
  } catch (e) {
    console.error(e);
    error.value = "Ocurrió un error al cargar los productos.";
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchProducts();
});
</script>

<style scoped>
/* Definiendo la paleta como variables CSS para fácil reutilización */
:root {
  --color-blue: #005a9c; /* Un azul corporativo */
  --color-yellow: #ffc107; /* Un amarillo vibrante */
  --color-white: #ffffff;
  --color-grey-light: #f0f2f5; /* Gris para fondos */
  --color-grey-medium: #a0a0a0; /* Gris para texto secundario/bordes */
  --color-grey-dark: #4a4a4a; /* Gris oscuro para texto principal */
}

.product-list-container {
  max-width: 1200px;
  margin: auto;
  padding: 20px;
  font-family: Avenir, Helvetica, Arial, sans-serif;
  background-color: var(--color-grey-light); /* Fondo general gris claro */
}

h1 {
  color: var(--color-blue);
  border-bottom: 2px solid var(--color-yellow);
  padding-bottom: 10px;
}

.error {
  color: #c62828;
  background-color: #ffcdd2;
  border: 1px solid #c62828;
  padding: 15px;
  border-radius: 8px;
  margin-top: 20px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 25px;
  margin-top: 20px;
}

.product-card {
  border: 1px solid var(--color-grey-medium);
  border-radius: 8px;
  padding: 20px;
  background-color: var(--color-white); /* Fondo de tarjeta blanco */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
  border-left: 5px solid transparent; /* Borde inicial para la transición */
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
  border-left: 5px solid var(--color-yellow); /* Borde amarillo al hacer hover */
}

.product-name {
  margin-top: 0;
  color: var(--color-blue); /* Título de la tarjeta en azul */
  font-size: 1.4em;
}

.product-description {
  font-size: 0.9em;
  color: var(--color-grey-dark);
  min-height: 40px;
}

.product-details {
  list-style: none;
  padding: 0;
  margin-top: 15px;
  font-size: 0.95em;
  color: var(--color-grey-dark);
}

.product-details li {
  padding: 6px 0;
  border-bottom: 1px solid var(--color-grey-light);
}

.product-details li:last-child {
  border-bottom: none;
}

.product-details strong {
  color: var(--color-blue); /* Etiquetas de detalles en azul */
}

.product-details em {
  color: var(--color-grey-medium); /* Contacto del proveedor en gris */
  font-style: italic;
}
</style>
