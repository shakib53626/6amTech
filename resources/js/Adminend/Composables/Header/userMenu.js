// composables/useUserDropdown.js
import { useForm } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import { UserCircleIcon, ChevronDownIcon, LogoutIcon, SettingsIcon, InfoCircleIcon } from '@/icons'

export function useUserDropdown() {
    const dropdownOpen = ref(false)
    const dropdownRef = ref(null)

    const form = useForm({})

    const menuItems = [
        { href: '/profile', icon: UserCircleIcon, text: 'Edit profile' },
    ]

    const toggleDropdown = () => {
        dropdownOpen.value = !dropdownOpen.value
    }

    const closeDropdown = () => {
        dropdownOpen.value = false
    }

    const signOut = () => {
        form.post('/logout', {
            onSuccess: () => { closeDropdown() },
            onError  : () => {}
        })
    }

    const handleClickOutside = (event) => {
        if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        closeDropdown()
        }
    }

    onMounted(() => {
        document.addEventListener('click', handleClickOutside)
    })

    onUnmounted(() => {
        document.removeEventListener('click', handleClickOutside)
    })

    return { form, dropdownOpen, dropdownRef, menuItems, toggleDropdown, closeDropdown, signOut }
}
