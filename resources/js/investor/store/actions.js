import router from '../routes/index'

import env from '../../env';
const domain_api= env.API_INVESTOR_PATH;

let actions = {
    login({commit, state}, credential){
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/login', credential, {
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(async (res) => {
                resolve(res);
                await commit('setAuthMessage', {
                    authMessage: '',
                });

                await commit('setAuth', {
                    user: res.data.user,
                    token: res.data.token,
                    isLoggedIn: true,
                });

                axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            })
            .catch(async (err) => {
                reject(err);
                if (err) {
                    console.log('Loggin error api');
                    // await commit('setAuthMessage', {
                    //     authMessage: 'Thông tin đăng nhập không chính xác',
                    // });
                }
            })
        });
    },

    register({commit, state}, form){
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/register', form, {
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(async (res) => {
                resolve(res);
                await commit('setAuth', {
                    user:res.data.user,
                    token:res.data.token,
                    isLoggedIn:true,
                })
                axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            }).catch((err) => {
                reject(err.response.data.errors);
                console.log(err)
            })
        })

    },

    editUser({state, commit}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/user-info/' + form.id, form.form, {
                params:{
                    _method:'PUT'
                }
            })
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err)
            })
        })
    },

    getUserById({state, commit}, id){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/user-info/' + id)
            .then((res) => {
                resolve(res);
                commit('setAuth', {
                    user: res.data,
                    token: state.auth.token,
                    isLoggedIn: true,
                })
            }).catch(err => {
                reject(err)
            })
        })

    },

    getUserBySlug({state, commit}, slug){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/user-info-slug/' + slug)
            .then((res) => {
                resolve(res);
            }).catch(err => {
                reject(err)
            })
        })

    },

    changePassword({state, commit}, form) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/user-info/change-password/' + form.id, form.form, {
                params: {
                    _method:'PUT'
                }
            })
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    logout({state, commit}) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/logout')
            .then(res => {
                resolve(res);

                commit('setAuth', {
                    user: {},
                    token: null,
                    isLoggedIn: false,
                });
            })
            .catch( err => {
                reject(err);
                console.log('err 1:', err);
            })
        })
    },

    getAllCompany({commit,state}){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
        axios.
        get(domain_api+'/company')
        .then(res=>{
            commit("setListCompany",res.data)
            commit("setCurrentUrl", {
                links:res.data.links,
                current_page:res.data.current_page,
                page:res.data.page,
            })
        }).catch(err=>{
            console.log('err 2:',err);
        })
    },

    // COMPANY ACTION
    getCompanyByPage({state,dispatch,commit},page){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token};
        axios.
        get(domain_api+'/company?page='+page)
            .then(res=>{
                commit("setListCompany",res.data)
                commit("setCurrentUrl", {
                    links:res.data.links,
                    current_page:res.data.current_page,
                    page:res.data.page,
                })
            }).catch(err=>{
            console.log('err 2:',err);
        })

    },
    createCompany({state,dispatch},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
            .post(domain_api+'/company',form)
            .then(res=>{
                resolve(res)
                dispatch("getAllCompany")
            }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    editCompany({state,dispatch},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios.post(domain_api+'/company/'+form.id,form.form,{
                params:{
                    _method:'PUT'
                }
            })
            .then(res=>{
                resolve(res)
                dispatch("getCompanyByPage",state.currentUrl.current_page)
            }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //COMPANY INVEST ACTIONS
    getAllCompanyInvestByPage({state,commit},page){
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        axios.
        get(domain_api + '/company-invest?page=' + page)
        .then(res=>{
            commit("setListCompanyInvest", res.data)
            commit("setCurrentUrl", {
                links: res.data.links,
                current_page: res.data.current_page,
                page: res.data.page,
            })
        })
        .catch(err=>{
            console.log('err 2:',err);
        })
    },

    getAllCompanyInvest({state, dispatch, commit}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/company-invest')
            .then(async (res) => {
                resolve(res);

                await commit("setListCompanyInvest", res.data);
                await commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
                console.log('err 2:',err);
            })
        })
    },

    getAllCompanyInvestByPaginateNull({state, commit}) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
        commit("setListCompanyInvestPaginate", null)
    },

    getAllCompanyInvestByPaginate({state, commit}, page) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/company-invest?page=' + page)
            .then(res => {
                resolve(res);
                commit("setListCompanyInvestPaginate", res.data);
            })
            .catch(err => {
                reject(err);
                console.log('err 2:', err);
            })
        });
    },

    getAllCompanyInvestSortBy({state, commit}, status){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/company-invest-sort-by/' + status)
            .then(async (res) => {
                resolve(res);
                await commit("setListCompanyInvest", res.data);
                await commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
                console.log('err 2:',err);
            })
        })
    },

    getAllCompanyInvestSortByPaginate({state, commit}, params) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/company-invest-sort-by/' + params.status + '?page=' + params.page)
            .then(res => {
                resolve(res);
                commit("setListCompanyInvestPaginate", res.data);
            })
            .catch(err => {
                reject(err);
                console.log('err 2:', err);
            })
        });
    },

    createCompanyInvest({state,commit},form){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token};
        return new Promise((resolve, reject) => {
            axios
                .post(domain_api+'/company-invest',form)
                .then(res=>{
                    console.log("data",res.data);
                    state.listCompanyInvest.data.push(res.data);
                    resolve(res)
                }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    updateCompanyInvest({state,commit,dispatch},form){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token};
        return new Promise((resolve, reject) => {
            axios
                .post(domain_api+'/company-invest/'+form.id,form.form,{
                    params:{
                        _method:'PUT'
                    }
                })
                .then(res=>{
                    dispatch("getAllCompanyInvestByPage",state.currentUrl.current_page)
                    resolve(res)
                }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    getCompanyInvestBySlug({state, commit}, slug){
        if (state.auth.token !== null) {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        }

        return new Promise((resolve, reject) => {
            axios.get(domain_api + '/company-invest/' + slug.slug + '/' + slug.locale)
            .then(res => {
                commit('setcompanyInvest', res.data);
                resolve(res)
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    getNewsById({state}, params) {
        return new Promise((resolve, reject) => {
            axios.get(domain_api + '/news/' + params.id + '/' + params.locale)
            .then(res => {
                resolve(res)
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //deleteItem

    deleteItem({state,dispatch},uri){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios.delete(domain_api+'/'+uri,{
                params:{
                    _method:'PUT'
                }
            })
            .then(res => {
                // dispatch("getCompanyByPage",state.currentUrl.current_page)
                router.go(0);
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    createComment({state},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios.post(domain_api+'/social-comment',form)
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    likeModel({state}, form) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/account-like-model', form)
            .then(res => {
                resolve(res)
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    account_follow_user({state, commit}, param) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/get-account-like/' + param.status, param.form)
            .then(res => {
                resolve(res);
                if (param.status === 0) {
                    commit('setAllUserFollow', res.data);
                } else {
                    commit('setUserFollow', res.data);
                }
            }).catch(err => {
                reject(err);
            })
        })
    },

    account_be_followed({state, commit}, param){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/get-account-be-like/' + param.status, param.form)
            .then(res => {
                resolve(res);
                if (param.status === 0) {
                    commit('setAllUserBeFollow', res.data);
                } else {
                    commit('setUserBeFollow', res.data);
                }
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    getAllModel({commit, state}, data){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/' + data.route)
            .then(res => {
                if (data.setState !== undefined) {
                    commit(data.setState,res.data)
                }
                resolve(res)
            })
            .catch(err => {
                reject(err)
            })
        })
    },

    createModel({state}, data) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/' + data.route, data.form)
            .then(res => {
                resolve(res);
                // state.listContractInputField.data.push(res.data);
                if (data.state_field !== undefined) {
                    if (state[data.state_field].data !== undefined) {
                        state[data.state_field].data.push(res.data);
                    } else {
                        state[data.state_field].push(res.data);
                    }
                }

            })
            .catch(err => {
                reject(err);
            })
        })
    },

    editModel({state, dispatch}, data){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios.post(domain_api+'/'+data.route + '/' +data.model_id,data.form,{
                params:{
                    _method:'PUT'
                }
            })
            .then(res=>{
                let data_ = {
                    route:data.routeGetAll,
                    setState:data.setState
                }
                dispatch('getAllModel',data_)
                resolve(res)
            }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    getAllCompanyInvestByUser({state, commit}, data) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/company-invest-of/' + data.slug + '/' + data.locale)
            .then((res) => {
                resolve(res)
                commit("setListCompanyInvestByUser", res.data);
            })
            .catch((err) => {
                reject(err);
            })
        })
    }
}



export default actions
