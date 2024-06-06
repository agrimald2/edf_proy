<template>
    <div class="pt-24 min-h-3/4 flex flex-col items-center justify-center text-center">
        <div class="mb-4">
            <i class="fa-solid fa-circle-check text-6xl text-green-600"></i>
        </div>
        <!-- Modal Content -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-green-600">Permuta enviada</h2>
            <p class="text-sm text-gray-700 mt-2">Los datos para tu permuta han sido enviados de manera exitosa.</p>
        </div>
        <!-- Accept Button -->
        <div class="mt-24 mb-6 w-full">
            <button @click="accept"
                class="w-full bg-black text-white py-2 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">Aceptar</button>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {

        }
    },
    methods: {
        accept() {
            this.$emit('accept')
        }
    }
}
</script>