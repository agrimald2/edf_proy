<template>
    <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-row">
        <div class="w-3/5 border-r border-gray-200">
            <div class="p-4">
                <div class="text-sm font-semibold">
                    <i class="fa-solid fa-user"></i>
                    {{ permuta.cod_cliente }} - {{ permuta.location.name }}
                </div>
                <div class="text-xs flex items-center justify-between">
                    <div class="bg-gray-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4">
                        <i class="fa-brands fa-square-letterboxd"></i>
                        {{ permuta.volume }} CU
                    </div>
                </div>
                <div class="flex items-center mt-2 pl-2">
                    <!-- Supervisor Status -->
                    <div class="flex flex-col items-center">
                        <div :class="{
                            'w-8 h-8 flex items-center justify-center rounded-full bg-green-500': permuta.supervisor_status === 'Approved',
                            'w-8 h-8 flex items-center justify-center rounded-full bg-red-500': permuta.supervisor_status === 'Rejected',
                            'w-8 h-8 flex items-center justify-center rounded-full bg-gray-300': permuta.supervisor_status === 'Pending'
                        }">
                            <i :class="{
                                'fa-solid fa-check text-white': permuta.supervisor_status === 'Approved',
                                'fa-solid fa-times text-white': permuta.supervisor_status === 'Rejected',
                                'fa-solid fa-clock text-gray-400': permuta.supervisor_status === 'Pending'
                            }"></i>
                        </div>
                    </div>
                    <!-- Line Connector -->
                    <div :class="{
                        'h-1 w-16 bg-green-500': permuta.supervisor_status === 'Approved',
                        'h-1 w-16 bg-red-500': permuta.supervisor_status === 'Rejected',
                        'h-1 w-16 bg-gray-300': permuta.supervisor_status === 'Pending'
                    }"></div>
                    <!-- Gerente Status -->
                    <div class="flex flex-col items-center">
                        <div :class="{
                            'w-8 h-8 flex items-center justify-center rounded-full bg-green-500': permuta.gerente_status === 'Approved',
                            'w-8 h-8 flex items-center justify-center rounded-full bg-red-500': permuta.gerente_status === 'Rejected',
                            'w-8 h-8 flex items-center justify-center rounded-full bg-gray-300': permuta.gerente_status === 'Pending'
                        }">
                            <i :class="{
                                'fa-solid fa-check text-white': permuta.gerente_status === 'Approved',
                                'fa-solid fa-times text-white': permuta.gerente_status === 'Rejected',
                                'fa-solid fa-clock text-gray-400': permuta.gerente_status === 'Pending'
                            }"></i>
                        </div>
                    </div>
                    <!-- Line Connector -->
                    <div :class="{
                        'h-1 w-16 bg-green-500': permuta.gerente_status === 'Approved',
                        'h-1 w-16 bg-red-500': permuta.gerente_status === 'Rejected',
                        'h-1 w-16 bg-gray-300': permuta.gerente_status === 'Pending'
                    }"></div>
                    <!-- Trade Status -->
                    <div class="flex flex-col items-center">
                        <div :class="{
                            'w-8 h-8 flex items-center justify-center rounded-full bg-green-500': permuta.trade_status === 'Approved',
                            'w-8 h-8 flex items-center justify-center rounded-full bg-red-500': permuta.trade_status === 'Rejected',
                            'w-8 h-8 flex items-center justify-center rounded-full bg-gray-300': permuta.trade_status === 'Pending'
                        }">
                            <i :class="{
                                'fa-solid fa-check text-white': permuta.trade_status === 'Approved',
                                'fa-solid fa-times text-white': permuta.trade_status === 'Rejected',
                                'fa-solid fa-clock text-gray-400': permuta.trade_status === 'Pending'
                            }"></i>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-2">
                    <div class="text-xs font-medium text-gray-500">Supervisor</div>
                    <div class="text-xs font-medium text-gray-500 pr-5">Gerente</div>
                    <div class="text-xs font-medium text-gray-500">Trade</div>
                </div>
            </div>
        </div>
        <div class="w-2/5 text-left">
            <div class="pb-2 px-4 text-left pt-2">
                <div class="text-sm text-black font-bold">
                    Ruta: {{ permuta.route }}
                </div>
                <div class="text-xs mt-1 font-medium text-gray-500">{{ permuta.condition }} - {{ permuta.doors_to_negotiate }}
                    {{ permuta.doors_to_negotiate === 1 ? 'Puerta' : 'Puertas' }} </div>
                <div class="text-xs font-medium text-gray-500 mt-4">
                    <button class="bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full"
                        @click="openDetailModal(permuta)">Ver Detalles</button>
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