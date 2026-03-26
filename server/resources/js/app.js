import './bootstrap';
import {createInertiaApp} from '@inertiajs/vue3'
import {createApp, h} from "vue";
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";

import '../css/app.css'
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import DefaultLayout from "./Layout/DefaultLayout.vue";

createInertiaApp({

    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue');
        const page = resolvePageComponent(`./Pages/${name}.vue`, pages);

        page.then((module) => {

            if (module.default.layout === undefined) {
                module.default.layout = DefaultLayout;
            }
        });

        return page;
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
})
