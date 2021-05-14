import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const store = new Vuex.Store({
    state: {
        auth: {
            user:{},
            token:null,
            isLoggedIn:false,
        },
        // authMessage: {},
        tempFormContract: null,
        signature: null,
        locale: null,
        // companyInvest:{},
        // currentUrl: null,
        // listCompany:{},
        // listCompanyInvest:{},
        // listInvestType:{},
        // user_follow: {
        //     follow_user:[],
        //     be_followed:[],
        // },
        // all_user_follow: {
        //     follow_user:[],
        //     be_followed:[],
        // },
        // news:{},
        // listAllCategory:{},
        // listCategory:{},
        // category:{},
    },
    mutations,
    getters,
    actions,
    plugins: [createPersistedState()],
});

export default store;
