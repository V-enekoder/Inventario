import axios from "axios";

const apiClient = axios.create({
  // La URL base de tu API de Laravel
  baseURL: "http://localhost:8000/api",
  headers: {
    Accept: "application/json", // <--- CORREGIDO
    "Content-Type": "application/json", // <-- Esta necesita comillas por el guion '-'
  },
});

export default apiClient;
