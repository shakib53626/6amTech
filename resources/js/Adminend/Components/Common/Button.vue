<script setup>
const props = defineProps({
    size     : { type : String,              default: 'md' },
    variant  : { type : String,              default: 'primary' },
    startIcon: { type : [Object,  Function], default: null },
    endIcon  : { type : [Object,  Function], default: null },
    onClick  : { type : Function,            default: null, },
    className: { type : String,              default: '', },
    disabled : { type : Boolean,             default: false, },
})

const sizeClasses = {
  sm: 'px-4 py-2 text-sm',
  md: 'px-5 py-3.5 text-sm',
}

const variantClasses = {
  primary: 'bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 disabled:bg-brand-300',
  outline: 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03] dark:hover:text-gray-300',
}

const handleClick = () => {
  if (!props.disabled && props.onClick) {
    props.onClick()
  }
}

</script>

<template>
    <button
        :class="[ 'inline-flex items-center justify-center font-medium gap-2 rounded-lg transition',
            sizeClasses[size], variantClasses[variant], className,
            { 'cursor-not-allowed opacity-50': disabled },
        ]"

        @click="handleClick"
        :disabled="disabled"
    >
        <span v-if="startIcon" class="flex items-center">
            <component :is="startIcon" />
        </span>

        <slot></slot>

        <span v-if="endIcon" class="flex items-center">
            <component :is="endIcon" />
        </span>
    </button>
</template>


