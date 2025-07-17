import { ref, watch } from "vue";
import { route } from 'ziggy-js';
import { router, useForm } from '@inertiajs/vue3'
import { useCommon } from '@/Adminend/Composables';

export function useCategory(filters = {}){

    const { submitForm, destroyData } = useCommon();

    const categoryState = ref({
        dialogVisible: false,
        fileList     : [],
        search       : filters?.search_key || '',
        page         : filters?.current_page || 1,
        paginateSize : filters?.paginate_size || 50

    });

    const form = useForm({
        id         : '',
        name       : '',
        status     : 'Active',
        image      : '',
    })

    const handleAdd = () => {
        categoryState.value.dialogVisible = true;
    }

    watch( () => [categoryState.value.search, categoryState.value.page, categoryState.value.paginateSize],
        ([searchValue, pageValue, paginateSizeValue]) => {

            router.get(route('admin.categories.index'), {
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

        if (categoryState.value?.fileList?.length) { form.image = categoryState.value.fileList.length > 1 ? categoryState.value.fileList[1].raw : categoryState.value.fileList[0].raw }

        submitForm({
            form,
            state: categoryState.value,
            storeRoute: () => route('admin.categories.store'),
            updateRoute: (id) => route('admin.categories.update', id),
            successMessage: 'Category created successfully',
            updateMessage: 'Category updated successfully',
        });
    };

    const edit = (category) =>{

        form.id          = category?.id;
        form._method     = 'put',
        form.name        = category?.name;
        form.status      = category?.status;

        categoryState.value.fileList.push({ url : category?.image });
        categoryState.value.dialogVisible = true;
    }

    const destroy = (id) =>{
        destroyData({ id, routeName: 'admin.categories.destroy', });
    }

    return { categoryState, form, submit, handleAdd, edit, destroy }
}
