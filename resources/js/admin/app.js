/*!

 =========================================================
 * Vue Light Bootstrap Dashboard - v2.0.0 (Bootstrap 4)
 =========================================================

 * Product Page: http://www.creative-tim.com/product/light-bootstrap-dashboard
 * Copyright 2019 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE.md)

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import axios from "axios";

// LightBootstrap plugin
import LightBootstrap from './light-bootstrap-main'

// router setup
import router from './routes/index'

//store setup
import store from './store';
import './registerServiceWorker'
// plugin setup
Vue.use(VueRouter)
Vue.use(LightBootstrap)
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
})
