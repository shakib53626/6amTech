import { onMounted, onUnmounted, ref } from 'vue'

export function useDropdownMenu() {
    const open              = ref(false)
    const dashboardDropdown = ref(null)

    const toggleDropdown = () => {
        open.value = !open.value
    }

    const closeDropdown = () => {
        open.value = false
    }

    const handleMenuItemClick = (callback) => {
        if (typeof callback === 'function') {
            callback()
        }
        closeDropdown()
    }

    const onClickOutside = (event) => {
        if (dashboardDropdown.value && !dashboardDropdown.value.contains(event.target)) {
            closeDropdown()
        }
    }


    onMounted(() => {
        document.addEventListener('click', onClickOutside)
    })

    onUnmounted(() => {
        document.removeEventListener('click', onClickOutside)
    })

    return { open, dashboardDropdown, closeDropdown, handleMenuItemClick }
}
