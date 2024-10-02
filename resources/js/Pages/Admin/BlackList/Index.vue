<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista Negra
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <form @submit.prevent="uploadBlacklist" class="space-y-6">
                        <div>
                            <label for="blacklist-upload" class="block text-sm font-medium text-gray-700">
                                Documento de Lista Negra
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <span v-if="isProcessing" class="loader"></span>
                                    <p v-if="isProcessing" class="text-xs text-gray-500">
                                        {{ uploadStatus }}: {{ fileName }}
                                    </p>
                                    <p v-else-if="uploadStatus === 'THE DATA HAVE BEEN SUCCESSFULLY UPLOADED'"
                                        class="text-xs text-green-500">
                                        {{ uploadStatus }}
                                    </p>
                                    <p v-else-if="uploadStatus.includes('Upload Failed')" class="text-xs text-red-500">
                                        {{ uploadStatus }}
                                    </p>

                                    <svg v-else class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                        fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v24a4 4 0 004 4h16m8-12l-8 8m0 0l-8-8m8 8V12"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="blacklist-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span v-if="!isUploading">Selecciona un Archivo</span>
                                            <input id="blacklist-upload" name="blacklist-upload" type="file" class="sr-only"
                                                accept=".xlsx, .xls" @change="onFileChange">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        XLS, XLSX up to 100MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Subir Lista Negra
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import axios from 'axios';

const file = ref(null);
const uploadStatus = ref('');
const fileName = ref('');
const isProcessing = ref(false);

const onFileChange = (event) => {
    file.value = event.target.files[0];
    fileName.value = file.value ? file.value.name : '';
    uploadStatus.value = 'File selected';
};

const uploadBlacklist = async () => {
    if (file.value) {
        isProcessing.value = true;
        uploadStatus.value = 'Uploading...';
        const formData = new FormData();
        
        formData.append('blacklist', file.value);
        
        try {
            const response = await axios.post('/admin/upload-blacklist', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: (progressEvent) => {
                    // Handle the progress event if needed
                }
            });
            isProcessing.value = false;
            if (response.status === 200) {
                uploadStatus.value = 'THE DATA HAVE BEEN SUCCESSFULLY UPLOADED';
            } else {
                uploadStatus.value = 'Upload failed';
            }
        } catch (error) {
            console.error(error.response.data.message);
            isProcessing.value = false;
            uploadStatus.value = `Upload Failed: ${error.response.data.message || error.response.data.message}`;
        }
    }
};
</script>

<style scoped>
/* Include styles from Dashboard.vue */
</style>