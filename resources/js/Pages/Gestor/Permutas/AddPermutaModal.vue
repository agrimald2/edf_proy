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
                <div v-if="errorMessage" class="text-red-500 text-center mb-4">{{ errorMessage }}</div>
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
                            <select v-model="formData.location_id" class="w-full inputs_permutas">
                                <option value="" disabled selected>Locación</option>
                                <option v-for="location in locations" :key="location.id" :value="location.id">{{ location.name }}</option>
                            </select>
                        </div>
                        <div>
                            <input v-model="formData.route" type="text" placeholder="Ruta"
                                class="w-full inputs_permutas">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <div>
                            <input v-model="formData.subcanal" type="text" placeholder="Subcanal"
                                class="w-full inputs_permutas">
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <label class="mr-4">¿Cuenta con EDF?</label>
                        <div class="flex items-center">
                            <input type="radio" id="edfSi" value="1" v-model="formData.haveEdf" class="mr-1">
                            <label for="edfSi" class="mr-4">SI</label>
                            <input type="radio" id="edfNo" value="0" v-model="formData.haveEdf" class="mr-1">
                            <label for="edfNo">NO</label>
                        </div>
                    </div>
                    <p class="font-semibold">EDF a solicitar</p>
                    <div class="mt-4 mb-2">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex items-center ">
                                <div class="w-full">
                                    <select v-model="formData.condition" class="w-full inputs_permutas">
                                        <option value="" disabled selected>Condición</option>
                                        <option value="Nuevo">Nuevo</option>
                                        <option value="Repotenciado">Repotenciado</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <input v-model="formData.doorsToNegotiate" type="text" placeholder="Puertas a negociar"
                                    class="w-full inputs_permutas">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full">
                            <select v-model="formData.reason" class="w-full inputs_permutas">
                                <option value="" disabled selected>Motivo</option>
                                <option v-for="reason in reasons" :key="reason.id" :value="reason.name">{{ reason.name
                                    }}
                                </option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <input v-model="formData.justification" type="text" placeholder="Justificación"
                                    class="w-full inputs_permutas">
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 pt-2">
                        <button :disabled="!isFormComplete || isSubmitting" @click="submitForm"
                            :class="['w-full py-3 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50', isFormComplete && !isSubmitting ? 'bg-black text-white hover:bg-gray-800 focus:ring-gray-400' : 'bg-gray-300 text-gray-500 hover:bg-blue-700 focus:ring-blue-400']">
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
        sv: {
            type: String
        },
        ruta: {
            type: String
        }
    },
    data() {
        return {
            formData: {
                clientCode: '',
                volumeCU: '',
                location_id: '',
                route: this.ruta,
                subcanal: '',
                haveEdf: 0,
                doorsToNegotiate: '',
                condition: '',
                reason: '',
                justification: '',
                sv: this.sv
            },
            reasons: [],
            locations: [],
            sentPermutaViewModal: false,
            errorMessage: '',
            isSubmitting: false
        };
    },
    mounted() {
        fetch('/api/permuta-reasons')
            .then(response => response.json())
            .then(data => {
                this.reasons = data;
            })
            .catch(error => {
                console.error('Error fetching reasons:', error);
            });

        fetch('/api/locations')
            .then(response => response.json())
            .then(data => {
                this.locations = data;
            })
            .catch(error => {
                console.error('Error fetching locations:', error);
            });
    },
    computed: {
        isFormComplete() {
            return this.formData.clientCode && this.formData.volumeCU && this.formData.route && this.formData.haveEdf !== '' && this.formData.doorsToNegotiate && this.formData.condition && this.formData.reason;
        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        submitForm() {
            if (this.isFormComplete && !this.isSubmitting) {
                this.isSubmitting = true;
                fetch('/api/permutas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(this.formData),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);
                        this.showSentPermutaView();
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        this.errorMessage = 'Failed to submit permuta. Please try again.';
                    })
                    .finally(() => {
                        this.isSubmitting = false;
                    });
            } else {
                this.errorMessage = 'Please complete all fields before submitting.';
            }
        },
        showSentPermutaView() {
            this.sentPermutaViewModal = true;
        }
    }
}
</script>