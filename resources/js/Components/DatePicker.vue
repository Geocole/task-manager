<template>
  <div>
    <label class="block text-sm font-medium text-gray-600">
      Pick a Date
      <VueDatePicker
        :modelValue="date"
        @update:modelValue="updateDate"
        :enable-time-picker="false"
        :format="format"
        auto-apply
        :teleport-center="true"
        class="mt-1"
      />
    </label>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const props = defineProps({
  modelValue: {
    type: Date,
    default: null,
  },
})

const emits = defineEmits(['update:modelValue'])

const date = ref(props.modelValue);

const updateDate = (newDate) => {
  date.value = newDate;
  emits('update:modelValue', newDate);
};

const format = (date) => {
  if (!date) return '';
  const day = date.getDate().toString().padStart(2, '0');
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const year = date.getFullYear();
  return `${day}-${month}-${year}`;
};

watch(props.modelValue, (newValue) => {
  date.value = newValue;
});
</script>

<style>
/* Customisation pour s'intégrer avec Tailwind */
.dp__main {
  font-family: inherit;
}
.dp__input {
  @apply w-full px-7 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500;
}
</style>
