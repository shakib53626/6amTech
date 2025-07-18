import { ref, watch } from "vue";
import { route } from 'ziggy-js';
import { router, useForm } from '@inertiajs/vue3'
import { useCommon } from '@/Adminend/Composables';

export function useTransaction(filters = {}){

    const { submitForm, destroyData } = useCommon();

    const transactionState = ref({
        dialogVisible: false,
        search       : filters?.search_key || '',
        isTrash      : filters?.is_trashed || '',
        page         : filters?.current_page || 1,
        paginateSize : filters?.paginate_size || 50

    });

    const form = useForm({
        id              : '',
        product_id      : '',
        type            : '',
        quantity        : '',
        transaction_date: '',
        description     : ''
    })

    const handleAdd = () => {
        transactionState.value.dialogVisible = true;
    }

    watch( () => [transactionState.value.search, transactionState.value.page, transactionState.value.paginateSize],
        ([searchValue, pageValue, paginateSizeValue]) => {

            router.get(route('admin.transactions.index'), {
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

        submitForm({
            form,
            state: transactionState.value,
            storeRoute: () => route('admin.transactions.store'),
            updateRoute: (id) => route('admin.transactions.update', id),
            successMessage: 'Transaction created successfully',
            updateMessage: 'Transaction updated successfully',
        });
    };

    const formatDateLocal = (date) => {
        if (!date) return ''
        const d = new Date(date)
        const year = d.getFullYear()
        const month = String(d.getMonth() + 1).padStart(2, '0')
        const day = String(d.getDate()).padStart(2, '0')
        return `${year}-${month}-${day}`
    }

    const edit = (transaction) =>{

        form.id               = transaction?.id;
        form._method          = 'put',
        form.type             = transaction?.type;
        form.quantity         = transaction?.quantity;
        form.product_id       = transaction?.product_id;
        form.transaction_date = formatDateLocal(transaction?.transaction_date);
        form.description      = transaction?.description

        transactionState.value.dialogVisible = true;
    }

    const destroy = (id) =>{
        destroyData({ id, routeName: 'admin.transactions.destroy', });
    }

    return { transactionState, form, submit, handleAdd, edit, destroy }
}
