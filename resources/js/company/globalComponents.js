import BaseInput from './components/Inputs/BaseInput.vue'
import BaseCheckbox from './components/Inputs/BaseCheckbox.vue'
import BaseRadio from './components/Inputs/BaseRadio.vue'
import BaseDropdown from './components/BaseDropdown.vue'
import Card from './components/Cards/Card.vue'
import CompanyInput from "./components/Inputs/CompanyInput";
import CompanyInvestInput from "./components/Inputs/CompanyInvestInput";
import CompanyInvestFAQInput from "./components/Inputs/CompanyInvestFAQInput";
import InvestorInput from "./components/Inputs/InvestorInput";
/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */

const GlobalComponents = {
  install (Vue) {
    Vue.component(BaseInput.name, BaseInput)
    Vue.component(BaseCheckbox.name, BaseCheckbox)
    Vue.component(BaseRadio.name, BaseRadio)
    Vue.component(BaseDropdown.name, BaseDropdown)
    Vue.component(CompanyInput.name, CompanyInput)
    Vue.component(CompanyInvestInput.name, CompanyInvestInput)
    Vue.component(CompanyInvestFAQInput.name, CompanyInvestFAQInput)
    Vue.component(InvestorInput.name, InvestorInput)
    Vue.component('card', Card)
  }
}

export default GlobalComponents
