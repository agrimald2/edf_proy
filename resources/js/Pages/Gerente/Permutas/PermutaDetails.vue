<template>
    <div class="z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-2 overflow-y-auto">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-4 relative">
            <button @click="closeModal" class="absolute top-1 right-1 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-circle-xmark text-gray-500"></i>
            </button>
            <div v-if="showDetails">
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold">Detalles de Permuta</h2>
                    <p class="text-gray-600 text-sm">Aprobado por: {{ approvedBy }}</p>
                </div>
                <div>
                    <div v-if="errorMessage" class="text-red-500 text-center mb-2 text-sm">{{ errorMessage }}</div>
                    <div class="space-y-2">
                        <div class="px-2 rounded-lg">
                            <div class="grid grid-cols-2 text-sm">
                                <p><span class="font-bold">Código de cliente:</span></p>
                                <p class="text-right">{{ formData.clientCode }}</p>
                                <p><span class="font-bold">Fecha de Permuta:</span></p>
                                <p class="text-right">{{ new Date(permuta.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}</p>
                                <p><span class="font-bold">Volumen en CU:</span></p>
                                <p class="text-right">{{ formData.volumeCU }}</p>
                                <p><span class="font-bold">Locación:</span></p>
                                <p class="text-right">{{ formData.location }}</p>
                                <p><span class="font-bold">Ruta:</span></p>
                                <p class="text-right">{{ formData.route }}</p>
                                <p><span class="font-bold">Subcanal:</span></p>
                                <p class="text-right">{{ formData.subcanal }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="px-2 pb-1 rounded-lg">
                            <h3 class="font-bold mb-1 text-red-700 text-sm">EDF a solicitar</h3>
                            <div class="grid grid-cols-2 text-sm">
                                <p><span class="font-bold">Condición:</span></p>
                                <p class="text-right">{{ formData.condition }}</p>
                                <p><span class="font-bold">Puertas a negociar:</span></p>
                                <p class="text-right">{{ formData.doorsToNegotiate }}</p>
                                <p><span class="font-bold">Motivo:</span></p>
                                <p class="text-right">{{ formData.reason }}</p>
                                <p><span class="font-bold">Justificación:</span></p>
                                <p class="text-right">{{ formData.justification }}</p>
                            </div>
                        </div>
                    </div>
                    <div v-if="permuta.gerente_status == 'Pending'" class="mt-6 flex justify-between">
                        <button @click="approvePermuta"
                            class="w-1/2 py-1 font-medium rounded-md bg-green-500 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 mr-2">
                            Aprobar
                        </button>
                        <button @click="rejectPermuta"
                            class="w-1/2 py-1 font-medium rounded-md bg-red-500 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 ml-2">
                            Rechazar
                        </button>
                    </div>
                    <div class="mt-2 text-center">
                        <button @click="closeModal"
                            class="w-full bg-black text-white px-2 py-1 rounded-lg hover:bg-red-600 focus:outline-none text-sm">Cerrar</button>
                    </div>
                </div>
            </div>
            <PermutaRejectReasonModal v-if="showRejectReasonModal" :permuta-id="permuta.id"
                @show-details-modal="detailsModal" @show-rejected-modal="showRejectedModal = true"
                @close="showRejectReasonModal = false" />
            <PermutaRejectedModal v-if="showRejectedModal" :permuta-id="permuta.id"
                @close="showRejectedModal = false" />
            <PermutaApproveConfirmationModal v-if="showApproveConfirmationModal" :permuta-id="permuta.id" :sv="sv"
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
                date: new Date(this.permuta.created_at).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }),
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
            showApprovedModal: false,
            approvedBy: '-'
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

        fetch(`/api/supervisor/nameByMesa/${this.permuta.supervisor_approved_by}`)
            .then(response => response.json())
            .then(data => {
                this.approvedBy = data.nombre_sv;
                console.log(data);
            })
            .catch(error => {
                console.error('Error fetching approved by name:', error);
            });
        console.log(this.permuta.supervisor_approved_by);
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
