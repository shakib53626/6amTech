<script setup>
import { computed } from 'vue';
import { TextInput, UploadImage, SelectOptions } from '@/Adminend/Components';
const props = defineProps({
    transactionState: { type: Object, default: false },
    form            : { type: Object },
    submit          : { type: Function },
    products        : { type: Array, default: () => [] }
});

const handleClose = () => {
    props.form.reset();
    props.form.clearErrors();
    props.transactionState.dialogVisible = false;
};

</script>

<template>
    <el-dialog class="dark:bg-gray-900" v-model="transactionState.dialogVisible" :title="form.id ? `Edit Task` : 'Add new Task'" width="600" @close="handleClose">

        <el-form :model="form" label-position="top">

            <div class="grid grid-cols-2 gap-2 mb-3">
                <select-options v-model="form.product_id" label="Product" placeholder="Select Product" :error="form?.errors?.product_id">
                    <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                </select-options>

                <select-options v-model="form.type" label="Type" placeholder="Select Type" :error="form?.errors?.type">
                    <option value="In">In</option>
                    <option value="Out">Out</option>
                </select-options>

                <text-input type="number" v-model="form.quantity" label="Quantity" placeholder="Quantity" :error="form?.errors?.quantity"/>
                <text-input type="date" v-model="form.transaction_date" label="Transaction Date" placeholder="Transaction Date" :error="form?.errors?.transaction_date"/>

            </div>

            <textarea v-model="form.description" class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" label="Write Description" placeholder="Description" :error="form?.errors?.description" rows="4"/>
        </el-form>

        <template #footer>
            <div class="dialog-footer">
                <el-button @click="transactionState.dialogVisible = false">Cancel</el-button>
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
