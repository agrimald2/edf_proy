<template>
    <div class="z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <button @click="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-circle-xmark text-gray-500"></i>
            </button>
            <div v-if="showDetails">
                <div class="text-center mb-10 pt-2">
                    <h2 class="text-lg font-bold">Detalles de Permuta</h2>
                    <p>Revisa la información de la permuta</p>
                </div>
                <div>
                    <div v-if="errorMessage" class="text-red-500 text-center mb-4">{{ errorMessage }}</div>
                    <div class="space-y-2">
                        <p class="font-semibold mb-2">Información del cliente</p>
                        <div class="space-y-2">
                            <p><span class="font-medium">Código de cliente:</span> {{ formData.clientCode }}</p>
                            <p><span class="font-medium">Volumen en CU:</span> {{ formData.volumeCU }}</p>
                            <p><span class="font-medium">Locación:</span> {{ formData.location }}</p>
                            <p><span class="font-medium">Ruta:</span> {{ formData.route }}</p>
                            <p><span class="font-medium">Subcanal:</span> {{ formData.subcanal }}</p>
                            <p class="font-semibold mt-4">EDF a solicitar</p>
                            <p><span class="font-medium">Condición:</span> {{ formData.condition }}</p>
                            <p><span class="font-medium">Puertas a negociar:</span> {{ formData.doorsToNegotiate }}</p>
                            <p><span class="font-medium">Motivo:</span> {{ formData.reason }}</p>
                            <p><span class="font-medium">Justificación:</span> {{ formData.justification }}</p>
                        </div>
                    </div>
                    <div class="mt-2 text-center bg-white border rounded-lg py-2 border-black font-medium">
                        <button @click="closeModal" class=" text-black hover:underline focus:outline-none
                        rounded-full">Cerrar</button>
                    </div>
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

<script>
export default {
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        permuta: {
            type: Object,
            required: true
        },
        haveAvailableLimit: {
            type: Boolean,
            default: true
        },
        sv: {
            type: String,
        }
    },
    data() {
        return {
            formData: {
                clientCode: this.permuta.cod_cliente,
                volumeCU: this.permuta.volume,
                location: this.permuta.location.name,
                route: this.permuta.route,
                subcanal: this.permuta.subcanal,
                haveEdf: this.permuta.have_edf,
                doorsToNegotiate: this.permuta.doors_to_negotiate,
                condition: this.permuta.condition,
                reason: this.permuta.reason,
                justification: this.permuta.justification
            },
            reasons: [],
            sentPermutaViewModal: false,
            errorMessage: '',
            isSubmitting: false,
            showDetails: true
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
    },
    methods: {
        detailsModal() {
            console.log("A");
            this.showDetails = true;
        },
        closeModal() {
            this.$emit('close');
            this.detailsModal();
        },
    }
}
</script>
