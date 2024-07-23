<template>
    <GuestLayout :title="`Permutas | EDF`">
        <AddPermutaModal v-if="showAddPermutaModal" @close="closeAddPermutaModal" :sv="sv" :ruta="route"
            :location_id="location_id" />
        <template #header>
            <div class="grid grid-cols-2 gap-4 items-center">
                <div>
                    <h2 class="font-bold text-sm text-black leading-tight">
                        ¡Hola!
                    </h2>
                    <p>Gestor <span v-if="gv !== 'N/A'" class="text-sm"> {{ gv }}</span></p>
                </div>
                <!-- 
                <div class="flex items-center" style="margin-left: auto">
                    <span class="text-xs font-bold">Frecuencia:</span>
                    <select style="padding-right: 2rem;"
                        class="block mt-1 border-none rounded focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                        <option value="lunes">Lunes</option>
                        <option value="martes">Martes</option>
                        <option value="miércoles">Miércoles</option>
                        <option value="jueves">Jueves</option>
                        <option value="viernes">Viernes</option>
                        <option value="sábado">Sábado</option>
                        <option value="domingo">Domingo</option>
                    </select>
                    <button @click="logout"
                        class="absolute top-2 right-0 ml-4 flex items-center text-sm font-bold text-red-600">
                        <i class="fa-solid fa-sign-out-alt mr-2"></i>
                    </button>
                </div>
                -->
            </div>
        </template>
        <div class="flex flex-col gap-4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
                <div class="flex-1 border-r border-gray-200">
                    <div class="p-4">
                        <div class="text-sm font-semibold"><i class="fa-solid fa-check-circle text-green-500"></i>
                            Aprobadas
                        </div>
                        <div class="text-xs pt-2 pl-4">
                            <span class="font-bold">
                                Cantidad:
                            </span>
                            {{ approvedCount }}
                        </div>
                    </div>
                </div>
                <div class="flex-1 text-left">
                    <div class="p-4 text-left">
                        <div class="text-sm text-black font-bold"><i class="fa-solid fa-clock text-yellow-500"></i>
                            Pendientes
                        </div>
                        <div class="text-xs mt-1 font-medium text-gray-500">
                            Cantidad: {{ pendingCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-2 my-2">
            <button @click="openAddPermutaModal"
                class="bg-black text-white px-4 py-1 rounded-lg shadow-lg flex-1 font-bold">
                <i class="fa-solid fa-plus mr-2"></i>Ingresar permuta
            </button>
        </div>
        <div class="px-2">
            <div class="relative mx-auto text-gray-600 w-full">
                <h2 class="font-bold text-sm text-black leading-tight pt-4 pb-2">
                    Lista de Permutas
                </h2>
                <input
                    class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none w-full"
                    type="search" name="search" placeholder="Buscar" v-model="searchQuery">
            </div>
        </div>
        <div class="flex gap-2 my-4 px-2">
            <button class="px-3 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'todos', 'bg-white text-black': selectedFilter !== 'todos' }"
                @click="selectedFilter = 'todos'">Todos</button>
            <button class="px-3 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'approved', 'bg-white text-black': selectedFilter !== 'approved' }"
                @click="selectedFilter = 'approved'">Aprobadas</button>
            <button class="px-3 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'rejected', 'bg-white text-black': selectedFilter !== 'rejected' }"
                @click="selectedFilter = 'rejected'">Rechazadas</button>
            <button class="px-3 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'pending', 'bg-white text-black': selectedFilter !== 'pending' }"
                @click="selectedFilter = 'pending'">Pendientes</button>
        </div>
        <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col gap-4">
                <div v-for="permuta in filteredPermutas" :key="permuta.id"
                    class="bg-white shadow-md rounded-lg overflow-hidden flex flex-row">
                    <div class="w-3/5 border-r border-gray-200">
                        <div class="p-4">
                            <div class="text-sm font-semibold"><i class="fa-solid fa-user"></i>
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
            </div>
        </div>
    </GuestLayout>
</template>
<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PermutaDetails from './PermutaDetails.vue';
import axios from 'axios';
import AddPermutaModal from './AddPermutaModal.vue';

export default {
    components: {
        GuestLayout,
        PermutaDetails,
        AddPermutaModal
    },
    props: ['supervisor', 'route', 'sv', 'gv', 'location_id'],
    data() {
        return {
            todaysDate: new Date().toLocaleDateString('es-ES', {
                weekday: 'short', year: 'numeric',
                month: 'short', day: 'numeric'
            }).replace(/^\w/, c => c.toUpperCase()),
            selectedFilter: 'todos',
            permutas: [],
            searchQuery: '',
            showDetailModal: false,
            selectedPermuta: null,
            showAddPermutaModal: false,
        };
    },
    computed: {
        filteredPermutas() {
            return this.permutas.filter(permuta => {
                if (this.selectedFilter === 'todos') {
                    return true;
                } else if (this.selectedFilter === 'rejected') {
                    return permuta.trade_status.toLowerCase() === 'rejected' || permuta.supervisor_status.toLowerCase() === 'rejected' || permuta.gerente_status.toLowerCase() === 'rejected';
                } else if (this.selectedFilter === 'pending') {
                    return permuta.trade_status.toLowerCase() === 'pending' && permuta.supervisor_status.toLowerCase() !== 'rejected' && permuta.gerente_status.toLowerCase() !== 'rejected';
                } else {
                    return permuta.trade_status.toLowerCase() === this.selectedFilter;
                }
            }).filter(permuta => {
                return permuta.cod_cliente.includes(this.searchQuery) || permuta.location.name.includes(this.searchQuery);
            });
        },
        approvedCount() {
            return this.permutas.filter(permuta => permuta.trade_status.toLowerCase() === 'approved').length;
        },
        pendingCount() {
            return this.permutas.filter(permuta => permuta.trade_status.toLowerCase() === 'pending' && permuta.supervisor_status.toLowerCase() !== 'rejected' && permuta.gerente_status.toLowerCase() !== 'rejected').length;
        }
    },
    methods: {
        async getPermutas() {
            try {
                const response = await axios.get(`/api/gestor/${this.route}/permutas`);
                this.permutas = response.data;
            } catch (error) {
                console.error('Error fetching permutas:', error);
            }
        },
        statusClass(gerente_status) {
            switch (gerente_status.toLowerCase()) {
                case 'approved':
                    return 'bg-green-100 text-green-800';
                case 'rejected':
                    return 'bg-red-100 text-red-800';
                case 'pending':
                    return 'bg-yellow-100 text-yellow-800';
                default:
                    return 'bg-gray-100 text-gray-800';
            }
        },
        statusIcon(gerente_status) {
            switch (gerente_status.toLowerCase()) {
                case 'approved':
                    return 'fa-solid fa-check';
                case 'rejected':
                    return 'fa-solid fa-x';
                case 'pending':
                    return 'fa-solid fa-spinner';
                default:
                    return 'fa-solid fa-question';
            }
        },
        openDetailModal(permuta) {
            this.selectedPermuta = permuta;
            this.showDetailModal = true;
        },
        logout() {
            axios.post('/logout')
                .then(response => {
                    window.location.href = '/login';
                })
                .catch(error => {
                    console.error('Error during logout:', error);
                });
        },
        openAddPermutaModal() {
            this.showAddPermutaModal = true;
        },
        closeAddPermutaModal() {
            this.showAddPermutaModal = false;
        }
    },
    mounted() {
        this.getPermutas();
    }
};
</script>
