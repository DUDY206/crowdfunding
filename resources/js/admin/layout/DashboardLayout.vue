<template>
    <div class="wrapper">
        <side-bar>
            <mobile-menu slot="content"></mobile-menu>
            <!-- <sidebar-link to="/overview">
                <i class="nc-icon nc-chart-pie-35"></i>
                <p>Dashboard</p>
            </sidebar-link>
            <sidebar-link to="/table-list">
                <i class="nc-icon nc-notes"></i>
                <p>Table list</p>
            </sidebar-link>
            <sidebar-link to="/typography">
                <i class="nc-icon nc-paper-2"></i>
                <p>Typography</p>
            </sidebar-link>
            <sidebar-link to="/icons">
                <i class="nc-icon nc-atom"></i>
                <p>Icons</p>
            </sidebar-link>
            <sidebar-link to="/maps">
                <i class="nc-icon nc-pin-3"></i>
                <p>Maps</p>
            </sidebar-link>
            <sidebar-link to="/notifications">
                <i class="nc-icon nc-bell-55"></i>
                <p>Notifications</p>
            </sidebar-link> -->
            <sidebar-link to="/user">
                <i class="nc-icon nc-circle-09"></i>
                <p>Thông tin cá nhân</p>
            </sidebar-link>
            <sidebar-link to="/manage-admin">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lý quản trị</p>
            </sidebar-link>
            <sidebar-link to="/user-info">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lý người dùng</p>
            </sidebar-link>
            <sidebar-link to="/all-company">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lí công ty</p>
            </sidebar-link>
            <sidebar-link to="/category">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lý thể loại ngành</p>
            </sidebar-link>
            <sidebar-link to="/company-invest">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lý dự án</p>
            </sidebar-link>
            <sidebar-link to="/invest-type">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lý hình thức đầu tư</p>
            </sidebar-link>
            <sidebar-link to="/orders">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lý thanh toán</p>
            </sidebar-link>
            <sidebar-link to="/news">
                <i class="nc-icon nc-bell-55"></i>
                <p>Quản lý tin tức</p>
            </sidebar-link>
        </side-bar>
        <div class="main-panel" v-bind:class="{'overflow-hidden' : isLoading}">
            <div class="logout-loading" v-if="isLoading">
                <flash-dot-progress></flash-dot-progress>
            </div>
            <top-navbar
                :onLoading="onLoading"
                :offLoading="offLoading"
            ></top-navbar>

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
    import FlashDotProgress from '../../commons/FlashDotProgress';

    export default {
        components: {
            TopNavbar,
            ContentFooter,
            DashboardContent,
            MobileMenu,
            FlashDotProgress
        },
        computed: {
            ...mapGetters(['auth'])
        },
        data() {
            return {
                isLoading: false,
            }
        },
        methods: {
            toggleSidebar() {
                if (this.$sidebar.showSidebar) {
                    this.$sidebar.displaySidebar(false)
                }
            },
            onLoading() {
                this.isLoading = true;
            },
            offLoading() {
                this.isLoading = false;
            }
        },
        mounted() {
            if (this.auth.token == null) {
                router.push({path: '/login'}).then(r => {
                });
            }
        }
    }
</script>

<style scoped lang="scss">
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
