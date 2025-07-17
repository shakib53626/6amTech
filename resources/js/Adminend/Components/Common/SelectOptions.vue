<script setup>
const model = defineModel({
    type   : [String, Number],
    default: ''
});

const props = defineProps({
    label      : { type: String},
    placeholder: { type: String},
    error      : { type: String, default: '' }
});

</script>

<template>
    <div>
        <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-400" > {{ label }} </label>

        <div class="relative">
            <select v-model="model" :placeholder="placeholder"
                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                :class="[ 'border rounded px-3 py-2 w-full transition duration-300 focus:outline-none', error ? 'border-red-500' : model && !error ? 'border-green-600' : 'border-gray-300' ]">
                <option value="" disabled selected>{{ placeholder }}</option>
                <slot></slot>
            </select>
        </div>

        <!-- Error -->
        <span v-if="error" class="mt-1 text-sm text-red-600 dark:text-red-500">{{ error }}</span>
    </div>
</template>
