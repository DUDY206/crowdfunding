import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import axios from "axios";
import CKEditor from 'ckeditor4-vue';
import VueI18n from 'vue-i18n'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
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
//localization
import messages from './locales/index';
const i18n = new VueI18n({
    locales:'en',
    messages
})
// configure router

Vue.prototype.router = router;
Vue.prototype.$axios = axios;
window.axios = require('axios');
/* eslint-disable no-new */
new Vue({
    el: '#app',
    render: h => h(App),
    router,
    store:store,
    i18n
})
