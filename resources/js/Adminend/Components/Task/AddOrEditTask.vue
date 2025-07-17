<script setup>
import { computed } from 'vue';
import { TextInput, UploadImage, SelectOptions } from '@/Adminend/Components';
const props = defineProps({
    taskState: { type: Object, default: false },
    form     : { type: Object },
    submit   : { type: Function },
    users    : { type: Array, default: () => [] }
});

const handleClose = () => {
    props.form.reset();
    props.form.clearErrors();
    props.taskState.dialogVisible = false;
};

</script>

<template>
    <el-dialog class="dark:bg-gray-900" v-model="taskState.dialogVisible" :title="form.id ? `Edit Task` : 'Add new Task'" width="600" @close="handleClose">

        <el-form :model="form" label-position="top">

            <div class="grid grid-cols-2 gap-2 mb-3">
                <text-input v-model="form.title" label="Title" placeholder="Title" :error="form?.errors?.title"/>
                <text-input type="date" v-model="form.due_date" label="Due Date" placeholder="Due Date" :error="form?.errors?.due_date"/>

                <select-options v-model="form.user_id" label="User" placeholder="Select User" :error="form?.errors?.user_id">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select-options>

                <select-options v-model="form.status" label="Status" placeholder="Select Status" :error="form?.errors?.status">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select-options>

                <select-options v-model="form.completed" label="Complete" placeholder="Select Complete" :error="form?.errors?.complete">
                    <option value="Complete">Complete</option>
                    <option value="Incomplete">Incomplete</option>
                </select-options>

                <select-options v-model="form.priority" label="Priority" placeholder="Select Priority" :error="form?.errors?.priority">
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select-options>

            </div>

            <textarea v-model="form.description" class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" label="Write Description" placeholder="Description" :error="form?.errors?.description" rows="4"/>
        </el-form>

        <template #footer>
            <div class="dialog-footer">
                <el-button @click="taskState.dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="submit">
                    <span v-if="form.processing" class="flex items-center justify-center">
                        <svg class="animate-spin me-1.5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);"><path d="M2 11h5v2H2zm15 0h5v2h-5zm-6 6h2v5h-2zm0-15h2v5h-2zM4.222 5.636l1.414-1.414 3.536 3.536-1.414 1.414zm15.556 12.728-1.414 1.414-3.536-3.536 1.414-1.414zm-12.02-3.536 1.414 1.414-3.536 3.536-1.414-1.414zm7.07-7.071 3.536-3.535 1.414 1.415-3.536 3.535z"></path></svg>
                        Loading...
                    </span>
                    <span v-else>Confirm</span>
                </el-button>
            </div>
        </template>

    </el-dialog>
</template>

<style scoped>

</style>
