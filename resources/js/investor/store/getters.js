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
    },
    user_follow:state=>{
        return state.user_follow
    },
    listInvestType:state=>{
        return state.listInvestType
    },
    tempFormContract:state=>{
        return state.tempFormContract
    },
    companyInvest:state=>{
        return state.companyInvest
    },
    signature:state=>{
        return state.signature
    }

}

export default  getters
