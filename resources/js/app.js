import './bootstrap';

import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./**/Pages/**/*.vue', { eager: true })
        const path  = `./${name.replace('/', '/Pages/')}.vue`
        let   page  = pages[path]

        // page.default.layout = page.default.layout || AuthLayout

        if (!page) {
            throw new Error(`Page not found: ${name} (mapped to ${path})`)
        }

        return page
    },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})
