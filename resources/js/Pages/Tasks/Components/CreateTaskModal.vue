<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TaskForm from './TaskForm.vue'

const props = defineProps({
    show: Boolean,
    projects: Array
})

const emit = defineEmits(['close', 'taskCreated'])

const taskForm = useForm({
    name: '',
    priority: '',
    project_id: '',
    status: '',
    due_date: ''
})
const page = usePage()

const createTask = (formData) => {
    taskForm.name = formData.name
    taskForm.priority = formData.priority
    taskForm.project_id = formData.project_id
    taskForm.status = formData.status
    taskForm.due_date = formData.due_date

    taskForm.post(route('tasks.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            const newTask = page.props.tasks[page.props.tasks.length - 1]
            close('taskCreated', newTask)
            emit('close')
        },
    })
}

const closeModal = () => {
    taskForm.reset()
    taskForm.clearErrors()
    emit('close')
}
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Create task</h2>
            <TaskForm
                :projects="projects"
                :isEdit="false"
                @submit="createTask"
                @cancel="closeModal"
            >
                <template #actions>
                    <SecondaryButton @click="closeModal" class="mr-2">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="taskForm.processing">Create</PrimaryButton>
                </template>
            </TaskForm>
        </div>
    </Modal>
</template>
