export default {
    setUser(state, user) {
        state.user = user;
    },
    setAuth(state, auth){
        state.auth = auth;
    },
    setListCompany(state,listCompany){
        state.listCompany = listCompany;
    },
    setCurrentUrl(state,currentUrl){
        state.currentUrl = currentUrl
    },
    setListCompanyInvest(state, listCompanyInvest){
        state.listCompanyInvest = listCompanyInvest
    },
    setListAdmin(state,listAdmin){
        state.listAdmin = listAdmin
    },
    setlistInvestor(state,listInvestor){
        state.listInvestor = listInvestor
    },
    setlistInvestType(state,listInvestType){
        state.listInvestType = listInvestType
    },
    setlistContractInputField(state,listContractInputField){
        state.listContractInputField = listContractInputField
    },
    setlistContractTemplate(state,listContractTemplate){
        state.listContractTemplate = listContractTemplate
    },
    setlistInputField(state,listInputField){
        state.listInputField = listInputField
    },
    setcurrentInvestType(state,currentInvestType){
        state.currentInvestType = currentInvestType
    }

}
