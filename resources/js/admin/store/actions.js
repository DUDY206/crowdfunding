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
        }).catch((err) => {
            console.log('err 1:',err);
        }).finally(()=>{
            router.push({path: '/all-company'}).then(r => {});
        })
    },

     getAllCompany({commit,state}){
        axios.defaults.headers.common = {'Authorization': `Bearer `+state.auth.token}
        axios.
        get(domain_api+'/company')
        .then(res=>{
            commit("setListCompany",res.data)
            console.log('res:',res.data);
        }).catch(err=>{
            console.log('err 2:',err);
        })
    }
}



export default actions
