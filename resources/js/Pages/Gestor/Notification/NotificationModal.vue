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
        <li v-for="(notification, index) in notifications" :key="index" class="flex items-center space-x-4 hover:bg-gray-100 rounded-md transition duration-150 ease-in-out">
          <a :href="notification.link" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-4 w-full p-2 rounded-md">
            <i :class="notification.icon" class="text-xl"></i>
            <span>{{ notification.text }}</span>
          </a>
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
      notifications: [],
    };
  },
  created() {
    this.fetchNotifications();
  },
  methods: {
    fetchNotifications() {
      axios.get('/api/notifications')
        .then(response => {
          this.notifications = response.data.map(notification => ({
            icon: this.getIconClass(notification),
            text: notification.content,
            link: notification.link
          }));
        })
        .catch(error => {
          console.error('There was an error fetching the notifications:', error);
        });
    },
    getIconClass(notification) {
      // Placeholder for icon class logic based on notification properties
      return 'fas fa-info-circle'; // Default icon class
    },
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
