<template>
    <GuestLayout :title="`Permutas | EDF`">
        <div class="flex items-center justify-between px-4 py-2 bg-white shadow-md border-b border-gray-200">
            <button @click="goBack()" class="text-black text-sm hover:text-gray-800">
                <i class="fa-solid fa-chevron-left font-bold"></i>
            </button>
            <h3 class="text-center text-sm font-bold text-gray-800 flex-1">Permutas</h3>
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
        <!-- 
        <div class="px-2 my-2">
            <button @click="openAddPermutaModal"
                class="bg-black text-white px-4 py-1 rounded-lg shadow-lg flex-1 font-bold">
                <i class="fa-solid fa-plus mr-2"></i>Ingresar permuta
            </button>
        </div>
        -->
        <div class="px-2 flex justify-between items-center my-4">
            <h2 class="font-bold text-sm text-black leading-tight">
                Lista de Permutas
            </h2>
            <button @click="goToPendingPermutas" class="relative border border-black text-black font-semibold px-4 py-1 rounded ml-4 text-xs">
                Permutas por aprobar
                <span class="absolute -bottom-1 -left-2 inline-block w-4 h-4 bg-red-500 text-white text-xxs font-bold rounded-full text-center">
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
        <div class="flex gap-1 my-2 px-1 overflow-x-auto no-scrollbar">
            <button class="px-1 py0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === 'todos', 'bg-white text-black': selectedFilter !== 'todos' }"
                @click="selectedFilter = 'todos'" style="font-size: 12px">Todos</button>
            <button class="px-1 py-0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === 'approved', 'bg-white text-black': selectedFilter !== 'approved' }"
                @click="selectedFilter = 'approved'" style="font-size: 12px">Aprobadas</button>
            <button class="px-1 py-0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === 'rejected', 'bg-white text-black': selectedFilter !== 'rejected' }"
                @click="selectedFilter = 'rejected'" style="font-size: 12px">Rechazadas</button>
            <button class="px-1 py-0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === 'pending', 'bg-white text-black': selectedFilter !== 'pending' }"
                @click="selectedFilter = 'pending'" style="font-size: 12px">Pendientes</button>
        </div>
        <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col gap-4">
                <PermutaItem
                    v-for="permuta in sortedPermutas"
                    :key="permuta.id"
                    :permuta="permuta"
                    :showDetailModal="showDetailModal"
                    :selectedPermuta="selectedPermuta"
                    :sv="mesa"
                    @open-detail-modal="openDetailModal"
                />
            </div>
        </div>
    </GuestLayout>
</template>
<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PermutaItem from './PermutaItem.vue';
import axios from 'axios';

export default {
    components: {
        GuestLayout,
        PermutaItem
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
            selectedMonth: new Date().toLocaleString('es-ES', { month: 'long' }).toLowerCase(),
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
            return this.permutas.filter(permuta => permuta.supervisor_status.toLowerCase() === 'pending').length;
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
        },
        goBack() {
            window.location.href = `/mesa/${this.mesa}/info`;
        },
        goToPendingPermutas() {
            window.location.href = `/supervisor/${this.mesa}/dashboard/permutas/pending`;
        }
    },
    mounted() {
        this.getPermutas();
    }
};
</script>
