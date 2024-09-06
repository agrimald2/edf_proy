<template>
    <transition name="modal">
        <div class="fixed inset-0 z-30 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-if="visible">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);"></div>
                <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-6 py-4">
                        <div class="sm:flex sm:items-start">
                            <div class="text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Create New Notification
                                </h3>
                                <div class="mt-2">
                                    <form id="createNotificationForm" class="space-y-6" @submit.prevent="submitForm">
                                        <div>
                                            <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
                                            <textarea id="content" v-model="form.content" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" required></textarea>
                                        </div>
                                        <div>
                                            <label for="link" class="block text-sm font-medium text-gray-700">Link:</label>
                                            <input type="text" id="link" v-model="form.link" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        </div>
                                        <div class="sm:flex sm:space-x-4">
                                            <div class="sm:flex-1 mx-2">
                                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date:</label>
                                                <input type="date" id="start_date" v-model="form.start_date" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                            <div class="sm:flex-1 mx-2">
                                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date:</label>
                                                <input type="date" id="end_date" v-model="form.end_date" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" />
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Create
                                            </button>
                                            <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" @click="closeModal">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="alertVisible" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        <span class="font-medium">Success!</span> Notification created successfully.
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        visible: Boolean
    },
    data() {
        return {
            form: {
                content: '',
                link: '',
                start_date: '',
                end_date: ''
            },
            alertVisible: false
        };
    },
    methods: {
        submitForm() {
            axios.post('/notifications', this.form)
                .then(response => {
                    this.showAlert();
                    this.$emit('formSubmitted');
                })
                .catch(error => {
                    console.error('There was an error creating the notification:', error);
                });
        },
        closeModal() {
            this.$emit('close');
        },
        showAlert() {
            this.alertVisible = true;
            setTimeout(() => {
                this.alertVisible = false;
            }, 3000); // Hide the alert after 3 seconds
        }
    }
};
</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.5s;
}
.modal-enter, .modal-leave-to /* .modal-leave-active in <2.1.8 */ {
    opacity: 0;
}
</style>
