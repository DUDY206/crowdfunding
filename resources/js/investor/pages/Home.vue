<template>
    <div class="d-flex flex-column min-vh-100">
        <not-found-page v-if="!checkPage"></not-found-page>
        <banner v-if="checkPage"></banner>

        <!-- cover home pc -->
        <div class="image-cover pc"
            v-if="checkPage && showCoverHome"
            v-bind:style="{
                background: 'url(' + domain + 'investor/images/cover-pc.svg)',
                backgroundRepeat: 'no-repeat',
                backgroundPositionX: '27vw',
                backgroundPositionY: 'bottom',
            }"
        >
            <div class="s-container">
                <div class="wrapper-s-container">
                    <div class="title-cover pc">{{ $t('cover.title1') }}</div>
                    <div class="description-cover pc">{{ $t('cover.description1') }}</div>
                    <div class="filter-sign-up" v-if="auth.token === null">
                        <input type="email" v-model="email" :placeholder="$t('cover.keyup_email')" class="btn-pc-bb short-text" ref="focus_email" />
                        <i v-if="(typeof startEmail !== 'undefined')" class="far fa-check-circle"></i>
                        <input v-if="!checkBtn" @click="getEmail" type="submit" class="btn-pc-bb btn-primary-pc short-text" :value="$t('cover.become_investor')" />
                        <input v-else type="submit" class="btn-pc-bb btn-primary-pc short-text" :value="$t('cover.become_investor')" />
                    </div>
                    <div class="filter-sign-up" v-if="auth.token !== null">
                        <a class="btn-pc-bb btn-primary-pc short-text text-center text-decoration-none cursor-pointer" @click="nextToCompany">{{ $t('cover.discover_companies') }}</a>
                    </div>
                    <!-- <div class="small-tip">
                        {{ $t('cover.tips') }}
                    </div> -->
                </div>
            </div>
        </div>

        <!-- cover category pc -->
        <BoxProgress v-if="isLoadingImageCover" />
        <div class="image-cover pc"
            v-if="checkPage && showCoverCategory && category.img_cover !== null && !isLoadingImageCover"
            v-bind:style="{
                background: 'url(' + domain + 'storage/categories/cover/' + category.img_cover + ') no-repeat 50% 100%',
                backgroundSize: 'cover',
            }"
        >
            <div class="s-container">
                <div class="wrapper-s-container">
                    <div class="title-cover pc">{{ category.lang_name[locale] }}</div>
                    <div class="description-cover pc short-text-8">{{ category.lang_description[locale] }}</div>
                    <div class="filter-sign-up" v-if="auth.token === null">
                        <input type="email" v-model="email" :placeholder="$t('cover.keyup_email')" class="btn-pc-bb short-text" ref="focus_email" />
                        <i v-if="(typeof startEmail !== 'undefined')" class="far fa-check-circle"></i>
                        <input v-if="!checkBtn" @click="getEmail" type="submit" class="btn-pc-bb btn-primary-pc short-text" :value="$t('cover.become_investor')" />
                        <input v-else type="submit" class="btn-pc-bb btn-primary-pc short-text" :value="$t('cover.become_investor')" />
                    </div>
                    <div class="filter-sign-up" v-if="auth.token !== null">
                        <a class="btn-pc-bb btn-primary-pc short-text text-center text-decoration-none cursor-pointer" @click="nextToCompany">{{ $t('cover.explore_investments') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- cover mb -->
        <div class="image-cover"
            v-if="checkPage && showCoverHome"
            v-bind:style="{
                background: 'url(' + domain + 'investor/images/cover.png)',
                backgroundRepeat: 'no-repeat',
                backgroundPosition: 'right',
                backgroundSize: 'contain',
            }"
        >
            <div class="s-container">
                <div class="header-cover">
                    <p>{{ $t('cover.header') }}</p>
                    <img :src="domain + '/investor/images/logo.png'">
                </div>
                <div class="title-cover">{{ $t('cover.title') }}</div>
                <div class="description-cover">{{ $t('cover.description') }}</div>
            </div>
        </div>

        <router-view
            v-if="checkPage"
            :offLoadingCover="offLoadingCover"
        >
        </router-view>

        <b-footer v-if="checkPage"></b-footer>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import router from "../routes";
    import NotFoundPage from "./NotFoundPage";
    import BoxProgress from "../../commons/BoxProgress";
    import env from "../../env";
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "Home",
        components: {
            NotFoundPage,
            BoxProgress
        },
        computed: {
            ...mapGetters(['auth', 'startEmail', 'category', 'locale'])
        },
        data() {
            return {
                domain: domain,
                checkPage: true,
                showCoverHome: false,
                showCoverCategory: false,
                email: '',
                checkBtn: false,
                isNextToCompany: false,
                isLoadingImageCover: false,
            }
        },
        mounted() {
            var self = this;

            if (self.locale === null) {
                self.locale = 'vi';
            }

            if (typeof self.startEmail !== 'undefined') {
                self.email = self.startEmail;
            } else {
                self.email = '';
            }

            switch (self.$route.name) {
                case 'Home':
                    self.showCoverHome = true;
                    self.showCoverCategory = false;
                    self.isLoadingImageCover = false;
                    break;
                case 'Category':
                    self.showCoverHome = false;
                    self.showCoverCategory = true;
                    self.isLoadingImageCover = true;
                    break;
                default:
                    self.isLoadingImageCover = false;
                    break;
            }

            if (self.$route.params.locale !== 'en' && self.$route.params.locale !== 'vi') {
                self.checkPage = false;
            } else {
                self.checkPage = true;
                if (self.$route.params.locale !== undefined){
                    self.$i18n.locale = self.$route.params.locale;
                    self.$store.commit("setLocale", self.$route.params.locale);
                }
            }
        },
        methods: {
            getEmail() {
                var self = this;

                const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if (self.email === '') {
                    self.$toast.error(self.$t('cover.please_email'));
                    setTimeout(() => {
                        self.$refs.focus_email.focus()
                    }, 100);
                } else {
                    if (re.test(String(self.email).toLowerCase())) {
                        self.checkBtn = true;
                        self.$toast.info(self.$t('cover.checking_email'));
                        self.$store.dispatch('checkEmail', self.email)
                        .then((res) => {
                            if (res.data.length >= 1) {
                                self.$store.commit('setStartEmail');
                                self.$toast.error(self.$t('cover.valid_email'));
                            } else {
                                self.$store.commit('setStartEmail', self.email);
                                window.location.href = domain + 'register';
                            }
                            self.checkBtn = false;
                        })
                        .catch((err) => {
                            self.checkBtn = false;
                            console.log(err);
                            self.$toast.error(self.$t('errors.error_1'));
                        })
                    } else {
                        self.$toast.error(self.$t('cover.validate_email'));
                        setTimeout(() => {
                            self.$refs.focus_email.focus()
                        }, 100);
                    }
                }
            },
            nextToCompany() {
                document.getElementById('list-company-invest').scrollIntoView({behavior: "smooth"});
            },
            onLoadingCover() {
                var self = this;

                self.isLoadingImageCover = true;
            },
            offLoadingCover() {
                var self = this;

                self.isLoadingImageCover = false;
            }
        }
    }
</script>

<style scoped lang="scss">
    .image-cover.pc {
        display: block;
        background-color: white !important;
        height: 500px;
        padding: 0;

        .s-container {
            width: 58%;
            margin: 0 auto;

            .wrapper-s-container {
                width: 560px;

                .description-cover.pc {
                    color: black;
                    font-size: 25px;
                    line-height: 1.3;
                    font-weight: 350;
                    margin: 30px 0;
                }

                .filter-sign-up {
                    width: 54.16667%;
                    position: relative;

                    .btn-pc-bb {
                        display: block;
                        width: 100%;
                        border: 1px solid #ddd;
                        padding: 13px 13px;
                        font-size: 16px;
                        border-radius: 6px;
                        outline: none;
                        margin-bottom: 10px;
                    }

                    .btn-primary-pc {
                        background-color: #0049ff;
                        color: white !important;
                        font-weight: bold !important;
                        font-size: 19px !important;
                    }

                    .btn-primary-pc:hover {
                        background-color: #4072ef;
                    }

                    ::-webkit-input-placeholder {
                        color: #bdbdbd;
                        font-size: 17px;
                    }

                    i.far.fa-check-circle {
                        position: absolute;
                        right: 5px;
                        top: 18px;
                        color: #19c157;
                        font-weight: bold;
                    }
                }

                .small-tip {
                    font-size: 13px;
                    color: #666;
                    width: 243.75px;
                }
            }
        }
    }

    .image-cover {
        display: none;
        height: 320px;
        padding: 50px 0;
        width: 100%;
        margin-bottom: 20px;
        background-color: #ceeaff !important;
        border-bottom: 1px solid #eee;

        .s-container {
            width: 65%;
            margin-left: 30px;

            .header-cover {
                display: flex;
                align-items: center;

                p {
                    margin-bottom: 0;
                    margin-right: 15px;
                    font-size: 13px;
                    color: rgba(0,0,0,.6);
                }

                img {
                    width: 75px;
                    height: 25px;
                }
            }

            .title-cover {
                font-size: 40px;
                line-height: 48px;
                font-weight: 900;
                letter-spacing: -0.04em;
                margin-top: 15px;
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

            .title-cover:hover {
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

            .description-cover {
                font-size: 19px;
                line-height: 1.3;
                font-weight: 300;
                color: #777;
                margin-top: 10px;
            }
        }
    }

    @media only screen and (max-width: 900px) {
        .image-cover.pc {
            background-position-x: -9vw !important;
            margin-bottom: 0 !important;

            .s-container {
                .wrapper-s-container {
                    width: 100% !important;
                    text-align: center;

                    .filter-sign-up {
                        margin: 0 auto;
                    }

                    .small-tip {
                        margin: 0 auto;
                    }
                }
            }
        }

        .image-cover {
            display: block;
        }
    }

    @media only screen and (max-width: 670px) {
        .image-cover.pc {
            height: 100% !important;
            padding-bottom: 40px;

            .s-container {
                .wrapper-s-container {

                    .title-cover.pc {
                        margin-top: 0 !important;
                        font-size: 35px !important;
                    }

                    .description-cover.pc {
                        position: unset;
                        font-size: 19px !important;
                    }
                }
            }
        }

        .image-cover {
            background-position: right top !important;
            height: 300px !important;

            .s-container {
                .header-cover {
                    display: none !important;
                }

                .title-cover {
                    margin-top: 0 !important;
                }

                .description-cover {
                    margin-top: 20px;
                    position: absolute;
                }
            }
        }
    }

    @media only screen and (max-width: 550px) {
        .image-cover {
            background-position: right bottom !important;

            .s-container {
                .description-cover {
                    display: none;
                }
            }
        }

        .image-cover.pc {
            .s-container {
                .wrapper-s-container {
                    .filter-sign-up {
                        width: 54.16667%;

                        input {
                            font-size: 15px !important;
                        }

                        input.btn-primary-pc {
                            font-size: 13px !important;
                        }

                        ::-webkit-input-placeholder {
                            font-size: 15px !important;
                        }
                    }
                }
            }
        }
    }
</style>
