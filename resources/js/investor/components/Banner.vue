<template>
    <div class="container header-main" v-bind:class="{ 'fixed-header': scrollHeightPage }">
        <b-navbar toggleable="lg" variant="faded" type="light" >
            <b-navbar-brand v-bind:href="'/'+$i18n.locale">
                <img class="logo" :src="domain + 'investor/images/logo2.png'" alt="" >
            </b-navbar-brand>

            <b-navbar-toggle target="navbar-toggle-collapse">
                <template #default="{ expanded }">
                    <b-icon v-if="expanded" icon="chevron-up"></b-icon>
                    <b-icon v-else icon="justify"></b-icon>
                </template>
            </b-navbar-toggle>

            <b-collapse id="navbar-toggle-collapse" is-nav class="header-toggle-menu">
                <!-- pc -->
                <b-navbar-nav class="d-lg-flex d-none">
                    <li class="filter-wrapper">
                        <div class="drop-down-option short-text">
                            <a>
                                <span class="js-current_sort_option">{{ $t('header_banner.category') }}</span>
                            </a>
                        </div>
                        <div class="dropdown-box_wrapper">
                            <div class="dropdown-content">
                                <invest-header-card />
                            </div>
                        </div>
                    </li>
                    <li class="filter-wrapper">
                        <div class="drop-down-option short-text">
                            <a>
                                <span class="js-current_sort_option">{{ $t('header_banner.information_page') }}</span>
                            </a>
                        </div>
                        <div class="dropdown-box_wrapper">
                            <div class="dropdown-content">
                                <a :href="'/' + locale + '/about-bestb'" class="text-decoration-none text-black title short-text" v-bind:class="{ 'active-text active-br' : $route.name === 'AboutBestB'}">{{ $t('header_banner.about') }}</a>
                                <a :href="'/' + locale + '/news'" class="text-decoration-none text-black title short-text" v-bind:class="{ 'active-text active-br' : $route.name === 'News'}">{{ $t('news.news') }}</a>
                                <a :href="'/' + locale + '/contact-us'" class="text-decoration-none text-black title short-text" v-bind:class="{ 'active-text active-br' : $route.name === 'ContactUs'}">{{ $t('header_banner.contact_us') }}</a>
                            </div>
                        </div>
                    </li>
                    <li class="filter-wrapper">
                        <div class="drop-down-option short-text">
                            <a :href="'/' + locale + '/investment-guide'" v-bind:class="{ 'active-text' : $route.name === 'InvestmentGuide'}">
                                <span class="js-current_sort_option">{{ $t('header_banner.investment_guide') }}</span>
                            </a>
                        </div>
                    </li>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto d-lg-flex d-none tab-right-page-home">
                    <li class="filter-wrapper">
                        <div class="drop-down-option short-text">
                            <a>
                                <span class="js-current_sort_option">
                                    <!-- {{ $t('header_banner.language') + ' (' + $i18n.locale.toUpperCase() + ')' }} -->
                                    <!-- {{ domain }} -->
                                    <img :src="domain + url_folder_language + $i18n.locale + '.png'" />
                                </span>
                            </a>
                        </div>
                        <div class="dropdown-box_wrapper">
                            <div class="dropdown-content">
                                <a v-if="$i18n.locale !== 'en'" class="js-sort_deals short-text" @click="changeLanguage('en')">EN</a>
                                <a v-else class="js-sort_deals short-text active-text active-br">EN</a>

                                <a v-if="$i18n.locale !== 'vi'" class="js-sort_deals short-text" @click="changeLanguage('vi')">VI</a>
                                <a v-else class="js-sort_deals short-text active-text active-br">VI</a>
                            </div>
                        </div>
                    </li>
                    <li class="filter-wrapper user" v-if="checkLogin">
                        <div class="drop-down-option short-text">
                            <a>
                                <img v-bind:src="avatar" :title="auth.user.full_name" class="small-icon">
                            </a>
                        </div>
                        <div class="dropdown-box_wrapper">
                            <div class="dropdown-content">
                                <a class="short-text" v-bind:href="'/' + locale + '/user-info'" v-bind:class="{ 'active-text active-br' : $route.name === 'UserInfo'}">{{ $t('header_banner.profile') }}</a>
                                <a class="short-text" v-bind:href="'/' + locale + '/transaction'" v-bind:class="{ 'active-text active-br' : $route.name === 'Transaction'}">{{ $t('header_banner.transaction') }}</a>
                                <a class="short-text" href="/logout" @click="logout($event)">{{ $t('header_banner.log_out') }}</a>
                            </div>
                        </div>
                    </li>
                    <div class="wrapper-box-account" v-else>
                        <div class="box-item pointer">
                            <a @click="nextLogin">
                                {{ $t('header_banner.log_in') }}
                            </a>
                        </div>
                        <div class="box-item pointer">
                            <a @click="nextRegister">
                                {{ $t('header_banner.sign_up') }}
                            </a>
                        </div>
                    </div>
                </b-navbar-nav>

                <!-- mb -->
                <b-navbar-nav class="ml-auto d-lg-none d-block">
                    <b-dropdown-item :href="'/' + locale + '/about-bestb'">
                        <b>{{ $t('header_banner.about') }}</b>
                    </b-dropdown-item>
                    <b-dropdown-item :href="'/' + locale + '/news'">
                        <b>{{ $t('news.news') }}</b>
                    </b-dropdown-item>
                    <b-dropdown-item :href="'/' + locale + '/contact-us'">
                        <b>{{ $t('header_banner.contact_us') }}</b>
                    </b-dropdown-item>
                    <!-- <b-dropdown-item :href="'/' + locale + '/investment-guide'">
                        <b>{{ $t('header_banner.investment_guide') }}</b>
                    </b-dropdown-item> -->
                    <div>
                        <b-navbar-toggle class="navbar-toggle-collapse-option" target="navbar-toggle-collapse-language">
                            <template #default="{ expanded }">
                                <b>{{ $t('header_banner.language') + ' (' + $i18n.locale.toUpperCase() + ')' }}</b>
                                <b-icon v-if="expanded" icon="chevron-compact-up"></b-icon>
                                <b-icon v-else icon="chevron-compact-down"></b-icon>
                            </template>
                        </b-navbar-toggle>
                        <b-collapse id="navbar-toggle-collapse-language" class="navbar-toggle-collapse-option-content" is-nav>
                            <b-navbar-nav @click="changeLanguage('en')">EN</b-navbar-nav>
                            <b-navbar-nav @click="changeLanguage('vi')">VI</b-navbar-nav>
                        </b-collapse>
                    </div>
                    <hr />
                    <div v-if="checkLogin" style="margin-bottom: 20px">
                        <b-navbar-toggle class="navbar-toggle-collapse-option" target="navbar-toggle-collapse-user">
                            <template #default="{ expanded }">
                                <img v-bind:src="avatar" alt="" class="small-icon">
                                <b>
                                    <p class="font-weight-bold text-dark user-name d-inline">{{auth.user.full_name}}</p>
                                </b>
                                <b-icon v-if="expanded" icon="chevron-compact-up"></b-icon>
                                <b-icon v-else icon="chevron-compact-down"></b-icon>
                            </template>
                        </b-navbar-toggle>
                        <b-collapse id="navbar-toggle-collapse-user" class="navbar-toggle-collapse-option-content" is-nav>
                            <b-navbar-nav>
                                <a v-bind:href="'/' + locale + '/user-info'">{{ $t('header_banner.profile') }}</a>
                            </b-navbar-nav>
                            <b-navbar-nav>
                                <a v-bind:href="'/' + locale + '/transaction'">{{ $t('header_banner.transaction') }}</a>
                            </b-navbar-nav>
                            <b-navbar-nav>
                                <a @click="logout">{{ $t('header_banner.log_out') }}</a>
                            </b-navbar-nav>
                        </b-collapse>
                    </div>
                    <div class="wrapper-box-account" v-else style="margin-bottom: 20px">
                        <div class="box-item pointer">
                            <a @click="nextLogin">
                                {{ $t('header_banner.log_in') }}
                            </a>
                        </div>
                        <div class="box-item pointer">
                            <a @click="nextRegister">
                                {{ $t('header_banner.sign_up') }}
                            </a>
                        </div>
                    </div>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
        <div class="logout-loading" v-if="onLoading">
            <flash-dot-progress></flash-dot-progress>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import FlashDotProgress from "../../commons/FlashDotProgress";
    import env from '../../env';
    import InvestHeaderCard from './Card/InvestHeaderCard';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "banner",
        data(){
            return {
                domain: domain,
                hover_invest: false,
                hoverInvestTransition: false,
                avatar: '/investor/images/tmp.jpg',
                onLoading: false,
                checkLogin: false,
                scrollHeightPage: false,
                url_folder_language: 'images/language/',
            }
        },
        computed:{
            ...mapGetters([
                'locale', 'auth'
            ])
        },
        components: {
            FlashDotProgress,
            InvestHeaderCard,
        },
        mounted() {
            var self = this;

            if (self.auth.token !== null) {
                self.$store.dispatch('getUserBySlug', self.auth.user.slug)
                .then((res) => {
                    if (res.data.status === false) {
                        self.$router.push({path: '/confirm-register' }).then(r => {});
                    } else {
                        self.$store.commit('setAuth', {
                            user: res.data,
                            token: self.auth.token,
                            isLoggedIn: true,
                        })
                    }
                })
                .catch((err) => {
                    self.$store.commit('setAuth', {
                        user: {},
                        token: null,
                        isLoggedIn: false,
                    });
                    self.$toast.error(self.$t('errors.error_1'));
                });
            }

            if (self.auth.user !== null) {
                if (self.auth.user.avatar === "") {
                    self.avatar = domain + 'admin/img/default_avatar.png';
                } else {
                    self.avatar = domain + self.auth.user.avatar_path;
                }
            }

            if (self.auth.token == null) {
                self.checkLogin = false;
            } else {
                self.checkLogin = true;
            }

            // window.addEventListener('scroll', (e) => {
            //     if (Math.round(window.scrollY) >= 115) {
            //         self.scrollHeightPage = true;
            //     } else {
            //         self.scrollHeightPage = false;
            //     }
            // });
        },
        methods: {
            nextLogin() {
                var self = this;
                self.onLoading = true;

                self.onLoading = false;
                self.$router.push({path: '/login'}).then(r => {});
            },
            nextRegister() {
                var self = this;
                self.onLoading = true;

                self.onLoading = false;
                this.$router.push({path: '/register'}).then(r => {});
            },
            logout(e) {
                e.preventDefault();
                var self = this;
                self.onLoading = true;

                self.$store.commit('setStartEmail');
                this.$store.dispatch('logout')
                .then(res => {
                    self.onLoading = false;
                    window.location.href = domain;
                })
                .catch((err) => {
                    self.onLoading = false;
                    window.location.href = domain;
                    self.$store.commit('setAuth', {
                        user: {},
                        token: null,
                        isLoggedIn: false,
                    });
                })
            },
            onActiveHover() {
                var self = this;

                self.hover_invest = true;
                setTimeout(() => {
                    self.hoverInvestTransition = true
                }, 10);
            },
            offActiveHover() {
                var self = this;

                self.hoverInvestTransition = false
                setTimeout(() => {
                    self.hover_invest = false;
                }, 10);
            },
            changeLanguage(language) {
                var self = this;

                var currentLanguage = self.$route.params.locale;
                var currentUrl = self.$route.fullPath;
                var newUrl;

                switch (currentLanguage.length) {
                    case 2:
                        currentUrl = currentUrl.slice(currentLanguage.length + 1, currentUrl.length);
                        newUrl = language + currentUrl;
                        window.location.href = window.location.origin + '/' + newUrl;

                        break;
                    default:
                        self.$toast.error($('errors.error_1'));
                        break;
                }
            }
        },
    }
</script>

<style lang="scss" scoped>
    .container.header-main {
        transition: 1.5s all ease;
        max-width: 100%;
        border-bottom: thin solid #e1e1e1;
        box-shadow: 0 10px 10px rgb(0 0 0 / 5%);
        background: var(--main-dark-blue);
    }

    .navbar {
        padding: 0;

        a {
            .logo {
                width: 115px;
            }
        }
    }

    .navbar-toggler {
        color: white !important;
    }

    .un-pb-5 {
        padding-bottom: 0rem !important;
    }

    .fixed-header {
        position: fixed;
        background: white;
        z-index: 99999;
        padding-bottom: 0 !important;
        border-bottom: 1px solid #eee;
    }

    .navbar-brand {
        img {
            // max-height: 40px;
        }
    }

    .user-name:first-letter {
        text-transform: uppercase;
    }

    .invest-nav {
        position: relative;
        border-left: 1px solid #e0e0e0;

        .title:hover {
            cursor: pointer;
            color: blue;
        }
    }

    .wrapper-box-invest {
        height: 30px;
        position: absolute;
        top: 40px;
        left: -15px;
        display: grid;
        grid-template-columns: 280px 280px 280px;
    }

    // .invest-item:before {
    //     content: "";
    //     width: 0px;
    //     height: 0px;
    //     border: 10px solid #ffffff;
    //     border-bottom: 10px solid #e9e9e9;
    //     position: absolute;
    //     top: -21px;
    //     left: 40px;
    // }

    .active-invest-item {
        transform: translateY(-2%);
    }

    .message-icon {
        height: 35px;
        padding: 0 .5rem !important;
    }

    .logout-loading {
        position: fixed;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100vh;
        z-index: 99999999999;
        background: hsl(0deg 0% 100% / 85%);
    }

    .wrapper-box-account {
        display: flex;
        align-items: center;

        .box-item {
            margin-left: 25px;

            a {
                color: white;
                text-decoration: none;
                font-weight: bold;
            }

            a:hover {
                color: var(--main-light-green);
            }
        }

        .box-item:first-child {
            margin-left: 0;
        }
    }

    .pointer {
        cursor: pointer;
    }

    .active-text {
        color: var(--main-light-green) !important;
    }

    .active-br {
        background: rgba(44, 39, 104, 0.3) !important;
    }

    .filter-wrapper {
        position: relative;
        border-left: 1px solid #e0e0e0;
        padding: 0px 1rem;
        cursor: pointer;

        .drop-down-option {
            width: auto;

            a {
                text-decoration: none;
                color: white;
                font-weight: bold;

                span {
                    img {
                        border-radius: 2px;
                        width: 35px;
                        height: 35px;
                        object-fit: contain;
                    }
                }
            }

            a:hover {
                color: var(--main-light-green);
            }

            i {
                position: absolute;
                right: 15px;
                top: 10px;
            }
        }

        .dropdown-box_wrapper {
            width: 200px;
            position: absolute;
            top: 90%;
            left: 50%;
            z-index: 70;
            padding-top: 16px;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            visibility: hidden;
            opacity: 0;
            -webkit-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;

            .dropdown-content {
                position: relative;
                border-radius: 6px;
                font-size: 16px;
                font-weight: 400;
                text-align: left;
                white-space: nowrap;
                background-color: rgba(44, 39, 104, 0.86);
                box-shadow: 0 1px 2px rgb(0 0 0 / 20%), 0 -1px 0 rgb(0 0 0 / 2%);
                display: flex;
                flex-direction: column;

                a {
                    display: block;
                    width: auto;
                    height: auto;
                    margin: 0;
                    line-height: 1.5;
                    color: white;
                    padding: 10px 32px 10px 16px;
                    width: -webkit-fill-available;
                    text-decoration: none !important;
                }

                a:hover {
                    color: var(--main-light-green);
                    background: rgba(44, 39, 104, 0.3);
                }
            }
        }

        .dropdown-box_wrapper:before {
            content: '';
            position: absolute;
            top: 0%;
            left: 50%;
            height: 0;
            width: 0;
            pointer-events: none;
            margin-left: -9px;
            border: 9px solid transparent;
            border-bottom-color: white;
        }
    }

    .filter-wrapper:hover, .filter-wrapper:active {
        color: #0049ff;

        .dropdown-box_wrapper {
            visibility: visible;
            opacity: 1;
            top: 100%;
        }
    }

    .filter-wrapper.user {
        border-left: none;
        padding: 0;

        .dropdown-box_wrapper {
            width: 176px;
            left: -53px;
        }

        .dropdown-box_wrapper::before {
            right: 4%;
            left: auto;
        }
    }

    .tab-right-page-home {
        align-items: center;

        .filter-wrapper {
            border-left: none;
            margin-right: 10px;
        }
    }

    .navbar-toggle-collapse-option {
        border: none;
        padding: 0;
        font-size: 16px;
        color: black !important;
    }

    .navbar-toggle-collapse-option-content {
        background: rgba(0,0,0,.03);

        .navbar-nav {
            padding: 5px 5px;

            a {
                color: black;
                text-decoration: none;
            }
        }
    }

    @media only screen and (max-width: 1024px) {
        .container.pb-5 {
            padding-bottom: 0rem !important;
        }
    }
</style>
