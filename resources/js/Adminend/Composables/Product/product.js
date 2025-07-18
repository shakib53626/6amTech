import { ref, watch } from "vue";
import { route } from 'ziggy-js';
import { router, useForm } from '@inertiajs/vue3'
import { useCommon } from '@/Adminend/Composables';

export function useProduct(filters = {}){

    const { submitForm, destroyData } = useCommon();

    const productState = ref({
        dialogVisible: false,
        fileList     : [],
        search       : filters?.search_key || '',
        page         : filters?.current_page || 1,
        paginateSize : filters?.paginate_size || 50

    });

    const form = useForm({
        id         : '',
        name       : '',
        category_id: '',
        sku        : '',
        stock      : '',
        price      : '',
        discount   : '',
        status     : 'Active',
        image      : '',
    })

    const handleAdd = () => {
        productState.value.dialogVisible = true;
    }

    watch( () => [productState.value.search, productState.value.page, productState.value.paginateSize],
        ([searchValue, pageValue, paginateSizeValue]) => {

            router.get(route('admin.products.index'), {
                search       : searchValue,
                page         : pageValue,
                paginate_size: paginateSizeValue
            }, {
                preserveState: true,
                replace: true,
            })
        }
    )

    const submit = () => {

        if (productState.value?.fileList?.length) { form.image = productState.value.fileList.length > 1 ? productState.value.fileList[1].raw : productState.value.fileList[0].raw }

        submitForm({
            form,
            state: productState.value,
            storeRoute: () => route('admin.products.store'),
            updateRoute: (id) => route('admin.products.update', id),
            successMessage: 'Product created successfully',
            updateMessage: 'Product updated successfully',
        });
    };

    const edit = (category) =>{

        form.id          = category?.id;
        form._method     = 'put',
        form.name        = category?.name;
        form.category_id = category?.category_id,
        form.sku         = category?.sku,
        form.stock       = category?.stock,
        form.price       = category?.price,
        form.discount    = category?.discount,
        form.status      = category?.status;

        productState.value.fileList.push({ url : category?.image });
        productState.value.dialogVisible = true;
    }

    const destroy = (id) =>{
        destroyData({ id, routeName: 'admin.products.destroy', });
    }

    return { productState, form, submit, handleAdd, edit, destroy }
}
