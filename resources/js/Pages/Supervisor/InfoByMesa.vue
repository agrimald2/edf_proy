<template>
    <GuestLayout :title="`Mesa | EDF`">
        <template #header>
            <div class="grid grid-cols-2 gap-4 items-center">
                <div>
                    <p class="text-sm">{{ todaysDate }}</p>
                    <h2 class="font-bold text-sm text-black leading-tight">
                        ¡Hola, {{ supervisor }}!
                    </h2>
                </div>
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
            </div>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden px-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-row gap-4 w-2/5">
                            <div class="bg-green-600 rounded-lg flex-1 flex flex-col p-4">
                                <div class="flex items-center justify-between w-full mb-2">
                                    <i class="fa-solid fa-users text-white text-3xl"></i>
                                    <span class="bg-white text-green-600 rounded px-2 font-bold">20%</span>
                                </div>
                                <h3 class="text-md text-white">Avance de Cuota</h3>
                                <p class="text-white text-3xl font-bold text-left w-full"> 3/21</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-2">
            <div class="relative mx-auto text-gray-600 w-full">
                <input
                    class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none w-full"
                    type="search" name="search" placeholder="Buscar" v-model="searchQuery">
            </div>
        </div>
        <div class="flex gap-2 my-4 px-2">
            <button class="px-4 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'todos', 'bg-white text-black': selectedFilter !== 'todos' }"
                @click="selectedFilter = 'todos'">Todos</button>
            <button class="px-4 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'pendientes', 'bg-white text-black': selectedFilter !== 'pendientes' }"
                @click="selectedFilter = 'pendientes'">No Negociados</button>
            <button class="px-4 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'negociados', 'bg-white text-black': selectedFilter !== 'negociados' }"
                @click="selectedFilter = 'negociados'">Negociados</button>
        </div>
        <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col gap-4">
                <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
                    <div class="flex-1 border-r border-gray-200">
                        <div class="p-4">
                            <div class="text-sm font-semibold"><i class="fa-solid fa-user"></i>
                                IPH38 Andrea Vargas
                            </div>
                            <div class="text-xs pt-2 pl-4">
                                <span class="font-bold">
                                    Clientes Negociados:
                                </span>
                                3
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="p-4 text-left">
                            <div class="text-sm text-black font-bold">Puertas negociadas</div>
                            <div class="text-xs mt-1 font-medium text-gray-500">
                                Repotenciadas: 1
                            </div>
                            <div class="text-xs font-medium text-gray-500">
                                Nuevas: 2
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg overflow-hidden flex border-red-500 border-2 relative">
                    <div class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                        !
                    </div>
                    <div class="flex-1 border-r border-gray-200">
                        <div class="p-4">
                            <div class="text-sm font-semibold"><i class="fa-solid fa-user"></i>
                                IPH38 Andrea Vargas
                            </div>
                            <div class="text-xs pt-2 pl-4">
                                <span class="font-bold">
                                    Clientes Negociados:
                                </span>
                                3
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="p-4 text-left">
                            <div class="text-sm text-black font-bold">Puertas negociadas</div>
                            <div class="text-xs mt-1 font-medium text-gray-500">
                                Repotenciadas: 0
                            </div>
                            <div class="text-xs font-medium text-gray-500">
                                Nuevas: 0
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
    components: {
        GuestLayout
    },
    props: ['supervisor'],
    data() {
        return {
            todaysDate: new Date().toLocaleDateString('es-ES', {
                weekday: 'short', year: 'numeric',
                month: 'short', day: 'numeric'
            }).replace(/^\w/, c => c.toUpperCase()),
            selectedFilter: 'todos'
        };
    }
};
</script>
