// GeneralViews
import Home from "../pages/Home.vue";
import NotFound from "../pages/NotFoundPage";
import CompanyInvestDetail from "../components/Detail/CompanyInvestDetail";
import ListCompanyInvest from "../components/List/ListCompanyInvest";
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
                path: ':companyInvest',
                name: 'CompanyInvest',
                component: CompanyInvestDetail,
            }
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
