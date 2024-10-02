<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permutas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label for="instanceStatus" class="block text-sm font-medium text-gray-700">Instance Status</label>
                            <select id="instanceStatus" v-model="filterStatus" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Gerente">Gerente</option>
                                <option value="Trade">Trade</option>
                            </select>
                        </div>
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" id="startDate" v-model="startDate" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" id="endDate" v-model="endDate" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div class="md:col-span-3">
                            <label for="customerCode" class="block text-sm font-medium text-gray-700">Customer Code</label>
                            <input type="text" id="customerCode" v-model="searchCustomerCode" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer Code
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Volume
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Instance / Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="permuta in filteredPermutas" :key="permuta.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ permuta.cod_cliente }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ permuta.volume }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-start space-x-2">
                                            <div :class="statusBadgeClass(permuta.instance_status)" class="uppercase px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                {{ permuta.instance_status }}
                                            </div>
                                            <div :class="statusBadgeClass(getStatus(permuta))" class="uppercase px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                {{ getStatus(permuta) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ formatDate(permuta.created_at) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" @click="deletePermuta(permuta.id)" class="text-red-600 hover:text-red-900 ml-3">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';

export default {
    components: { AppLayout },
    setup() {
        const permutas = ref([]);
        const filterStatus = ref('');
        const startDate = ref('');
        const endDate = ref('');
        const searchCustomerCode = ref('');

        const getStatus = (permuta) => {
            switch (permuta.instance_status) {
                case 'Supervisor':
                    return permuta.supervisor_status;
                case 'Gerente':
                    return permuta.gerente_status;
                case 'Trade':
                    return permuta.trade_status;
                default:
                    return 'Unknown';
            }
        };

        const statusBadgeClass = (status) => {
            switch (status) {
                case 'Supervisor':
                return 'bg-gray-100 text-gray-800';

                case 'Gerente':
                return 'bg-gray-100 text-gray-800';

                case 'Trade':
                return 'bg-gray-100 text-gray-800';

                case 'Pending':
                    return 'bg-yellow-100 text-yellow-800';
                case 'Approved':
                    return 'bg-green-100 text-green-800';
                case 'Rejected':
                    return 'bg-red-100 text-red-800';
                default:
                    return 'bg-gray-100 text-gray-800';
            }
        };

        const formatDate = (dateString) => {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        };

        const filteredPermutas = computed(() => {
            return permutas.value.filter((permuta) => {
                return (!filterStatus.value || permuta.instance_status === filterStatus.value) &&
                       (!startDate.value || new Date(permuta.created_at) >= new Date(startDate.value)) &&
                       (!endDate.value || new Date(permuta.created_at) <= new Date(endDate.value)) &&
                       (!searchCustomerCode.value || permuta.cod_cliente.includes(searchCustomerCode.value));
            });
        });

        const getPermutas = async () => {
            try {
                const response = await axios.post('/admin/permutas');
                console.dir(response.data);
                permutas.value = response.data.permutas;
            } catch (error) {
                console.error('Error fetching permutas:', error);
            }
        };

        const deletePermuta = async (id) => {
            try {
                await axios.delete(`/admin/permutas/${id}`);
                permutas.value = permutas.value.filter(permuta => permuta.id !== id);
            } catch (error) {
                console.error('Error deleting permuta:', error);
            }
        };

        return {
            permutas,
            filterStatus,
            startDate,
            endDate,
            searchCustomerCode,
            filteredPermutas,
            getPermutas,
            getStatus,
            statusBadgeClass,
            formatDate,
            deletePermuta
        };
    },
    mounted() {
        this.getPermutas();
    },
};
</script>
