<script setup>
const props = defineProps({
    data : { type : Object },
    state: { type : Object}
});
</script>

<template>
    <el-card shadow="never" class="mt-2">
        <div class="block md:flex justify-between items-center">
            <el-pagination size="small" background layout="prev, pager, next" :current-page="data.current_page" :page-size="data.per_page" :total="data?.total" @current-change="val => state.page = val" class="mt-4" />

            <el-text type="info">
                Showing page {{ data.current_page }} of {{ data.last_page }}
                ( Total: {{ data.total }} items )
            </el-text>
        </div>
    </el-card>
</template>

<style scoped>
.el-pagination{
    margin-top: 0 !important;
}
</style>
