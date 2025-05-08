<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    projects: Array,
    selectedProjectId: String|Number,
})

const emit = defineEmits(['create', 'projectChange'])

const selectedProject = ref(props.selectedProjectId || '')

watch(selectedProject, (value) => {
    emit('projectChange', value)
    router.get(route('tasks.index'), { project_id: value })
})
</script>

<template>
    <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-700">Filter by project:</label>
        <select v-model="selectedProject" class="border-gray-300 rounded-lg shadow-sm mr-2">
            <option value="">All Projects</option>
            <option v-for="project in projects" :key="project.id" :value="project.id">
                {{ project.name }}
            </option>
        </select>
        <PrimaryButton @click="emit('create')">Add task</PrimaryButton>
    </div>
</template>
