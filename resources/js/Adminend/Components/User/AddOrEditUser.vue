<script setup>
import { computed } from 'vue';
import { TextInput, UploadImage, SelectOptions } from '@/Adminend/Components';
const props = defineProps({
    userState: { type: Object, default: false },
    form     : { type: Object },
    submit   : { type: Function },
    roles    : { type: Array }
});

const handleClose = () => {
    props.form.reset();
    props.form.clearErrors();
    props.userState.dialogVisible = false;
    props.userState.fileList = []
};

</script>

<template>
    <el-dialog class="dark:bg-gray-900" v-model="userState.dialogVisible" :title="form.id ? `Edit User - ${form?.name}` : 'Add new user'" width="600" @close="handleClose">

        <el-form :model="form" label-position="top">

            <div class="grid grid-cols-2 gap-2 mb-3">
                <text-input v-model="form.name" label="Name" placeholder="Name" :error="form?.errors?.name"/>
                <text-input type="email" v-model="form.email" label="Email" placeholder="Email" :error="form?.errors?.email"/>
                <text-input type="tel" v-model="form.phone" label="Phone" placeholder="Phone" :error="form?.errors?.phone"/>

                <select-options v-model="form.role" label="Role" placeholder="Select Role" :error="form?.errors?.role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select-options>

                <select-options v-model="form.status" label="Status" placeholder="Select Status" :error="form?.errors?.status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select-options>

                <text-input type="password" v-model="form.password" label="Password" placeholder="Password" :error="form?.errors?.password" />
            </div>

            <upload-image v-model="userState.fileList" label="Profile Image"/>
        </el-form>

        <template #footer>
            <div class="dialog-footer">
                <el-button @click="userState.dialogVisible = false">Cancel</el-button>
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
