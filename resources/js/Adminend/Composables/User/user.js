import { ref, watch } from "vue";
import { route } from 'ziggy-js';
import { router, useForm } from '@inertiajs/vue3'
import { useCommon } from '@/Adminend/Composables';

export function useUser(filters = {}){

    const { submitForm, destroyData } = useCommon();

    const userState = ref({
        dialogVisible: false,
        fileList     : [],
        search       : filters?.search_key || '',
        isTrash      : filters?.is_trashed || '',
        page         : filters?.current_page || 1,
        paginateSize : filters?.paginate_size || 50

    });

    const form = useForm({
        id         : '',
        name       : '',
        phone      : '',
        email      : '',
        role       : 'admin',
        status     : 'Inactive',
        password   : '',
        image      : '',
    })

    const handleAdd = () => {
        userState.value.dialogVisible = true;
    }

    watch( () => [userState.value.search, userState.value.isTrash, userState.value.page, userState.value.paginateSize],
        ([searchValue, isTrashValue, pageValue, paginateSizeValue]) => {
            router.get(route('admin.users.index'), {
                search       : searchValue,
                is_trashed   : isTrashValue,
                page         : pageValue,
                paginate_size: paginateSizeValue
            }, {
                preserveState: true,
                replace: true,
            })
        }
    )

    const submit = () => {

        if (userState.value?.fileList?.length) { form.image = userState.value.fileList.length > 1 ? userState.value.fileList[1].raw : userState.value.fileList[0].raw }

        submitForm({
            form,
            state: userState.value,
            storeRoute: () => route('admin.users.store'),
            updateRoute: (id) => route('admin.users.update', id),
            successMessage: 'User created successfully',
            updateMessage: 'User updated successfully',
        });
    };

    const edit = (user) =>{

        form.id          = user?.id;
        form._method     = 'put',
        form.name        = user?.name;
        form.phone       = user?.phone;
        form.email       = user?.email;
        form.role        = user?.role;
        form.status      = user?.status;

        userState.value.fileList.push({ url : user?.image });
        userState.value.dialogVisible = true;
    }

    const destroy = (id) =>{
        destroyData({ id, routeName: 'admin.users.destroy', });
    }

    return { userState, form, submit, handleAdd, edit, destroy }
}
