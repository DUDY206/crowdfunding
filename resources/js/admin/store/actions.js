import router from '../routes/index'

import env from '../../env';
const domain_api= env.API_ADMIN_PATH;

let actions = {
    login({commit,state},credential){
        axios
        .post(domain_api+'/login',credential,{
            headers: {
                'Accept': 'application/json',
            },
        })
        .then(async (res) => {
            await commit('setAuth', {
                user:res.data.user,
                token:res.data.token,
                isLoggedIn:true,
            })
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            router.push({path: '/all-company'}).then(r => {});
        }).catch((err) => {
            console.log('err 1:',err);
        })
    },

    logout({state,commit}) {

        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
        axios
        .post(domain_api+'/logout')
        .then(res=>{
            commit('setAuth', {
                user: {},
                token:null,
                isLoggedIn:false,
            })
            router.push({path: '/login'}).then(r => {});
        }).catch(err=>{
            console.log('err 1:',err);
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
            axios
                .post(domain_api+'/company/'+form.id,form.form,{
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
    getAllCompanyInvest({state,dispatch,commit}){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
        axios.
        get(domain_api+'/company-invest')
            .then(res=>{
                commit("setListCompanyInvest",res.data)
                commit("setCurrentUrl", {
                    links:res.data.links,
                    current_page:res.data.current_page,
                    page:res.data.page,
                })
            }).catch(err=>{
            console.log('err 2:',err);
        })
    },

    getAllCompanyInvestByPage({state,commit},page){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token};
        axios.
        get(domain_api+'/company-invest?page='+page)
            .then(res=>{
                commit("setListCompanyInvest",res.data)
                commit("setCurrentUrl", {
                    links:res.data.links,
                    current_page:res.data.current_page,
                    page:res.data.page,
                })
            }).catch(err=>{
            console.log('err 2:',err);
        })
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

    //deleteItem

    deleteItem({state,dispatch},uri){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .delete(domain_api+'/'+uri,{
                    params:{
                        _method:'PUT'
                    }
                })
                .then(res=>{
                    // dispatch("getCompanyByPage",state.currentUrl.current_page)
                    router.go(0);
                    resolve(res)
                }).catch(err => {
                    reject(err.response.data.errors);
            })
        })
    },

    //faq - risks
    createFAQRisk({state},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/company-invest-faq',form)
                .then(res=>{
                    resolve(res)
                }).catch(err => {
                    console.log(err);
                    reject(err.response.data.errors);
            })
        })
    },

    //manage admin
    getAllAdmin({commit,state}){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
        axios.
        get(domain_api+'/manage-admin')
            .then(res=>{
                commit("setListAdmin",res.data)
                commit("setCurrentUrl", {
                    links:res.data.links,
                    current_page:res.data.current_page,
                    page:res.data.page,
                })
            }).catch(err=>{
            console.log('err :',err);
        })
    },

    getAdminByPage({state,dispatch,commit},page){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token};
        axios.
        get(domain_api+'/manage-admin?page='+page)
            .then(res=>{
                commit("setListAdmin",res.data)
                commit("setCurrentUrl", {
                    links:res.data.links,
                    current_page:res.data.current_page,
                    page:res.data.page,
                })
            }).catch(err=>{
            console.log('err 2:',err);
        })

    },
    createAdmin({state},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/manage-admin',form)
                .then(res=>{
                    console.log(res.data[0]);
                    state.listAdmin.data.push(res.data[0]);
                    resolve(res)
                }).catch(err => {
                console.log(err);
                reject(err.response.data.errors);
            })
        })
    },
    editAdmin({state,dispatch},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/manage-admin/'+form.id,form.form,{
                    params:{
                        _method:'PUT'
                    }
                })
                .then(res=>{
                    resolve(res)
                    dispatch("getAdminByPage",state.currentUrl.current_page)
                }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //end manage admin

    //investor
    getAllInvestor({commit,state}){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
        axios.
        get(domain_api+'/user-info')
            .then(res=>{
                commit("setlistInvestor",res.data)
                commit("setCurrentUrl", {
                    links:res.data.links,
                    current_page:res.data.current_page,
                    page:res.data.page,
                })
            }).catch(err=>{
            console.log('err :',err);
        })
    },

    getInvestorByPage({state,dispatch,commit},page){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token};
        axios.
        get(domain_api+'/user-info?page='+page)
            .then(res=>{
                commit("setlistInvestor",res.data)
                commit("setCurrentUrl", {
                    links:res.data.links,
                    current_page:res.data.current_page,
                    page:res.data.page,
                })
            }).catch(err=>{
            console.log('err 2:',err);
        })

    },
    createInvestor({state},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/user-info',form)
                .then(res=>{
                    console.log(res.data);
                    state.listInvestor.data.push(res.data);
                    resolve(res)
                }).catch(err => {
                console.log(err);
                reject(err.response.data.errors);
            })
        })
    },
    editInvestor({state,dispatch},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/user-info/'+form.id,form.form,{
                    params:{
                        _method:'PUT'
                    }
                })
                .then(res=>{
                    resolve(res)
                    dispatch("getInvestorByPage",state.currentUrl.current_page)
                }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //invest type
    getAllInvestType({commit,state}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios.
            get(domain_api+'/invest-type')
                .then(res=>{
                    console.log(res.data[0]);
                    commit("setlistInvestType",res.data[0])
                    resolve(res)
                }).catch(err=>{
                    reject(err)
            })
        })
    },
    createInvestType({state},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/invest-type',form)
                .then(res=>{
                    console.log(res.data);
                    state.listAdmin.data.push(res.data);
                    resolve(res)
                }).catch(err => {
                console.log(err);
                reject(err.response.data.errors);
            })
        })
    },
    editInvestType({state,dispatch},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/invest-type/'+form.id,form.form,{
                    params:{
                        _method:'PUT'
                    }
                })
                .then(res=>{
                    resolve(res)
                    dispatch("getAllInvestType")
                }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },
    syncInvestHasType({state,dispatch},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/invest-has-type',form)
                .then(res=>{
                    resolve(res)
                }).catch(err => {
                    reject(err.response.data.errors);
            })
        })
    }
}



export default actions
