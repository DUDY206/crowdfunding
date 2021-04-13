<template>
    <router-view></router-view>
</template>

<script>
    import {mapGetters} from "vuex";
    export default {
        computed:{
            ...mapGetters(['auth', 'locale'])
        },
        methods: {
            clearState() {
                // this.$store.commit('settempFormContract', null);
                var self = this;
                console.log("BestB");
            }
        },
        mounted() {
            window.addEventListener('beforeunload', this.clearState)
        }
    }
</script>
<style >

</style>
