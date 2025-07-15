import './bootstrap';

import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3'
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import AdminLayout from './Layouts/AdminLayout.vue';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./**/Pages/**/*.vue', { eager: true })
        const path  = `./${name.replace('/', '/Pages/')}.vue`
        let   page  = pages[path]

        page.default.layout = page.default.layout || AdminLayout

        if (!page) {
            throw new Error(`Page not found: ${name} (mapped to ${path})`)
        }

        return page
    },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })

    app.component('Link', Link)
    app.use(ZiggyVue)
    app.use(plugin)
    app.mount(el)
  },
})
