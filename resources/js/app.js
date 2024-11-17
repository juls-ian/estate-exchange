import './bootstrap';
import '@css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import Vue3Toastify from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import MainLayout from '@/Layouts/MainLayout.vue';

createInertiaApp({
  // the name is connected to the controllers
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    // uppercase to lowercase
    // name = name.replace(/^listing\//, 'Listing/');
    let page = pages[`./Pages/${name}.vue`];
    if (!page) {
      throw new Error(`Page not found: ${name}`);
    }
    page.default.layout = page.default.layout || MainLayout;
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(Vue3Toastify)
      .mount(el);
  }
});
