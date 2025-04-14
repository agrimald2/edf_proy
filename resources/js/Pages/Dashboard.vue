<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
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

const uploadFile = async () => {
    if (file.value) {
        isProcessing.value = true;
        uploadStatus.value = 'Uploading...';
        const formData = new FormData();
        
        console.log('FormData');

        formData.append('csv', file.value);

        console.log('Appended');
        
        try {
            console.log('Try...');
            const response = await axios.post('/upload-csv', formData, {
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
            console.log("HOLA");
            console.dir(error.response.data.message);
            isProcessing.value = false;
            uploadStatus.value = `Upload Failed: ${error.response.data.message || error.response.data.message}`;
        }
    }
};

const downloadTemplate = () => {
    window.location.href = '/nedfac_template.xlsx';
};

const isUploading = computed(() => uploadStatus.value === 'File selected' || isProcessing.value);
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Importar Data
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <form @submit.prevent="uploadFile" class="space-y-6">
                        <div>
                            <label for="file-upload" class="block text-sm font-medium text-gray-700">
                                Excel document
                            </label>
                            <div class="my-1">
                                <button @click="downloadTemplate"
                                    class="inline-flex justify-center py-1 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Descarga Excel Template
                                </button>
                            </div>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <span v-if="isUploading" class="loader"></span>
                                    <p v-if="isUploading" class="text-xs text-gray-500">
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
                                        <label for="file-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span v-if="!isUploading">Selecciona un Archivo</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only"
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
                                Cargar Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style scoped>
.loader {
    width: 48px;
    height: 12px;
    margin-top: 40px;
    background: #8b02f4fc;
    display: inline-block;
    position: relative;
}

.loader::after {
    content: '';
    left: 50%;
    top: -47px;
    transform: translate(-50%, 0);
    position: absolute;
    border: 15px solid transparent;
    border-bottom-color: #8b02f4fc;
    box-sizing: border-box;
    animation: bump 0.4s ease-in-out infinite alternate;
}

.loader::before {
    content: '';
    left: 50%;
    bottom: 15px;
    transform: translate(-50%, 0);
    position: absolute;
    width: 15px;
    height: 20px;
    background: #8b02f4fc;
    box-sizing: border-box;
    animation: bump 0.4s ease-in-out infinite alternate;
}

@keyframes bump {
    0% {
        transform: translate(-50%, 5px);
    }

    100% {
        transform: translate(-50%, -5px);
    }
}
</style>