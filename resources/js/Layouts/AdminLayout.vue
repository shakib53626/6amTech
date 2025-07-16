<script setup>
import { Sidebar, Backdrop, Header } from '@/Adminend/Components'
import { useSidebar } from '@/Adminend/composables'
const { isExpanded, isHovered } = useSidebar()
</script>

<template>
  <div class="min-h-screen bg-gray-100/50 dark:bg-gray-900 xl:flex">
    <Sidebar />
    <Backdrop />
    <div class="flex-1 transition-all duration-300 ease-in-out" :class="[isExpanded || isHovered ? 'lg:ml-[290px]' : 'lg:ml-[83px]']" >
      <Header />

      <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <slot></slot>
      </div>

    </div>
  </div>
</template>

