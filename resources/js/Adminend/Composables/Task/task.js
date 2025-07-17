import { ref, watch } from "vue";
import { route } from 'ziggy-js';
import { router, useForm } from '@inertiajs/vue3'
import { useCommon } from '@/Adminend/Composables';

export function useTask(filters = {}){

    const { submitForm, destroyData } = useCommon();

    const taskState = ref({
        dialogVisible: false,
        search       : filters?.search_key || '',
        isTrash      : filters?.is_trashed || '',
        page         : filters?.current_page || 1,
        paginateSize : filters?.paginate_size || 50

    });

    const form = useForm({
        id         : '',
        title      : '',
        description: '',
        completed  : "Incomplete",
        due_date   : '',
        priority   : 'Low',
        status     : '',
        category   : '',
        user_id    : ''
    })

    const handleAdd = () => {
        taskState.value.dialogVisible = true;
    }

    watch( () => [taskState.value.search, taskState.value.page, taskState.value.paginateSize],
        ([searchValue, pageValue, paginateSizeValue]) => {

            router.get(route('admin.tasks.index'), {
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
            state: taskState.value,
            storeRoute: () => route('admin.tasks.store'),
            updateRoute: (id) => route('admin.tasks.update', id),
            successMessage: 'Task created successfully',
            updateMessage: 'Task updated successfully',
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

    const edit = (task) =>{

        form.id          = task?.id;
        form._method     = 'put',
        form.title       = task?.title;
        form.description = task?.description;
        form.completed   = task?.completed;
        form.due_date    = formatDateLocal(task?.due_date);
        form.priority    = task?.priority;
        form.status      = task?.status;
        form.category    = task?.category;
        form.user_id     = task?.user_id;

        taskState.value.dialogVisible = true;
    }

    const destroy = (id) =>{
        destroyData({ id, routeName: 'admin.tasks.destroy', });
    }

    return { taskState, form, submit, handleAdd, edit, destroy }
}
