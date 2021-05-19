<template>
    <div class="wrapper-login" v-if="locale !== null">
        <div class="container" id="container">
            <div class="form-container log-in-container">
                <form autocomplete="off" v-if="!isFormCodeConfirm">
                    <h1 class="logo">BestB - {{ $t('authenticator.register_slogan') }}</h1>
                    <!-- <div class="social-container">
                        <a href="#" class="social" title="Google">
                            <img src="/investor/images/google.png" class="pr-3 " />
                        </a>
                        <a href="#" class="social" title="Facebook">
                            <img src="/investor/images/fb.png" class="pr-3" />
                        </a>
                    </div>
                    <span>OR</span> -->
                    <br />
                    <br />
                    <input type="email" :placeholder="[[$t('authenticator.email')]]" v-model="credential.email" />
                    <span class="error-login" v-if="errors.email">{{errors.email}}</span>

                    <input type="password" :placeholder="[[$t('authenticator.password')]]" v-model="credential.password" />
                    <span class="error-login" v-if="errors.password">{{errors.password}}</span>

                    <input type="password" :placeholder="[[$t('authenticator.confirm_password')]]" v-model="credential.confirm_password" />
                    <span class="error-login" v-if="errors.confirm_password">{{errors.confirm_password}}</span>

                    <input type="text" :placeholder="[[$t('authenticator.user_name')]]" v-model="credential.user_name" />
                    <span class="error-login" v-if="errors.user_name">{{errors.user_name}}</span>

                    <input type="text" :placeholder="[[$t('authenticator.full_name')]]" v-model="credential.full_name" />
                    <span class="error-login" v-if="errors.full_name">{{errors.full_name}}</span>

                    <input type="number" :placeholder="[[$t('authenticator.phone_number')]]" min="0" v-model="credential.phone_number" />
                    <span class="error-login" v-if="errors.phone_number">{{errors.phone_number}}</span>

                    <input type="date" :placeholder="[[$t('authenticator.date_of_birth')]]" v-model="credential.date_of_birth" />
                    <span class="error-login" v-if="errors.date_of_birth">{{errors.date_of_birth}}</span>

                    <a href="login" class="register" @click="nextToPage($event, '/login')">{{ $t('authenticator.are_u_login') }}</a>
                    <button @click="submit" v-bind:class="{ 'unactive-btn loading': this.isActiveBtn }">
                        <dot-progress v-if="this.isActiveBtn"></dot-progress>
                        <div>{{ $t('authenticator.register') }}</div>
                    </button>
                </form>
                <form autocomplete="off" v-else>
                    <h1 class="logo">BestB - {{ $t('authenticator.register_slogan') }}</h1>
                    <br />
                    <br />
                    <input type="text" :placeholder="[[$t('authenticator.code_confirm')]]" v-model="code_confirm" />
                    <span class="error-login" v-if="error_code_confirm">{{ error_code_confirm }}</span>

                    <a class="register" @click="nextToFormRegister">{{ $t('authenticator.back') }}</a>
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
        name: "Login",
        data() {
            return {
                credential: {
                    email:'',
                    password:'',
                    confirm_password:'',
                    user_name:'',
                    full_name:'',
                    phone_number:'',
                    date_of_birth:'',
                },
                errors: {
                    email:'',
                    password:'',
                    confirm_password:'',
                    user_name:'',
                    full_name:'',
                    phone_number:'',
                    date_of_birth:'',
                },
                isActiveBtn: false,
                isFormCodeConfirm: false,
                code_confirm: '',
                error_code_confirm: '',
                slug_user: '',
            }
        },
        components: {
            DotProgress
        },
        computed: {
            ...mapGetters(['auth', 'locale', 'startEmail'])
        },
        mounted() {
            if (typeof this.startEmail !== 'undefined') {
                this.credential.email = this.startEmail;
            }

            if (this.auth.token !== null) {
                router.push({path: '/' + this.locale}).then(r => {});
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
            nextToPage(e, url) {
                e.preventDefault();

                this.$router.push({path: url}).then(() => {});
            },
            nextToFormRegister(e) {
                e.preventDefault();

                this.isFormCodeConfirm = false;
            },
            submit(e) {
                e.preventDefault();
                var self = this;

                var currentLocale = null;
                this.errors.confirm_password = '';
                this.isActiveBtn = true;

                if (this.credential.password !== this.credential.confirm_password) {
                    this.errors.confirm_password = this.$t('authenticator.error.confirm_password');
                    this.$toast.error(this.$t('authenticator.repassword_fail'));
                    this.isActiveBtn = false;

                    this.errors.email = '';
                    this.errors.password = '';
                    this.errors.confirm_password = '';
                    this.errors.user_name = '';
                    this.errors.full_name = '';
                    this.errors.phone_number = '';
                    this.errors.date_of_birth = '';
                } else {
                    self.credential.code_email = Math.floor(Math.random() * 100000);
                    this.$store.dispatch('register', this.credential)
                    .then((res) => {
                        self.errors.email = '';
                        self.errors.password = '';
                        self.errors.confirm_password = '';
                        self.errors.user_name = '';
                        self.errors.full_name = '';
                        self.errors.phone_number = '';
                        self.errors.date_of_birth = '';

                        self.getSlugUser(res.data.slug);

                        self.isFormCodeConfirm = true;
                        self.isActiveBtn = false;
                    })
                    .catch((err) => {
                        let errorJson = err;
                        self.$toast.error(self.$t('authenticator.message_login_fail'));
                        self.$toast.error(self.$t('authenticator.message_register_fail'));

                        for (var key in errorJson) {
                            for (var error in self.errors) {
                                if (typeof errorJson[error] === 'undefined') {
                                    self.errors[error] = '';
                                } else {
                                    self.errors[key] = errorJson[key][0];
                                }
                            }
                        }

                        self.isActiveBtn = false
                    })
                }
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
                    slug: self.slug_user,
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
