<script setup>
defineProps({
    status: {
        type: String,
        default: 'success' // 'success' or 'error'
    }
})
</script>

<template>
    <div v-if="status" :class="{
        'bg-green-100 text-green-800': status === 'success',
        'bg-red-100 text-red-800': status === 'error'
    }" class="px-4 py-2 rounded mb-4">
        <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div class="text-sm" :class="{
                'text-red-600': status === 'pending',
                'text-yellow-600': status === 'in_progress',
                'text-green-600': status === 'done',
            }">
                {{ status.replace('_', ' ').toUpperCase() }}
            </div>
        </transition>
    </div>
</template>
