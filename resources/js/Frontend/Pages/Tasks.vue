<script setup>
import { BasicTable, Button, TextInput, Pagination } from '@/Adminend/components'
import { ChangeTask } from '@/Frontend/Components';
import UserLayout from '@/Layouts/UserLayout.vue';
import { useTask } from '@/Frontend/Composables'
import { PlusIcon } from '@/icons'

const props = defineProps({
    tasks  : Object,
    users  : Array,
    filters: Object
})

const { taskState, form, submit, changeStatus } = useTask(props.filters)
defineOptions({ layout : UserLayout});
</script>

<template>
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Card Header -->
        <div class="flex justify-between px-6 py-5">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                Tasks List Table
            </h3>

            <div class="flex items-center gap-2">
                <text-input placeholder="Search" height="h-9" v-model="taskState.search" class="w-64" />
                <Button size="sm" variant="outline" @click="$navigateTo('user.tasks.index', {'completed' : 'Incomplete', 'user_id' : $page.props.auth.user?.id})"> Incomplete </Button>
                <Button size="sm" variant="outline" @click="$navigateTo('user.tasks.index', {'completed' : 'Complete', 'user_id' : $page.props.auth.user?.id})"> Complete </Button>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
            <div class="space-y-5">
                <basic-table>
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-5 py-3 text-left w-9 sm:px-4">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">SL</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Task Title</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Description</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Is Complete</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Due Date</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Priority</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr v-for="(task, index) in tasks.data" :key="index" class="border-t border-gray-100 dark:border-gray-800">

                            <td class="px-2 py-4 sm:px-4">
                                {{ index+1 }}
                            </td>

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
                                <p class="text-sm text-gray-600">{{ task.description }}</p>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <span
                                    :class="[
                                        'rounded-full px-2 py-0.5 text-theme-xs font-semibold',
                                        {
                                            'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500': task.completed === 'Complete',
                                            'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500': task.completed === 'Incomplete',
                                        },
                                    ]"
                                >
                                    {{ task.completed }}
                                </span>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <el-tag class="font-bold" size="large" :type="task.status == 'Pending' ? 'warning' : task.status == 'In Progress' ? 'primary' : 'success'">{{ task.status }}</el-tag>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                {{ $formatDate(task.due_date) }}
                            </td>


                            <td class="px-5 py-4 sm:px-6">
                                <el-tag class="font-bold" size="large" :type="task.priority == 'Low' ? 'primary' : task.priority == 'Medium' ? 'warning' : 'danger'">{{ task.priority }}</el-tag>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <el-button type="primary" plain @click="changeStatus(task)">  Change </el-button>
                            </td>
                        </tr>
                    </tbody>
                </basic-table>

                <Pagination :data="tasks" :style="taskState" />
            </div>
        </div>

        <change-task :taskState="taskState" :form="form" :submit="submit"/>
    </div>

</template>
