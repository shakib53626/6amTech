import { ref, computed, onMounted, onUnmounted } from 'vue'
import { GridIcon, UserCircleIcon, ListIcon, TaskIcon } from '@/icons'
import { usePage } from '@inertiajs/vue3'

const isMobile     = ref(false)
const isMobileOpen = ref(false)
const isExpanded   = ref(true)
const isHovered    = ref(false)
const activeItem   = ref(null)
const openSubmenu  = ref(null)


export function useSidebar() {

  const page        = usePage()
  const permissions = computed(() => page.props.auth?.user?.permissions || [])
  const routeName   = computed(() => page.props.route?.name || '')

  const handleResize = () => {
    const mobile = window.innerWidth < 768
    isMobile.value = mobile

    if (!mobile) isMobileOpen.value = false
  }

  onMounted(() => {
    handleResize()
    window.addEventListener('resize', handleResize)
  })

  onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
  })

  const toggleSidebar = () => {
    if (isMobile.value) {
      isMobileOpen.value = !isMobileOpen.value
    } else {
      isExpanded.value = !isExpanded.value
    }
  }

  const toggleMobileSidebar = () => {
    isMobileOpen.value = !isMobileOpen.value
  }

  const setIsHovered = (value) => {
    isHovered.value = value
  }

  const setActiveItem = (item) => {
    activeItem.value = item
  }

  const toggleSubmenu = (key) => {
    openSubmenu.value = openSubmenu.value === key ? null : key
  }

  const hasPermission = (permission) => {
    return !permission || permissions.value.includes(permission)
  }

  const menuGroups = computed(() => {
    const allMenus = [
      {
        title: 'Menu',
        items: [
          { name: 'Dashboard', icon: GridIcon, path: 'admin.dashboard', permission: null },

          {
            name: 'User Manage', icon: UserCircleIcon,
            children: [
              { name: 'Users',       path: 'admin.users.index',       permission: null       },
            ],
          },

          {
            name: 'Task Manage', icon: TaskIcon,
            children: [
                { name: 'Tasks',       path: 'admin.tasks.index',       permission: null       },
            ],
          },

          {
            name: 'Inventory Manage', icon: ListIcon,
            children: [
                { name: 'Categories',       path: 'admin.categories.index',       permission: null       },
                { name: 'Products',         path: 'admin.products.index',         permission: null       },
                { name: 'Transactions',     path: 'admin.transactions.index',     permission: null       },
            ],
          },
        ],
      },
    ]

    return allMenus.map((group) => ({
      ...group,
      items: group.items
        .map((item) => {
          if (!item.children) {
            return hasPermission(item.permission) ? item : null
          }

          const filteredChildren = item.children.filter((child) =>
            hasPermission(child.permission)
          )

          return filteredChildren.length ? { ...item, children: filteredChildren } : null
        })
        .filter(Boolean),
    }))
  })

    const isActive = (routes) => routes.includes(routeName.value)

    const isChildActive = (children) => {
        return children?.some(child => routeName.value === child.path)
    }

    const activeMenu = computed(() => routeName.value)

    const defaultOpeneds = computed(() => {
        const current = routeName.value
        const opened = []

        menuGroups.value.forEach((group, groupIndex) => {
            group.items.forEach((item, itemIndex) => {
                if (item.children) {
                    const match = item.children.find((child) => child.path === current)
                    if (match) opened.push(`${groupIndex}-${itemIndex}`)
                }
            })
        })

        return opened
    })

  return {
    // States
    isMobile, isMobileOpen, isHovered, activeItem, openSubmenu,
    isExpanded: computed(() => (isMobile.value ? false : isExpanded.value)),

    // Action
    toggleSidebar, toggleMobileSidebar, setIsHovered, setActiveItem, toggleSubmenu,

    // Menu Data
    menuGroups, activeMenu, defaultOpeneds, isActive, isChildActive
  }
}
