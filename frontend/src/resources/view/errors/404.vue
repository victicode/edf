<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goHome = () => {
  router.push('/dashboard')
}

const goBack = () => {
  router.go(-1)
}
</script>

<template>
  <div class="error-404-container">
    <div class="error-404-content">
      <!-- Ilustración animada -->
      <div class="error-404-illustration">
        <div class="error-number">
          <span class="number-4">4</span>
          <div class="number-0-circle">
            <q-icon name="eva-alert-circle-outline" size="120px" color="primary" />
          </div>
          <span class="number-4">4</span>
        </div>
      </div>

      <!-- Contenido -->
      <div class="error-404-text">
        <h1 class="error-title">Página no encontrada</h1>
        <p class="error-description">
          Lo sentimos, la página que estás buscando no existe o ha sido movida.
          Puedes regresar al inicio o volver atrás.
        </p>
      </div>

      <!-- Botones de acción -->
      <div class="error-404-actions">
        <q-btn
          @click="goHome"
          color="primary"
          size="md"
          unelevated
          class="action-btn"
        >
        <div class="items-center flex">
          <q-icon name="eva-home-outline" />
          <div  class="mt-1 ml-1">
            Ir al inicio
          </div>
        </div>
        </q-btn>
        <q-btn
          @click="goBack"
          outline
          color="primary"
          size="md"
          class="action-btn"
        >
        <q-icon name="eva-arrow-back-outline" />
          <div  class="mt-1 ml-1">
            Volver atrás
          </div>
        </q-btn>
      </div>

      <!-- Enlaces útiles -->
      <div class="error-404-links">
        <div class="links-title">Enlaces útiles:</div>
        <div class="links-list">
          <router-link to="/dashboard" class="link-item">
            <q-icon name="eva-bar-chart-outline" size="20px" />
            <span>Dashboard</span>
          </router-link>
          <router-link to="/client/reserves/list" class="link-item">
            <q-icon name="eva-calendar-outline" size="20px" />
            <span>Mis Reservas</span>
          </router-link>
          <router-link to="/client/notifications" class="link-item">
            <q-icon name="eva-bell-outline" size="20px" />
            <span>Notificaciones</span>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.error-404-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
  padding: 2rem 1rem;
}

.error-404-content {
  max-width: 600px;
  width: 100%;
  text-align: center;
  animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.error-404-illustration {
  margin-bottom: 2rem;
}

.error-number {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.number-4 {
  font-size: 10rem;
  font-weight: 800;
  color: #0e344c;
  line-height: 1;
  text-shadow: 0 4px 20px rgba(14, 52, 76, 0.2);
  animation: bounce 2s infinite;

  &:first-child {
    animation-delay: 0s;
  }

  &:last-child {
    animation-delay: 0.2s;
  }
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-20px);
  }
}

.number-0-circle {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(14, 52, 76, 0.1) 0%, rgba(38, 166, 154, 0.1) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  animation: pulse 2s infinite;
  border: 3px solid rgba(14, 52, 76, 0.2);
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.05);
    opacity: 0.9;
  }
}

.error-404-text {
  margin-bottom: 2.5rem;
}

.error-title {
  font-size: 2rem;
  font-weight: 700;
  color: #0e344c;
  margin-bottom: 1rem;
  line-height: 1.2;
}

.error-description {
  font-size: 1.1rem;
  color: #666;
  line-height: 1.6;
  max-width: 500px;
  margin: 0 auto;
}

.error-404-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 3rem;
}

.action-btn {
  min-width: 160px;
  padding: 0.7rem 2rem;
  border-radius: 0.75rem;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(14, 52, 76, 0.15);

  &:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(14, 52, 76, 0.25);
  }
}

.error-404-links {
  padding-top: 2rem;
  border-top: 1px solid rgba(14, 52, 76, 0.1);
}

.links-title {
  font-size: 0.9rem;
  color: #999;
  margin-bottom: 1rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.links-list {
  display: flex;
  gap: 1.5rem;
  justify-content: center;
  flex-wrap: wrap;
}

.link-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #0e344c;
  text-decoration: none;
  font-weight: 500;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  transition: all 0.3s ease;
  background: rgba(14, 52, 76, 0.05);

  &:hover {
    background: rgba(14, 52, 76, 0.1);
    transform: translateY(-2px);
    color: #26A69A;
  }

  span {
    font-size: 0.95rem;
  }
}

// Responsive
@media (max-width: 768px) {
  .error-404-container {
    padding: 1rem;
  }

  .number-4 {
    font-size: 6rem;
  }

  .number-0-circle {
    width: 100px;
    height: 100px;

    :deep(.q-icon) {
      font-size: 70px !important;
    }
  }

  .error-title {
    font-size: 1.5rem;
  }

  .error-description {
    font-size: 1rem;
    padding: 0 1rem;
  }

  .error-404-actions {
    flex-direction: column;
    align-items: stretch;
  }

  .action-btn {
    margin: auto;
    width: 85%;
  }

  .links-list {
    flex-direction: column;
    gap: 0.75rem;
  }

  .link-item {
    width: 100%;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .number-4 {
    font-size: 4.5rem;
  }

  .number-0-circle {
    width: 80px;
    height: 80px;

    :deep(.q-icon) {
      font-size: 50px !important;
    }
  }

  .error-title {
    font-size: 1.25rem;
  }

  .error-description {
    font-size: 0.9rem;
  }
}
</style>

