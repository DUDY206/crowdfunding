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
    setLocale(state,locale){
        state.locale=locale
    }

}
