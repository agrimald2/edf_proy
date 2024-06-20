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
                        </div>
                        <div v-if="permuta.status == 'Pending'" class="mt-2 pt-2 flex justify-between">
                            <button @click="approvePermuta"
                                class="w-1/2 py-3 font-medium rounded-md bg-green-500 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 mr-2">
                                APROBAR
                            </button>
                            <button @click="rejectPermuta"
                                class="w-1/2 py-3 font-medium rounded-md bg-red-500 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 ml-2">
                                RECHAZAR
                            </button>
                        </div>
                    </div>
                    <div class="mt-2 text-center bg-white border rounded-lg py-2 border-black font-medium">
                        <button @click="closeModal" class=" text-black hover:underline focus:outline-none
                        rounded-full">Cerrar</button>
                    </div>
                </div>
            </div>

            <PermutaRejectReasonModal v-if="showRejectReasonModal" :permuta-id="permuta.id"
                @show-details-modal="detailsModal" @show-rejected-modal="showRejectedModal = true"
                @close="showRejectReasonModal = false" />
            <PermutaRejectedModal v-if="showRejectedModal" :permuta-id="permuta.id"
                @close="showRejectedModal = false" />
            <PermutaApproveConfirmationModal v-if="showApproveConfirmationModal" :permuta-id="permuta.id"
                @show-details-modal="detailsModal" @close="showApproveConfirmationModal = false"
                @show-approved-modal="showApprovedModal = true" />
            <PermutaApprovedModal v-if="showApprovedModal" :permuta-id="permuta.id"
                @close="showApprovedModal = false" />
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
import PermutaRejectReasonModal from './PermutaRejectReasonModal.vue';
import PermutaApproveConfirmationModal from './PermutaApproveConfirmationModal.vue';
import PermutaApprovedModal from './PermutaApprovedModal.vue';
import PermutaRejectedModal from './PermutaRejectedModal.vue';
export default {
    components: {
        PermutaRejectReasonModal,
        PermutaApproveConfirmationModal,
        PermutaApprovedModal,
        PermutaRejectedModal
    },
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        permuta: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            formData: {
                clientCode: this.permuta.cod_cliente,
                volumeCU: this.permuta.volume,
                location: this.permuta.location,
                route: this.permuta.route,
                subcanal: this.permuta.subcanal,
                haveEdf: this.permuta.have_edf,
                doorsToNegotiate: this.permuta.doors_to_negotiate,
                condition: this.permuta.condition,
                reason: this.permuta.reason
            },
            reasons: [],
            sentPermutaViewModal: false,
            errorMessage: '',
            isSubmitting: false,
            errorMessage: '',
            isSubmitting: false,
            showDetails: true,
            showRejectReasonModal: false,
            showRejectedModal: false,
            showApproveConfirmationModal: false,
            showApprovedModal: false
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
        approvePermuta() {
            this.showDetails = false;
            this.showApproveConfirmationModal = true;
        },
        rejectPermuta() {
            this.showDetails = false;
            this.showRejectReasonModal = true;
        },
        detailsModal() {
            console.log("A");
            this.showDetails = true;
            this.showRejectReasonModal = false;
            this.showRejectedModal = false;
            this.showApproveConfirmationModal = false;
            this.showApprovedModal = false;
        },
        closeModal() {
            this.$emit('close');
            this.detailsModal();
        },
    }
}
</script>
