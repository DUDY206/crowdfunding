<template>
    <div class="wrapper-login">
        <div class="container" id="container">
            <div class="form-container log-in-container">
                <form @submit="submit" autocomplete="off">
                    <h1 class="logo">BestB</h1>
                    <!-- <div class="social-container">
                        <a href="#" class="social" title="Google">
                            <img src="/investor/images/google.png" class="pr-3 " />
                        </a>
                        <a href="#" class="social" title="Facebook">
                            <img src="/investor/images/fb.png" class="pr-3" />
                        </a>
                    </div> -->
                    <!-- <span>OR</span> -->

                    <input type="email" :placeholder="$t('authenticator.email')" name="email" v-model="credential.email" />
                    <input type="password" :placeholder="$t('authenticator.password')" name="password" v-model="credential.password" />

                    <a href="register" class="register" @click="nextToPage($event, '/register')">{{$t('authenticator.register')}}?</a>

                    <button type="submit" v-bind:class="{ 'unactive-btn loading': this.isActiveBtn }">
                        <dot-progress v-if="this.isActiveBtn"></dot-progress>
                        <div>{{$t('authenticator.login')}}</div>
                    </button>

                    <a href="/" class="register" @click="nextToPage($event, '/')">{{$t('authenticator.back_home')}}?</a>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-right">
                        <h1>BestB</h1>
                        <p>
                            {{ $t('authenticator.concept') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import router from "../routes";
    import DotProgress from "../../commons/DotProgress";

    export default {
        name: "Login",
        data(){
            return {
                credential:{
                    email:'',
                    password:'',
                },
                isActiveBtn: false,
                currentLocale: null,
            }
        },
        components: {
            DotProgress
        },
        computed:{
            ...mapGetters(['auth', 'locale', 'startEmail'])
        },
        methods: {
            nextToPage(e, url) {
                e.preventDefault();

                this.$router.push({path: url}).then(() => {});
            },
            submit(e) {
                e.preventDefault();
                var self = this;

                if (self.locale === null) {
                    self.currentLocale = 'vi';
                } else {
                    self.currentLocale = self.locale;
                }

                if (self.credential.email == '' || self.credential.password == '') {
                    self.$toast.error(self.$t('authenticator.null_info_login'));
                } else {
                    self.isActiveBtn = true;
                    self.$store.dispatch('login', self.credential)
                    .then((res) => {
                        self.isActiveBtn = false;
                        router.push({path: '/' + self.currentLocale}).then(r => {});
                    })
                    .catch((err) => {
                        self.isActiveBtn = false;
                        self.$toast.error(self.$t('authenticator.info_login_fail'));
                    })
                }

            },
        },
        mounted() {
            if (typeof this.startEmail !== 'undefined') {
                this.credential.email = this.startEmail;
            }

            if (this.locale === null) {
                this.locale = 'vi';
            }

            this.$i18n.locale = "vi";
            this.$store.commit("setLocale", "vi");

            if (this.auth.token !== null) {
                router.push({path: '/' + this.locale}).then(r => {});
            }
        }
    }
</script>

<style lang="scss" scoped>
    * {
        box-sizing: border-box;
    }

    .wrapper-login {
        background: #f3e0e2;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        height: 100vh;
    }

    h1.logo {
        font-weight: bold;
        margin: 0;
    }

    .logo {
        background: #CA4246;
        background-color: #CA4246;
        background: conic-gradient(
            #CA4246 16.666%,
            #E16541 16.666%,
            #E16541 33.333%,
            #F18F43 33.333%,
            #F18F43 50%,
            #8B9862 50%,
            #8B9862 66.666%,
            #476098 66.666%,
            #476098 83.333%,
            #A7489B 83.333%);
        background-size: 57%;
        background-repeat: repeat;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rainbow-text-animation-rev 0.5s ease forwards;
        cursor: pointer;
    }

    .logo:hover {
        animation: rainbow-text-animation 0.5s ease forwards;
    }

    @keyframes rainbow-text-animation {
        0% {
            background-size: 57%;
            background-position: 0 0;
        }
        20% {
            background-size: 57%;
            background-position: 0 1em;
        }
        100% {
            background-size: 300%;
            background-position: -9em 1em;
        }
    }

    @keyframes rainbow-text-animation-rev {
        0% {
            background-size: 300%;
            background-position: -9em 1em;
        }
        20% {
            background-size: 57%;
            background-position: 0 1em;
        }
        100% {
            background-size: 57%;
            background-position: 0 0;
        }
    }

    p {
        font-size: 14px;
        font-weight: 100;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
    }

    span {
        font-size: 12px;
    }

    a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
    }

    button {
        border-radius: 20px;
        border: 1px solid #FF4B2B;
        background-color: #FF4B2B;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        transform: scaleY(0.9);
    }

    button:hover {
        background-color: #942310;
        transform: scaleY(1);
    }

    .unactive-btn {
        pointer-events: none;
        background: #942310;
        transform: scale(1);
    }

    .loading {
        height: 44px;
        width: 155px;
        padding-right: 0px;
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        outline: none;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
    }

    .log-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }


    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
    }


    .overlay {
        background: #FF416C;
        background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
        background: linear-gradient(to right, #FF4B2B, #FF416C);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
    }


    .overlay-right {
        right: 0;
    }


    .social-container {
        margin: 30px 0 20px 0;
    }

    a.social:hover {
        background: #f3eded;
    }

    .social-container a {
        border: 1px solid #DDDDDD;
        border-radius: 50%;
        display: inline-flex;
        margin: 0 5px;
        padding: 5px;
        height: 40px;
        width: 40px;
        cursor: pointer;
    }

    a.register:hover {
        text-decoration: underline;
        color: blue;
        cursor: pointer;
    }

    .error-login {
        padding: 10px 0;
        font-size: 14px;
        color: red;
        font-weight: bold;
    }

    .loader {
        left: 10px;
    }

    @media screen and (max-width: 1200px) {
        .container {
            width: 750px;
            min-height: 450px;
        }
    }

    @media screen and (max-width: 780px) {
        .wrapper-login {
            height: 100vh;
        }

        .container {
            width: 450px;
        }

        .log-in-container {
            width: 100%;
        }

        .overlay-container {
            display: none;
        }
    }

    @media screen and (max-width: 750px) {
        .wrapper-login {
            height: 100vh;
        }
    }

    @media screen and (max-width: 425px) {
        .container {
            width: 350px;
            padding-top: 30px;
            padding-bottom: 30px;
        }
    }

    @media screen and (max-width: 320px) {
        .container {
            width: 300px;
        }
    }

    @media screen and (max-width: 280px) {
        .container {
            width: 250px;
        }

        form {
            padding: 0px 10px;
        }
    }
</style>
