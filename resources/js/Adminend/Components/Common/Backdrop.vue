<script setup>
import { useSidebar } from '@/Adminend/composables'
const { toggleMobileSidebar, isMobileOpen } = useSidebar()
</script>

<template>
  <div
    v-if="isMobileOpen"
    class="fixed inset-0 bg-gray-900/50 z-9999 lg:hidden"
    @click="toggleMobileSidebar"
  ></div>
</template>

