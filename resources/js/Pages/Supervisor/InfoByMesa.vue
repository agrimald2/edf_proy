<template>
    <GuestLayout :title="`Mesa | EDF`">
        <template #header>
            <div class="grid grid-cols-2 gap-4 items-center">
                <div>
                    <p class="text-xs">{{ todaysDate }}</p>
                    <h2 class="font-bold text-xs text-black leading-tight">
                        ¡Hola, {{ supervisor }}!
                    </h2>
                </div>
                <!--
                <div class="flex items-center" style="margin-left: auto">
                    <span class="text-xs font-bold">Frecuencia:</span>
                    <select style="padding-right: 2rem;"
                        class="block mt-1 border-none rounded focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-xs">
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
        <div class="py-4">
            <div class="max-w-5xl mx-auto sm:px-4 lg:px-6">
                <div class="overflow-hidden px-2">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row gap-2 w-1/3">
                            <div class="bg-green-600 rounded-md flex-1 flex flex-col p-2">
                                <div class="flex items-center justify-between w-full mb-1">
                                    <i class="fa-solid fa-users text-white text-xl"></i>
                                </div>
                                <h3 class="text-xs text-white">Avance de Cuota</h3>
                                <p class="text-white text-xl font-bold text-left w-full"> {{ negociados }}/{{ cuota }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-2 mb-4">
            <button @click="$inertia.get(route('supervisor.permutas.list', { mesa }))"
                class="bg-black text-white py-1 px-4 rounded-md flex items-center">
                <i class="fa-solid fa-book mr-2"></i>
                Permutas
            </button>
        </div>
        <div class="px-2">
            <div class="relative mx-auto text-gray-600 w-full">
                <input
                    class="border-2 border-gray-300 bg-white h-8 px-4 pr-14 rounded-lg text-xs focus:outline-none w-full"
                    type="search" name="search" placeholder="Buscar por GV" v-model="searchQuery">
            </div>
        </div>
        <div class="flex gap-2 my-4 px-2">
            <button class="px-3 py-1 text-xs rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'todos', 'bg-white text-black': selectedFilter !== 'todos' }"
                @click="selectedFilter = 'todos'">Todos</button>
            <button class="px-3 py-1 text-xs rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'pendientes', 'bg-white text-black': selectedFilter !== 'pendientes' }"
                @click="selectedFilter = 'pendientes'">Con avance</button>
            <button class="px-3 py-1 text-xs rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'negociados', 'bg-white text-black': selectedFilter !== 'negociados' }"
                @click="selectedFilter = 'negociados'">Sin avance</button>
        </div>
        <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col gap-4">
                <div v-for="gestor in filteredGestores" :key="gestor.ruta" style="position:relative"
                    :class="['bg-white shadow-md rounded-lg overflow-hidden flex', { 'border-red-500 border-2': gestor.total_negociados == 0 }]">
                    <div v-if="gestor.total_negociados == 0"
                        class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-tr-lg">
                        !
                    </div>
                    <div class="flex-1 border-r border-gray-200">
                        <div class="p-4">
                            <div class="text-xs font-semibold"><i class="fa-solid fa-user"></i>
                                {{ gestor.ruta }} {{ gestor.gv }}
                            </div>
                            <div class="text-xs pt-2 pl-4">
                                <span class="font-bold">
                                    Clientes Negociados:
                                </span>
                                {{ gestor.total_negociados }}
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="p-4 text-left">
                            <div class="text-xs text-black font-bold">Puertas negociadas</div>
                            <div class="text-xs mt-1 font-medium text-gray-500">
                                Repotenciadas: {{ gestor.n_puertas_negociadas_repotenciadas }}
                            </div>
                            <div class="text-xs font-medium text-gray-500">
                                Nuevas: {{ gestor.n_puertas_negociadas_nuevas }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';

export default {
    props: {
        mesa: String,
        clients: Array,
        negociados: Number,
        noNegociados: Number,
        gv: String,
        cuota: Number,
        pending: Number,
        supervisor: String, // Moved supervisor prop here,
        progress: String,
        gestores: Array,
    },
    components: {
        GuestLayout
    },
    data() {
        return {
            todaysDate: new Date().toLocaleDateString('es-ES', {
                weekday: 'short', year: 'numeric',
                month: 'short', day: 'numeric'
            }).replace(/^\w/, c => c.toUpperCase()),
            selectedFilter: 'todos',
            searchQuery: '' // Added searchQuery to data
        };
    },
    computed: {
        filteredGestores() {
            return this.gestores.filter(gestor => {
                const matchesSearch = gestor.gv.toLowerCase().includes(this.searchQuery.toLowerCase());
                if (this.selectedFilter === 'pendientes') {
                    return matchesSearch && gestor.total_negociados === 0;
                } else if (this.selectedFilter === 'negociados') {
                    return matchesSearch && gestor.total_negociados > 0;
                }
                return matchesSearch;
            });
        }
    }
};
</script>
