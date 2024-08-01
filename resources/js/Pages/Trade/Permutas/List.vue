<template>
    <GuestLayout :title="`Permutas | EDF`">
        <div class="flex items-center justify-between px-4 py-2 bg-white shadow-md border-b border-gray-200">
            <h3 class="text-center text-sm font-bold text-gray-800 flex-1">Hola Carla!</h3>
        </div>
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
                    <option selected value="todos">todos</option>
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
        <div class="flex gap-2 my-4 px-2">
            <select v-model="selectedRegion" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Todas las Regiones</option>
                <option v-for="region in regions" :key="region.id" :value="region.name">{{ region.name }}</option>
            </select>
            <select v-model="selectedLocation" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Todas las Localidades</option>
                <option v-for="location in locations" :key="location.id" :value="location.name">{{ location.name }}</option>
            </select>
        </div>
        <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col gap-4">
                <div v-for="permuta in filteredPermutas" :key="permuta.id"
                    class="bg-white shadow-md rounded-lg overflow-hidden flex">
                    <div class="w-3/5 border-r border-gray-200">
                        <div class="p-4">
                            <div class="text-sm font-semibold"><i class="fa-solid fa-user"></i>
                                {{ permuta.cod_cliente }} - {{ permuta.location.name }}
                            </div>
                            <div class="text-xs flex items-center justify-between">
                                <div class="bg-gray-100 rounded pt-1 pl-2 pb-1 pr-2 flex-3/4">
                                    <i class="fa-brands fa-square-letterboxd mr-2"></i>
                                    {{ permuta.have_edf ? 'Cuenta con EDF' : 'No cuenta con EDF' }}
                                </div>
                                <div class="flex-1/4 text-right">
                                    {{ permuta.volume }} CU
                                </div>
                            </div>
                            <div class="mt-2">
                                <span :class="statusClass(permuta.trade_status)"
                                    class="text-xs font-semibold mr-2 px-2.5 py-1 rounded">
                                    <i :class="statusIcon(permuta.trade_status)"></i> 
                                    {{ permuta.trade_status === 'Approved' ? 'Aprobada' : permuta.trade_status === 'Rejected' ? 'Rechazada' : permuta.trade_status === 'Pending' ? 'Pendiente' : permuta.trade_status }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="w-2/5 text-left">
                        <div class="p-4 text-left">
                            <div class="text-sm text-black font-bold">{{ permuta.subcanal }}</div>
                            <div class="text-xs mt-1 font-medium text-gray-500">
                                Ruta: {{ permuta.route }}
                            </div>
                            <div class="text-xs font-medium text-gray-500 mt-2">
                                <button class="bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full"
                                    @click="openDetailModal(permuta)">Ver
                                    más</button>
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

export default {
    components: {
        GuestLayout,
        PermutaDetails
    },
    props: ['supervisor'],
    data() {
        return {
            todaysDate: new Date().toLocaleDateString('es-ES', {
                weekday: 'short', year: 'numeric',
                month: 'short', day: 'numeric'
            }).replace(/^\w/, c => c.toUpperCase()),
            selectedFilter: 'todos',
            selectedMonth: 'todos',
            selectedRegion: '',
            selectedLocation: '',
            permutas: [],
            regions: [],
            locations: [],
            searchQuery: '',
            showDetailModal: false,
            selectedPermuta: null
        };
    },
    computed: {
        filteredPermutas() {
            return this.permutas.filter(permuta => {
                if (this.selectedFilter === 'todos') {
                    return true;
                } else if (this.selectedFilter === 'approved') {
                    return permuta.trade_status.toLowerCase() === 'approved';
                } else if (this.selectedFilter === 'rejected') {
                    return permuta.trade_status.toLowerCase() === 'rejected' || permuta.supervisor_status.toLowerCase() === 'rejected' || permuta.gerente_status.toLowerCase() === 'rejected';
                } else if (this.selectedFilter === 'pending') {
                    return permuta.trade_status.toLowerCase() === 'pending' && permuta.supervisor_status.toLowerCase() !== 'rejected' && permuta.gerente_status.toLowerCase() !== 'rejected';
                } else {
                    return permuta.gerente_status.toLowerCase() === this.selectedFilter;
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
            return this.permutas.filter(permuta => permuta.trade_status.toLowerCase() === 'pending').length;
        }
    },
    methods: {
        async getPermutas() {
            try {
                const response = await axios.get('/api/trade/permutas');
                this.permutas = response.data;
            } catch (error) {
                console.error('Error fetching permutas:', error);
            }
        },
        async getRegions() {
            try {
                const response = await axios.get('/api/regions');
                this.regions = response.data;
            } catch (error) {
                console.error('Error fetching regions:', error);
            }
        },
        async getLocations() {
            try {
                const response = await axios.get('/api/locations');
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
        openDetailModal(permuta) {
            this.selectedPermuta = permuta;
            this.showDetailModal = true;
        },
        goBack() {
            window.location.href = `/mesa/${this.supervisor}/info`;
        },
        logout() {
            axios.post('/logout')
                .then(response => {
                    window.location.href = '/login';
                })
                .catch(error => {
                    console.error('Error during logout:', error);
                });
        }
    },
    mounted() {
        this.getPermutas();
        this.getRegions();
        this.getLocations();
    }
};
</script>