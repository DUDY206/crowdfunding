<template>
    <div class="wrapper">
        <side-bar>
            <mobile-menu slot="content"></mobile-menu>
<!--            <sidebar-link to="/overview">-->
<!--                <i class="nc-icon nc-chart-pie-35"></i>-->
<!--                <p>Dashboard</p>-->
<!--            </sidebar-link>-->
            <sidebar-link to="/user">
                <i class="nc-icon nc-circle-09"></i>
                <p>User Profile</p>
            </sidebar-link>
<!--            <sidebar-link to="/table-list">-->
<!--                <i class="nc-icon nc-notes"></i>-->
<!--                <p>Table list</p>-->
<!--            </sidebar-link>-->
<!--            <sidebar-link to="/typography">-->
<!--                <i class="nc-icon nc-paper-2"></i>-->
<!--                <p>Typography</p>-->
<!--            </sidebar-link>-->
<!--            <sidebar-link to="/icons">-->
<!--                <i class="nc-icon nc-atom"></i>-->
<!--                <p>Icons</p>-->
<!--            </sidebar-link>-->
<!--            <sidebar-link to="/maps">-->
<!--                <i class="nc-icon nc-pin-3"></i>-->
<!--                <p>Maps</p>-->
<!--            </sidebar-link>-->
<!--            <sidebar-link to="/notifications">-->
<!--                <i class="nc-icon nc-bell-55"></i>-->
<!--                <p>Notifications</p>-->
<!--            </sidebar-link>-->
            <sidebar-link to="/all-company">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lí công ty</p>
            </sidebar-link>
            <sidebar-link to="/company-invest">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lý dự án</p>
            </sidebar-link>
            <sidebar-link to="/manage-admin">
                <i class="nc-icon nc-bell-55"></i>
                <p>Danh sách admin</p>
            </sidebar-link>
            <sidebar-link to="/user-info">
                <i class="nc-icon nc-bell-55"></i>
                <p>Danh sách người dùng</p>
            </sidebar-link>
            <sidebar-link to="/invest-type">
                <i class="nc-icon nc-bell-55"></i>
                <p>Hình thức đầu tư</p>
            </sidebar-link>

            <template slot="bottom-links">
                <sidebar-link class="active"
                              to="/admin/upgrade">
                    <i class="nc-icon nc-alien-33"></i>
                    <p>Upgrade to PRO</p>
                </sidebar-link>
            </template>
        </side-bar>
        <div class="main-panel">
            <top-navbar></top-navbar>

            <dashboard-content @click="toggleSidebar">

            </dashboard-content>

            <content-footer></content-footer>
        </div>
    </div>
</template>
<style lang="scss">

</style>
<script>
    import TopNavbar from './TopNavbar.vue'
    import ContentFooter from './ContentFooter.vue'
    import DashboardContent from './Content.vue'
    import MobileMenu from './MobileMenu.vue'
    import router from '../routes/index'
    import {mapGetters} from "vuex";

    export default {
        components: {
            TopNavbar,
            ContentFooter,
            DashboardContent,
            MobileMenu
        },
        methods: {
            toggleSidebar() {
                if (this.$sidebar.showSidebar) {
                    this.$sidebar.displaySidebar(false)
                }
            }
        },
        computed: {
            ...mapGetters(['auth'])
        },
        mounted() {
            if (this.auth.token == null) {
                router.push({path: '/login'}).then(r => {
                });
            }
        }
    }

</script>
