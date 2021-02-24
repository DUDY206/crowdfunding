<template>
    <div class="login d-flex flex-column align-items-center" v-if="locale !== null">
        <div class="main d-flex flex-column align-items-center p-5" >
            <h1 class="text-center">Log in with</h1>
            <div class="d-flex align-content-between">
                <b-button variant="link" class="font-weight-bold mr-3"><img src="/investor/images/google.png" class="pr-3 ">Google</b-button>
                <b-button variant="link" class="font-weight-bold"><img src="/investor/images/fb.png" class="pr-3">Facebook</b-button>
            </div>
            <p>or</p>

            <p class="font-weight-bold">{{$t('authenticator.email')}}</p>
            <input type="text" v-model="credential.email" class="w-100 py-2 cre-input">
            <span class="error">{{errors.email}}</span>

            <p class="font-weight-bold">{{$t('authenticator.password')}}</p>
            <input type="text" v-model="credential.password" class="w-100 py-2 cre-input">
            <span class="error">{{errors.password}}</span>

            <p class="font-weight-bold">{{$t('authenticator.confirm_password')}}</p>
            <input type="text" v-model="credential.confirm_password" class="w-100 py-2 cre-input">
            <span class="error">{{errors.confirm_password}}</span>

            <p class="font-weight-bold">{{$t('authenticator.user_name')}}</p>
            <input type="text" v-model="credential.user_name" class="w-100 py-2 cre-input">
            <span class="error">{{errors.user_name}}</span>

            <p class="font-weight-bold">{{$t('authenticator.full_name')}}</p>
            <input type="text" v-model="credential.full_name" class="w-100 py-2 cre-input">
            <span class="error">{{errors.full_name}}</span>

            <p class="font-weight-bold">{{$t('authenticator.phone_number')}}</p>
            <input type="text" v-model="credential.phone_number" class="w-100 py-2 cre-input">
            <span class="error">{{errors.phone_number}}</span>

            <p class="font-weight-bold">{{$t('authenticator.date_of_birth')}}</p>
            <input type="text" v-model="credential.date_of_birth" class="w-100 py-2 cre-input">
            <span class="error">{{errors.date_of_birth}}</span>


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
                    confirm_password:'',
                    user_name:'',
                    full_name:'',
                    phone_number:'',
                    date_of_birth:'',
                },
                errors:{
                    email:'',
                    password:'',
                    confirm_password:'',
                    user_name:'',
                    full_name:'',
                    phone_number:'',
                    date_of_birth:'',
                }
            }
        },
        computed:{
            ...mapGetters(['auth','locale'])
        },
        methods:{
            submit(){
                this.errors.confirm_password = '';
                if(this.credential.password !== this.credential.confirm_password){
                    this.errors.confirm_password = this.$t('auth.error.confirm_password');
                }else{
                    this.$store.dispatch('register',this.credential)
                        .then((res)=>{
                            router.push({path: '/'+this.$store.state.locale}).then(r => {});
                        }).catch((err)=>{
                            let errorJson = JSON.parse(JSON.stringify(err))
                            console.log(err)
                            this.$toast.error('Xin thử lại');
                            for(var key in errorJson){
                                if(typeof errorJson[key] !== 'undefined'){
                                    this.errors[key] = errorJson[key][0];
                                }else{
                                    this.errors[key] = '';
                                }
                            }
                    })
                }
            }
        },
        mounted() {
            if(this.auth.token !== null){
                router.push({path: '/' + this.locale}).then(r => {});
            }
            if(this.$store.state.locale !== null ){
                this.$i18n.locale = this.$store.state.locale;
                this.$store.commit("setLocale",this.$store.state.locale);
            }else{
                this.$i18n.locale = "en";
                this.$store.commit("setLocale","en");
            }
            console.log(this.locale);
            console.log(this.$store.state.locale);

        }

    }
</script>

<style lang="scss" scoped>
    .login{
        width: 100%;
        height: 100vh;
        background: var(--main-dark);
    }
    .main{
        background: white;
        position: absolute;
        transform: translate(0,-50%);
        top:50%;
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
