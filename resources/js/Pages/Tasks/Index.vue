<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3'
import { ref, watch, computed } from 'vue'
import { VueDraggableNext } from 'vue-draggable-next'
import AppLayout from '@/Layouts/AppLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'
import SelectInput from '@/Components/SelectInput.vue'
import DatePicker from '@/Components/DatePicker.vue'
const props = defineProps({
    tasks: Array,
    projects: Array,
    filters: Object,
})

const selectedProject = ref(props.filters?.project_id || '')
const taskList = ref([...props.tasks])
const project = props.projects.find((p) => p.id === parseInt(selectedProject.value));
const currentProjectStatus = ref(project ? project.status : null);

const projectOptions = computed(() => [
    { value: '', label: 'No project' },
    ...props.projects.map((p) => ({ value: p.id, label: p.name })),
])

const currentTask = ref(null)
const createModalOpen = ref(false)
const editModalOpen = ref(false)
const deleteModalOpen = ref(false)
const successMessage = ref(null)
const errorMessage = ref(null)
const reorderErrorMessage = ref(null);
const page = usePage()

watch(selectedProject, (value) => {
    if (!value) {
        currentProjectStatus.value = null;
        return;
    }
    const project = props.projects.find((p) => p.id === parseInt(value));
    currentProjectStatus.value = project ? project.status : null;
    router.get(route('tasks.index'), { project_id: value })
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
// Forms
const deleteForm = useForm({})
const editForm = useForm({
    name: '',
    priority: '',
    project_id: '',
    status: '',
    due_date: ''
})

const taskForm = useForm({
    name: '',
    priority: '',
    project_id: '',
    status: '',
    due_date: ''
})
const format = (date) => {
    if (!date) return '';
    if (typeof date === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(date)) {
        return date;
    }
    const value = !date.getDate() ? new Date(date) : date
    const day = new Date(value).getDate().toString().padStart(2, '0');
    const month = (value.getMonth() + 1).toString().padStart(2, '0');
    const year = value.getFullYear();
return `${year}-${month}-${day}`;
};

const formatStatus = (status) => {
    return status.toLowerCase().replace(/ /g, '_');
};

// CRUD Logic
function openCreateModal() {
    taskForm.reset()
    taskForm.clearErrors() // ← reset errors
    createModalOpen.value = true
}

function closeCreateModal() {
    taskForm.reset()
    taskForm.clearErrors() // ← reset errors
    createModalOpen.value = false
}

function createTask() {
    taskForm.due_date = format(taskForm.due_date);
    taskForm.status = formatStatus(taskForm.status);
    taskForm.post(route('tasks.store'), {
        preserveScroll: true,
        onSuccess: () => closeCreateModal(),
    })
}

function openEditModal(task) {
    console.log(task)
    currentTask.value = task
    editForm.reset()
    editForm.clearErrors() // ← reset errors
    editForm.name = task.name
    editForm.project_id = task.project_id
    editForm.priority = task.priority
    editForm.status = task.status.replace('_', ' ').toUpperCase()
    editForm.due_date = task.due_date
    editModalOpen.value = true
}

function closeEditModal() {
    editModalOpen.value = false
    editForm.reset()
    editForm.clearErrors() // ← reset errors
    currentTask.value = null
}

function updateTask() {
    editForm.due_date = format(editForm.due_date);
    editForm.status = formatStatus(editForm.status);
    editForm.put(route('tasks.update', currentTask.value.id), {
        preserveScroll: true,
        onSuccess: (page) => {
            const index = taskList.value.findIndex(t => t.id === currentTask.value.id)
            if (index !== -1 && page?.props?.tasks) {
                const updatedTask = page.props.tasks.find(t => t.id === currentTask.value.id)
                if (updatedTask) taskList.value[index] = { ...updatedTask }
            }
            closeEditModal()
            setTimeout(() => {
                successMessage = ""
            }, 1200);
        },
    })
}

function openDeleteModal(task) {
    currentTask.value = task
    deleteModalOpen.value = true
}

function closeDeleteModal() {
    deleteModalOpen.value = false
    currentTask.value = null
}

function deleteTask() {
    deleteForm.delete(route('tasks.delete', currentTask.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            taskList.value = taskList.value.filter(task => task.id !== currentTask.value.id)
            closeDeleteModal()
            setTimeout(() => {
                errorMessage = ""
            }, 1200);
        }
    })
}

const onReorderEnd = () => {
    if (currentProjectStatus.value === 'completed') {
        reorderErrorMessage.value = "This project is marked as completed. Reorder is not allowed.";
        setTimeout(() => {
            successMessage.value = null
        }, 1200)
        return;
    }
    taskList.value.forEach((task, index) => {
        task.priority = index + 1
    })
    const orderedIds = taskList.value.map(task => task.id)

    router.post(route('tasks.reorder'), {
        tasks: orderedIds,
        project_id: selectedProject.value
    }, {
        preserveScroll: true,
        onSuccess: () => {

        },
        onError: (error) => {
            console.error('Erreur lors du reorder:', error)
        },
    })
}
</script>
<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
<template>
  <AppLayout title="Dashboard" :user="$page.props.auth.user">
    <Head title="Tasks" />
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Task List</h1>

        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">Filter by project:</label>
            <select v-model="selectedProject" class="border-gray-300 rounded-lg shadow-sm mr-2 ">
                <option value="">All Projects</option>
                <option v-for="project in projects" :key="project.id" :value="project.id">
                    {{ project.name }}
                </option>
            </select>
            <PrimaryButton @click="openCreateModal">Add task</PrimaryButton>
        </div>
        <div v-show="successMessage" class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div class="text-sm text-gray-600">
                    {{ successMessage }}
                </div>
            </transition>
        </div>
        <div v-show="errorMessage" class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div class="text-sm text-gray-600">
                    {{ errorMessage }}
                </div>
            </transition>
        </div>

        <div v-if="reorderErrorMessage" class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div class="text-sm text-red-600">
                    {{ reorderErrorMessage }}
                </div>
            </transition>
        </div>


        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                        <th class="px-12 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>

                <!-- Draggable tbody -->
                <VueDraggableNext v-model="taskList" item-key="id" tag="tbody" class="divide-y divide-gray-200"
                    @end="onReorderEnd" @start="currentProjectStatus && currentProjectStatus.value === 'completed'">
                    <tr class="hover:bg-gray-50" v-for="task in taskList" :key="task.id">
                        <td class="px-6 py-4">{{ task.name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ task.priority }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span :class="{
                                'text-red-600': task.status === 'pending',
                                'text-yellow-600': task.status === 'in_progress',
                                'text-green-600': task.status === 'done',
                            }">
                                {{ task.status.replace('_', ' ').toUpperCase() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : '—' }}
                        </td>
                        <td>
                            <div class="flex space-x-2">
                                <SecondaryButton :disabled="currentProjectStatus && currentProjectStatus.value === 'completed'" @click="openEditModal(task)">Edit</SecondaryButton>
                                <DangerButton :disabled="currentProjectStatus && currentProjectStatus.value === 'completed'" @click="openDeleteModal(task)">Delete</DangerButton>
                            </div>
                        </td>
                    </tr>
                </VueDraggableNext>
            </table>
            <!-- Create Modal -->
            <Modal :show="createModalOpen" @close="closeCreateModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Create task</h2>
                    <form class="mt-6" @submit.prevent="createTask">
                        <InputLabel for="name" value="Task name" />
                        <TextInput id="name" v-model="taskForm.name" class="mt-1 block w-full"
                            @input="taskForm.clearErrors('name')" />
                        <InputError :message="taskForm.errors.name" class="mt-2" />

                        <div class="mt-4" v-if="projects.length > 0">
                            <InputLabel for="project_id" value="Project" />
                            <SelectInput id="project_id" v-model="taskForm.project_id" :options="projectOptions" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="priority" value="Priority" />
                            <TextInput id="edit_priority" v-model="taskForm.priority" type="number"
                                class="mt-1 block w-full" />
                            <InputError :message="taskForm.errors.priority" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="status" value="Status" />
                            <TextInput id="status" v-model="taskForm.status" type="text" placeholder="Pending, In progress, Done"
                                class="mt-1 block w-full" />
                            <InputError :message="taskForm.errors.status" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <DatePicker
                                :modelValue="taskForm.due_date"
                                @update:modelValue="(val) => taskForm.due_date = val"
                                label="Date"
                                :options="{
                                    minDate: new Date(),
                                    maxDate: '+1M',
                                    firstDay: 1
                                }"
                            />
                            <InputError :message="taskForm.errors.due_date" class="mt-2" />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeCreateModal" class="mr-2">Cancel</SecondaryButton>
                            <PrimaryButton :disabled="taskForm.processing">Create</PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>

            <!-- Edit Modal -->
            <Modal :show="editModalOpen" @close="closeEditModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Update task</h2>
                    <form class="mt-6" @submit.prevent="updateTask">
                        <InputLabel for="edit_name" value="Task name" />
                        <TextInput id="edit_name" v-model="editForm.name" class="mt-1 block w-full"
                            @input="editForm.clearErrors('name')" />
                        <InputError :message="editForm.errors.name" class="mt-2" />

                        <div class="mt-4" v-if="projects.length > 0">
                            <InputLabel for="edit_project_id" value="Projet" />
                            <SelectInput id="edit_project_id" v-model="editForm.project_id" :options="projectOptions" />
                            <InputError :message="editForm.errors.project_id" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="edit_priority" value="Priorité" />
                            <TextInput id="edit_priority" v-model="editForm.priority" type="number"
                                class="mt-1 block w-full" />
                            <InputError :message="editForm.errors.priority" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="edit_status" value="Statut" />
                            <TextInput id="edit_status" v-model="editForm.status" type="text" placeholder="Pending, In progress, Done"
                                class="mt-1 block w-full" />
                            <InputError :message="editForm.errors.status" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <DatePicker
                                :modelValue="editForm.due_date"
                                @update:modelValue="(val) => taskForm.due_date = val"
                                label="Date"
                                :options="{
                                    minDate: new Date(),
                                    maxDate: '+1M',
                                    firstDay: 1
                                }"
                            />
                            <InputError :message="editForm.errors.due_date" class="mt-2" />
                        </div>
                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeEditModal" class="mr-2">Cancel</SecondaryButton>
                            <PrimaryButton :disabled="taskForm.processing">Update</PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>

            <!-- Delete Modal -->
            <Modal :show="deleteModalOpen" @close="closeDeleteModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Delete task</h2>
                    <p class="mt-2 text-gray-600">This action is irreversible.</p>
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeDeleteModal" class="mr-2">Cancel</SecondaryButton>
                        <DangerButton @click="deleteTask" :disabled="deleteForm.processing">Delete</DangerButton>
                    </div>
                </div>
            </Modal>

        </div>
    </div>
  </AppLayout>
</template>
