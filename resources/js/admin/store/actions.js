import router from '../routes/index'
const domain_api= 'http://api.bestb-crowdfunding.ccc/admin';

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

    logout({state}) {
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
        axios
        .post(domain_api+'/logout')
        .then(res=>{
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
            commit("setCurrentUrl",'/company')
            console.log('res:',res.data);
        }).catch(err=>{
            console.log('err 2:',err);
        })
    },

    // COMPANY ACTION

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
                    dispatch("getAllCompany")
                }).catch(err => {
                reject(err.response.data.errors);
            })
        })
    },
    //

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
                    resolve(res)
                    dispatch("getAllCompany")
                }).catch(err => {
                    reject(err.response.data.errors);
            })
        })
    }
}



export default actions
