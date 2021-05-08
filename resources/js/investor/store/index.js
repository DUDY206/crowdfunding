import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const store = new Vuex.Store({
    state: {
        auth:{
            user:{},
            token:null,
            isLoggedIn:false,
        },
        authMessage: {},
        listCompany:{},
        listCompanyInvest:{},
        listInvestType:{},
        tempFormContract:null,
        companyInvest:{},
        signature:null,
        currentUrl:null,
        locale:null,
        user_follow: {
            follow_user:[],
            be_followed:[],
        },
        all_user_follow: {
            follow_user:[],
            be_followed:[],
        },
        news:{},
        listCategory:{},
    },
    mutations,
    getters,
    actions,
    plugins: [createPersistedState()],
});

export default store;
