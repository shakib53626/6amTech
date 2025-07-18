<script setup>
import { BasicTable, AddOrEditTransaction, Button, TextInput, Pagination } from '@/Adminend/components'
import { useTransaction } from '@/Adminend/Composables'
import { PlusIcon } from '@/icons'

const props = defineProps({
    transactions: Object,
    products    : Array,
    filters     : Object
})

const { transactionState, form, submit, edit, destroy, handleAdd } = useTransaction(props.filters)
</script>

<template>
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Card Header -->
        <div class="flex justify-between px-6 py-5">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                Tasks List Table
            </h3>

            <div class="flex items-center gap-2">
                <text-input placeholder="Search" height="h-9" v-model="transactionState.search" class="w-64" />
                <Button size="sm" variant="outline" :startIcon="PlusIcon" @click="handleAdd"> Add Task </Button>
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
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Product</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Type</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Quantity</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Date</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Description</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr v-for="(transaction, index) in transactions.data" :key="index" class="border-t border-gray-100 dark:border-gray-800">

                            <td class="px-2 py-4 sm:px-4">
                                {{ index+1 }}
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <span class="block font-semibold text-gray-800 text-theme-sm dark:text-white/90">
                                            {{ transaction.product.name }}
                                        </span>

                                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                            <span class="font-semibold">Current Stock : </span>{{ transaction.product.stock }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <el-tag class="font-bold" size="large" :type="transaction.type == 'In' ? 'success' : 'danger'">{{ transaction.type }}</el-tag>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                {{ transaction.quantity }}
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                {{ $formatDate(transaction.transaction_date ) }}
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                {{ (transaction.description ?? '').split(' ').slice(0, 10).join(' ') }}...
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <el-button type="primary" plain @click="edit(transaction)">  Edit </el-button>

                                <el-button type="danger" @click="destroy(transaction?.id)" plain> Delete </el-button>
                            </td>
                        </tr>
                    </tbody>
                </basic-table>

                <Pagination :data="transactions" :style="transactionState" />
            </div>
        </div>
    </div>

    <!-- Add Or Edit Transaction Dialog -->
    <add-or-edit-transaction :transactionState="transactionState" :form="form" :submit="submit" :products="products"/>
</template>
