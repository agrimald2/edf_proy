<template>
    <div class="text-center mb-10 pt-2">
        <h2 class="text-lg font-bold">Rechazar Permuta</h2>
        <p>Ingresa el motivo del rechazo</p>
    </div>
    <div>
        <form class="space-y-4" @submit.prevent="submitForm">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <select v-model="formData.rejected_reason" class="w-full inputs_permutas">
                        <option value="0" disabled selected>Selecciona Motivo de rechazo</option>
                        <option v-for="reason in reasons" :key="reason" :value="reason.name">{{ reason.name }}</option>
                    </select>
                </div>
                <div>
                    <textarea v-model="formData.rejected_comments" placeholder="Comentarios (opcional)"
                        class="w-full inputs_permutas" style="min-height: 100px;"></textarea>
                </div>
            </div>
            <div class="mt-2 text-center bg-black border rounded-lg py-2 border-black font-medium">
                <button type="submit"
                    class="text-white hover:underline focus:outline-none rounded-full">Aceptar</button>
            </div>
            <div class="mt-2 text-center bg-white border rounded-lg py-2 border-black font-medium">
                <button @click="backModal" type="button"
                    class="text-black hover:underline focus:outline-none rounded-full">Atrás</button>
            </div>
        </form>
    </div>
</template>
<style></style>

<script>
export default {
    props: {
        permutaId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            formData: {
                rejected_reason: 0,
                rejected_comments: null
            },
            reasons: []
        }
    },
    mounted() {
        this.getReasons();
    },
    methods: {
        submitForm() {
            fetch(`/api/permutas/${this.permutaId}/reject/supervisor`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.formData)
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Permuta rejected:', data);
                    this.$emit('close');
                    this.$emit('show-rejected-modal');
                })
                .catch(error => {
                    console.error('Error rejecting permuta:', error);
                });
        },
        closeModal() {
            this.$emit('close');
        },
        backModal() {
            this.$emit('show-details-modal');
        },
        getReasons() {
            fetch('/api/permuta-rejected-reasons')
                .then(response => response.json())
                .then(data => {
                    this.reasons = data;
                })
                .catch(error => {
                    console.error('Error fetching reasons:', error);
                });
        }
    }
}
</script>

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
