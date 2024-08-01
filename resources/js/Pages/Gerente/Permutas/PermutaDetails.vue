<template>
    <div class="z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <button @click="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-circle-xmark text-gray-500"></i>
            </button>
            <div v-if="showDetails">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold">Detalles de Permuta</h2>
                    <p v-if="permuta.supervisor_approved_by" class="text-gray-600">Aprobado por: {{permuta.supervisor_approved_by}}</p>
                </div>
                <div>
                    <div v-if="errorMessage" class="text-red-500 text-center mb-4">{{ errorMessage }}</div>
                    <div class="space-y-4">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="font-bold mb-2 text-red-700">Información del cliente</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <p><span class="font-medium">Código de cliente:</span></p>
                                <p>{{ formData.clientCode }}</p>
                                <p><span class="font-medium">Volumen en CU:</span></p>
                                <p>{{ formData.volumeCU }}</p>
                                <p><span class="font-medium">Locación:</span></p>
                                <p>{{ formData.location }}</p>
                                <p><span class="font-medium">Ruta:</span></p>
                                <p>{{ formData.route }}</p>
                                <p><span class="font-medium">Subcanal:</span></p>
                                <p>{{ formData.subcanal }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="font-bold mb-2 text-red-700">EDF a solicitar</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <p><span class="font-medium">Condición:</span></p>
                                <p>{{ formData.condition }}</p>
                                <p><span class="font-medium">Puertas a negociar:</span></p>
                                <p>{{ formData.doorsToNegotiate }}</p>
                                <p><span class="font-medium">Motivo:</span></p>
                                <p>{{ formData.reason }}</p>
                                <p><span class="font-medium">Justificación:</span></p>
                                <p>{{ formData.justification }}</p>
                            </div>
                        </div>
                    </div>
                    <div v-if="permuta.gerente_status == 'Pending'" class="mt-6 flex justify-between">
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
