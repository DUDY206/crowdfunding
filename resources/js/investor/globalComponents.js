import Banner from "./components/Banner";
import Footer from "./components/Footer";
/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */

const GlobalComponents = {
  install (Vue) {
    Vue.component(Banner.name, Banner)
    Vue.component('b-footer', Footer)
  }
}

export default GlobalComponents
