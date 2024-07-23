<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const login = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout title="Ingresar | EDF">
        <div class="flex items-center justify-center h-screen">
            <div class="w-full max-w-xs">
                <form @submit.prevent="login" class="bg-white px-8 pt-6 pb-4 mb-4">
                    <div class="text-center flex justify-center my-4">
                        <img src="/logo.png" alt="" style="width: 65%;">
                    </div>
                    <div class="mb-4 mt-6">
                        <input v-model="form.email"
                            class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-300"
                            placeholder="Ingresa tu email" type="email">
                    </div>
                    <div class="mb-4">
                        <input v-model="form.password"
                            class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-300"
                            placeholder="Ingresa tu contraseña" type="password">
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