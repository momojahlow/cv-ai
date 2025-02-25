import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { showToast } from './Utils/useToast';
import { router } from '@inertiajs/vue3';


  
// Global error handling for Inertia
router.on('error', (errors) => {
    if (errors.message) {
        showToast('error', errors.message); // Display the error message
    } else {
        showToast('error', 'An unexpected error occurred.'); // Fallback message
    }
});

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
