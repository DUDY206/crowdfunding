import router from '../routes/index'

import env from '../../env';
import { reject } from 'lodash';
const domain_api= env.API_ADMIN_PATH;

let actions = {
    login({commit, state}, credential) {
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/login', credential, {
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(async (res) => {
                resolve(res);
                await commit('setAuth', {
                    user: res.data.user,
                    token: res.data.token,
                    isLoggedIn: true,
                });

                axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
                router.push({path: '/all-company'}).then(r => {});
            })
            .catch((err) => {
                reject(err);
                console.log('err 1:', err);
            })
        })
    },

    logout({state,commit}) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/logout')
            .then(res => {
                resolve(res);
                commit('setAuth', {
                    user: {},
                    token: null,
                    isLoggedIn: false,
                })
                router.push({path: '/login'}).then(r => {});
            })
            .catch(err => {
                reject(err);
                console.log('err 1:',err);
            })
        })
    },

    getCurrentAdmin({state, commit}, id) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}

        return new Promise((resolve, reject) => {
            axios.get(domain_api + '/manage-admin/' + id)
            .then((res) => {
                resolve(res);
                commit('setAuth', {
                    user: res.data,
                    token: state.auth.token,
                    isLoggedIn: true,
                });
            })
            .catch((err) => {
                reject(err);
                console.log('err 1:',err);
            })
        });
    },

    getAllCompany({commit, state}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/company')
            .then(res => {
                resolve(res);
                commit("setListCompany", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
                console.log('err 2:', err);
            })
        })
    },

    // COMPANY ACTION
    getCompanyByPage({state, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
            axios.get(domain_api + '/company?page=' + page)
            .then(res => {
                resolve(res);
                commit("setListCompany", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
                console.log('err 2:', err);
            })
        })
    },

    createCompany({state, dispatch}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/company', form)
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    editCompany({state,dispatch},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/company/' + form.id, form.form, {
                params:{
                    _method:'PUT'
                }
            })
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //COMPANY INVEST ACTIONS
    getAllCompanyInvest({state, dispatch, commit}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/company-invest')
            .then(res => {
                resolve(res);
                commit("setListCompanyInvest", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
                console.log('err 2:', err);
            })
        })
    },

    getAllCompanyInvestByPage({state, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
            axios.get(domain_api + '/company-invest?page=' + page)
            .then(res => {
                resolve(res);
                commit("setListCompanyInvest", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
                console.log('err 2:', err);
            })
        })
    },

    createCompanyInvest({state,commit},form){
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/company-invest', form)
            .then(res => {
                resolve(res)
            }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    showCompanyInvest({state, commit}, id){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/company-invest/' + id)
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    updateCompanyInvest({state, commit, dispatch}, form){
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/company-invest/' + form.id, form.form, {
                params: {
                    _method:'PUT'
                }
            })
            .then(res => {
                // dispatch("getAllCompanyInvestByPage", state.currentUrl.current_page)
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    searchCompanyInvest({state, commit}, key) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        return new Promise((resolve, reject) => {
            axios.get(domain_api + '/search-company-invest', {
                params: {
                    keyName: key
                }
            })
            .then(res => {
                resolve(res);
                commit("setListCompanyInvest", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    //category
    getAllCategory({state, commit}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/category')
            .then(res => {
                resolve(res);
                commit("setListCategory", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    getAllCategoryByPage({state, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/category?page=' + page)
            .then(res => {
                resolve(res);
                commit("setListCategory", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    createCategory({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/category', form)
            .then(res => {
                resolve(res)
            }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    addCategoryToInvest({state}, params) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/category-invest/' + params.id, params.form)
            .then(res => {
                resolve(res)
            }).catch(err => {
                reject(err);
            })
        })
    },

    updateCategory({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/category/' + form.id, form.form, {
                params: {
                    _method: 'PUT'
                }
            })
            .then(res => {
                resolve(res);
            }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //news
    getAllNews({state, commit}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/news')
            .then(res => {
                resolve(res);
                commit("setListNews", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    getAllNewsByPage({state, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/news?page=' + page)
            .then(res => {
                resolve(res);
                commit("setListNews", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    getAllNewsOfInvest({state, commit}, investId){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/news-of-invest/' + investId)
            .then(res => {
                resolve(res);
                commit("setListNews", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    getAllNewsOfInvestByPage({state, commit}, params) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/news-of-invest/' + params.investId + '?page=' + params.page)
            .then(res => {
                resolve(res);
                commit("setListNews", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    createNews({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/news', form)
            .then(res => {
                resolve(res)
            }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    updateNews({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
        return new Promise((resolve, reject) => {
            axios.post(domain_api + '/news/' + form.id, form.form, {
                params: {
                    _method: 'PUT'
                }
            })
            .then(res => {
                resolve(res);
            }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //deleteItem
    deleteItem({state, dispatch}, parameters) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}

            if (parameters.route === 'manage-admin') {
                axios.get(domain_api + '/' + parameters.uri)
                .then(res => {
                    if (state.auth.user.id === res.data.id) {
                        var message = {
                            statusAdminLogging: true,
                            content: "Không thể xóa, tài khoản hiện tại đang đăng nhập hệ thống"
                        };
                        reject(message);
                    } else {
                        axios.delete(domain_api + '/' + parameters.uri, {
                            params: {
                                _method: 'DELETE'
                            }
                        })
                        .then(res => {
                            resolve(res);
                            router.go(0);
                        })
                        .catch(err => {
                            reject(err.response.data.errors);
                        })
                    }
                }).catch(err => {
                    reject(err.response.data.errors);
                })
            } else {
                axios.delete(domain_api + '/' + parameters.uri, {
                    params: {
                        _method: 'DELETE'
                    }
                })
                .then(res => {
                    resolve(res);
                    router.go(0);
                })
                .catch(err => {
                    reject(err.response.data.errors);
                })
            }
        })
    },

    //faq - risks
    createFAQRisk({state}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/company-invest-faq', form)
            .then(res => {
                resolve(res);
                router.go(0);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //manage admin
    getAllAdmin({commit, state}) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/manage-admin')
            .then(res => {
                resolve(res);
                commit("setListAdmin", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
                console.log('err :', err);
            })
        })
    },

    getAdminByPage({state, dispatch, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
            axios.get(domain_api + '/manage-admin?page=' + page)
            .then(res => {
                resolve(res);
                commit("setListAdmin", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
                console.log('err 2:', err);
            })
        })
    },

    createAdmin({state}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/manage-admin', form)
            .then(res => {
                // state.listAdmin.data.push(res.data[0]);
                resolve(res);
            })
            .catch(err => {
                console.log(err);
                reject(err.response.data.errors);
            })
        })
    },

    editAdmin({state, dispatch}, form) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/manage-admin/' + form.id, form.form, {
                params:{
                    _method:'PUT'
                }
            })
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    editImageAdmin({state, dispatch}, data) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/update-image-admin/' + data.id, data.form, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                params: {
                    _method:'PUT'
                },
            })
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data);
            })
        })
    },
    //end manage admin

    //investor
    getAllInvestor({commit, state}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/user-info')
            .then(res => {
                resolve(res);
                commit("setlistInvestor", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
                console.log('err :', err);
            })
        })
    },

    getInvestorByPage({state, dispatch, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
            axios.get(domain_api + '/user-info?page=' + page)
            .then(res => {
                resolve(res);
                commit("setlistInvestor", res.data);
                commit("setCurrentUrl", {
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

    createInvestor({state}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/user-info', form)
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                console.log(err);
                reject(err.response.data.errors);
            })
        })
    },

    editInvestor({state,dispatch}, form) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api+'/user-info/'+form.id,form.form,{
                params:{
                    _method:'PUT'
                }
            })
            .then(res => {
                resolve(res);
                // dispatch("getInvestorByPage", state.currentUrl.current_page);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //invest type
    getAllInvestType({commit, state}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/invest-type')
            .then(res => {
                resolve(res);
                commit("setlistInvestType", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    getInvestTypeByPage({state, dispatch, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
            axios.get(domain_api + '/invest-type?page=' + page)
            .then(res => {
                resolve(res);
                commit("setlistInvestType", res.data);
                commit("setCurrentUrl", {
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

    createInvestType({state}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/invest-type', form)
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                console.log(err);
                reject(err.response.data.errors);
            })
        })
    },

    editInvestType({state,dispatch},form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api+'/invest-type/' + form.id, form.form, {
                params:{
                    _method:'PUT'
                }
            })
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    syncInvestHasType({state, dispatch}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/invest-has-type', form)
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //CONSTRACT INPUT FIELD
    //CÁC TRƯỜNG INPUT TRONG HỢP ĐỒNG
    getAllContractInputField({commit, state}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/contract-input-field')
            .then(res => {
                resolve(res);
                commit("setlistContractInputField", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    getContractInputFieldByPage({state, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token};
            axios.get(domain_api + '/contract-input-field?page=' + page)
            .then(res => {
                resolve(res);
                commit("setlistContractInputField", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                });
            })
            .catch(err => {
                console.log('err 2:', err);
                reject(err);
            })
        })
    },

    createContractInputField({state}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api+'/contract-input-field', form)
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                console.log(err);
                reject(err.response.data.errors);
            })
        })
    },

    editContractInputField({state}, form){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/contract-input-field/' + form.id, form.form, {
                params:{
                    _method:'PUT'
                }
            })
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err.response.data.errors);
            })
        })
    },

    //Order
    getAllOrder({state, commit}){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/order')
            .then(res => {
                resolve(res);
                commit("setListOrder", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    getAllOrderByPage({state, commit}, page){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/order?page=' + page)
            .then(res => {
                resolve(res);
                commit("setListOrder", res.data);
                commit("setCurrentUrl", {
                    links: res.data.links,
                    current_page: res.data.current_page,
                    page: res.data.page,
                })
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    showOrder({state, commit}, id){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/order/' + id)
            .then(res => {
                resolve(res);
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    updateOrder({state}, form) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/order/' + form.id, form.form, {
                params: {
                    _method: 'PUT'
                }
            })
            .then((res) => {
                resolve(res);
            })
            .catch((err) => {
                reject(err);
            })
        });
    },

    //TRAIT METHODS
    getAllModel({commit, state}, data) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.get(domain_api + '/' + data.route)
            .then(res => {
                if (data.setState !== undefined) {
                    commit(data.setState, res.data);
                }
                resolve(res);
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    createModel({state}, data) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.token}
            axios.post(domain_api + '/' + data.route, data.form)
            .then(res=>{
                // state.listContractInputField.data.push(res.data);
                if (data.state_field !== undefined) {
                    if (state[data.state_field].data !== undefined) {
                        state[data.state_field].data.push(res.data);
                    } else {
                        state[data.state_field].push(res.data);
                    }
                }
                resolve(res);
            })
            .catch(err => {
                reject(err);
            })
        })
    },

    editModel({state,dispatch},data){
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
            axios
                .post(domain_api+'/'+data.route + '/' +data.model_id,data.form,{
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
                console.log(err);
                reject(err.response.data.errors);
            })
        })
    },
}

export default actions
