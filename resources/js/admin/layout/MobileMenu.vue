<template>
    <ul class="nav nav-mobile-menu">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nc-icon nc-zoom-split hidden-lg-up"></i>
                <span class="d-lg-none">Search</span>
            </a>
        </li>
        <base-dropdown>
            <template slot="title">
                <i class="fa fa-globe"></i>
                <b class="caret"></b>
                <span class="notification">5 Notifications</span>
            </template>
            <a class="dropdown-item" href="#">Notification 1</a>
            <a class="dropdown-item" href="#">Notification 2</a>
            <a class="dropdown-item" href="#">Notification 3</a>
            <a class="dropdown-item" href="#">Notification 4</a>
            <a class="dropdown-item" href="#">Another notification</a>
        </base-dropdown>
        <base-dropdown :title="auth.user.full_name">
            <a class="dropdown-item" href="/user">Thông tin</a>
            <div class="divider"></div>
            <a class="dropdown-item" href="#" @click="logout()">Log out</a>
        </base-dropdown>
    </ul>
</template>
<script>
    import {mapGetters} from "vuex"

    export default {
        name: 'mobile-menu',
        computed:{
            ...mapGetters(['auth'])
        },
        methods: {
            logout(){
                this.$store.dispatch('logout')
            }
        },
    }
</script>
<style>
</style>
