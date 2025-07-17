import { route } from 'ziggy-js';
import { ElMessageBox } from 'element-plus';
import { router, usePage } from '@inertiajs/vue3';
import { useNotification } from '@/Adminend/Composables';

export function useCommon() {
    const notify = useNotification();
    const page   = usePage();

    const submitForm = ({ form, state, storeRoute, updateRoute, successMessage = 'Saved successfully', updateMessage = 'Updated successfully', reload = true }) => {

        const isEdit  = !!form.id;
        const message = isEdit ? updateMessage : successMessage;
        const url     = isEdit ? updateRoute(form.id) : storeRoute();

        if (isEdit) {
            form.processing = true;
            router.post(url, { ...form, _method: 'put' }, {
                onSuccess: () => {
                    if (state?.dialogVisible !== undefined) state.dialogVisible = false;
                    form.reset();
                    if (reload) router.reload();
                    notify.Success(message);
                    form.processing = false;
                },
                onError: (errors) => {
                    form.errors = errors;
                    form.processing = false;
                }
            });
        } else {
            form.post(url, {
                forceFormData: true,
                onSuccess: () => {
                    if (state?.dialogVisible !== undefined) state.dialogVisible = false;
                    form.reset();
                    if (reload) router.reload();
                    notify.Success(message);
                },
                onError: (errors) => {
                    console.log(errors);

                }
            });
        }
    };

    const destroyData = ({
        id,
        routeName,
        confirmText = 'Are you sure you want to delete this item?',
        successMessage = 'Deleted successfully',
        errorMessage = 'Deletion failed',
        cancelMessage = 'Deletion cancelled',
        params = null,
    }) => {
        ElMessageBox.confirm(
            confirmText,
            'Warning',
            {
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                type: 'warning',
                center: true,
            }
        )
        .then(() => {
            const routeParams = params ? params : id;
            router.delete(route(routeName, routeParams), {
                onSuccess: (msg) => notify.Success(successMessage),
                onError: () => notify.Error(errorMessage),
            });
        })
        .catch(() => {
            notify.Info(cancelMessage);
        });
    };

    return { submitForm, destroyData };
}
