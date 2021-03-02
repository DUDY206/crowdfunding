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
    listAdmin:state=>{
        return state.listAdmin
    },
    listInvestor:state=>{
        return state.listInvestor
    },
    listInvestType:state=>{
        return state.listInvestType
    }

}

export default  getters
