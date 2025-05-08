<script setup>
import { useForm } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'
import SelectInput from '@/Components/SelectInput.vue'
import DatePicker from '@/Components/DatePicker.vue'

const props = defineProps({
    task: Object,
    projects: Array,
    isEdit: Boolean,
})

const emit = defineEmits(['submit', 'cancel'])

const projectOptions = [
    { value: '', label: 'No project' },
    ...props.projects.map((p) => ({ value: p.id, label: p.name })),
]

const form = useForm({
    name: props.task?.name || '',
    priority: props.task?.priority || '',
    project_id: props.task?.project_id || '',
    status: props.task?.status?.replace('_', ' ').toUpperCase() || '',
    due_date: props.task?.due_date || ''
})

const format = (date) => {
    if (!date) return '';
    if (typeof date === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(date)) {
        return date;
    }
    const value = !date.getDate() ? new Date(date) : date
    const day = new Date(value).getDate().toString().padStart(2, '0');
    const month = (value.getMonth() + 1).toString().padStart(2, '0');
    const year = value.getFullYear();
    return `${year}-${month}-${day}`;
};

const formatStatus = (status) => {
    return status.toLowerCase().replace(/ /g, '_');
};

const submitForm = () => {
    const formData = { ...form }
    formData.due_date = format(formData.due_date);
    formData.status = formatStatus(formData.status);
    emit('submit', formData)
}
</script>

<template>
    <form class="mt-6" @submit.prevent="submitForm">
        <InputLabel for="name" value="Task name" />
        <TextInput :id="isEdit ? 'edit_name' : 'name'" v-model="form.name" class="mt-1 block w-full"
            @input="form.clearErrors('name')" />
        <InputError :message="form.errors.name" class="mt-2" />

        <div class="mt-4" v-if="projects.length > 0">
            <InputLabel :for="isEdit ? 'edit_project_id' : 'project_id'" value="Project" />
            <SelectInput :id="isEdit ? 'edit_project_id' : 'project_id'" v-model="form.project_id" :options="projectOptions" />
            <InputError :message="form.errors.project_id" class="mt-2" />
        </div>

        <div class="mt-4">
            <InputLabel :for="isEdit ? 'edit_priority' : 'priority'" value="Priority" />
            <TextInput :id="isEdit ? 'edit_priority' : 'priority'" v-model="form.priority" type="number"
                class="mt-1 block w-full" />
            <InputError :message="form.errors.priority" class="mt-2" />
        </div>

        <div class="mt-4">
            <InputLabel :for="isEdit ? 'edit_status' : 'status'" value="Status" />
            <TextInput :id="isEdit ? 'edit_status' : 'status'" v-model="form.status" type="text"
                placeholder="Pending, In progress, Done" class="mt-1 block w-full" />
            <InputError :message="form.errors.status" class="mt-2" />
        </div>

        <div class="mt-4">
            <DatePicker
                :modelValue="form.due_date"
                @update:modelValue="(val) => form.due_date = val"
                label="Date"
                :options="{
                    minDate: new Date(),
                    maxDate: '+1M',
                    firstDay: 1
                }"
            />
            <InputError :message="form.errors.due_date" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
            <slot name="actions"></slot>
        </div>
    </form>
</template>
