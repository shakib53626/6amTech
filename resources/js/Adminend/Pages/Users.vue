<script setup>
import { BasicTable, AddOrEditUser, Button, TextInput, Pagination } from '@/Adminend/components'
import { useUser } from '@/Adminend/Composables'
import { PlusIcon } from '@/icons'

const { userState, form, submit, edit, destroy, handleAdd } = useUser()

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
                <text-input placeholder="Search by name or email" v-model="userState.search" class="w-64" />
                <Button size="sm" variant="outline" :startIcon="PlusIcon" @click="handleAdd"> Add User </Button>
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
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Phone Number</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Email</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
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
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ user.phone }}</p>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ user.email }}</p>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <span
                                    :class="[
                                        'rounded-full px-2 py-0.5 text-theme-xs font-semibold',
                                        {
                                            'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500': user.status === 'Active',
                                            'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500': user.status === 'Inactive',
                                        },
                                    ]"
                                >
                                    {{ user.status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <el-button type="primary" plain @click="edit(user)">  Edit </el-button>

                                <el-button type="danger" @click="destroy(user?.id)" plain> Delete </el-button>
                            </td>
                        </tr>
                    </tbody>
                </basic-table>

                <Pagination :data="users" :style="userState" />
            </div>
        </div>
    </div>

    <!-- Add Or Edit User Dialog -->
    <AddOrEditUser :userState="userState" :form="form" :submit="submit"/>
</template>
