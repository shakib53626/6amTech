<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { TaskReportCard, MonthlySale, RecentTask } from '@/Frontend/Components';

defineOptions({ layout : UserLayout});

const props = defineProps({reports : Object});
</script>

<template>
    <div class="grid grid-cols-12 gap-4 md:gap-6">

        <div class="col-span-12 space-y-6 xl:col-span-12">
            <task-report-card :reports="reports"/>
            <monthly-sale :data="reports.monthlyData"/>
        </div>

        <div class="col-span-12 xl:col-span-12">
            <recent-task :data="reports.recentTask"/>
        </div>

    </div>
</template>
