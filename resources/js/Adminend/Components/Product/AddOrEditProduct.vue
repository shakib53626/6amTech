<script setup>
import { computed } from 'vue';
import { TextInput, UploadImage, SelectOptions } from '@/Adminend/Components';
const props = defineProps({
    productState: { type: Object, default: false },
    form      : { type: Object },
    submit    : { type: Function },
    categories: { type: Array }
});

const handleClose = () => {
    props.form.reset();
    props.form.clearErrors();
    props.productState.dialogVisible = false;
    props.productState.fileList = []
};

const screen = window.innerWidth;
</script>

<template>
    <el-dialog class="dark:bg-gray-900" v-model="productState.dialogVisible" :title="form.id ? `Edit Product - ${form?.name}` : 'Add new Product'" :width="screen > 991 ? '800' : screen > 768 ? '500' : '300'" @close="handleClose">

        <el-form :model="form" label-position="top">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 mb-3">
                <text-input v-model="form.name" label="Name"      placeholder="Name"         :error="form?.errors?.name"/>

                <select-options v-model="form.category_id" label="Category" placeholder="Select Category" :error="form?.errors?.category_id">
                    <option :value="val.id" v-for="(val, index) in categories" :key="index">{{ val?.name }}</option>
                </select-options>

                <text-input v-model="form.sku"  label="SKU"       placeholder="Product Sku"  :error="form?.errors?.sku"/>
                <text-input v-model="form.stock" label="Stock"    placeholder="Stock"        :error="form?.errors?.stock"/>
                <text-input type="number" v-model="form.price" label="Price" placeholder="Price" :error="form?.errors?.price"/>
                <text-input type="number" v-model="form.discount" label="Discount" placeholder="Discount" :error="form?.errors?.discount"/>

                <select-options v-model="form.status" label="Status" placeholder="Select Status" :error="form?.errors?.status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select-options>

            </div>

            <textarea v-model="form.description" placeholder="Product Description" class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" label="Write Description" rows="4"></textarea>
            <upload-image v-model="productState.fileList" :form="form" label="Product Image"/>
        </el-form>

        <template #footer>
            <div class="dialog-footer">
                <el-button @click="productState.dialogVisible = false">Cancel</el-button>
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
