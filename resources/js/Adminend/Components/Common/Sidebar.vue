<script setup>
import { useSidebar } from '@/Adminend/Composables';
const {
  menuGroups,
  isExpanded,
  isMobileOpen,
  isHovered,
  openSubmenu,
  toggleSubmenu,
  isActive
} = useSidebar()
</script>

<template>
  <aside
    class="fixed mt-16 flex flex-col lg:mt-0 top-0 px-5 left-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200 lg:w-[290px] lg:translate-x-0"
    @mouseenter="!isExpanded && (isHovered = true)"
    @mouseleave="isHovered = false"
  >
    <div class="py-8 flex justify-start">
      <img class="dark:hidden" src="@/images/logo/logo.svg" alt="Logo" width="150" />
      <img class="hidden dark:block" src="@/images/logo/logo-dark.svg" alt="Logo" width="150" />
    </div>

    <div class="flex flex-col overflow-y-auto no-scrollbar">
      <nav class="mb-6">
        <div class="flex flex-col gap-4">
          <div v-for="(group, groupIndex) in menuGroups" :key="groupIndex">

            <h2 class="mb-4 text-xs uppercase flex text-gray-400 justify-start">
              {{ group.title }}
            </h2>

            <ul class="flex flex-col gap-2">

              <li v-for="(item, itemIndex) in group.items" :key="item.name">

                <!-- No Submenu -->
                <button  v-if="!item.children" class="flex menu-item group w-full lg:justify-start text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 p-2 rounded-md"
                    :class="{ 'bg-orange-100/80 dark:bg-orange-200 text-orange-600': isActive(item.path) }"
                     @click="$inertia.visit(route(item.path))"
                >
                  <span class="menu-item-icon-inactive me-2">
                    <component :is="item.icon" />
                  </span>
                  <span class="menu-item-text font-semibold">{{ item.name }}</span>
                </button>

                <!-- With Submenu -->
                <div v-else>
                    <button class="flex menu-item group w-full lg:justify-start text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 p-2 rounded-md" @click="toggleSubmenu(`${groupIndex}-${itemIndex}`)" >
                        <span class="menu-item-icon-inactive me-2">
                            <component :is="item.icon" />
                        </span>

                        <span class="menu-item-text font-semibold">{{ item.name }}</span>
                        <ChevronDownIcon class="ml-auto w-5 h-5" />

                    </button>

                    <ul class="mt-2 ml-9 space-y-2" v-show="openSubmenu === `${groupIndex}-${itemIndex}`" >
                        <li v-for="sub in item.children" :key="sub.name" class="menu-dropdown-item font-semibold text-gray-600 cursor-pointer" @click="$inertia.visit(route(sub.path))">
                            {{ sub.name }}
                        </li>
                    </ul>

                </div>

              </li>

            </ul>

          </div>
        </div>
      </nav>
    </div>
  </aside>
</template>
