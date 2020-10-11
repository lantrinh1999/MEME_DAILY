require("../bootstrap");

import Vue from "vue";
import VueMeta from "vue-meta";
import PortalVue from "portal-vue";
import { InertiaApp } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress/src";
import "codemirror/lib/codemirror.css";
import "@toast-ui/editor/dist/toastui-editor.css";
import VTooltip from "v-tooltip";

Vue.use(VTooltip);
Vue.config.productionTip = false;
Vue.mixin({ methods: { route: window.route } });
Vue.use(InertiaApp);
Vue.use(PortalVue);
Vue.use(VueMeta);

InertiaProgress.init();

// const app = document.getElementById("app");

export default new Vue({
    metaInfo: {
        titleTemplate: (title) => (title ? `${title} - MEME CMS` : "MEME CMS"),
    },
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) =>
                    import(`./Pages/${name}`).then((module) => module.default),
            },
        }),
});
