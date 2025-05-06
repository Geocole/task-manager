<script setup>
import { Head, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { VueDraggableNext } from 'vue-draggable-next'

const props = defineProps({
  tasks: Array,
  projects: Array,
  filters: Object,
})

const selectedProject = ref(props.filters?.project_id || '')
const taskList = ref([...props.tasks]) // pour v-model du drag

watch(selectedProject, (value) => {
  router.get(route('tasks.index'), { project_id: value }, { preserveState: true, replace: true })
})

const onReorderEnd = () => {
    taskList.value.forEach((task, index) => {
        task.priority = index + 1
    })
    const orderedIds = taskList.value.map(task => task.id)

    axios.post(route('tasks.reorder'), {
        tasks: orderedIds,
    }).then(() => {
        console.log('Priorites updated')
    }).catch(error => {
        console.error('Error:', error)
    })
}
</script>

<template>
  <Head title="Tasks" />

  <div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Task List</h1>

    <div class="mb-4">
      <label class="block mb-1 text-sm font-medium text-gray-700">Filter by project:</label>
      <select v-model="selectedProject" class="border-gray-300 rounded-lg shadow-sm">
        <option value="">All Projects</option>
        <option v-for="project in projects" :key="project.id" :value="project.id">
          {{ project.name }}
        </option>
      </select>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
          </tr>
        </thead>

        <!-- Draggable tbody -->
        <VueDraggableNext
          v-model="taskList"
          item-key="id"
          tag="tbody"
          class="divide-y divide-gray-200"
          @end="onReorderEnd"
        >
            <tr class="hover:bg-gray-50" v-for="task in taskList" :key="task.id">
              <td class="px-6 py-4">{{ task.name }}</td>
              <td class="px-6 py-4 text-gray-600">{{ task.priority }}</td>
              <td class="px-6 py-4 text-sm">
                <span
                  :class="{
                    'text-red-600': task.status === 'pending',
                    'text-yellow-600': task.status === 'in_progress',
                    'text-green-600': task.status === 'done',
                  }"
                >
                  {{ task.status.replace('_', ' ') }}
                </span>
              </td>
              <td class="px-6 py-4 text-gray-600">
                {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : '—' }}
              </td>
            </tr>
        </VueDraggableNext>
      </table>
    </div>
  </div>
</template>
