<template>
    <div class="d-flex flex-column min-vh-100">
        <banner></banner>
        <router-view></router-view>
        <b-footer></b-footer>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import router from "../routes";

    export default {
        name: "Home",
        computed:{
            ...mapGetters(['auth'])
        },
        mounted() {
            if(this.$route.params.locale !== undefined){
                this.$i18n.locale = this.$route.params.locale;
                this.$store.commit("setLocale",this.$route.params.locale);
            }

            if (this.auth.token == null) {
                router.push({path: '/login'}).then(r => {});
            }
        }
    }
</script>

<style scoped>

</style>
