let getters = {
    startEmail: state => {
        return state.startEmail
    },
    auth: state => {
        return state.auth
    },
    authMessage: state => {
        return state.authMessage
    },
    listCompany:state => {
        return state.listCompany
    },
    currentUrl:state => {
        return state.currentUrl
    },
    listCompanyInvest:state => {
        return state.listCompanyInvest
    },
    listCompanyInvestByUser:state => {
        return state.listCompanyInvestByUser
    },
    listCompanyInvestPaginate:state => {
        return state.listCompanyInvestPaginate
    },
    locale:state => {
        return state.locale
    },
    user_follow:state => {
        return state.user_follow
    },
    all_user_follow:state => {
        return state.all_user_follow
    },
    listInvestType:state => {
        return state.listInvestType
    },
    tempFormContract:state => {
        return state.tempFormContract
    },
    companyInvest:state => {
        return state.companyInvest
    },
    signature:state => {
        return state.signature
    },
    news:state => {
        return state.news
    }

}

export default  getters
