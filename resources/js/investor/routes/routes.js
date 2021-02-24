// GeneralViews
import Home from "../pages/Home.vue";
import NotFound from "../pages/NotFoundPage";
import CompanyInvestDetail from "../components/Detail/CompanyInvestDetail";
import ListCompanyInvest from "../components/List/ListCompanyInvest";
import Login from "../pages/Login";
import Register from "../pages/Register";
import UserInfo from "../pages/UserInfo";
import UserInfoSlug from "../pages/UserInfoSlug";
// Admin pages
const routes = [
    // {
    //   path: '/',
    //   component: DashboardLayout,
    //   redirect: 'admin/overview'
    // },
    {
        path: '/',
        redirect: '/en',
        component: Home,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },


    {
        path: '/:locale/',
        name: 'Locale',
        component: Home,
        children:[
            {
                path: '',
                name: 'Home',
                component: ListCompanyInvest,
            },
            {
                path: 'user-info',
                name: 'User Info',
                component: UserInfo
            },
            {
                path: 'user/:slug',
                name: 'User Info Slug',
                component: UserInfoSlug
            },
            {
                path: ':companyInvest',
                name: 'CompanyInvest',
                component: CompanyInvestDetail,
            },

        ]
    },

    {path: '*', component: NotFound}
]

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
 function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes
