<script setup>
import { VueDraggableNext } from 'vue-draggable-next'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

import TaskItem from './TaskItem.vue'

const props = defineProps({
    tasks: Array,
    projectId: String|Number,
    isProjectCompleted: Boolean
})

const emit = defineEmits(['edit', 'delete', 'reorderError'])
const taskList = ref([...props.tasks])
const onReorderEnd = () => {
    if (props.isProjectCompleted) {
        emit('reorderError', "This project is marked as completed. Reorder is not allowed.");
        return;
    }

    const orderedIds = props.tasks.map(task => task.id)

    router.post(route('tasks.reorder'), {
        tasks: orderedIds,
        project_id: props.projectId
    }, {
        preserveScroll: true,
        onError: (error) => {
            console.error('Erreur lors du reorder:', error)
        },
    })
}
</script>

<template>
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

            <VueDraggableNext v-model="taskList" item-key="id" tag="tbody" class="divide-y divide-gray-200"
                @end="onReorderEnd" @start="isProjectCompleted">
                    <TaskItem v-for="(task, index) in taskList" :key="index"
                        :task="task"
                        :isProjectCompleted="isProjectCompleted"
                        @edit="task => emit('edit', task)"
                        @delete="task => emit('delete', task)"
                    />
            </VueDraggableNext>
        </table>
    </div>
</template>
