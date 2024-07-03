<template>
    <GuestLayout :title="`Permutas | EDF`">
        <template #header>
            <div class="grid grid-cols-2 gap-4 items-center">
                <div>
                    <h2 class="font-bold text-sm text-black leading-tight">
                        ¡Hola Miguel! 
                    </h2>
                    <p class="text-sm">Supervisor </p>
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
                            Restantes
                        </div>
                        <div class="text-xs mt-1 font-medium text-gray-500">
                            Cantidad: {{ pendingCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 
        <div class="px-2 my-2">
            <button @click="openAddPermutaModal"
                class="bg-black text-white px-4 py-1 rounded-lg shadow-lg flex-1 font-bold">
                <i class="fa-solid fa-plus mr-2"></i>Ingresar permuta
            </button>
        </div>
        -->
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
                <div v-for="permuta in sortedPermutas" :key="permuta.id"
                    class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col md:flex-row">
                    <div class="w-full md:w-3/5 border-r border-gray-200">
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
                            <hr>
                            <div class="mt-2">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr>
                                                <th class="py-2 px-4 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                    :class="{ 'bg-gray-100': permuta.instance_status === 'Supervisor' }">
                                                    Supervisor</th>
                                                <th class="py-2 px-4 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                    :class="{ 'bg-gray-100': permuta.instance_status === 'Gerente' }">
                                                    Gerente
                                                </th>
                                                <th class="py-2 px-4 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                                    :class="{ 'bg-gray-100': permuta.instance_status === 'Trade' }">
                                                    Trade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200 text-sm"
                                                    :class="{ 'font-bold': permuta.instance_status === 'Supervisor' }">
                                                    {{ permuta.supervisor_status === 'Pending' ? 'Pendiente' : permuta.supervisor_status === 'Rejected' ? 'Rechazado' : permuta.supervisor_status === 'Approved' ? 'Aprobado' : permuta.supervisor_status }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200 text-sm"
                                                    :class="{ 'font-bold': permuta.instance_status === 'Gerente' }">
                                                    {{ permuta.gerente_status === 'Pending' ? 'Pendiente' : permuta.gerente_status === 'Rejected' ? 'Rechazado' : permuta.gerente_status === 'Approved' ? 'Aprobado' : permuta.gerente_status }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200 text-sm"
                                                    :class="{ 'font-bold': permuta.instance_status === 'Trade' }">
                                                    {{ permuta.trade_status === 'Pending' ? 'Pendiente' : permuta.trade_status === 'Rejected' ? 'Rechazado' : permuta.trade_status === 'Approved' ? 'Aprobado' : permuta.trade_status }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-2/5 text-left">
                        <div class="pb-2 px-4 text-left">
                            <div class="text-sm text-black font-bold">{{ permuta.condition }} - {{ permuta.doors_to_negotiate }} {{ permuta.doors_to_negotiate === 1 ? 'Puerta' : 'Puertas' }} </div>
                            <div class="text-xs mt-1 font-medium text-gray-500">
                                Ruta: {{ permuta.route }}
                            </div>
                            <div class="text-xs font-medium text-gray-500 mt-4">
                                <button class="bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full"
                                    @click="openDetailModal(permuta)">Ver
                                    más</button>
                            </div>
                            <PermutaDetails v-if="showDetailModal" :show="showDetailModal" :permuta="selectedPermuta"
                                :haveAvailableLimit="haveAvailableLimit" :sv="mesa" @close="showDetailModal = false" />
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
    props: {
        mesa: {
            type: String,
        },
        haveAvailableLimit: {
            type: Boolean
        }
    },
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
                return permuta.cod_cliente.includes(this.searchQuery) || permuta.location.name.includes(this.searchQuery);
            });
        },
        sortedPermutas() {
            return this.filteredPermutas.sort((a, b) => {
                if (a.supervisor_status === 'Pending' && b.supervisor_status !== 'Pending') {
                    return -1;
                } else if (a.supervisor_status !== 'Pending' && b.supervisor_status === 'Pending') {
                    return 1;
                } else {
                    return 0;
                }
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
                const response = await axios.get(`/api/supervisor/${this.mesa}/permutas`);
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
        }
    },
    mounted() {
        this.getPermutas();
    }
};
</script>
