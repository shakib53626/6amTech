<script setup>
import { BasicTable, AddOrEditProduct, Button, TextInput, Pagination } from '@/Adminend/components'
import { useProduct } from '@/Adminend/Composables'
import { PlusIcon } from '@/icons'

const props = defineProps({
    products  : Object,
    categories: Array,
    filters   : Object
})

const { productState, form, submit, edit, destroy, handleAdd } = useProduct(props.filters)
</script>

<template>
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Card Header -->
        <div class="block md:flex justify-between px-6 py-5">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                Products List Table
            </h3>

            <div class="flex items-center gap-2">
                <text-input placeholder="Search by name or email" v-model="productState.search" class="w-64" height="h-9" />
                <Button size="sm" variant="outline" :startIcon="PlusIcon" @click="handleAdd"> Add User </Button>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
            <div class="space-y-5">
                <basic-table>
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-5 py-3 text-left w-3/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">SL</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Product Info</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Product Price</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Stock</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Description</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                            </th>

                            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
                                <p class="font-semibold text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr v-for="(product, index) in products.data" :key="index" class="border-t border-gray-100 dark:border-gray-800">

                            <td class="py-4 sm:px-4">
                                {{ index+1 }}
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 overflow-hidden rounded-full">
                                        <img :src="product.image" :alt="product.name" />
                                    </div>

                                    <div>
                                        <span class="block font-semibold text-gray-800 text-theme-sm dark:text-white/90">
                                            {{ product.name }} <span v-if="product.sku">({{ product.sku }})</span>
                                        </span>

                                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                            {{ product.category.name }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <span class="block font-semibold text-gray-800 text-theme-sm dark:text-white/90">
                                    <span class="font-normal">Price :</span> {{ product.price }} Tk
                                </span>

                                <span class="block text-gray-500 text-theme-xs dark:text-gray-400" v-if="product?.discount">
                                    <span class="font-normal">Discount :</span> {{ product.discount }} Tk
                                </span>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                {{ product.stock }}
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ (product.description ?? '').split(' ').slice(0, 10).join(' ') }}...
                                </p>
                            </td>

                            <td class="px-5 py-4 sm:px-6">
                                <span
                                    :class="[
                                        'rounded-full px-2 py-0.5 text-theme-xs font-semibold',
                                        {
                                            'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500': product.status === 'Active',
                                            'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500': product.status === 'Inactive',
                                        },
                                    ]"
                                >
                                    {{ product.status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <el-button type="primary" plain @click="edit(product)">  Edit </el-button>

                                <el-button type="danger" @click="destroy(product?.id)" plain> Delete </el-button>
                            </td>
                        </tr>
                    </tbody>
                </basic-table>

                <Pagination :data="products" :style="productState" />
            </div>
        </div>
    </div>

    <!-- Add Or Edit User Dialog -->
    <add-or-edit-product :productState="productState" :form="form" :submit="submit" :categories="categories"/>
</template>
