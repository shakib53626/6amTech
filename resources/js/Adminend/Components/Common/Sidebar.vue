<script setup>
import { route } from 'ziggy-js'
import { ChevronDownIcon } from '@/icons';
import { useSidebar } from '@/Adminend/Composables';
const { menuGroups, isExpanded, activeMenu, isMobileOpen, defaultOpeneds, isHovered, openSubmenu, toggleSubmenu, isActive, isChildActive } = useSidebar()

</script>

<template>
    <aside
        :class="[ 'fixed mt-16 flex flex-col lg:mt-0 top-0 px-5 left-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200',
            {
                'lg:w-[290px]': isExpanded || isMobileOpen || isHovered,
                'lg:w-[83px]': !isExpanded && !isHovered,
                'translate-x-0 w-[290px]': isMobileOpen,
                '-translate-x-full': !isMobileOpen,
                'lg:translate-x-0': true,
            },
        ]"
        @mouseenter="!isExpanded && (isHovered = true)"
        @mouseleave="isHovered = false"
    >

        <div class="py-8 flex justify-start cursor-pointer" @click="$navigateTo('admin.dashboard')">
            <img class="dark:hidden" src="@/images/logo/logo.svg" alt="Logo" width="150" v-if="isExpanded || isHovered"/>
            <img class="dark:hidden" src="@/images/logo/logo-icon.png" alt="Logo" width="45" v-else/>
            <img class="hidden dark:block" src="@/images/logo/logo-dark.svg" alt="Logo" width="150" />
        </div>

        <div class="flex flex-col overflow-y-auto no-scrollbar">
            <nav class="mb-6">
                <div class="flex flex-col gap-4">
                    <div v-for="(group, groupIndex) in menuGroups" :key="groupIndex">

                        <h2 class="mb-4 ms-1 text-xs uppercase flex text-gray-400 justify-start">
                            {{ group.title }}
                        </h2>

                        <ul class="flex flex-col gap-2">
                            <li v-for="(item, itemIndex) in group.items" :key="item.name">

                                <!-- No Submenu -->
                                <button  v-if="!item.children" class="flex menu-item group w-full lg:justify-start text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 p-2 rounded-md"
                                    :class="{ 'bg-orange-100/80 dark:bg-orange-200/15 text-orange-600': isActive(item.path) }"
                                    @click="$navigateTo(item.path)"
                                >
                                    <span class="menu-item-icon-inactive me-2">
                                        <component :is="item.icon" />
                                    </span>

                                    <span class="menu-item-text font-semibold" v-show="isExpanded || isHovered">{{ item.name }}</span>
                                </button>

                                <!-- With Submenu -->
                                <div v-else>

                                    <button class="flex items-center menu-item group w-full lg:justify-start text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 p-2 rounded-md" @click="toggleSubmenu(`${groupIndex}-${itemIndex}`)"
                                        :class="{ 'bg-orange-100/80 dark:bg-orange-200/15 text-orange-600': isChildActive(item.children) }"
                                    >
                                        <span class="menu-item-icon-inactive me-2">
                                            <component :is="item.icon" />
                                        </span>

                                        <span class="menu-item-text font-semibold" v-show="isExpanded || isHovered">{{ item.name }}</span>
                                        <ChevronDownIcon class="ml-auto w-5 h-5 pt-1" :class="{ 'rotate-180': openSubmenu === `${groupIndex}-${itemIndex}` || defaultOpeneds.includes(`${groupIndex}-${itemIndex}`) }" />
                                    </button>

                                    <ul class="mt-2 ml-9 space-y-2" v-show="openSubmenu === `${groupIndex}-${itemIndex}` || defaultOpeneds.includes(`${groupIndex}-${itemIndex}`)" >
                                        <li v-for="sub in item.children" :key="sub.name" class="menu-dropdown-item font-semibold text-gray-600 cursor-pointer hover:text-orange-400" @click="$navigateTo(sub.path)"
                                            :class="{ 'text-orange-600': isActive(sub.path) }"
                                        >
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
