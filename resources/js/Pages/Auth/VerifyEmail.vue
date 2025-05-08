<template>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded">
        <h2 class="text-xl font-bold mb-4">Email Verification</h2>
        <p>An email verification link has been sent to your registered email address. Please verify your email before
            continuing.</p>

        <button @click="resendEmail" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Resend Verification Email
        </button>

        <div v-if="successMessage" class="mt-4 text-green-500">
            {{ successMessage }}
        </div>
        <div v-if="errorMessage" class="mt-4 text-red-500">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const successMessage = ref(null);
const errorMessage = ref(null);

const resendEmail = () => {
    router.post(route('verification.send'), {}, {
        onSuccess: () => {
            successMessage.value = 'Verification email has been resent.';
            setTimeout(() => {
                successMessage.value = null;
            }, 3000);
        },
        onError: () => {
            errorMessage.value = 'Failed to resend verification email.';
            setTimeout(() => {
                errorMessage.value = null;
            }, 3000);
        }
    });
};
</script>
