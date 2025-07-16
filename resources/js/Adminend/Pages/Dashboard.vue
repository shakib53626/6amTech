<script setup>
import { EcommerceMetrics, MonthlyTarget, MonthlySale, StatisticsChart } from '@/Adminend/Components';

</script>

<template>
    <div class="grid grid-cols-12 gap-4 md:gap-6">

        <div class="col-span-12 space-y-6 xl:col-span-7">
            <ecommerce-metrics />
            <monthly-sale />
        </div>

        <div class="col-span-12 xl:col-span-5">
            <monthly-target />
        </div>

        <div class="col-span-12">
            <statistics-chart />
        </div>

    </div>
</template>
