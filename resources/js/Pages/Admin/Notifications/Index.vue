<template>
    <AppLayout title="Notifications">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Notifications
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <div class="flex justify-between mb-6">
                        <button @click="showCreateNotificationModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-plus-circle"></i> Add Notification
                        </button>
                    </div>
                    <div class="hidden sm:block">
                        <table class="table-auto w-full mb-6 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2">Content</th>
                                    <th class="px-4 py-2">Link</th>
                                    <th class="px-4 py-2">Start Date</th>
                                    <th class="px-4 py-2">End Date</th>
                                    <th class="px-4 py-2">Active</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="notification in notifications" :key="notification.id" class="border-b text-center">
                                    <td class="px-4 py-2">{{ notification.content }}</td>
                                    <td class="px-4 py-2">{{ notification.link }}</td>
                                    <td class="px-4 py-2">{{ notification.start_date ? new Date(notification.start_date).toLocaleDateString('en-GB') : 'sin fecha' }}</td>
                                    <td class="px-4 py-2">{{ notification.end_date ? new Date(notification.end_date).toLocaleDateString('en-GB') : 'sin fecha' }}</td>
                                    <td class="px-4 py-2">
                                        <button :class="notification.active ? 'bg-green-500' : 'bg-gray-300'" class="text-white font-bold py-2 px-3 rounded" @click="toggleActive(notification)">
                                            <i :class="notification.active ? 'fas fa-check-circle' : 'fas fa-times-circle'"></i>
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 flex justify-center">
                                        <!-- 
                                        <button @click="editNotification(notification)" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-3 px-3 rounded mr-2 flex items-center justify-center">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                        -->
                                        <button @click="deleteNotification(notification.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-3 rounded flex items-center justify-center">
                                            <i class="fas fa-trash-alt"></i> 
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="sm:hidden">
                        <ul class="divide-y divide-gray-200">
                            <li v-for="notification in notifications" :key="notification.id" class="py-4">
                                <div class="flex flex-col bg-gray-100 p-4 rounded-lg">
                                    <div class="font-bold mb-2">{{ notification.content }}</div>
                                    <div class="text-blue-500 hover:text-blue-600 mb-2">{{ notification.link }}</div>
                                    <div class="text-sm text-gray-600 mb-2">{{ notification.start_date ? new Date(notification.start_date).toLocaleDateString('en-GB') : 'No start date' }}</div>
                                    <div class="text-sm text-gray-600 mb-2">{{ notification.end_date ? new Date(notification.end_date).toLocaleDateString('en-GB') : 'No end date' }}</div>
                                    <div class="flex items-center justify-between">
                                        <button :class="notification.active ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-300 hover:bg-gray-400'" class="text-white font-bold py-1 px-3 rounded transition duration-300 ease-in-out" @click.stop="toggleActive(notification)">
                                            <i :class="notification.active ? 'fas fa-check-circle' : 'fas fa-times-circle'"></i> {{ notification.active ? 'Active' : 'Inactive' }}
                                        </button>
                                        <div>
                                            <button @click.stop="editNotification(notification)" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded mr-2 transition duration-300 ease-in-out">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button @click.stop="deleteNotification(notification.id)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded transition duration-300 ease-in-out">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <CreateNotificationModal v-show="isCreateModalVisible" :visible="isCreateModalVisible" @close="hideCreateNotificationModal" @formSubmitted="fetchNotifications"/>        
        </div>
    </AppLayout>
</template>
<script>
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateNotificationModal from '@/Pages/Admin/Notifications/CreateNotificationModal.vue';

export default {
    data() {
        return {
            notifications: [],
            isCreateModalVisible: false,
        };
    },
    components: { AppLayout, CreateNotificationModal },
    created() {
        this.fetchNotifications();
    },
    methods: {
        fetchNotifications() {
            axios.get('/notifications')
                .then(response => {
                    this.notifications = response.data;
                })
                .catch(error => {
                    console.error('There was an error fetching the notifications:', error);
                });
        },
        showCreateNotificationModal() {
            this.isCreateModalVisible = true;
        },
        hideCreateNotificationModal() {
            this.isCreateModalVisible = false;
        },
        editNotification(notification) {
            // Logic to edit an existing notification
        },
        deleteNotification(id) {
            if (confirm('Are you sure you want to delete this notification?')) {
                axios.delete(`/notifications/${id}`)
                    .then(response => {
                        this.fetchNotifications(); // Refresh the list
                    })
                    .catch(error => {
                        console.error('There was an error deleting the notification:', error);
                    });
            }
        },
        toggleActive(notification) {
            const originalActiveStatus = notification.active;
            notification.active = !notification.active;
            axios.put(`/notifications/toggle/${notification.id}`)
                .then(response => {
                    // Handle the response, e.g., show a success message
                })
                .catch(error => {
                    console.error('There was an error updating the notification status:', error);
                    notification.active = originalActiveStatus;
                });
        }
    },
};
</script>
