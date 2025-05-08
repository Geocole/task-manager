<script setup>
import { Head, usePage, router } from '@inertiajs/vue3'
import { ref, watch, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

import TaskFilter from './Components/TaskFilter.vue'
import TaskTable from './Components/TaskTable.vue'
import CreateTaskModal from './Components/CreateTaskModal.vue'
import EditTaskModal from './Components/EditTaskModal.vue'
import DeleteTaskModal from './Components/DeleteTaskModal.vue'
import FlashMessage from './Components/FlashMessage.vue'

const props = defineProps({
    tasks: Array,
    projects: Array,
    filters: Object,
})

const page = usePage()
const taskList = ref([...props.tasks])
const selectedProject = ref(props.filters?.project_id || '')
const createModalOpen = ref(false)
const editModalOpen = ref(false)
const deleteModalOpen = ref(false)
const currentTask = ref(null)
const successMessage = ref(null)
const errorMessage = ref(null)
const reorderErrorMessage = ref(null)

const isProjectCompleted = computed(() => {
    if (!selectedProject.value) return false;
    const project = props.projects.find((p) => p.id === parseInt(selectedProject.value));
    return project ? project.status === 'completed' : false;
})


watch(() => page.props?.flash?.success, (newValue) => {
    if (newValue) {
        successMessage.value = newValue
        setTimeout(() => {
            successMessage.value = null
        }, 1200)
    }
})

watch(() => page.props?.flash?.error, (newValue) => {
    if (newValue) {
        errorMessage.value = newValue
        setTimeout(() => {
            errorMessage.value = null
        }, 1200)
    }
})

const handleProjectChange = (projectId) => {
    selectedProject.value = projectId
}

const handleOpenCreateModal = () => {
    createModalOpen.value = true
}

const handleCloseCreateModal = () => {
    createModalOpen.value = false
}

const handleOpenEditModal = (task) => {
    currentTask.value = task
    editModalOpen.value = true
}

const handleCloseEditModal = () => {
    editModalOpen.value = false
    currentTask.value = null
}

const handleTaskUpdated = (updatedTask) => {
    const index = taskList.value.findIndex(t => t.id === updatedTask.id)
    if (index !== -1) {
        taskList.value[index] = { ...updatedTask }
    }
}

const handleOpenDeleteModal = (task) => {
    currentTask.value = task
    deleteModalOpen.value = true
}

const handleCloseDeleteModal = () => {
    deleteModalOpen.value = false
    currentTask.value = null
}

const handleTaskDeleted = (taskId) => {
    taskList.value = taskList.value.filter(task => task.id !== taskId)
}

const handleReorderError = (message) => {
    reorderErrorMessage.value = message
    setTimeout(() => {
        reorderErrorMessage.value = null
    }, 3000)
}
</script>

<template>
  <AppLayout title="Dashboard" :user="$page.props.auth.user">
    <Head title="Tasks" />
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Task List</h1>

        <!-- Filtre et bouton d'ajout -->
        <TaskFilter
            :projects="projects"
            :selectedProjectId="selectedProject"
            @create="handleOpenCreateModal"
            @projectChange="handleProjectChange"
        />

        <!-- Messages flash -->
        <FlashMessage :message="successMessage" type="success" />
        <FlashMessage :message="errorMessage" type="error" />
        <FlashMessage :message="reorderErrorMessage" type="error" />

        <!-- Tableau de tâches -->
        <TaskTable
            :tasks="taskList"
            :projectId="selectedProject"
            :isProjectCompleted="isProjectCompleted"
            @edit="handleOpenEditModal"
            @delete="handleOpenDeleteModal"
            @reorderError="handleReorderError"
        />

        <!-- Modales -->
        <CreateTaskModal
            :show="createModalOpen"
            :projects="projects"
            @taskCreated="task => taskList.value.push(task)"
            @close="handleCloseCreateModal"
        />

        <EditTaskModal
            :show="editModalOpen"
            :task="currentTask"
            :projects="projects"
            @close="handleCloseEditModal"
            @updated="handleTaskUpdated"
        />

        <DeleteTaskModal
            :show="deleteModalOpen"
            :task="currentTask"
            @close="handleCloseDeleteModal"
            @deleted="handleTaskDeleted"
        />
    </div>
  </AppLayout>
</template>
