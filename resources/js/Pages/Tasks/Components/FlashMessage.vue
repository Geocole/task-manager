<script setup>
defineProps({
    message: String,
    type: {
        type: String,
        default: 'success' // 'success' or 'error'
    }
})
</script>

<template>
    <div v-if="message" :class="{
        'bg-green-100 text-green-800': type === 'success',
        'bg-red-100 text-red-800': type === 'error'
    }" class="px-4 py-2 rounded mb-4">
        <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div class="text-sm" :class="{
                'text-gray-600': type === 'success',
                'text-red-600': type === 'error'
            }">
                {{ message }}
            </div>
        </transition>
    </div>
</template>
