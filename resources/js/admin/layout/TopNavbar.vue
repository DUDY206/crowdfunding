<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button type="button"
                    class="navbar-toggler navbar-toggler-right"
                    :class="{toggled: $sidebar.showSidebar}"
                    aria-controls="navigation-index"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                    @click="toggleSidebar">
                <span class="navbar-toggler-bar burger-lines"></span>
                <span class="navbar-toggler-bar burger-lines"></span>
                <span class="navbar-toggler-bar burger-lines"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nc-icon nc-zoom-split"></i>
                            <span class="d-lg-block">&nbsp;Search</span>
                        </a>
                    </li>
                    <base-dropdown tag="li">
                        <template slot="title">
                            <i class="nc-icon nc-planet"></i>
                            <b class="caret"></b>
                            <span class="notification">5</span>
                        </template>
                        <a class="dropdown-item" href="#">Notification 1</a>
                        <a class="dropdown-item" href="#">Notification 2</a>
                        <a class="dropdown-item" href="#">Notification 3</a>
                        <a class="dropdown-item" href="#">Notification 4</a>
                        <a class="dropdown-item" href="#">Another notification</a>
                    </base-dropdown>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <base-dropdown :title="auth.user.full_name">
                        <a class="dropdown-item" href="/user">Thông tin</a>
                        <div class="divider"></div>
                        <a class="dropdown-item" href="#" @click="logout()">Log out</a>
                    </base-dropdown>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
    import {mapGetters} from "vuex";

    export default {
        computed: {
            routeName() {
                const {name} = this.$route
                return this.capitalizeFirstLetter(name)
            }
        },
        computed:{
            ...mapGetters(['auth'])
        },
        data() {
            return {
                activeNotifications: false
            }
        },
        methods: {
            capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1)
            },
            toggleNotificationDropDown() {
                this.activeNotifications = !this.activeNotifications
            },
            closeDropDown() {
                this.activeNotifications = false
            },
            toggleSidebar() {
                this.$sidebar.displaySidebar(!this.$sidebar.showSidebar)
            },
            hideSidebar() {
                this.$sidebar.displaySidebar(false)
            },
            logout(){
                this.$store.dispatch('logout')
            }
        },
        mounted() {
            var self = this;
        }
    }

</script>
<style>

</style>
