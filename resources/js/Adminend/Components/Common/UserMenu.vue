<script setup>
import { ChevronDownIcon, LogoutIcon } from '@/icons';
import { useUserDropdown } from '@/Adminend/composables'

const { dropdownOpen, dropdownRef, menuItems, toggleDropdown, signOut } = useUserDropdown()
</script>

<template>
  <div class="relative" ref="dropdownRef">

    <button class="flex items-center text-gray-700 dark:text-gray-400" @click.prevent="toggleDropdown">

        <span class="mr-3 overflow-hidden rounded-full h-11 w-11">
            <img src="@/images/user/owner.jpg" alt="User" />
        </span>

        <span class="block mr-1 font-semibold text-theme-sm">{{ $page.props.auth.user?.name || 'Guest' }}</span>

        <ChevronDownIcon :class="{ 'rotate-180': dropdownOpen }" />
    </button>

    <!-- Dropdown Start -->
    <div v-if="dropdownOpen" class="absolute right-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark" >

        <div class="text-center border-b border-gray-200 pb-3">
            <span class="block font-semibold text-lg text-gray-700 text-theme-sm dark:text-gray-400"> {{ $page.props.auth.user?.name || 'Guest' }} </span>
            <span class="block text-theme-xs text-gray-500 dark:text-gray-400"> {{ $page.props.auth.user?.email || 'guest@example.com' }} </span>
        </div>

        <ul class="flex flex-col gap-1 pt-4 pb-3 border-b border-gray-200 dark:border-gray-800">
            <li v-for="item in menuItems" :key="item.href">
                <Link :href="item.href" class="flex items-center gap-3 px-3 py-2 font-semibold text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300" >
                    <component :is="item.icon" class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300" />
                    {{ item.text }}
                </Link>
            </li>
        </ul>

        <Link href="/signin" @click="signOut" class="flex items-center gap-3 px-3 py-2 mt-3 font-semibold text-gray-700 rounded-lg group text-theme-sm cursor-pointer hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300" >
            <LogoutIcon class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300" />
            Sign out
        </Link>

    </div>

  </div>
</template>


