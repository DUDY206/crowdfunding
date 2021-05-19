<template>
    <div class="wrapper-login" v-if="locale !== null">
        <div class="container" id="container">
            <div class="form-container log-in-container">
                <form autocomplete="off">
                    <h1 class="logo">BestB - {{ $t('authenticator.title_confirm_account') }}</h1>
                    <br />
                    <br />
                    <input type="text" :placeholder="[[$t('authenticator.code_confirm')]]" v-model="code_confirm" />
                    <span class="error-login" v-if="error_code_confirm">{{ error_code_confirm }}</span>

                    <a class="register" @click="sendCodeEmail" v-if="btnSendMail">{{ $t('authenticator.send_code') }}</a>
                    <button @click="submitConfirm" v-bind:class="{ 'unactive-btn loading': this.isActiveBtn }">
                        <dot-progress v-if="this.isActiveBtn"></dot-progress>
                        <div>{{ $t('authenticator.confirm_code') }}</div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import router from "../routes";
    import DotProgress from "../../commons/DotProgress";

    export default {
        name: "ConfirmRegister",
        data() {
            return {
                isActiveBtn: false,
                code_confirm: '',
                error_code_confirm: '',
                slug_user: '',
                btnSendMail: true,
            }
        },
        components: {
            DotProgress
        },
        computed: {
            ...mapGetters(['auth', 'locale'])
        },
        mounted() {
            if (this.auth.token === null) {
                this.$router.push({path: '/vi' }).then(r => {});
            }

            if (this.auth.user.is_verify !== 0) {
                this.$router.push({path: '/vi' }).then(r => {});
            }

            if (this.$store.state.locale !== null ) {
                this.$i18n.locale = this.$store.state.locale;
                this.$store.commit("setLocale", this.$store.state.locale);
            } else {
                this.$i18n.locale = "vi";
                this.$store.commit("setLocale", "vi");
            }
        },
        methods: {
            sendCodeEmail() {
                var self = this;
                self.btnSendMail = false;

                let formData = {
                    slug: self.auth.user.slug,
                    code_confirm: Math.floor(Math.random() * 100000)
                };

                self.$store.dispatch('sendCodeEmail', formData)
                .then((res) => {
                    self.btnSendMail = true;
                })
                .catch((err) => {
                    self.btnSendMail = true;
                })
            },
            getSlugUser(slug) {
                this.slug_user = slug;
            },
            submitConfirm(e) {
                e.preventDefault();
                var self = this;

                var currentLocale = null;
                this.isActiveBtn = true;

                let formData = {
                    slug: self.auth.user.slug,
                    code_confirm: self.code_confirm
                };

                self.$store.dispatch('confirmRegister', formData)
                .then((res) => {
                    self.isActiveBtn = false;

                    if (res.data.status === true) {
                        self.$store.commit('setAuth', {
                            user: res.data.user,
                            token: res.data.token,
                            isLoggedIn: true,
                        })

                        self.error_code_confirm = '';
                        if (self.$store.state.locale === null) {
                            currentLocale = 'vi';
                        } else {
                            currentLocale = self.$store.state.locale;
                        }


                        router.push({path: '/' + currentLocale}).then(r => {});
                    } else {
                        self.error_code_confirm = self.$t('authenticator.check_code_email_fail');
                    }
                })
                .catch((err) => {
                    self.isActiveBtn = false;

                    console.log(err);
                })
            }
        },
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
        width: 135px;
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
        width: 550px;
        max-width: 100%;
        min-height: 100vh;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
    }

    .log-in-container {
        left: 0;
        width: 100%;
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
        font-size: 14px;
        color: red;
        font-weight: bold;
    }

    .loader {
        left: 10px;
    }

    @media screen and (max-height: 700px) {
        .container {
            overflow-y: scroll;
        }

        .form-container {
            height: auto;
        }
    }
</style>
