import { usePage } from '@inertiajs/vue3'

export function hasPermission(permission) {
    const permissions = usePage().props.auth?.user?.permissions || [];

    // when permission parameter is a Array
    if (Array.isArray(permission)) {
        return permission.some(p => permissions.includes(p));
    }

    // when permission parameter is a String
    return permissions.includes(permission);
}
