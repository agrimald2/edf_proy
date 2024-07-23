<template>
    <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-row">
        <div class="w-3/5 border-r border-gray-200">
            <div class="p-4">
                <div class="text-sm font-semibold">
                    <i class="fa-solid fa-user"></i>
                    {{ permuta.cod_cliente }} - {{ permuta.location.name }}
                </div>
                <div class="text-xs flex items-center justify-between text-stone-500">
                    <div class="bg-gray-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4">
                        <i class="fa-brands fa-square-letterboxd"></i>
                        {{ permuta.have_edf ? 'Cuenta con edf' : 'No cuenta con edf' }}
                    </div>
                    <div class="rounded pt-1 pl-1 pb-1 pr-2 flex-3/4 text-black">
                        {{ permuta.volume }} CU
                    </div>
                </div>
                <div class="text-xs font-semibold mt-1">
                    <div class="bg-gray-100 rounded pt-1 pl-1 pb-1 pr-2 inline-block text-stone-500">
                        <i class="fa-solid fa-calendar"></i>
                        {{ new Date(permuta.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="w-2/5 text-left">
            <div class="pb-2 px-4 text-left pt-2">
                <div class="text-sm text-black font-bold">
                    {{ permuta.location.name }}
                </div>
                <div class="text-sm text-black font-bold">
                    Ruta: {{ permuta.route }}
                </div>
                <div class="text-xs mt-1 font-medium text-gray-500">{{ permuta.condition }} - {{
                        permuta.doors_to_negotiate }}
                    {{ permuta.doors_to_negotiate === 1 ? 'Puerta' : 'Puertas' }} </div>
                <div class="text-xs font-medium text-gray-500 mt-4">
                    <button class="bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full"
                        @click="openDetailModal(permuta)">Ver Más</button>
                </div>
                <PermutaDetails v-if="showDetailModal" :show="showDetailModal" :permuta="selectedPermuta"
                    @close="showDetailModal = false" />
            </div>
        </div>
    </div>
</template>

<script>
import PermutaDetails from './PermutaDetails.vue';

export default {
    props: {
        permuta: {
            type: Object,
            required: true
        },
        showDetailModal: {
            type: Boolean,
            required: true
        },
        selectedPermuta: {
            type: Object,
            required: true
        }
    },
    components: {
        PermutaDetails
    },
    methods: {
        openDetailModal(permuta) {
            this.$emit('open-detail-modal', permuta);
        }
    }
};
</script>