<template>
    <div>
        <h1>Login vue</h1>
        <label>
            User name:
            <input type="text" v-model="credential.email">
        </label>

        <label>
            Password:
            <input type="password" v-model="credential.password">
        </label>

        <input type="submit" @click="submit()">
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import router from "../routes";

    export default {
        name: "Login",
        data(){
            return {
                credential:{
                    email:'',
                    password:'',
                }
            }
        },
        computed:{
            ...mapGetters(['auth'])
        },
        methods:{
            submit(){
                this.$store.dispatch('login',this.credential)
            }
        },
        mounted() {
            if(this.auth.token !== null){
                router.push({path: '/all-company'}).then(r => {});
            }
        }
    }
</script>

<style scoped>

</style>
