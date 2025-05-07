<!-- resources/js/Components/SelectInput.vue -->
<template>
    <div>
        <label :for="id" class="block text-sm font-medium text-gray-700 mb-1">{{ label }}</label>
        <select :id="id" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="">-- Choisir --</option>
            <option v-for="(option, index) in options" :key="index" :value="option.value">
                {{ option.label }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'SelectInput',
    props: {
        id: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        modelValue: {
            type: [String, Number],
            default: '',
        },
        options: {
            type: Array,
            default: () => [],
        },
    },
};
</script>
