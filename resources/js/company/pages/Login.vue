<template>
    <div class="login d-flex flex-column align-items-center">
        <div class="main d-flex flex-column align-items-center p-5" >
            <h1 class="text-center">Log in company invest with</h1>
            <div class="d-flex align-content-between">
                <b-button variant="link" class="font-weight-bold mr-3"><img src="/investor/images/google.png" class="pr-3 ">Google</b-button>
                <b-button variant="link" class="font-weight-bold"><img src="/investor/images/fb.png" class="pr-3">Facebook</b-button>
            </div>
            <p>or</p>

            <p class="font-weight-bold">Email</p>
            <input type="text" v-model="credential.email" class="w-100 py-2 cre-input">
            <p class="font-weight-bold">Password</p>
            <input type="password" v-model="credential.password" class="w-100 py-2 cre-input">
            <input type="submit" @click="submit()" class="w-100 mt-3 py-2 submit">
        </div>
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
                router.push({path: '/user'}).then(r => {});
            }
        }
    }
</script>

<style scoped>
    .login{
        width: 100%;
        height: 100vh;
        background: var(--main-dark);
    }
    .main{
        background: white;
        position: absolute;
        transform: translate(0,-50%);
        top:30%;
    }
    .btn-link{
        text-decoration: none!important;
        background: #aaaaaa3b;
    }
    .btn-link:hover{
        text-decoration: none!important;
        background: var(--main-dark);
        color: white!important;
    }
    input.cre-input{
        background: lavenderblush;
    }
    input.cre-input:focus{
        background: #ffa9c6;
    }
    .submit{
        background: cornflowerblue;
    }
</style>
