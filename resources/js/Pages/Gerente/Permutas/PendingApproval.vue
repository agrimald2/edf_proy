<template>
    <GuestLayout :title="`Permutas | EDF`">
        <div class="flex items-center justify-between px-4 py-2 bg-white shadow-md border-b border-gray-200">
            <button @click="goBack()" class="text-black text-sm hover:text-gray-800">
                <i class="fa-solid fa-chevron-left font-bold"></i>
            </button>
            <h3 class="text-center text-sm font-bold text-gray-800 flex-1">Permutas por aprobar</h3>
        </div>
        <div class="px-2 flex justify-between items-center my-4">
            <h2 class="font-bold text-sm text-black leading-tight">
                Lista de Permutas
            </h2>
        </div>
        <div class="flex gap-2 my-4 px-2">
            <button class="px-2 py-1 text-xs rounded-full border-black border-2 bg-blue-500 text-white"
                @click="exportExcel">Exportar Excel</button>
            <input type="file" @change="handleFileUpload" class="hidden" ref="fileInput">
            <button class="px-2 py-1 text-xs rounded-full border-black border-2 bg-green-500 text-white"
                @click="triggerFileInput">Importar Excel</button>
        </div>
        <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col gap-4">
                <PendingPermutaItem v-for="permuta in sortedPermutas" :key="permuta.id" :permuta="permuta"
                    :showDetailModal="showDetailModal" :selectedPermuta="selectedPermuta"
                    @open-detail-modal="openDetailModal" />
            </div>
        </div>
    </GuestLayout>
</template>
<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PendingPermutaItem from './PendingPermutaItem.vue';
import axios from 'axios';

export default {
    components: {
        GuestLayout,
        PendingPermutaItem
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
                const response = await axios.get(`/gerente/permutas/pending/list`);
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
            window.location.href = `/gerente/dashboard`;
        },
        exportExcel() {
            window.location.href = '/gerente/pendingPermutas';
        },
        triggerFileInput() {
            console.log("HOLA 2");
            this.$refs.fileInput.click();
        },
        async handleFileUpload(event) {
            console.log("HOLA 3");
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);

            try {
                const response = await axios.post('/gerente/importPendingPermutas', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log('Import successful:', response.data);
                this.getPermutas();
                alert('Importación exitosa');
            } catch (error) {
                console.error('Error importing permutas:', error);
                alert('Error durante la importación');
            }
        }

    },
    mounted() {
        this.getPermutas();
    }
};
</script>
