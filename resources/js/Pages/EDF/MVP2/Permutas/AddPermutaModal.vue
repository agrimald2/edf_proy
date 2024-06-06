<template>
    <div class="z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div v-if="!sentPermutaViewModal" class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <button @click="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-circle-xmark text-gray-500"></i>
            </button>
            <div class="text-center mb-10 pt-6">
                <h2 class="text-lg font-bold">Permutas</h2>
                <p>Ingresa los datos solicitados</p>
            </div>
            <div>
                <form class="space-y-4" @submit.prevent="submitForm">
                    <p class="font-semibold mb-2">Información del cliente</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input v-model="formData.clientCode" type="text" placeholder="Código de cliente"
                                class="w-full inputs_permutas">
                        </div>
                        <div>
                            <input v-model="formData.volumeCU" type="text" placeholder="Volumen en CU"
                                class="w-full inputs_permutas">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input v-model="formData.location" type="text" placeholder="Locación"
                                class="w-full inputs_permutas">
                        </div>
                        <div>
                            <input v-model="formData.route" type="text" placeholder="Ruta"
                                class="w-full inputs_permutas">
                        </div>
                    </div>
                    <div class="mt-4 mb-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-center">
                                <p class="mb-2 text-left text-gray-800">¿Cuenta con EDF?</p>
                            </div>
                            <div class="flex justify-center items-center space-x-6">
                                <label class="flex items-center">
                                    <input v-model="formData.edf" type="radio" name="edf" value="yes"
                                        class="form-radio h-5 w-5 border-2 border-gray-400">
                                    <span class="ml-2">Sí</span>
                                </label>
                                <label class="flex items-center">
                                    <input v-model="formData.edf" type="radio" name="edf" value="no"
                                        class="form-radio h-5 w-5 border-2 border-gray-400">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <p class="font-semibold">EDF a solicitar</p>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <input v-model="formData.doorsToNegotiate" type="text" placeholder="Puertas a negociar"
                                class="w-full inputs_permutas">
                        </div>
                        <div>
                            <select v-model="formData.condition" class="w-full inputs_permutas">
                                <option value="" disabled selected>Condición</option>
                                <option value="Nuevo">Nuevo</option>
                                <option value="Repotenciado">Repotenciado</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <select v-model="formData.reason" class="w-full inputs_permutas">
                            <option value="" disabled selected>Seleccionar motivo de permuta</option>
                            <option value="1">Motivo 1</option>
                            <option value="2">Motivo 2</option>
                            <option value="3">Motivo 3</option>
                            <!-- @TODO Motivos de Permuta DB -->
                        </select>
                    </div>
                    <div class="mt-10 pt-10">
                        <button :disabled="!isFormComplete" @click="submitForm"
                            :class="['w-full py-3 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50', isFormComplete ? 'bg-black text-white hover:bg-gray-800 focus:ring-gray-400' : 'bg-gray-300 text-gray-500 hover:bg-blue-700 focus:ring-blue-400']">
                            Enviar permuta
                        </button>
                    </div>
                </form>
                <div class="mt-2 text-center bg-white border rounded-lg py-2 border-black font-medium">
                    <button @click="closeModal" class=" text-black hover:underline focus:outline-none
                        rounded-full">Cerrar</button>
                </div>
            </div>
        </div>
        <div v-else class="bg-white rounded-lg shadow-lg w-96 p-6">
            <PermutaSent @accept="closeModal" />
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

<script>
import PermutaSent from './PermutaSent.vue';
export default {
    components: {
        PermutaSent
    },
    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            formData: {
                clientCode: '',
                volumeCU: '',
                location: '',
                route: '',
                edf: '',
                doorsToNegotiate: '',
                condition: '',
                reason: ''
            },
            sentPermutaViewModal: false
        };
    },
    computed: {
        isFormComplete() {
            return this.formData.clientCode && this.formData.volumeCU && this.formData.location && this.formData.route && this.formData.edf && this.formData.doorsToNegotiate && this.formData.condition && this.formData.reason;
        }
    },
    methods: {
        closeModal() {
            console.log("Hoolaa");
            this.$emit('close');
        },
        submitForm() {
            if (this.isFormComplete) {
                this.showSentPermutaView();
                /* Send the data to the POST route
                fetch('/your-post-route', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        this.closeModal();
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                */
            }
        },
        showSentPermutaView() {
            this.sentPermutaViewModal = true;
        }
    }
}
</script>
