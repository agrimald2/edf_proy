<script setup>
import { ref, computed, onMounted } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AddPermutaModal from './Permutas/AddPermutaModal.vue';
import CatalogoModal from './Catalogo/CatalogoModal.vue';
import NotificationModal from '@/Pages/Gestor/Notification/NotificationModal.vue';

const props = defineProps({
    sv: String,
    ruta: String,
    clients: Array,
    negociados: Number,
    noNegociados: Number,
    gv: String,
    cuota: Number,
    pending: Number,
});

const searchQuery = ref('');
const selectedFilter = ref('todos');
const selectedDay = ref('');

let showAddPermutaModal = ref(false);
let showCatalogoModal = ref(false);
let showNotificationModal = ref(false); // Added state for Notification Modal

// Function to get the current day of the week
const getCurrentDayOfWeek = () => {
    const days = ['DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
    return days[new Date().getDay()];
};

const openAddPermutaModal = () => {
    showAddPermutaModal.value = true;
};

const closeAddPermutaModal = () => {
    showAddPermutaModal.value = false;
};

const openCatalogoModal = () => {
    showCatalogoModal.value = true;
};

const closeCatalogoModal = () => {
    showCatalogoModal.value = false;
};

const openNotificationModal = () => { // Added function to open Notification Modal
    showNotificationModal.value = true;
};

const closeNotificationModal = () => { // Added function to close Notification Modal
    showNotificationModal.value = false;
};

const seePermutas = () => {
    window.location.href = `/gestor/${props.ruta}/permutas`;
}
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

const negotiationPercentage = computed(() => {
    const totalClients = props.clients.length;
    const negotiatedClients = props.negociados;
    const cuota = props.cuota;

    console.log("NEGOCIADOS:");
    console.log(negotiatedClients);
    console.log("COUTA:");
    console.log(cuota);

    return totalClients > 0 ? Math.round((negotiatedClients / cuota) * 100) : 0;
});

const todaysDate = new Date().toLocaleDateString('es-ES', {
    weekday: 'short', year: 'numeric',
    month: 'short', day: 'numeric'
}).replace(/^\w/, c => c.toUpperCase())
</script>

<template>
    <GuestLayout :title="`Dashboard | EDF`">
        <AddPermutaModal v-if="showAddPermutaModal" @close="closeAddPermutaModal" :sv="sv" :ruta="ruta" />
        <CatalogoModal v-if="showCatalogoModal" @close="closeCatalogoModal" />
        <NotificationModal v-if="showNotificationModal" @close="closeNotificationModal" /> <!-- Added Notification Modal -->
        <template #header>
            <div class="grid grid-cols-2 gap-4 items-center">
                <div>
                    <p class="text-sm">{{ todaysDate }}</p>
                    <h2 class="font-bold text-sm text-black leading-tight">
                        ¡Hola, {{ props.gv }}!
                    </h2>
                </div>
                <div class="flex items-center gap-2"> <!-- Added flex container for select and notification button -->
                    <select v-model="selectedDay"
                        class="block w-full mt-1 border border-gray-100 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 font-bold">
                        <option value="">TODOS</option>
                        <option value="LUNES">Lunes</option>
                        <option value="MARTES">Martes</option>
                        <option value="MIERCOLES">Miércoles</option>
                        <option value="JUEVES">Jueves</option>
                        <option value="VIERNES">Viernes</option>
                        <option value="SABADO">Sábado</option>
                        <option value="DOMINGO">Domingo</option>
                    </select>
                    <button @click="openNotificationModal" class="relative">
                        <i class="fa-solid fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 text-white text-xs font-bold rounded-full text-center">3</span> <!-- Example notification count -->
                    </button>
                </div>
            </div>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden p-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-row gap-4 w-3/4">
                            <div class="bg-green-600 rounded-lg flex-1 flex flex-col p-4">
                                <div class="flex items-center justify-between w-full mb-2">
                                    <i class="fa-solid fa-users text-white text-3xl"></i>
                                    <!--  <span class="bg-white text-green-600 rounded-full px-2 font-bold">{{ negotiationPercentage }}%</span> -->
                                </div>
                                <h3 class="text-md text-white">EDF negociados</h3>
                                <p class="text-white text-3xl font-bold text-left w-full">{{ negociados }}</p>
                            </div>
                            <div class="bg-red-600 rounded-lg flex-1 flex flex-col p-4">
                                <div class="flex items-center justify-start w-full mb-2">
                                    <i class="fa-solid fa-users text-white text-3xl"></i>
                                </div>
                                <h3 class="text-md text-white text-left">EDF pendientes</h3>
                                <p class="text-white text-3xl font-bold text-left">{{ pending }}</p>
                            </div>
                        </div>
                        <div class="flex flex-row gap-4">
                            <button @click="seePermutas"
                                class="bg-black text-white px-4 py-1 rounded-lg shadow-lg flex-1 font-bold">
                                <i class="fa-solid fa-eye mr-2"></i>Permutas
                            </button>
                            <button @click="openCatalogoModal"
                                class="bg-white text-black border-2 border-black px-4 py-1 rounded-lg shadow-lg flex-1 font-bold">
                                Ver catálogo EDF
                            </button>
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
                            type="search" name="search" placeholder="Buscar" v-model="searchQuery">
                    </div>
                    <div class="flex gap-2 my-4">
                        <button class="px-4 py-1 text-sm rounded-full border-black border-2"
                            :class="{ 'bg-black text-white': selectedFilter === 'todos', 'bg-white text-black': selectedFilter !== 'todos' }"
                            @click="selectedFilter = 'todos'">Todos</button>
                        <button class="px-4 py-1 text-sm rounded-full border-black border-2"
                            :class="{ 'bg-black text-white': selectedFilter === 'pendientes', 'bg-white text-black': selectedFilter !== 'pendientes' }"
                            @click="selectedFilter = 'pendientes'">Pendientes</button>
                        <button class="px-4 py-1 text-sm rounded-full border-black border-2"
                            :class="{ 'bg-black text-white': selectedFilter === 'negociados', 'bg-white text-black': selectedFilter !== 'negociados' }"
                            @click="selectedFilter = 'negociados'">Negociados</button>
                    </div>
                </div>

                <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex flex-col gap-4">
                        <div class="bg-white shadow-md rounded-lg overflow-hidden flex border-2" :class="{ 'border-green-500': client.NEGOCIADO === 'NEGOCIADO', 'border-transparent': client.NEGOCIADO !== 'NEGOCIADO' }"
                            v-for="client in filteredClients">
                            <div class="flex-1 border-r border-gray-200">
                                <div class="p-4">
                                    <div style="font-size:10px" class="text-sm font-semibold"><i class="fa-solid fa-user"></i>
                                        {{ client.COD_CLIENTE }}
                                        - {{ client.CLIENTE }}</div>
                                    <div style="font-size:10px" class="text-sm">{{ client.DIRECCION.charAt(0).toUpperCase() + client.DIRECCION.slice(1).toLowerCase() }}</div>
                                    <div class="mt-2">
                                        <span v-if="client.N_EDF == 0"
                                            class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">
                                            <i class="fa-solid fa-fax"></i> No cuenta con EDF
                                        </span>
                                        <span v-else
                                            class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">
                                            <i class="fa-solid fa-fax"></i> Cuenta con {{ client.N_EDF }} EDF
                                        </span> <br />
                                        <span v-if="client.STATUS === 'EN RUTA' || client.STATUS === 'NEGOCIADO'"
                                            class="text-green-600 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <span v-if="client.dias_restantes >= 0">
                                                <span>
                                                    El EDF llega en {{client.dias_restantes}} días
                                                </span>
                                            </span>
                                            <span v-else class="text-red-600">
                                                El EDF debió llegar hace {{ Math.abs(client.dias_restantes) }} días
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="client.NEGOCIADO == 'PENDIENTE'" class="flex-1 text-left">
                                <div class="p-4 text-left">
                                    <div class="text-sm text-black font-bold">Puedes negociar</div>
                                    <ul class="list-disc pl-3">
                                        <li style="font-size:10px" class="text-xs mt-1">EDF - {{ client.PUERTAS_A_NEGOCIAR }} Puertas - {{ client.CONDICION.charAt(0).toUpperCase() + client.CONDICION.slice(1).toLowerCase() }}</li>
                                        <li  v-if="client.PUERTAS_A_NEGOCIAR_2" style="font-size:10px" class="mb-2 text-xs mt-1">EDF - {{ client.PUERTAS_A_NEGOCIAR_2 }} Puertas - {{ client.CONDICION_2.charAt(0).toUpperCase() + client.CONDICION_2.slice(1).toLowerCase() }}</li>
                                    </ul>
                                    
                                    <a :href="`https://wa.link/ibba8o`" target="_blank"
                                        class=" ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md">
                                        <i class="fa-brands fa-whatsapp"></i>
                                        Negociar EDF
                                    </a>
                                </div>
                            </div>
                            <div v-else class="flex-1 text-left">
                                <div class="p-4 text-left">
                                    <div class="text-sm font-medium text-black font-semibold">
                                        <i class="fa-solid fa-circle-check mr-2"></i>Has Negociado
                                        <ul class="list-disc pl-3">
                                            <li v-if="client.PUERTAS_A_NEGOCIAR != 0" style="font-size:10px" class="text-xs mt-1">EDF - {{ client.PUERTAS_A_NEGOCIAR }} Puertas - Repotenciado</li>
                                            <li v-if="client.PUERTAS_A_NEGOCIAR_2 && client.PUERTAS_A_NEGOCIAR_2 != 0" style="font-size:10px" class="mb-2 text-xs mt-1">EDF - {{ client.PUERTAS_A_NEGOCIAR_2 }} Puertas - Nuevo</li>
                                        </ul>
                                    </div>
                                    <ol class="flex items-center w-full mt-4">
                                        <!-- NEGOCIADO -->
                                        <li class="flex w-full items-center after:content-[''] after:w-full after:h-0.5 after:border-b after:border-gray-200 after:border-2 after:inline-block">
                                            <span
                                                :class="[
                                                    'flex items-center justify-center w-8 h-8 rounded-full lg:h-10 lg:w-10 shrink-0',
                                                    client.STATUS === 'NEGOCIADO' || client.STATUS === 'EN RUTA' || client.STATUS === 'ENTREGADO' || client.STATUS === 'NO EFECTIVO' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-300'
                                                ]">
                                                <i class="fa-solid fa-handshake text-xs"></i>
                                            </span>
                                        </li>
                                        <!-- EN RUTA -->
                                        <li class="flex w-full items-center after:content-[''] after:w-full after:h-0.5 after:border-b after:border-gray-200 after:border-2 after:inline-block">
                                            <span
                                                :class="[
                                                    'flex items-center justify-center w-8 h-8 rounded-full lg:h-10 lg:w-10 shrink-0',
                                                    client.STATUS === 'EN RUTA' || client.STATUS === 'ENTREGADO' || client.STATUS === 'NO EFECTIVO' ? 'bg-green-500 text-white' : 'bg-gray-50 text-gray-300'
                                                ]">
                                                <i class="fa-solid fa-arrows-rotate text-xs"></i>
                                            </span>
                                        </li>
                                        <!-- ENTREGADO -->
                                        <li class="flex w-full items-center">
                                            <span
                                                :class="[
                                                    'flex items-center justify-center w-8 h-8 rounded-full lg:h-10 lg:w-10 shrink-0',
                                                    client.STATUS === 'ENTREGADO' ? 'bg-green-500 text-white' : client.STATUS === 'NO EFECTIVO' ? 'bg-red-500 text-white' : 'bg-gray-50 text-gray-300'
                                                ]">
                                                <i :class="client.STATUS === 'NO EFECTIVO' ? 'fa-solid fa-xmark text-xs' : 'fa-solid fa-check text-xs'"></i>
                                            </span>
                                        </li>
                                    </ol>
                                    <div class="flex items-center w-full mt-2">
                                        <div class="flex w-full items-center justify-left text-xs text-gray-500">
                                            <span v-if="client.STATUS === 'NEGOCIADO'" class="text-green-500">Negociado</span>
                                        </div>
                                        <div class="w-full items-center justify-left text-xs text-gray-500">
                                            <span v-if="client.STATUS === 'EN RUTA'" class="text-green-500">En Ruta</span> 
                                            <br />
                                        </div>
                                        <div class="flex w-full items-center justify-left text-xs text-gray-500">
                                            <span v-if="client.STATUS === 'ENTREGADO'" class="text-green-500">Entregado</span>
                                            <span v-if="client.STATUS === 'NO EFECTIVO'" class="text-red-500">No efectiva</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
