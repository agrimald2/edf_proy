<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const ruta = ref('');
const errors = ref({});

const { props } = usePage();
onMounted(() => {
    if (props.errors && props.errors.code) {
        errors.value = props.errors;
    }
});

const search = () => {
    const baseUrl = `/login/${ruta.value}`;
    window.location.href = baseUrl;
};
</script>

<template>
    <GuestLayout title="Ingresar | EDF">
        <div class="flex items-center justify-center h-screen">
            <div class="w-full max-w-xs">
                <form @submit.prevent="search" class="bg-white px-8 pt-6 pb-4 mb-4">
                    <div class="text-center flex justify-center my-4">
                        <img src="/logo.png" alt="" style="width: 65%;">
                    </div>
                    <div v-if="errors.code" class="mb-4 mt-6">
                        <p class="text-red-500 text-xs italic">{{ errors.code }}</p>
                    </div>
                    <div class="mb-4 mt-6">
                        <input v-model="ruta"
                            class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-300"
                            placeholder="Ingresa tu código">
                        <p class="text-sm text-gray-500 mt-2" style="font-size:12px"><i class="fa-solid fa-circle-info"></i> Ejem. Gestor: I9H47  / Supervisor: I9SV04</p>
                    </div>
                    <button
                        class="w-full bg-red-arca hover:bg-red-700 text-white py-2 px-4 rounded-lg flex items-center justify-center focus:outline-none focus:shadow-outline"
                        type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Ingresar
                    </button>
                    <div class="mt-4 text-center">
                        <a href="/login" class="text-sm text-blue-300 hover:text-blue-500">
                            Acceso Gerente/Trade
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>