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
    },
    setUserFollow(state,follow_user){
        state.user_follow.follow_user = follow_user
    },
    setUserBeFollow(state,be_followed){
        state.user_follow.be_followed = be_followed
    }

}
