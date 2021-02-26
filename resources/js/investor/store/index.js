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
        listCompany:{},
        listCompanyInvest:{},
        currentUrl:null,
        locale:null,
        user_follow:{
            follow_user:[],
            be_followed:[],
        }
    },
    mutations,
    getters,
    actions,
    plugins: [createPersistedState()],
});

export default store;
