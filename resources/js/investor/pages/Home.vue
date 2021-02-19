<template>
    <div>
        <banner></banner>
        <router-view></router-view>
        <b-footer></b-footer>
    </div>
</template>

<script>
    export default {
        name: "Home",
        mounted() {
            if(this.$route.params.locale !== undefined){
                this.$i18n.locale = this.$route.params.locale;
                this.$store.commit("setLocale",this.$route.params.locale);
            }
        }
    }
</script>

<style scoped>

</style>
