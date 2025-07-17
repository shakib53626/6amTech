<script setup>
import { BasicTable, AddOrEditTask, Button, TextInput } from '@/Adminend/components'
import { useTask } from '@/Adminend/Composables'
import { PlusIcon } from '@/icons'
import Users from './Users.vue'
import { fi } from 'element-plus/es/locales.mjs'

const props = defineProps({
    tasks: Object,
    users: Array,
    filters: Object
})

const { taskState, form, submit, edit, destroy, handleAdd } = useTask(props.filters)
</script>

<template>
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Card Header -->
        <div class="flex justify-between px-6 py-5">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                Tasks List Table
            </h3>

            <div class="flex items-center gap-2">
                <text-input placeholder="Search" v-model="taskState.search" class="w-64" />
                <Button size="sm" variant="outline" :startIcon="PlusIcon" @click="handleAdd"> Add Task </Button>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
            <div class="space-y-5">
                <basic-table>
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-5 py-3 text-left w-3/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">SL</p>
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
                        <tr v-for="(task, index) in tasks.data" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <span class="block font-semibold text-gray-800 text-theme-sm dark:text-white/90">
                                            {{ task.title }}
                                        </span>

                                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                            {{ task.user.name }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ task.description }}</p>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ task.complete }}</p>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <span
                                    :class="[
                                        'rounded-full px-2 py-0.5 text-theme-xs font-semibold',
                                        {
                                            'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500': task.status === 'Active',
                                            'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500': task.status === 'Inactive',
                                        },
                                    ]"
                                >
                                    {{ task.status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <el-button type="primary" plain @click="edit(task)">  Edit </el-button>

                                <el-button type="danger" @click="destroy(task?.id)" plain> Delete </el-button>
                            </td>
                        </tr>
                    </tbody>
                </basic-table>
            </div>
        </div>
    </div>

    <!-- Add Or Edit Task Dialog -->
    <AddOrEditTask :taskState="taskState" :form="form" :submit="submit" :users="users"/>
</template>
