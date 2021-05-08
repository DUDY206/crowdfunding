export default {
    setStartEmail(state, startEmail) {
        state.startEmail = startEmail;
    },
    setUser(state, user) {
        state.user = user;
    },
    setAuth(state, auth){
        state.auth = auth;
    },
    setAuthMessage(state, authMessage) {
        state.authMessage = authMessage
    },
    setListCompany(state, listCompany) {
        state.listCompany = listCompany;
    },
    setCurrentUrl(state, currentUrl) {
        state.currentUrl = currentUrl
    },
    setListCompanyInvest(state, listCompanyInvest){
        state.listCompanyInvest = listCompanyInvest
    },
    setListCompanyInvestByUser(state, listCompanyInvestByUser){
        state.listCompanyInvestByUser = listCompanyInvestByUser
    },
    setListCompanyInvestPaginate(state, listCompanyInvestPaginate){
        state.listCompanyInvestPaginate = listCompanyInvestPaginate
    },
    setLocale(state, locale){
        state.locale = locale
    },
    setUserFollow(state, follow_user){
        state.user_follow.follow_user = follow_user
    },
    setUserBeFollow(state, be_followed){
        state.user_follow.be_followed = be_followed
    },
    setAllUserFollow(state, follow_user){
        state.all_user_follow.follow_user = follow_user
    },
    setAllUserBeFollow(state, be_followed){
        state.all_user_follow.be_followed = be_followed
    },
    setlistInvestType(state, listInvestType){
        state.listInvestType = listInvestType
    },
    settempFormContract(state, tempFormContract){
        state.tempFormContract = tempFormContract
    },
    setcompanyInvest(state, companyInvest){
        state.companyInvest = companyInvest
    },
    setsignature(state, signature){
        state.signature = signature
    },
    setNews(state, news){
        state.news = news;
    },
    setListCategory(state, listCategory) {
        state.listCategory = listCategory
    },
    setCategory(state, category) {
        state.category = category
    },
}
