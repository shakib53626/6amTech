import { ref, watchEffect, onMounted } from 'vue'

const theme = ref(localStorage.getItem('theme') || 'light')

export function useTheme() {
  const toggleTheme = () => {
    theme.value = theme.value === 'dark' ? 'light' : 'dark'
    updateDOM()
    localStorage.setItem('theme', theme.value)
  }

  const updateDOM = () => {
    if (theme.value === 'dark') {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }
  }

  onMounted(() => updateDOM())

  watchEffect(() => {
    updateDOM()
  })

  return {
    theme,
    toggleTheme,
  }
}
