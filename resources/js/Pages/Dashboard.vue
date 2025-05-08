<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3';

defineProps({
  projectCount: Number,
  taskCount: Number,
  tasksToday: Number,
})

const { flash } = usePage().props;

const message = flash.verified;

setTimeout(() => {
  message = null;
}, 5000);
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
<template>
  <Head title="Dashboard" />

  <AppLayout title="Dashboard" :user="$page.props.auth.user">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>
    <transition name="fade">
    <div v-if="message" class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center w-sm">
      {{ message }}
    </div>
  </transition>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 uppercase">Projects</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ projectCount }}</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 uppercase">Tasks</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ taskCount }}</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-sm text-gray-500 uppercase">Due Today</h3>
            <p class="text-3xl font-bold text-red-500">{{ tasksToday }}</p>
          </div>
        </div>

        <div class="mt-8">
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Welcome back 👋</h3>
            <p class="text-gray-600">Here’s a quick overview of your projects and tasks today.</p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
