<template>
    <h1>List company</h1>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "ListCompany",
        computed:{
            ...mapGetters(['listCompany','auth'])
        },
        mounted() {
            this.$store.dispatch('getAllCompany');
        }
    }
</script>

<style scoped>

</style>
