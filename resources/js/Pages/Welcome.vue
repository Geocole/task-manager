<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  auth: Object,
})
</script>

<template>
  <Head title="Welcome to TaskManager" />

  <div class="relative min-h-screen bg-gray-100 flex flex-col items-center justify-center text-gray-800 px-6">
    <!-- Navigation -->
    <nav class="w-full max-w-7xl flex justify-between items-center py-4">
      <h1 class="text-2xl font-bold text-indigo-600">TaskManager</h1>

      <div v-if="canLogin" class="flex gap-4">
        <template v-if="auth.user">
          <Link
            href="/dashboard"
            class="text-sm text-indigo-600 hover:underline font-semibold"
          >
            Dashboard
          </Link>
        </template>
        <template v-else>
          <Link
            href="/login"
            class="text-sm text-indigo-600 hover:underline font-semibold px-4 py-2"
          >
            Log in
          </Link>

          <Link
            v-if="canRegister"
            href="/register"
            class="ml-4 text-sm text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded shadow"
          >
            Register
          </Link>
        </template>
      </div>
    </nav>

    <!-- Hero section -->
    <div class="text-center mt-16">
      <h2 class="text-3xl sm:text-4xl font-bold leading-tight">
        Manage your projects and tasks effortlessly.
      </h2>
      <p class="mt-4 text-gray-600 max-w-xl mx-auto">
        Organize projects, prioritize tasks, track deadlines and collaborate with ease. All in one place, powered by Laravel + Vue 3 + Inertia.js.
      </p>

      <div class="mt-6">
        <Link
          href="/login"
          class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow"
        >
          Get Started
        </Link>
      </div>
    </div>

    <!-- Features -->
    <div class="mt-20 grid md:grid-cols-3 gap-8 max-w-6xl w-full">
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">🎯 Project Management</h3>
        <p class="text-sm text-gray-600">
          Create, update, delete, and monitor your projects in one place with deadlines and budget tracking.
        </p>
      </div>

      <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">✅ Task Prioritization</h3>
        <p class="text-sm text-gray-600">
          Add tasks, assign priorities, and drag & drop to reorder them by urgency.
        </p>
      </div>

      <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">🔒 Secure & Verified</h3>
        <p class="text-sm text-gray-600">
          Email verification, 2FA, and role-based access handled with Laravel Jetstream.
        </p>
      </div>
    </div>
  </div>
</template>
