let getters = {
    auth: state => {
        return state.auth
    },
    listCompany:state=>{
        return state.listCompany
    },
    currentUrl:state=>{
        return state.currentUrl
    },
    listCompanyInvest:state=>{
        return state.listCompanyInvest
    },
    locale:state=>{
        return state.locale
    }

}

export default  getters
