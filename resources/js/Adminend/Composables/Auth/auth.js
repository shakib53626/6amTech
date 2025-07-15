import { route } from 'ziggy-js';
import { computed, ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

export function useAuth() {

    const processing = ref(false);
    const logo       = '/storage/logo/6amTech-Primary-Logo.svg'
    const form       = useForm({
        email      : '',
        password   : '',
        remember_me: false,
    });

    const emailError = computed(() => {
        if (!form.email) return 'Email is required';

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(form.email)) return 'Invalid email format';
        return '';
    });

    const passwordError = computed(() => {
        if (!form.password) return 'Password is required';
        if (form.password.length < 6) return 'Password must be at least 6 characters';
        return '';
    });

    const hasValidationError = computed(() => {
        return emailError.value || passwordError.value;
    });


    const login = async () => {

        if (hasValidationError.value) {
            const newErrors = {};

            if (emailError.value) {
                newErrors.email = emailError.value;
            }

            if (passwordError.value) {
                newErrors.password = passwordError.value;
            }

            form.errors = newErrors;
            return;
        }

        form.post('/login');
    };

    watch(
        [() => form.email, () => form.password],
        () => {
            const newErrors = {};

            if (emailError.value && form.email) {
                newErrors.email = emailError.value;
            }

            if (passwordError.value && form.password) {
                newErrors.password = passwordError.value;
            }

            form.errors = newErrors;
        }
    );

    const logout = () => {
        processing.value = true;

        router.post(route('logout'), {}, {
            onFinish: () => {
                processing.value = false;
            }
        });
    };

    return { form, logo, processing, login, logout};
}
