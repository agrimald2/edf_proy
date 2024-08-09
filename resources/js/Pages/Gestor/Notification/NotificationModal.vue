<template>
  <div v-if="show" class="fixed inset-0 flex items-start justify-center z-50">
    <div :class="['bg-white w-full max-w-md rounded-lg shadow-lg mt-0', show ? 'animate-slide-down' : 'animate-slide-up']" style="top: 0;">
      <div class="flex justify-between items-center p-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold">Notificaciones</h2>
        <button @click="close" class="text-gray-500 hover:text-gray-700">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <ul class="p-4 space-y-4">
        <li v-for="(notification, index) in notifications" :key="index" class="flex items-center space-x-4">
          <i :class="notification.icon" class="text-xl"></i>
          <span>{{ notification.text }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: true,
      notifications: [
        { icon: 'fas fa-info-circle', text: 'Notificación 1' },
        { icon: 'fas fa-exclamation-circle', text: 'Notificación 2' },
        { icon: 'fas fa-check-circle', text: 'Notificación 3' },
      ],
    };
  },
  methods: {
    close() {
      this.show = false;
      setTimeout(() => {
        this.$emit('close');
      }, 500); // Wait for the animation to finish before emitting the close event
    },
  },
};
</script>

<style scoped>
@keyframes slide-down {
  0% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(0%);
  }
}

@keyframes slide-up {
  0% {
    transform: translateY(0%);
  }
  100% {
    transform: translateY(-100%);
  }
}

.animate-slide-down {
  animation: slide-down 0.5s ease-out forwards;
}

.animate-slide-up {
  animation: slide-up 0.5s ease-out forwards;
}
</style>
