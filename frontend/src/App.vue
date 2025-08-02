<!-- src/App.vue -->
<template>
  <div id="app">
    <nav>
      <router-link to="/">Home</router-link> |
      <router-link to="/products">Productos</router-link>|
      <router-link to="/categories">Categorías</router-link>
    </nav>
    <router-view />
  </div>
</template>

<script>
export default {
  name: "App",
};
</script>

<style>
/* ESTILOS GLOBALES - SIN 'scoped' */

/* 1. Definimos la paleta de colores para toda la aplicación */
:root {
  --color-blue: #005a9c;
  --color-yellow: #ffc107;
  --color-white: #ffffff;
  --color-grey-light: #f0f2f5;
  --color-grey-medium: #a0a0a0;
  --color-grey-dark: #4a4a4a;
}

/* 2. Estilos base para el cuerpo de la aplicación */
body {
  margin: 0;
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  background-color: var(--color-grey-light); /* Fondo general gris claro */
}

#app {
  text-align: center;
  color: var(--color-grey-dark);
}

/* 3. Estilos para la barra de navegación */
nav {
  padding: 30px;
  background-color: var(--color-white);
  border-bottom: 1px solid #e0e0e0;
}

nav a {
  font-weight: bold;
  color: var(--color-blue); /* Enlaces en azul */
  text-decoration: none;
  margin: 0 15px;
  transition: color 0.3s;
}

nav a:hover {
  color: var(--color-grey-dark);
}

/* Estilo para el enlace de la ruta activa, lo resalta en amarillo */
nav a.router-link-exact-active {
  color: var(--color-blue);
  border-bottom: 3px solid var(--color-yellow);
  padding-bottom: 5px;
}
</style>
