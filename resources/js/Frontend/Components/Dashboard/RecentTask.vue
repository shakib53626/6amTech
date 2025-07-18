<script setup>
const props = defineProps({
    data : { type : Array }
});
</script>
<template>
  <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6" >
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">

      <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Tasks</h3>
      </div>

      <div class="flex items-center gap-3">

        <button @click="$navigateTo('user.tasks.index', {'user_id': $page.props.auth.user?.id})" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200" >
            See all
        </button>
      </div>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
      <table class="min-w-full">
        <thead>
          <tr class="border-t border-gray-100 dark:border-gray-800">

            <th class="py-3 text-left">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">SL</p>
            </th>

            <th class="py-3 text-left">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Task Title</p>
            </th>

            <th class="py-3 text-left">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Description</p>
            </th>

            <th class="py-3 text-left">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Is Complete</p>
            </th>

            <th class="py-3 text-left">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
            </th>

            <th class="py-3 text-left">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Due Date</p>
            </th>

            <th class="py-3 text-left">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Priority</p>
            </th>

          </tr>
        </thead>
        <tbody>
          <tr v-for="(task, index) in data?.data" :key="index" class="border-t border-gray-100 dark:border-gray-800" >
            <td class="px-2 py-4 sm:px-4">
                {{ index+1 }}
            </td>

            <td class="py-4">
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

            <td class="py-4">
                <p class="text-sm text-gray-600">{{ task.description }}</p>
            </td>

            <td class="py-4">
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

            <td class="py-4">
                <el-tag class="font-bold" size="large" :type="task.status == 'Pending' ? 'warning' : task.status == 'In Progress' ? 'primary' : 'success'">{{ task.status }}</el-tag>
            </td>

            <td class="py-4">
                {{ $formatDate(task.due_date) }}
            </td>


            <td class="py-4">
                <el-tag class="font-bold" size="large" :type="task.priority == 'Low' ? 'primary' : task.priority == 'Medium' ? 'warning' : 'danger'">{{ task.priority }}</el-tag>
            </td>

          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

