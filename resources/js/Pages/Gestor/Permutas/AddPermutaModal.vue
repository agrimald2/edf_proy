<template>
    <div class="z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div v-if="!sentPermutaViewModal"
            class="bg-white rounded-lg shadow-lg w-96 p-6 relative max-h-[85vh] overflow-y-auto"
            style="margin-left: auto; margin-right: auto; margin-top: 2rem;">
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
                        <div class="relative" ref="search">
                            <input v-model="formData.clientCode" type="tel" placeholder="Código de cliente"
                                :class="['w-full inputs_permutas', showError && formData.clientCode === '' ? 'border-red-500' : '']"
                                @focus="showDropdown = true" @blur="setTimeout(() => showDropdown = false, 100)">
                            <ul v-show="showDropdown && searchResults.length"
                                class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                                <li v-for="result in searchResults" :key="result.code"
                                    class="p-2 hover:bg-gray-100 cursor-pointer" @click="selectClient(result)">
                                    {{ result.code }}
                                </li>
                            </ul>
                        </div>
                        <div>
                            <input v-model="formData.volumeCU" type="tel" placeholder="Volumen en CU" :disabled="disableVolumeCU"
                                :class="['w-full inputs_permutas', showError && formData.volumeCU === '' ? 'border-red-500' : '']">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input type="text" class="w-full inputs_permutas" disabled :value="locationName">
                        </div>
                        <div>
                            <input v-model="formData.route" type="text" placeholder="Ruta" disabled
                                class="w-full inputs_permutas">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <div>
                            <input v-model="formData.subcanal" type="text" placeholder="Subcanal"
                                :class="['w-full inputs_permutas', showError && formData.subcanal === '' ? 'border-red-500' : '']">
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
                                <select v-model="formData.doorsToNegotiate" class="w-full inputs_permutas">
                                    <option v-for="option in doorsOptions" :key="option" :value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full">
                            <select v-model="formData.reason" class="w-full inputs_permutas">
                                <option value="" disabled selected>Motivo</option>
                                <option v-for="reason in reasons" :key="reason.id" :value="reason.name">{{ reason.name
                                    }}</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <input v-model="formData.justification" type="text" placeholder="Justificación"
                                    :class="['w-full inputs_permutas', showError && formData.justification === '' ? 'border-red-500' : '']">
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
                    <button @click="closeModal"
                        class=" text-black hover:underline focus:outline-none rounded-full">Cerrar</button>
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

.border-red-500 {
    border: 1px solid red;
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
        },
        location_id: {
            type: String
        }
    },
    data() {
        return {
            formData: {
                clientCode: '',
                volumeCU: '',
                location_id: this.location_id,
                route: this.ruta,
                subcanal: '',
                haveEdf: 0,
                doorsToNegotiate: '',
                condition: '',
                reason: '',
                justification: '',
                sv: this.sv
            },
            disableVolumeCU: false,
            reasons: [],
            locations: [],
            sentPermutaViewModal: false,
            errorMessage: '',
            isSubmitting: false,
            showError: false,
            searchResults: [],
            selectedClient: null,
            showDropdown: false,
        };
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
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
    beforeDestroy() {
        document.removeEventListener('click', this.handleClickOutside);
    },
    computed: {
        isFormComplete() {
            return this.formData.location_id && this.formData.clientCode && this.formData.volumeCU && this.formData.route && this.formData.haveEdf !== '' && this.formData.doorsToNegotiate && this.formData.condition && this.formData.reason;
        },
        doorsOptions() {
            const volumeCU = parseInt(this.formData.volumeCU);
            const condition = this.formData.condition.toUpperCase();
            let options = [];

            if (volumeCU < 20) {
                if (condition === 'REPOTENCIADO') {
                    options = [0.5, 1];
                }
            } else if (volumeCU < 40) {
                if (condition === 'REPOTENCIADO') {
                    options = [0.5, 1, 2];
                } else if (condition === 'NUEVO') {
                    options = [0.5, 1];
                }
            } else if (volumeCU < 42) {
                if (condition === 'REPOTENCIADO' || condition === 'NUEVO') {
                    options = [0.5, 1, 2];
                }
            } else if (volumeCU < 60) {
                if (condition === 'REPOTENCIADO') {
                    options = [0.5, 1, 2, 3];
                } else if (condition === 'NUEVO') {
                    options = [0.5, 1, 2];
                }
            } else if (volumeCU >= 60) {
                if (condition === 'REPOTENCIADO' || condition === 'NUEVO') {
                    options = [0.5, 1, 2, 3];
                }
            }

            return options;
        },
        locationName() {
            const location = this.locations.find(loc => loc.id === this.formData.location_id);
            return location ? location.name : '';
        }
    },
    watch: {
        'formData.clientCode'(newVal) {
            if (newVal.length >= 3) { // Asumiendo que quieres empezar a buscar después de 3 caracteres
                this.searchClients(newVal);
            } else {
                this.searchResults = [];
            }
        },
        selectedClient(newVal, oldVal) {
            if (newVal) {
                this.formData.volumeCU = newVal.volumen_cu;
            }
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
                            return response.json().then(errData => {
                                console.dir(errData);
                                throw new Error(errData.error || 'Network response was not ok');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Success:', data);
                        this.showSentPermutaView();
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        this.errorMessage = `ERROR: ${error.message}`;
                        this.showError = true;
                    })
                    .finally(() => {
                        this.isSubmitting = false;
                    });
            } else {
                this.errorMessage = 'Please complete all fields before submitting.';
                this.showError = true;
            }
        },
        showSentPermutaView() {
            this.sentPermutaViewModal = true;
        },
        searchClients(query) {
            fetch(`/api/customers/search/${query}`)
                .then(response => response.json())
                .then(data => {
                    this.searchResults = data;
                })
                .catch(error => {
                    console.error('Error fetching clients:', error);
                });
        },
        selectClient(client) {
            this.selectedClient = client;
            this.formData.clientCode = client.code;
            // El volumen en CU se actualizará automáticamente gracias al watcher de selectedClient
            // disabled input volumen cu
            this.disableVolumeCU = true;
        },
        handleClickOutside(event) {
            if (this.$refs.search && !this.$refs.search.contains(event.target)) {
                this.showDropdown = false;
            }
        },
    }
}
</script>