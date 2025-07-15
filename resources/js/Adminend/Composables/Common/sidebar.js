import { ref, computed, onMounted, onUnmounted } from 'vue'
import { usePage } from '@inertiajs/vue3'

import { GridIcon, CalenderIcon, UserCircleIcon, ListIcon, TableIcon, PageIcon, PieChartIcon, PlugInIcon, BoxCubeIcon } from '@/icons'

export function useSidebar() {
  const page        = usePage()
  const permissions = computed(() => page.props.auth?.user?.permissions || [])
  const routeName   = computed(() => page.props.route?.name || '')

  const isMobile     = ref(false)
  const isMobileOpen = ref(false)
  const isExpanded   = ref(true)
  const isHovered    = ref(false)
  const activeItem   = ref(null)
  const openSubmenu  = ref(null)

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
          { name: 'Dashboard',   icon: GridIcon,      path: 'dashboard',  permission: null },

          { name: 'User Manage',       icon: UserCircleIcon,
            children: [
              { name: 'Permissions',  path: 'permissions', permission: 'permissions-read' },
            ],
          },
        ],
      },
    ]

    return allMenus.map(group => ({
      ...group,
      items: group.items
        .map(item => {
          if (!item.children) {
            return hasPermission(item.permission) ? item : null
          }

          const filteredChildren = item.children.filter(child =>
            hasPermission(child.permission)
          )

          return filteredChildren.length ? { ...item, children: filteredChildren } : null
        })
        .filter(Boolean),
    }))
  })

  const isActive = (routes) => routes.includes(routeName.value)

  const activeMenu = computed(() => routeName.value)

  const defaultOpeneds = computed(() => {
    const current = routeName.value
    const opened = []

    menuGroups.value.forEach((group, groupIndex) => {
      group.items.forEach((item, itemIndex) => {
        if (item.children) {
          const match = item.children.find(child => child.path === current)
          if (match) opened.push(`${groupIndex}-${itemIndex}`)
        }
      })
    })

    return opened
  })

  return {
    // States
    isMobile,
    isMobileOpen,
    isExpanded: computed(() => (isMobile.value ? false : isExpanded.value)),
    isHovered,
    activeItem,
    openSubmenu,

    // Actions
    toggleSidebar,
    toggleMobileSidebar,
    setIsHovered,
    setActiveItem,
    toggleSubmenu,

    // Menu Data
    menuGroups,
    activeMenu,
    defaultOpeneds,
    isActive,
  }
}
