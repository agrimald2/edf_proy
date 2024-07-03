<template>
    <div class="z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-circle-xmark text-red-500"></i>
            </button>
            <div class="text-center mb-5 pt-2">
                <h2 class="text-lg font-bold">Catálogo de EDF</h2>
            </div>
            <div class="flex justify-center mb-6">
                <button
                    :class="['py-2', selectedTab === 'tipos' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500']"
                    @click="selectedTab = 'tipos'">
                    Tipos de EDF
                </button>
                <!-- 
                <button
                    :class="['py-2 ml-4', selectedTab === 'condiciones' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-500']"
                    @click="selectedTab = 'condiciones'">
                    Condiciones de instalación
                </button>
                -->
            </div>
            <div v-if="selectedTab === 'tipos'">
                <!-- Contenido para Tipos de EDF -->
                <EdfTypesCarrousel />

            </div>
            <div v-else>
                <CondicionesCarrousel />
                <!-- Contenido para Condiciones de instalación -->
            </div>
        </div>
    </div>
</template>
<style>
.left-full {
    left: -100%;
}

.carousel-item {
    float: left;
    position: relative;
    display: block;
    width: 100%;
    margin-right: -100%;
    backface-visibility: hidden;
}

.carousel-item.active {
    left: 0;
}
</style>
<script>
import EdfTypesCarrousel from './EdfTypesCarrousel.vue';
import CondicionesCarrousel from './CondicionesCarrousel.vue';

export default {
    components: {
        EdfTypesCarrousel, CondicionesCarrousel
    },
    data() {
        return {
            selectedTab: 'tipos'
        };
    }
};
</script>