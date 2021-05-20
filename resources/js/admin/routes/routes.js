import DashboardLayout from '../layout/DashboardLayout.vue'
// GeneralViews
import NotFound from '../pages/NotFoundPage.vue'

// Admin pages
import Overview from '../pages/Overview.vue'
import UserProfile from '../pages/UserProfile.vue'
import TableList from '../pages/TableList.vue'
import Typography from '../pages/Typography.vue'
import Icons from '../pages/Icons.vue'
import Maps from '../pages/Maps.vue'
import Notifications from '../pages/Notifications.vue'
import Upgrade from '../pages/Upgrade.vue'
import Login from "../pages/Login";
import ListCompany from "../pages/ListCompany";
import ListCompanyInvest from "../pages/ListCompanyInvest";
import ListAdmin from "../pages/ListAdmin";
import ListInvestor from "../pages/ListInvestor";
import ListInvestType from "../pages/ListInvestType";
import ListContractInputField from "../pages/ListContractInputField";
import ListNews from "../pages/ListNews";
import ListOrder from "../pages/ListOrder";
import ListCategory from "../pages/ListCategory";
import ListImageAdvertisement from "../pages/ListImageAdvertisement";

const routes = [
    // {
    //   path: '/',
    //   component: DashboardLayout,
    //   redirect: 'admin/overview'
    // },
    {
        path: '/',
        component: DashboardLayout,
        // redirect: 'admin/overview',
        children: [
            {
                path: 'overview',
                name: 'Overview',
                component: Overview
            },
            {
                path: 'user',
                name: 'User',
                component: UserProfile
            },
            {
                path: 'table-list',
                name: 'Table List',
                component: TableList
            },
            {
                path: 'typography',
                name: 'Typography',
                component: Typography
            },
            {
                path: 'icons',
                name: 'Icons',
                component: Icons
            },
            {
                path: 'maps',
                name: 'Maps',
                component: Maps
            },
            {
                path: 'notifications',
                name: 'Notifications',
                component: Notifications
            },
            {
                path: 'upgrade',
                name: 'Upgrade to PRO',
                component: Upgrade
            },

            //----------------------------- Company manager
            {
                path: 'all-company',
                name: 'All company',
                component: ListCompany
            },
            {
                path: 'all-company?page=:page',
                name: 'All company page',
                component: ListCompany
            },
            {
                path: 'all-company/search',
                name: 'Search company',
                component: ListCompany
            },
            {
                path: 'all-company/search?keySearch=:keySearch',
                name: 'Search company by key',
                component: ListCompany
            },
            {
                path: 'all-company/search?keySearch=:keySearch&page=:page',
                name: 'Search company by key paginate',
                component: ListCompany
            },

            //----------------------------- Company invest manager
            {
                path: 'company-invest',
                name: 'Company Invest',
                component: ListCompanyInvest
            },
            {
                path: 'company-invest?page=:page',
                name: 'Company Invest page',
                component: ListCompanyInvest
            },
            {
                path: 'company-invest/search',
                name: 'Search company invest',
                component: ListCompanyInvest
            },
            {
                path: 'company-invest/search?keySearch=:keySearch',
                name: 'Search company invest by key',
                component: ListCompanyInvest
            },
            {
                path: 'company-invest/search?keySearch=:keySearch&page=:page',
                name: 'Search company invest by key paginate',
                component: ListCompanyInvest
            },

            //----------------------------- Admin manager
            {
                path: 'manage-admin',
                name: 'All admin',
                component: ListAdmin
            },
            {
                path: 'manage-admin?page=:page',
                name: 'All admin page',
                component: ListAdmin
            },

            //----------------------------- User manager
            {
                path: 'user-info',
                name: 'All users',
                component: ListInvestor
            },
            {
                path: 'user-info?page=:page',
                name: 'All users page',
                component: ListInvestor
            },
            {
                path: 'user-info/search',
                name: 'Search user',
                component: ListInvestor
            },
            {
                path: 'user-info/search?keySearch=:keySearch',
                name: 'Search user by key',
                component: ListInvestor
            },
            {
                path: 'user-info/search?keySearch=:keySearch&page=:page',
                name: 'Search user by key paginate',
                component: ListInvestor
            },

            {
                path: 'invest-type',
                name: 'All invest type',
                component: ListInvestType
            },
            {
                path: 'contract-input-field',
                name: 'All Contract Input Field',
                component: ListContractInputField
            },
            {
                path: 'contract-input-field?page=:page',
                name: 'All Contract Input Field page',
                component: ListContractInputField
            },
            {
                path: 'news',
                name: 'All news',
                component: ListNews
            },
            {
                path: 'news/:investId',
                name: 'The news of invest',
                component: ListNews
            },

            //----------------------------- Order manager
            {
                path: 'orders',
                name: 'All order',
                component: ListOrder
            },
            {
                path: 'orders/search',
                name: 'Search orders',
                component: ListOrder
            },
            {
                path: 'orders/search?keySearch=:keySearch',
                name: 'Search orders by key',
                component: ListOrder
            },
            {
                path: 'orders/search?keySearch=:keySearch&page=:page',
                name: 'Search orders by key paginate',
                component: ListOrder
            },

            //----------------------------- Category manager
            {
                path: 'category',
                name: 'All category',
                component: ListCategory
            },
            {
                path: 'category/search',
                name: 'Search category',
                component: ListCategory
            },
            {
                path: 'category/search?keySearch=:keySearch',
                name: 'Search category by key',
                component: ListCategory
            },
            {
                path: 'category/search?keySearch=:keySearch&page=:page',
                name: 'Search category by key paginate',
                component: ListCategory
            },

            //----------------------------- Images advertisement manager
            {
                path: 'image-advertisement',
                name: 'All images advertisement',
                component: ListImageAdvertisement
            },
        ]
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
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
