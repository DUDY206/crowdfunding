import Vue from 'vue';
import Router from 'vue-router';
import routes from "./routes";
import VueRouter from "vue-router";
Vue.use(Router);

const router = new VueRouter({
    mode:'history',
    routes, // short for routes: routes
    linkActiveClass: 'nav-item active',
    scrollBehavior: (to) => {
        if (to.hash) {
            return {selector: to.hash}
        } else {
            return {x: 0, y: 0}
        }
    }
})

export default router;
