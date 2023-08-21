import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';
import './vts.config.js';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import Layout from './Layouts/Layout.vue';
import Login from './Pages/Auth/Login.vue';

createInertiaApp({
  title: (title) => `${title} - Expense Manager`,
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    let page = pages[`./Pages/${name}.vue`];
    page.default.layout = name.startsWith('Auth/') ? Login : Layout;
    return page;
  },

  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el);
  },
});
