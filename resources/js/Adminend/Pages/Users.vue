<script setup>
import { BasicTable, Button } from '@/Adminend/components'
import { PlusIcon } from '@/icons'

const props = defineProps({
    users: Object
})
</script>

<template>
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Card Header -->
        <div class="flex justify-between px-6 py-5">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                Users List Table
            </h3>

            <div class="flex items-center gap-2">
                <Button size="sm" variant="outline" :startIcon="PlusIcon"> Add User </Button>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
            <div class="space-y-5">
                <basic-table>
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-5 py-3 text-left w-3/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">User</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Project Name</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Team</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Budget</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr v-for="(user, index) in users.data" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 overflow-hidden rounded-full">
                                        <img :src="user.image" :alt="user.name" />
                                    </div>

                                    <div>
                                        <span class="block font-semibold text-gray-800 text-theme-sm dark:text-white/90">
                                            {{ user.name }}
                                        </span>

                                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                            {{ user.role }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ user.project }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                            <div class="flex -space-x-2">
                                <div
                                v-for="(member, memberIndex) in user.team"
                                :key="memberIndex"
                                class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900"
                                >
                                <img :src="member" alt="team member" />
                                </div>
                            </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                            <span
                                :class="[
                                'rounded-full px-2 py-0.5 text-theme-xs font-semibold',
                                {
                                    'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500':
                                    user.status === 'Active',
                                    'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400':
                                    user.status === 'Pending',
                                    'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500':
                                    user.status === 'Cancel',
                                },
                                ]"
                            >
                                {{ user.status }}
                            </span>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ user.budget }}</p>
                            </td>
                        </tr>
                    </tbody>
                </basic-table>
            </div>
        </div>
    </div>
</template>
