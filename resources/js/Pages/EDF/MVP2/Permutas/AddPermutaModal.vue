<template>
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <!-- Modal Container -->
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <!-- Modal Header -->
            <div class="text-center mb-10 pt-6">
                <h2 class="text-lg font-bold">Permutas</h2>
                <p>Ingresa los datos solicitados</p>
            </div>
            <!-- Modal Content -->
            <div>
                <form class="space-y-4">
                    <p class="font-semibold mb-2">Información del cliente</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input id="clientCode" type="text" placeholder="Código de cliente"
                                class="w-full inputs_permutas">
                        </div>
                        <div>
                            <input id="volumeCU" type="text" placeholder="Volumen en CU" class="w-full inputs_permutas">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input id="location" type="text" placeholder="Locación" class="w-full inputs_permutas">
                        </div>
                        <div>
                            <input id="route" type="text" placeholder="Ruta" class="w-full inputs_permutas">
                        </div>
                    </div>
                    <div class="mt-4 mb-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-center">
                                <p class="mb-2 text-left text-gray-800">¿Cuenta con EDF?</p>
                            </div>
                            <div class="flex justify-center items-center space-x-6">
                                <label class="flex items-center">
                                    <input type="radio" name="edf" value="yes"
                                        class="form-radio h-5 w-5 border-2 border-gray-400">
                                    <span class="ml-2">Sí</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="edf" value="no"
                                        class="form-radio h-5 w-5 border-2 border-gray-400">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <p class="font-semibold">EDF a solicitar</p>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <input id="doorsToNegotiate" type="text" placeholder="Puertas a negociar"
                                class="w-full inputs_permutas">
                        </div>
                        <div>
                            <select id="condition" class="w-full inputs_permutas">
                                <option value="" disabled selected>Condición</option>
                                <option value="">Nuevo</option>
                                <option value="">Repotenciado</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <select id="reason" class="w-full inputs_permutas">
                            <option value="" disabled selected>Seleccionar motivo de permuta</option>
                            <option value="1" >Motivo 1</option>
                            <option value="2" >Motivo 2</option>
                            <option value="3" >Motivo 3</option>
                            <!-- @TODO Motivos de Permuta DB -->
                        </select>
                    </div>
                    <div class="mt-10 pt-10">
                        <button type="submit"
                            class="w-full bg-gray-300 text-gray-500 py-3 font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Enviar
                            permuta</button>
                    </div>
                </form>
                <div class="mt-2 text-center bg-white border rounded-lg py-2 border-black font-medium">
                    <button class="text-black hover:underline focus:outline-none rounded-full">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.inputs_permutas {
    border-radius: 0.375rem;
    background-color: #f8f8fc;
    border: none;
    padding: 15px 10px;
    color: black;
    /* Input text color */
}

.inputs_permutas::placeholder {
    color: gray;
    /* Placeholder text color */
}
</style>