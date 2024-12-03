<template>
    <GuestLayout :title="`Permutas | EDF`">
        <AddPermutaModal v-if="showAddPermutaModal" @close="closeAddPermutaModal" :sv="sv" :ruta="route"
            :location_id="location_id" />
        <div class="flex items-center justify-between px-4 py-2 bg-white shadow-md border-b border-gray-200">
            <button @click="goBack()" class="text-black text-sm hover:text-gray-800">
                <i class="fa-solid fa-chevron-left font-bold"></i>
            </button>
            <h3 class="text-center text-sm font-bold text-gray-800 flex-1">Permutas</h3>
            <div class="flex items-center">
                <label class="text-xs font-semibold mr-2">Mes:</label>
                <select v-model="selectedMonth" class="border border-gray-300 rounded-md text-xs p-1 px-2">
                    <option value="todos">Todos</option>
                    <option value="enero">Ene</option>
                    <option value="febrero">Feb</option>
                    <option value="marzo">Mar</option>
                    <option value="abril">Abr</option>
                    <option value="mayo">May</option>
                    <option value="junio">Jun</option>
                    <option value="julio">Jul</option>
                    <option value="agosto">Ago</option>
                    <option value="septiembre">Sep</option>
                    <option value="octubre">Oct</option>
                    <option value="noviembre">Nov</option>
                    <option value="diciembre">Dic</option>
                </select>
            </div>
        </div>
        <div class="flex flex-row gap-2 bg-white shadow-md rounded-lg overflow-hidden p-2 items-center">
            <div class="flex-1 text-center text-xs">
                <span class="font-bold"> Aprobadas: </span> {{ approvedCount }}
            </div>
            <div class="flex-1 text-center text-xs text-black">
                <span class="font-bold">Pendientes: </span> {{ pendingCount }}
            </div>
        </div>
        <div class="px-2 flex justify-between items-center my-4">
            
            <h2 class="font-bold text-sm text-black leading-tight">
                Lista de Permutas
            </h2>

            <button @click="openAddPermutaModal"
                class="bg-black text-white px-2 py-1 rounded-lg shadow-lg font-bold ml-auto">
                <i class="fa-solid fa-plus mr-2"></i>Ingresar permuta
            </button>
        </div>
        <div class="px-2">
            <div class="relative text-gray-600 w-full">
                <input
                    class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none w-full"
                    type="search" name="search" placeholder="Buscar" v-model="searchQuery">
            </div>
        </div>
        <div class="flex gap-1 my-2 px-1">
            <button class="px-1 py-0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === 'todos', 'bg-white text-black': selectedFilter !== 'todos' }"
                @click="selectedFilter = 'todos'" style="font-size: 13px">Todos</button>
            <button class="px-1 py-0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === 'approved', 'bg-white text-black': selectedFilter !== 'approved' }"
                @click="selectedFilter = 'approved'" style="font-size: 13px">Aprobadas</button>
            <button class="px-1 py-0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === 'rejected', 'bg-white text-black': selectedFilter !== 'rejected' }"
                @click="selectedFilter = 'rejected'" style="font-size: 13px">Rechazadas</button>
            <button class="px-1 py-0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === 'pending', 'bg-white text-black': selectedFilter !== 'pending' }"
                @click="selectedFilter = 'pending'" style="font-size: 13px">Pendientes</button>
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
                                <div :class="{
                                    'bg-green-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4': permuta.trade_status === 'Approved',
                                    'bg-red-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4': permuta.trade_status === 'Rejected',
                                    'bg-gray-100 rounded pt-1 pl-1 pb-1 pr-2 flex-3/4': permuta.trade_status === 'Pending'
                                }">
                                    <i :class="{
                                        'fa-solid fa-check text-green-500': permuta.trade_status === 'Approved',
                                        'fa-solid fa-times text-red-500': permuta.trade_status === 'Rejected',
                                        'fa-solid fa-clock text-gray-500': permuta.trade_status === 'Pending'
                                    }"></i>
                                    <span v-if="permuta.trade_status === 'Approved'"> Aprobado</span>
                                    <span v-if="permuta.trade_status === 'Rejected'"> Rechazado</span>
                                    <span v-if="permuta.trade_status === 'Pending'"> Pendiente</span>
                                </div>
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
                                <div class="text-xs font-medium text-gray-500">Supervisor <br>  
                                    <span v-if="permuta.supervisor_approved_at">{{ new Date(permuta.supervisor_approved_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: '2-digit' }) }}</span>
                                </div>
                                <div class="text-xs font-medium text-gray-500 pr-5">Gerente <br>  
                                    <span v-if="permuta.gerente_approved_at">{{ new Date(permuta.gerente_approved_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: '2-digit' }) }}</span>
                                </div>
                                <div class="text-xs font-medium text-gray-500">Trade <br>  
                                    <span v-if="permuta.trade_approved_at">{{ new Date(permuta.trade_approved_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: '2-digit' }) }}</span>
                                </div>
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
        const monthMap = {
            0: 'enero',
            1: 'febrero',
            2: 'marzo',
            3: 'abril',
            4: 'mayo',
            5: 'junio',
            6: 'julio',
            7: 'agosto',
            8: 'septiembre',
            9: 'octubre',
            10: 'noviembre',
            11: 'diciembre'
        };
        const currentMonth = new Date().getMonth();
        return {
            todaysDate: new Date().toLocaleDateString('es-ES', {
                weekday: 'short', year: 'numeric',
                month: 'short', day: 'numeric'
            }).replace(/^\w/, c => c.toUpperCase()),
            selectedFilter: 'todos',
            selectedMonth: monthMap[currentMonth],
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
                if (this.selectedMonth !== 'todos') {
                    const monthMap = {
                        'enero': 0,
                        'febrero': 1,
                        'marzo': 2,
                        'abril': 3,
                        'mayo': 4,
                        'junio': 5,
                        'julio': 6,
                        'agosto': 7,
                        'septiembre': 8,
                        'octubre': 9,
                        'noviembre': 10,
                        'diciembre': 11
                    };
                    const permutaDate = new Date(permuta.created_at);
                    if (permutaDate.getMonth() !== monthMap[this.selectedMonth]) {
                        return false;
                    }
                }
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
        goBack() {
            window.history.back();
        },
        goToPendingPermutas() {
            window.location.href = `/gestor/${this.route}/dashboard/permutas/pending`;
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
