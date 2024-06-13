<template>
    <GuestLayout :title="`Permutas | EDF`">
        <template #header>
            <div class="grid grid-cols-2 gap-4 items-center">
                <div>
                    <h2 class="font-bold text-sm text-black leading-tight">
                        ¡Hola, Javier!
                    </h2>
                    <p class="text-sm">Gerente de sala</p>
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
                            3
                        </div>
                    </div>
                </div>
                <div class="flex-1 text-left">
                    <div class="p-4 text-left">
                        <div class="text-sm text-black font-bold"><i class="fa-solid fa-clock text-yellow-500"></i>
                            Restantes
                        </div>
                        <div class="text-xs mt-1 font-medium text-gray-500">
                            Cantidad: 5
                        </div>
                    </div>
                </div>
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
                :class="{ 'bg-black text-white': selectedFilter === 'aprobadas', 'bg-white text-black': selectedFilter !== 'aprobadas' }"
                @click="selectedFilter = 'aprobadas'">Aprobadas</button>
            <button class="px-3 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'rechazadas', 'bg-white text-black': selectedFilter !== 'rechazadas' }"
                @click="selectedFilter = 'rechazadas'">Rechazadas</button>
            <button class="px-3 py-1 text-sm rounded-full border-black border-2"
                :class="{ 'bg-black text-white': selectedFilter === 'pendientes', 'bg-white text-black': selectedFilter !== 'pendientes' }"
                @click="selectedFilter = 'pendientes'">Pendientes</button>
        </div>
        <div class="p-2 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col gap-4">
                <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
                    <div class="w-3/5 border-r border-gray-200">
                        <div class="p-4">
                            <div class="text-sm font-semibold"><i class="fa-solid fa-user"></i>
                                9485839 - Luis Rosales
                            </div>
                            <div class="text-xs flex items-center justify-between">
                                <div class="bg-gray-100 rounded pt-1 pl-2 pb-1 pr-2 flex-3/4">
                                    <i class="fa-brands fa-square-letterboxd mr-2"></i>
                                    No cuenta con EDF
                                </div>
                                <div class="flex-1/4 text-right">
                                    50 CU
                                </div>
                            </div>
                            <div class="mt-2">
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-1 rounded dark:bg-red-200 dark:text-red-900">
                                    <i class="fa-solid fa-x"></i> Permuta Rechazada
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="w-2/5 text-left">
                        <div class="p-4 text-left">
                            <div class="text-sm text-black font-bold">MESA</div>
                            <div class="text-xs mt-1 font-medium text-gray-500">
                                Ruta 3948
                            </div>
                            <div class="text-xs font-medium text-gray-500 mt-2">
                                <button class="bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full">Ver
                                    más</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
                    <div class="w-3/5 border-r border-gray-200">
                        <div class="p-4">
                            <div class="text-sm font-semibold"><i class="fa-solid fa-user"></i>
                                9485839 - Luis Rosales
                            </div>
                            <div class="text-xs flex items-center justify-between">
                                <div class="bg-gray-100 rounded pt-1 pl-2 pb-1 pr-2 flex-3/4">
                                    <i class=" fa-brands fa-square-letterboxd mr-2"></i>
                                    No cuenta con EDF
                                </div>
                                <div class="flex-1/4 text-right">
                                    50 CU
                                </div>
                            </div>
                            <div class="mt-2">
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-1 rounded dark:bg-green-200 dark:text-green-900">
                                    <i class="fa-solid fa-check"></i> Permuta Aprobada
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="w-2/5 text-left">
                        <div class="p-4 text-left">
                            <div class="text-sm text-black font-bold">33 PACI VES</div>
                            <div class="text-xs mt-1 font-medium text-gray-500">
                                Ruta 3948
                            </div>
                            <div class="text-xs font-medium text-gray-500 mt-2">
                                <button class="bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full">Ver
                                    más</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
                    <div class="w-3/5 border-r border-gray-200">
                        <div class="p-4">
                            <div class="text-sm font-semibold"><i class="fa-solid fa-user"></i>
                                9485839 - Luis Rosales
                            </div>
                            <div class="text-xs flex items-center justify-between">
                                <div class="bg-gray-100 rounded pt-1 pl-2 pb-1 pr-2 flex-3/4">
                                    <i class=" fa-brands fa-square-letterboxd mr-2"></i>
                                    No cuenta con EDF
                                </div>
                                <div class="flex-1/4 text-right">
                                    50 CU
                                </div>
                            </div>
                            <div class="mt-2">
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-1 rounded dark:bg-yellow-200 dark:text-yellow-900">
                                    <i class="fa-solid fa-spinner"></i> Permuta Pendiente
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="w-2/5 text-left">
                        <div class="p-4 text-left">
                            <div class="text-sm text-black font-bold">33 PACI VES</div>
                            <div class="text-xs mt-1 font-medium text-gray-500">
                                Ruta 3948
                            </div>
                            <div class="text-xs font-medium text-gray-500 mt-2">
                                <button class="bg-red-500 text-white font-bold py-1 px-2 rounded-md w-full">Ver
                                    más</button>
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
