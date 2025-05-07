<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
  projects: Array,
})

const statusClasses = {
  planned: 'bg-blue-100 text-blue-800',
  in_progress: 'bg-yellow-100 text-yellow-800',
  completed: 'bg-green-100 text-green-800',
  on_hold: 'bg-red-100 text-red-800',
}
</script>

<template>
  <Head title="Projects" />

  <AppLayout title="Dashboard" :user="$page.props.auth.user">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Projects
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="(project, index) in projects"
            :key="index"
            class="bg-white p-6 rounded-lg shadow-md transition duration-300 hover:shadow-lg"
          >
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
              {{ project.name }}
            </h3>

            <!-- Status Badge -->
            <span
              class="px-3 py-1 text-sm font-semibold rounded-full inline-block mb-4"
              :class="statusClasses[project.status]"
            >
              {{ project.status.replace('_', ' ').toUpperCase() }}
            </span>

            <!-- Project Details -->
            <div class="space-y-2 text-sm text-gray-600">
              <p><strong>Client:</strong> {{ project.client_name }}</p>
              <p><strong>Project Manager:</strong> {{ project.project_manager }}</p>
              <p><strong>Budget:</strong> {{ new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(project.budget) }}</p>
              <p><strong>Location:</strong> {{ project.location }}</p>
              <p><strong>Category:</strong> {{ project.category }}</p>
              <p><strong>Code:</strong> {{ project.code }}</p>
            </div>

            <!-- Dates -->
            <div class="mt-4 space-y-1 text-sm">
              <p><strong>Start Date:</strong> {{ new Date(project.start_date).toLocaleDateString() }}</p>
              <p><strong>End Date:</strong> {{ new Date(project.end_date).toLocaleDateString() }}</p>
              <p><strong>Delivery Date:</strong> {{ new Date(project.delivery_date).toLocaleDateString() }}</p>
            </div>

            <!-- Task Count -->
            <div class="mt-4">
              <span class="text-sm font-bold text-indigo-600">
                Task count: {{ project.tasks_count }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
