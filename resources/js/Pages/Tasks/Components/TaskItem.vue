<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import StatusBadge from './StatusBadge.vue'

defineProps({
    task: Object,
    isProjectCompleted: Boolean
})

const emit = defineEmits(['edit', 'delete'])
</script>

<template>
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4">{{ task.name }}</td>
        <td class="px-6 py-4 text-gray-600">{{ task.priority }}</td>
        <td class="px-6 py-4 text-sm">
            <StatusBadge :status="task.status" />
        </td>
        <td class="px-6 py-4 text-gray-600">
            {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : '—' }}
        </td>
        <td>
            <div class="flex space-x-2">
                <SecondaryButton :disabled="isProjectCompleted" @click="emit('edit', task)">Edit</SecondaryButton>
                <DangerButton :disabled="isProjectCompleted" @click="emit('delete', task)">Delete</DangerButton>
            </div>
        </td>
    </tr>
</template>
