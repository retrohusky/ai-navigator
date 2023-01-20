import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

const Modules = import.meta.glob('./../../Modules/**/Pages/**/*.vue');

createInertiaApp({
    resolve: name => {
        const [Module, View] = name.split('::');
        let ModulePath = `../../Modules/${Module}/Pages/${View}.vue`;

        if (!Modules[ModulePath]) {
            console.error('Error when resolving a module!');
            console.log( ModulePath );
            return false;
        }

        // @ts-ignore
        return Modules[ModulePath]().then(ModuleFile => ModuleFile?.default);
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
}).then();
