import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import axios from "axios";
import CKEditor from 'ckeditor4-vue';
import VueI18n from 'vue-i18n'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import VueSignaturePad from 'vue-signature-pad';

// LightBootstrap plugin
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// router setup
import router from './routes/index'

//store setup
import store from './store';
import './registerServiceWorker'
import globlalComponents from './globalComponents';

// plugin setup
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueToast);
Vue.use(CKEditor);
Vue.use(globlalComponents)
Vue.use(VueI18n)
Vue.use(VueSignaturePad)

//localization
import messages from './locales/index';
const i18n = new VueI18n({
    locales:'vi',
    messages,
    silentTranslationWarn: true
})

// configure router
Vue.prototype.router = router;
Vue.prototype.$axios = axios;
Vue.config.productionTip = false;
window.axios = require('axios');

// import Echo from 'laravel-echo';
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: "41fa8d57b8031a4b05f2",
//     cluster: "ap1",
//     forceTLS: true
// });

/* eslint-disable no-new */
new Vue({
    el: '#app',
    render: h => h(App),
    router,
    store:store,
    i18n
})
