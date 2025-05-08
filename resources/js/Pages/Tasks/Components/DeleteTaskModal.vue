<script setup>
import { useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'

const props = defineProps({
    show: Boolean,
    task: Object
})

const emit = defineEmits(['close', 'deleted'])

const deleteForm = useForm({})

const deleteTask = () => {
    deleteForm.delete(route('tasks.delete', props.task.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('deleted', props.task.id)
            emit('close')
        }
    })
}

const closeModal = () => {
    emit('close')
}
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Delete task</h2>
            <p class="mt-2 text-gray-600">This action is irreversible.</p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal" class="mr-2">Cancel</SecondaryButton>
                <DangerButton @click="deleteTask" :disabled="deleteForm.processing">Delete</DangerButton>
            </div>
        </div>
    </Modal>
</template>
