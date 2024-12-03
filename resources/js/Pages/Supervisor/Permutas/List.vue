<template>
    <GuestLayout title="Permutas | EDF">
        <div class="flex items-center justify-between px-4 py-2 bg-white shadow-md border-b border-gray-200">
            <button @click="goBack" class="text-black text-sm hover:text-gray-800">
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
                    <option v-for="(month, index) in months" :key="index" :value="month">{{ month.slice(0, 3) }}</option>
                </select>
            </div>
        </div>
        <div class="px-2 flex justify-between items-center my-4">
            <h2 class="font-bold text-sm text-black leading-tight">Lista de Permutas</h2>
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
                    type="search" placeholder="Buscar" v-model="searchQuery">
            </div>
        </div>
        <div class="flex gap-1 my-2 px-1 overflow-x-auto no-scrollbar">
            <button v-for="filter in filters" :key="filter" class="px-1 py-0.5 text-xxs rounded-full border-black border"
                :class="{ 'bg-black text-white': selectedFilter === filter, 'bg-white text-black': selectedFilter !== filter }"
                @click="selectedFilter = filter" style="font-size: 12px">{{ filter.charAt(0).toUpperCase() + filter.slice(1) }}</button>
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
        <PermutaDetails v-if="showDetailModal" :show="showDetailModal" :permuta="selectedPermuta" @close="closeDetailModal" :sv="mesa" />
    </GuestLayout>
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PermutaItem from './PermutaItem.vue';
import PermutaDetails from './PermutaDetails.vue';
import axios from 'axios';

export default {
    components: {
        GuestLayout,
        PermutaItem,
        PermutaDetails
    },
    props: {
        mesa: String,
        haveAvailableLimit: Boolean
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
            months: ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
            filters: ['todos', 'approved', 'rejected', 'pending']
        };
    },
    computed: {
        filteredPermutas() {
            return this.permutas.filter(permuta => {
                const status = permuta.trade_status.toLowerCase();
                const supervisorStatus = permuta.supervisor_status.toLowerCase();
                const gerenteStatus = permuta.gerente_status.toLowerCase();
                const isRejected = status === 'rejected' || supervisorStatus === 'rejected' || gerenteStatus === 'rejected';
                const isPending = status === 'pending' && !isRejected;

                if (this.selectedFilter === 'todos') return true;
                if (this.selectedFilter === 'approved') return status === 'approved';
                if (this.selectedFilter === 'rejected') return isRejected;
                if (this.selectedFilter === 'pending') return isPending;
                return gerenteStatus === this.selectedFilter;
            }).filter(permuta => {
                if (this.selectedMonth !== 'todos') {
                    const permutaDate = new Date(permuta.created_at);
                    return permutaDate.getMonth() === this.months.indexOf(this.selectedMonth);
                }
                return permuta.cod_cliente.includes(this.searchQuery) || permuta.location.name.includes(this.searchQuery);
            });
        },
        sortedPermutas() {
            return this.filteredPermutas.sort((a, b) => a.supervisor_status === 'Pending' ? -1 : 1);
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
        openDetailModal(permuta) {
            this.selectedPermuta = permuta;
            this.showDetailModal = true;
        },
        closeDetailModal() {
            this.showDetailModal = false;
            this.selectedPermuta = null;
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