import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export function navigateTo(name, params = {}, query = {}) {
  const url = route(name, params);
  router.visit(url, {
    data: query,
    preserveScroll: true,
    preserveState: true,
  });
}
