<template>
    <div class="container pb-5">
        <b-navbar toggleable="lg" variant="faded" type="light" >
            <b-navbar-brand v-bind:href="'/'+$i18n.locale">
                <img src="/investor/images/logo.png" alt="" >
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <li href="#" class="invest-nav nav-item b-nav-dropdown dropdown d-flex align-items-center px-3"
                        @mouseover="hover_invest = true"
                        @mouseleave="hover_invest = false"
                    >Invest
                        <div class="invest-item main-border " v-if="hover_invest">
                            <div v-for="index of 6" :key="index" >
                                <a href="#" class="text-decoration-none">
                                    <div class="p-lg-3">
                                        <div class="w-100 d-flex">
                                            <img src="/investor/images/tmp.jpg" class="normal-icon ">
                                            <div class="pl-lg-3 d-inline-block">
                                                <p class="m-0">Start up</p>
                                                <p>Lorem ipsum dolor sit amet Lorem ipsum dolor sit.. </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>

                    <b-nav-item-dropdown v-bind:text="$i18n.locale.toUpperCase()" right class="d-flex align-items-center">
                        <b-dropdown-item href="/en" v-if="$i18n.locale !== 'en'" >EN</b-dropdown-item>
                        <b-dropdown-item href="/vi" v-if="$i18n.locale !== 'vi'" >VI</b-dropdown-item>

                    </b-nav-item-dropdown>


                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
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
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "banner",
        data(){
            return {
                hover_invest:false,
                avatar: '/investor/images/tmp.jpg',
            }
        },
        computed:{
            ...mapGetters([
                'locale','auth'
            ])
        },
        methods:{
            logout(){
                this.$store.dispatch('logout')
            }
        },
        mounted() {
            if(this.auth.user !== null){
                this.avatar = this.auth.user.avatar_path
            }
        }
    }
</script>

<style lang="scss" scoped>

    .navbar-brand{
        img{
            max-height: 40px;
        }
    }
    #nav-collapse{
        border-left: solid 1px rgba(0,0,0,.2);
    }
    .invest-nav{
        position: relative;

    }
    .invest-item{
        background: white;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 100;
    }
    .invest-item{
        display: grid;
        grid-template-columns: 280px 280px 280px;
        &>div{
            box-sizing: border-box;
            p{
                white-space: break-spaces;
            }
        }
        &>div:nth-child(3n+2){
            border-left:solid 1px var(--main-grey);
            border-right:solid 1px var(--main-grey);
        }
        &>div:nth-child(3) ~ div{
            border-top: solid 1px var(--main-grey);;
        }
    }
    .message-icon{
        height: 35px;
        padding: 0 .5rem!important;
    }
</style>
