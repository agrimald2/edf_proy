<script setup>
import { ref, computed, onMounted } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const props = defineProps({
    ruta: String,
    clients: Array,
    negociados: Number,
    noNegociados: Number,
    gv: String
});

const searchQuery = ref('');
const selectedFilter = ref('todos');
const selectedDay = ref('');

// Function to get the current day of the week
const getCurrentDayOfWeek = () => {
    const days = ['DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
    return days[new Date().getDay()];
};

onMounted(() => {
    selectedDay.value = getCurrentDayOfWeek();
});

const filteredClients = computed(() => {
    let clientsMap = new Map(); // Mapa para rastrear los COD_CLIENTE únicos
    let clients = props.clients.filter(client => {
        const matchesCOD_CLIENTE = client.COD_CLIENTE.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesCLIENTE = client.CLIENTE.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesDay = client.FREC_VISITA.includes(selectedDay.value) || selectedDay.value === '';
        let matchesFilter = false;
        if (selectedFilter.value === 'todos') {
            matchesFilter = true;
        } else if (selectedFilter.value === 'pendientes' && client.NEGOCIADO === 'PENDIENTE') {
            matchesFilter = true;
        } else if (selectedFilter.value === 'negociados' && client.NEGOCIADO === 'NEGOCIADO') {
            matchesFilter = true;
        }
        // Verificar si el cliente ya ha sido agregado según su COD_CLIENTE
        let notAddedYet = !clientsMap.has(client.COD_CLIENTE);
        if (notAddedYet && (matchesCOD_CLIENTE || matchesCLIENTE) && matchesFilter && matchesDay) {
            clientsMap.set(client.COD_CLIENTE, true); // Marcar el COD_CLIENTE como agregado
            return true;
        }
        return false;
    });

    // Prioritize clients with "PENDIENTE" status
    return clients.sort((a, b) => {
        if (a.NEGOCIADO === 'PENDIENTE' && b.NEGOCIADO !== 'PENDIENTE') {
            return -1;
        } else if (a.NEGOCIADO !== 'PENDIENTE' && b.NEGOCIADO === 'PENDIENTE') {
            return 1;
        }
        return 0;
    });
});

const filteredNegociados = computed(() => {
    let negociadosMap = new Map(); // Mapa para rastrear los COD_CLIENTE de los negociados únicos
    let count = 0;
    props.clients.forEach(client => {
        if (client.NEGOCIADO === 'NEGOCIADO' && (client.FREC_VISITA.includes(selectedDay.value) || selectedDay.value === '') && !negociadosMap.has(client.COD_CLIENTE)) {
            negociadosMap.set(client.COD_CLIENTE, true); // Marcar el COD_CLIENTE como contado
            count++;
        }
    });
    return count;
});

const filteredNoNegociados = computed(() => {
    let noNegociadosMap = new Map(); // Mapa para rastrear los COD_CLIENTE de los no negociados únicos
    let count = 0;
    props.clients.forEach(client => {
        if (client.NEGOCIADO === 'PENDIENTE' && (client.FREC_VISITA.includes(selectedDay.value) || selectedDay.value === '') && !noNegociadosMap.has(client.COD_CLIENTE)) {
            noNegociadosMap.set(client.COD_CLIENTE, true); // Marcar el COD_CLIENTE como contado
            count++;
        }
    });
    return count;
});
</script>

<template>
    <GuestLayout :title="`Dashboard | Salvador Palacios`">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Hola, {{ props.gv.split(' ').slice(1).join(' ') }}!
                </h2>
                <select v-model="selectedDay"
                    class="form-select block w-1/4 mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Seleccione una frecuencia</option>
                    <option value="LUNES">LUNES</option>
                    <option value="MARTES">MARTES</option>
                    <option value="MIERCOLES">MIERCOLES</option>
                    <option value="JUEVES">JUEVES</option>
                    <option value="VIERNES">VIERNES</option>
                    <option value="SABADO">SABADO</option>
                    <option value="DOMINGO">DOMINGO</option>
                </select>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-2">
                        <div class="flex flex-row justify-between items-center gap-4">
                            <div class="bg-yellow-500 rounded-lg shadow-lg flex-1" style="background-color: #4E9814;">
                                <div class="p-4 flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-users text-white text-xl"></i>
                                    <h3 class="text-xl font-semibold text-white">Negociados</h3>
                                    <p class="text-white text-2xl font-bold">{{ filteredNegociados }}</p>
                                </div>
                            </div>
                            <div class="bg-yellow-500 rounded-lg shadow-lg flex-1" style="background-color: #C6372A;">
                                <div class="p-4 flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-users text-white text-xl"></i>
                                    <h3 class="text-lg font-semibold text-white">Pendientes</h3>
                                    <p class="text-white text-2xl font-bold">{{ filteredNoNegociados }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2">
                    <h1 class="p-2 font-bold">
                        Lista de oportunidad Clientes
                    </h1>
                    <div class="pt-2 relative mx-auto text-gray-600 w-full">
                        <input
                            class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none w-full"
                            type="search" name="search" placeholder="Buscar..." v-model="searchQuery">
                    </div>
                    <div class="flex gap-2 my-4">
                        <button class="px-4 py-2 text-white rounded-full"
                            :class="{ 'bg-black': selectedFilter === 'todos', 'bg-gray-500': selectedFilter !== 'todos' }"
                            @click="selectedFilter = 'todos'">TODOS</button>
                        <button class="px-4 py-2 text-white rounded-full"
                            :class="{ 'bg-black': selectedFilter === 'pendientes', 'bg-gray-500': selectedFilter !== 'pendientes' }"
                            @click="selectedFilter = 'pendientes'">PENDIENTES</button>
                        <button class="px-4 py-2 text-white rounded-full"
                            :class="{ 'bg-black': selectedFilter === 'negociados', 'bg-gray-500': selectedFilter !== 'negociados' }"
                            @click="selectedFilter = 'negociados'">NEGOCIADOS</button>
                    </div>
                </div>

                <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex flex-col gap-4">
                        <div class="bg-white shadow-md rounded-lg overflow-hidden flex"
                            v-for="client in filteredClients">
                            <div class="flex-1 border-r border-gray-200">
                                <div class="p-4">
                                    <div class="text-sm font-semibold"><i class="fa-solid fa-user"></i> {{
        client.COD_CLIENTE }}
                                        - {{ client.CLIENTE }}</div>
                                    <div class="text-sm"><i class="fa-solid fa-location-dot"></i> {{ client.DIRECCIÓN }}
                                    </div>
                                    <div class="mt-2">
                                        <span v-if="client.N_EDF == 0"
                                            class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">
                                            <i class="fa-solid fa-fax"></i> No cuenta con EDF
                                        </span>
                                        <span v-else
                                            class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">
                                            <i class="fa-solid fa-fax"></i> Cuenta con {{ client.N_EDF }} EDF
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="client.NEGOCIADO == 'PENDIENTE'" class="flex-1 text-left">
                                <div class="p-4 text-left">
                                    <div class="text-sm font-medium text-gray-500">Puedes negociar</div>
                                    <div class="flex items-center mt-2">
                                        <div class="text-sm font-semibold">EDF | {{ client.PUERTAS_A_NEGOCIAR }} Pts |
                                            {{
        client.CONDICION }}</div>
                                    </div>
                                    <a :href="`https://wa.link/ibba8o`" target="_blank"
                                        class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md">
                                        <i class="fa-brands fa-whatsapp"></i>
                                        Negociar EDF
                                    </a>
                                </div>
                            </div>
                            <div v-else class="flex-1 text-left">
                                <div class="p-4 text-left">
                                    <div class="text-sm font-medium text-gray-500"><i
                                            class="fa-solid fa-check-to-slot mr-2"></i>Haz Negociado</div>
                                    <div class="flex items-center mt-2">
                                        <div class="text-sm font-semibold">EDF | {{ client.PUERTAS_A_NEGOCIAR }} Pts |
                                            {{client.CONDICION}}</div>
                                    </div>
                                    <button
                                        class="ml-auto bg-green-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md">
                                        <i class="fa-solid fa-shuffle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
