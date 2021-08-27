// GeneralViews
import CompanyInvestDetail from "../components/Detail/CompanyInvestDetail";
import ListCompanyInvest from "../components/List/ListCompanyInvest";
import ListNews from "../components/List/ListNews";
import NewsDetail from "../components/Detail/NewsDetail";
import ListCategoryInvest from "../components/List/ListCategoryInvest";
import ListTransaction from "../components/List/ListTransaction";
import Home from "../pages/Home.vue";
import NotFound from "../pages/NotFoundPage";
import Login from "../pages/Login";
import Register from "../pages/Register";
import UserInfo from "../pages/UserInfo";
import ConfirmRegister from "../pages/ConfirmRegister";
import UserInfoSlug from "../pages/UserInfoSlug";
import ContractShow from "../pages/ContractShow";
import ContractForm from "../pages/ContractForm";
import ContractPdf from "../pages/ContractPdf";
import SuccessPayment from "../pages/SuccessPayment";
import AboutBestB from "../pages/AboutBestB";
import ContactUs from "../pages/ContactUs";
import InvestmentGuide from "../pages/InvestmentGuide";
import PrivacyPolicy from "../pages/PrivacyPolicy";
import PaymentTerm from "../pages/PaymentTerm";
import ServiceTerm from "../pages/ServiceTerm";

// Admin pages
const routes = [
    // {
    //   path: '/',
    //   component: DashboardLayout,
    //   redirect: 'admin/overview'
    // },
    {
        path: '/',
        redirect: '/vi',
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
        path: '/confirm-register',
        name: 'ConfirmRegister',
        component: ConfirmRegister
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
                path: 'sort/:key',
                name: 'Home',
                component: ListCompanyInvest,
            },
            {
                path: ':about-bestb',
                name: 'AboutBestB',
                component: AboutBestB,
            },
            {
                path: 'user-info',
                name: 'UserInfo',
                component: UserInfo
            },
            {
                path: 'user/:slug',
                name: 'UserInfoSlug',
                component: UserInfoSlug
            },
            {
                path: 'invest/:companyInvest',
                name: 'CompanyInvest',
                component: CompanyInvestDetail,
            },
            {
                path: 'invest/:companyInvest/contract/:investTypeId/confirm-contract-form/:contractId',
                name: 'ContractConfirm',
                component: ContractShow,
            },
            {
                path: 'invest/:companyInvest/contract/:investTypeId/create-form',
                name: 'ContractForm',
                component: ContractForm,
            },
            {
                path: 'order/:orderId',
                name: 'ContractPdf',
                component: ContractPdf,
            },
            {
                path: 'payment/vnpay/success-payment',
                name: 'Success Payment',
                component: SuccessPayment,
            },
            {
                path: 'news',
                name: 'News',
                component: ListNews,
            },
            {
                path: 'news/:slug',
                name: 'NewsDetail',
                component: NewsDetail,
            },
            {
                path: 'contact-us',
                name: 'ContactUs',
                component: ContactUs,
            },
            {
                path: 'category/:slugCategory',
                name: 'Category',
                component: ListCategoryInvest,
            },
            {
                path: 'transaction',
                name: 'Transaction',
                component: ListTransaction,
            },
            {
                path: 'investment-guide',
                name: 'InvestmentGuide',
                component: InvestmentGuide,
            },
            {
                path: 'privacy-policies',
                name: 'PrivacyPolicy',
                component: PrivacyPolicy,
            },
            {
                path: 'payment-terms',
                name: 'PaymentTerm',
                component: PaymentTerm,
            },
            {
                path: 'service-terms',
                name: 'ServiceTerm',
                component: ServiceTerm,
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
