<template>
    <div class="z-20 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-2 overflow-y-auto">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-4 relative">
            <button @click="closeModal" class="absolute top-1 right-1 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-circle-xmark text-gray-500"></i>
            </button>
            <div v-if="showDetails">
                <div class="text-center mb-4">
                    <h2 class="text-xl font-bold">Detalles de Permuta</h2>
                    <p class="text-gray-600 text-sm">Revisa la información de la permuta</p>
                </div>
                <div>
                    <div v-if="errorMessage" class="text-red-500 text-center mb-2 text-sm">{{ errorMessage }}</div>
                    <div class="space-y-2">
                        <div class="px-2 rounded-lg">
                            <div class="grid grid-cols-2 text-sm">
                                <p><span class="font-bold">Código de cliente:</span></p>
                                <p class="text-right">{{ formData.clientCode }}</p>
                                <p><span class="font-bold">Fecha de Permuta:</span></p>
                                <p class="text-right">{{ new Date(permuta.created_at).toLocaleDateString('es-ES', {
                                    day:
                                        '2-digit', month: '2-digit', year: 'numeric' }) }}</p>
                                <p><span class="font-bold">Volumen en CU:</span></p>
                                <p class="text-right">{{ formData.volumeCU }}</p>
                                <p><span class="font-bold">Locación:</span></p>
                                <p class="text-right">{{ formData.location }}</p>
                                <p><span class="font-bold">Ruta:</span></p>
                                <p class="text-right">{{ formData.route }}</p>
                                <p><span class="font-bold">Subcanal:</span></p>
                                <p class="text-right">{{ formData.subcanal }}</p>
                                <p v-if="formData.status === 'Rejected'"><span class="font-bold">Estado:</span></p>
                                <p class="text-right">{{ formData.status }}</p>
                                <p v-if="formData.status === 'Rejected'"><span class="font-bold">Motivo:</span></p>
                                <p class="text-right">{{ formData.rejectedReasonPermuta }}</p>
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
                    <div class="mt-2 text-center">
                        <button @click="closeModal"
                            class="w-full bg-black text-white px-2 py-1 rounded-lg hover:bg-red-600 focus:outline-none text-sm">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

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
            formData: this.mapPermutaToFormData(this.permuta),
            reasons: [],
            sentPermutaViewModal: false,
            errorMessage: '',
            isSubmitting: false,
            showDetails: true
        };
    },
    mounted() {
        this.fetchReasons();
    },
    methods: {
        mapPermutaToFormData(permuta) {
            const status = ['supervisor_status', 'gerente_status', 'trade_status'].find(status => permuta[status].toLowerCase() === 'rejected') || 'Pending';
            const rejectedReasonKey = ['supervisor_rejected_reason', 'gerente_rejected_reason', 'trade_rejected_reason'].find(key => permuta[key]) || '';
            const rejectedReason = permuta[rejectedReasonKey] || '';
            
            return {
                clientCode: permuta.cod_cliente,
                volumeCU: permuta.volume,
                location: permuta.location.name,
                route: permuta.route,
                subcanal: permuta.subcanal,
                haveEdf: permuta.have_edf,
                doorsToNegotiate: permuta.doors_to_negotiate,
                condition: permuta.condition,
                reason: permuta.reason,
                justification: permuta.justification,
                status: status === 'Pending' ? 'Pending' : 'Rejected',
                rejectedReasonPermuta: rejectedReason
            };
        },
        fetchReasons() {
            fetch('/api/permuta-reasons')
                .then(response => response.json())
                .then(data => {
                    this.reasons = data;
                })
                .catch(error => {
                    console.error('Error fetching reasons:', error);
                });
        },
        detailsModal() {
            this.showDetails = true;
        },
        closeModal() {
            this.$emit('close');
            this.detailsModal();
        },
    }
}
</script>
