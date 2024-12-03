<template>
    <GuestLayout :title="`Permutas | EDF`">
        <template #header>
            <div class="grid grid-cols-2 gap-4 items-center border-b border-gray-200">
                <div>
                    <h2 class="font-bold text-sm text-black leading-tight">
                        ¡Hola, {{ $page.props.auth.user.name }} !
                    </h2>
                    <p class="text-sm">Gerente de Sala</p>
                </div>
                <div class="flex items-center" style="margin-left: auto">
                    <button @click="logout"
                        class="absolute top-2 right-0 ml-4 flex items-center text-sm font-bold text-red-600">
                        <i class="fa-solid fa-sign-out-alt mr-2"></i>
                    </button>
                </div>
            </div>
        </template>
        <div class="flex flex-row gap-2 bg-white shadow-md rounded-lg overflow-hidden p-2 items-center">
            <div class="flex-1 text-center text-xs">
                <span class="font-bold"> Aprobadas: </span> {{ approvedCount }}
            </div>
            <div class="flex-1 text-center text-xs text-black">
                <span class="font-bold">Pendientes: </span> {{ pendingCount }}
            </div>
            <div class="flex-1 text-center">
                <label class="text-xs font-semibold mr-2">Mes:</label>
                <select v-model="selectedMonth" class="border border-gray-300 rounded-md text-xs p-1 px-2">
                    <option value="todos">todos</option>
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
        <div class="px-2 flex justify-between items-center my-4">
            <h2 class="font-bold text-sm text-black leading-tight">
                Lista de Permutas
            </h2>
            <button @click="goToPendingPermutas"
                class="relative border border-black text-black font-semibold px-4 py-1 rounded ml-4 text-xs">
                Permutas por aprobar
                <span
                    class="absolute -bottom-1 -left-2 inline-block w-4 h-4 bg-red-500 text-white text-xxs font-bold rounded-full text-center">
                    {{ pendingCount }}
                </span>
            </button>
        </div>
        <div class="px-2">
            <div class="relative text-gray-600 w-full">
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
        <div class="flex gap-2 my-4 px-2">
            <!--
            <select v-model="selectedSubregion" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">T. Subregiones</option>
                <option v-for="subregion in subregions" :key="subregion.id" :value="subregion.name">{{ subregion.name }}</option>
            </select>
            -->
            <select v-model="selectedLocation"
                class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">T. Localidades</option>
                <option v-for="location in locations" :key="location.id" :value="location.name">{{ location.name }}
                </option>
            </select>
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
                                <div class="text-xs font-medium text-gray-500">Supervisor <br>
                                    <span v-if="permuta.supervisor_approved_at">{{ new
                                        Date(permuta.supervisor_approved_at).toLocaleDateString('es-ES', {
                                            day:
                                        '2-digit',
                                        month: '2-digit', year: '2-digit' }) }}</span>
                                </div>
                                <div class="text-xs font-medium text-gray-500 pr-5">Gerente <br>
                                    <span v-if="permuta.gerente_approved_at">{{ new
                                        Date(permuta.gerente_approved_at).toLocaleDateString('es-ES', {
                                            day: '2-digit',
                                        month:
                                        '2-digit', year: '2-digit' }) }}</span>
                                </div>
                                <div class="text-xs font-medium text-gray-500">Trade <br>
                                    <span v-if="permuta.trade_approved_at">{{ new
                                        Date(permuta.trade_approved_at).toLocaleDateString('es-ES', {
                                            day: '2-digit',
                                        month:
                                        '2-digit', year: '2-digit' }) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-2/5 text-left">
                        <div class="pb-2 px-4 text-left pt-2">
                            <div class="text-sm text-black font-bold">
                                Ruta: {{ permuta.route }}
                            </div>
                            <div class="text-xs mt-1 font-medium text-gray-500">{{ permuta.condition }} - {{
                                permuta.doors_to_negotiate }}
                                {{ permuta.doors_to_negotiate === 1 ? 'Puerta' : 'Puertas' }} </div>
                            <div class="text-xs font-medium text-gray-500 mt-4">
                                <button class="bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full"
                                    @click="openDetailModal(permuta.id)">Ver Detalles</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <PermutaDetails v-if="showDetailModal" :show="showDetailModal" :permuta="selectedPermuta"
            :id="`Permuta${selectedPermuta.id}`" @close="closeDetailModal" />
    </GuestLayout>
</template>
<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PermutaDetails from './PermutaDetails.vue';
import axios from 'axios';

export default {
    components: {
        GuestLayout,
        PermutaDetails
    },
    props: ['supervisor'],
    data() {
        const currentMonth = new Date().toLocaleString('es-ES', { month: 'long' }).toLowerCase();
        return {
            todaysDate: new Date().toLocaleDateString('es-ES', {
                weekday: 'short', year: 'numeric',
                month: 'short', day: 'numeric'
            }).replace(/^\w/, c => c.toUpperCase()),
            selectedFilter: 'todos',
            selectedSubregion: '',
            selectedLocation: '',
            selectedMonth: currentMonth,
            permutas: [],
            searchQuery: '',
            showDetailModal: false,
            selectedPermuta: null,
            subregions: [],
            locations: []
        };
    },
    computed: {
        filteredPermutas() {
            return this.permutas.filter(permuta => {
                if (this.selectedFilter === 'approved') {
                    return permuta.supervisor_status.toLowerCase() === 'approved' &&
                        permuta.gerente_status.toLowerCase() === 'approved' &&
                        permuta.trade_status.toLowerCase() === 'approved';
                } else if (this.selectedFilter === 'rejected') {
                    return permuta.supervisor_status.toLowerCase() === 'rejected' ||
                        permuta.gerente_status.toLowerCase() === 'rejected' ||
                        permuta.trade_status.toLowerCase() === 'rejected';
                } else if (this.selectedFilter === 'pending') {
                    return (permuta.supervisor_status.toLowerCase() === 'pending' ||
                        permuta.gerente_status.toLowerCase() === 'pending' ||
                        permuta.trade_status.toLowerCase() === 'pending') &&
                        permuta.supervisor_status.toLowerCase() !== 'rejected' &&
                        permuta.gerente_status.toLowerCase() !== 'rejected' &&
                        permuta.trade_status.toLowerCase() !== 'rejected';
                } else {
                    return true;
                }
            }).filter(permuta => {
                return (this.selectedSubregion === '' || permuta.location.subregion.name === this.selectedSubregion) &&
                    (this.selectedLocation === '' || permuta.location.name === this.selectedLocation) &&
                    (permuta.cod_cliente.includes(this.searchQuery) || permuta.location.name.includes(this.searchQuery));
            });
        },
        approvedCount() {
            return this.permutas.filter(permuta => permuta.supervisor_status.toLowerCase() === 'approved' &&
                permuta.gerente_status.toLowerCase() === 'approved' &&
                permuta.trade_status.toLowerCase() === 'approved').length;
        },
        pendingCount() {
            return this.permutas.filter(permuta => (permuta.supervisor_status.toLowerCase() === 'pending' ||
                permuta.gerente_status.toLowerCase() === 'pending' ||
                permuta.trade_status.toLowerCase() === 'pending') &&
                permuta.supervisor_status.toLowerCase() !== 'rejected' &&
                permuta.gerente_status.toLowerCase() !== 'rejected' &&
                permuta.trade_status.toLowerCase() !== 'rejected').length;
        }
    },
    methods: {
        async getPermutas() {
            try {
                const response = await axios.get('/gerente/permutas');
                this.permutas = response.data;
            } catch (error) {
                console.error('Error fetching permutas:', error);
            }
        },
        async getSubregions() {
            try {
                const response = await axios.get('/api/subregions/list');
                this.subregions = response.data;
            } catch (error) {
                console.error('Error fetching subregions:', error);
            }
        },
        async getLocations() {
            try {
                const response = await axios.get('/gerente/locations');
                this.locations = response.data;
            } catch (error) {
                console.error('Error fetching locations:', error);
            }
        },
        statusClass(trade_status) {
            switch (trade_status.toLowerCase()) {
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
        statusIcon(trade_status) {
            switch (trade_status.toLowerCase()) {
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
        openDetailModal(permutaId) {
            console.log("Opening detail modal for permuta ID:", permutaId);
            this.selectedPermuta = this.permutas.find(p => p.id === permutaId);
            this.showDetailModal = true;
        },
        closeDetailModal() {
            console.log("Closing detail modal");
            this.showDetailModal = false;
            this.selectedPermuta = null;
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
        goToPendingPermutas() {
            window.location.href = `/gerente/permutas/pending`;
        }
    },
    mounted() {
        this.getPermutas();
        this.getSubregions();
        this.getLocations();
    }
};
</script>
