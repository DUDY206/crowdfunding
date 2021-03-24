<template>
    <div class="container pb-5">
        <b-navbar toggleable="lg" variant="faded" type="light" >
            <b-navbar-brand v-bind:href="'/'+$i18n.locale">
                <img src="/investor/images/logo.png" alt="" >
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            <b-collapse id="nav-collapse" is-nav >
                <b-navbar-nav class="d-lg-flex d-none">
                    <li href="#" class="invest-nav nav-item b-nav-dropdown dropdown d-flex align-items-center px-3"
                        @mouseover="onActiveHover"
                        @mouseleave="offActiveHover"
                    >
                        <div class="title">Invest</div>
                        <div class="wrapper-box-invest" v-if="hover_invest">
                            <div class="invest-item main-border " v-bind:class="{'active-invest-item': hoverInvestTransition}">
                                <div v-for="index of 6" :key="index" >
                                    <a href="#" class="text-decoration-none">
                                        <div class="p-lg-3">
                                            <div class="w-100 d-flex">
                                                <img src="/investor/images/tmp.jpg" class="normal-icon ">
                                                <div class="pl-lg-3 d-inline-block">
                                                    <p class="m-0">Start up</p>
                                                    <p class="descript">Lorem ipsum dolor sit amet Lorem ipsum dolor sit.. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <b-nav-item-dropdown v-bind:text="$i18n.locale.toUpperCase()" right class="d-flex align-items-center">
                        <b-dropdown-item href="/en" v-if="$i18n.locale !== 'en'">EN</b-dropdown-item>
                        <b-dropdown-item href="/vi" v-if="$i18n.locale !== 'vi'">VI</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto d-lg-flex d-none">
                    <b-nav-item href="#">
                        <b-button variant="link">
                            <b-icon icon="mailbox" scale="1" class="text-black-50"></b-icon>
                        </b-button>
                    </b-nav-item>
                    <b-nav-item href="#">
                        <b-button variant="danger" class="message-icon">
                            <b-icon icon="lightning-fill" scale="1" class="text-white"></b-icon> 15
                        </b-button>
                    </b-nav-item>
                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template #button-content>
                            <img v-bind:src="avatar" alt="" class="small-icon">
                        </template>
                        <b-dropdown-item v-bind:href="'/'+locale+'/user-info'">My profile</b-dropdown-item>
                        <b-dropdown-item href="#">My application</b-dropdown-item>
                        <b-dropdown-item href="#">My portfolio</b-dropdown-item>
                        <b-dropdown-item href="#">Saved deals</b-dropdown-item>
                        <b-dropdown-item href="#">Invite friends</b-dropdown-item>
                        <b-dropdown-item href="#">Autopilot</b-dropdown-item>
                        <b-dropdown-item href="#">Settings</b-dropdown-item>
                        <b-dropdown-item href="#" @click="logout">Loggout</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto d-lg-none d-block">
                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template #button-content>
                            <img v-bind:src="avatar" alt="" class="small-icon">
                            <p class="font-weight-bold text-dark user-name d-inline">{{auth.user.full_name}}</p>
                        </template>
                        <b-dropdown-item v-bind:href="'/'+locale+'/user-info'">My profile</b-dropdown-item>
                        <b-dropdown-item href="#">My application</b-dropdown-item>
                        <b-dropdown-item href="#">My portfolio</b-dropdown-item>
                        <b-dropdown-item href="#">Saved deals</b-dropdown-item>
                        <b-dropdown-item href="#">Invite friends</b-dropdown-item>
                        <b-dropdown-item href="#">Autopilot</b-dropdown-item>
                        <b-dropdown-item href="#">Settings</b-dropdown-item>
                        <b-dropdown-item href="#" @click="logout">Loggout</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
        <div class="logout-loading" v-if="onLogout">
            <flash-dot-progress></flash-dot-progress>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import FlashDotProgress from "../../commons/FlashDotProgress";

    export default {
        name: "banner",
        data(){
            return {
                hover_invest: false,
                hoverInvestTransition: false,
                avatar: '/investor/images/tmp.jpg',
                onLogout: false
            }
        },
        computed:{
            ...mapGetters([
                'locale','auth'
            ])
        },
        components: {
            FlashDotProgress,
        },
        methods:{
            logout(){
                var self = this;
                self.onLogout = true;

                this.$store.dispatch('logout');
                setTimeout(() => {
                    self.onLogout = false;
                    this.$router.push({path: '/login'}).then(r => {});
                }, 3000)
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
        },
        mounted() {
            if(this.auth.user !== null){
                this.avatar = this.auth.user.avatar_path
            }
        }
    }
</script>

<style lang="scss" scoped>

    .navbar-brand {
        img {
            max-height: 40px;
        }
    }

    .user-name:first-letter {
        text-transform: uppercase;
    }

    @media only screen and (min-width: 992px) {
        #nav-collapse {
            border-left: solid 1px rgba(0,0,0,.2);
        }
    }

    .invest-nav {
        position: relative;

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

    .invest-item {
        background: white;
        position: absolute;
        top: 30px;
        z-index: 100;
        transform: translateY(-4%);
        transition: 0.5s all ease;
    }

    .invest-item:before {
        content: "";
        width: 0px;
        height: 0px;
        border: 10px solid #ffffff;
        border-bottom: 10px solid #e9e9e9;
        position: absolute;
        top: -21px;
        left: 40px;
    }

    .active-invest-item {
        transform: translateY(-2%);
    }

    .invest-item {
        display: grid;
        grid-template-columns: 280px 280px 280px;
        border-radius: 5px;

        .p-lg-3:hover {
            background: #f5f5f5;
        }

        & > div{
            box-sizing: border-box;

            p {
                white-space: break-spaces;
            }
        }

        & > div:nth-child(3n+2) {
            border-left: solid 1px #eeeeee;
            border-right: solid 1px #eeeeee;
        }

        & > div:nth-child(3) ~ div {
            border-top: solid 1px #eeeeee;
        }

        .main-border {
            border: none;
        }

        p.m-0 {
            color: #222222;
            font-weight: bold;
            font-size: 18px;
        }

        p.descript {
            color: #a9a9a9;
            font-size: 13px;
        }
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
        z-index: 99999;
        background: hsl(0deg 0% 100% / 85%);
    }
</style>
