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
    searchListCompanyInvest:state => {
        return state.searchListCompanyInvest
    },
    listAdmin:state=>{
        return state.listAdmin
    },
    listInvestor:state=>{
        return state.listInvestor
    },
    listInvestType:state=>{
        return state.listInvestType
    },
    listContractInputField:state=>{
        return state.listContractInputField
    },
    listContractTemplate:state=>{
        return state.listContractTemplate
    },
    listInputField:state=>{
        return state.listInputField
    },
    currentInvestType:state=>{
        return state.currentInvestType
    },
    listNews:state => {
        return state.listNews
    },
    listOrder:state => {
        return state.listOrder
    },
    listCategory:state => {
        return state.listCategory
    },
    listImageAdvertisement:state => {
        return state.listImageAdvertisement
    },
}

export default  getters
