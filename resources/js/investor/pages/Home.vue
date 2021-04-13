<template>
    <div class="d-flex flex-column min-vh-100">
        <not-found-page v-if="!checkPage"></not-found-page>
        <banner v-if="checkPage"></banner>
        <router-view v-if="checkPage"></router-view>
        <b-footer v-if="checkPage"></b-footer>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import router from "../routes";
    import NotFoundPage from "./NotFoundPage";

    export default {
        name: "Home",
        components: {
            NotFoundPage,
        },
        computed: {
            ...mapGetters(['auth'])
        },
        data() {
            return {
                checkPage: true,
            }
        },
        mounted() {
            if (this.$route.params.locale !== 'en' && this.$route.params.locale !== 'vi') {
                this.checkPage = false;
            } else {
                this.checkPage = true;
                if (this.$route.params.locale !== undefined){
                    this.$i18n.locale = this.$route.params.locale;
                    this.$store.commit("setLocale", this.$route.params.locale);
                }
            }
        }
    }
</script>

<style scoped>

</style>
