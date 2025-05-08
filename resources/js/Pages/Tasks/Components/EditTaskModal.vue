<script setup>
import { useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TaskForm from './TaskForm.vue'

const props = defineProps({
    show: Boolean,
    task: Object,
    projects: Array
})

const emit = defineEmits(['close', 'updated'])

const editForm = useForm({
    name: '',
    priority: '',
    project_id: '',
    status: '',
    due_date: ''
})

const updateTask = (formData) => {
    editForm.name = formData.name
    editForm.priority = formData.priority
    editForm.project_id = formData.project_id
    editForm.status = formData.status
    editForm.due_date = formData.due_date

    editForm.put(route('tasks.update', props.task.id), {
        preserveScroll: true,
        onSuccess: (page) => {
            if (page?.props?.tasks) {
                const updatedTask = page.props.tasks.find(t => t.id === props.task.id)
                if (updatedTask) emit('updated', updatedTask)
            }
            emit('close')
        },
    })
}

const closeModal = () => {
    editForm.reset()
    editForm.clearErrors()
    emit('close')
}
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Update task</h2>
            <TaskForm
                :task="task"
                :projects="projects"
                :isEdit="true"
                @submit="updateTask"
                @cancel="closeModal"
            >
                <template #actions>
                    <SecondaryButton @click="closeModal" class="mr-2">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="editForm.processing">Update</PrimaryButton>
                </template>
            </TaskForm>
        </div>
    </Modal>
</template>
