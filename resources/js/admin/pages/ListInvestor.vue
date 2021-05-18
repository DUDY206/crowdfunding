<template>
    <div class="content">
        <div class="loading-page" v-if="isLoading">
            <div class="overlay-load">
                <dot-space-progress></dot-space-progress>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <card class="strpied-tabled-with-hover"
                          body-classes="table-full-width table-responsive"
                    >
                        <template slot="header">
                            <h4 class="card-title">Quản lý người dùng</h4>
                            <p class="card-category">Danh sách tổng số {{numberStartDataPage}} / {{numberTotalDataPage}} người dùng</p>
                        </template>
                        <l-table class="table-hover table-striped"
                            :columns="columns"
                            :data="listInvestor.data"
                            :form="'InvestorInput'"
                            :formName="'NGƯỜI DÙNG'"
                            :model="'user-info'"
                            :onLoading="onLoading"
                            :offLoading="offLoading"
                        >
                        </l-table>
                        <div class="d-flex justify-content-center" v-if="totalPage > 1">
                            <b-button-group>
                                <b-button v-bind:href="currentUrl.links[0].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) - 1)">‹</b-button>
                                <b-button
                                    v-for="(item,index) in currentUrl.links.length - 1"
                                    v-if="index!==0"
                                    v-bind:key="index"
                                    v-bind:href="'?page='+currentUrl.links[index].url.split('=')[1]"
                                    v-bind:class="{ 'active-paginate': currentUrl.links[index].active }"
                                >
                                    {{currentUrl.links[index].label}}
                                </b-button>
                                <b-button v-bind:href="currentUrl.links[currentUrl.links.length-1].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) + 1)">›</b-button>
                            </b-button-group>
                        </div>
                    </card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LTable from "../components/Table";
    import Card from "../components/Cards/Card";
    import {mapGetters} from "vuex";
    import DotSpaceProgress from "../../commons/DotSpaceProgress";

    export default {
        name: "ListInvestor",
        components: {
            LTable,
            Card,
            DotSpaceProgress
        },
        data(){
            return {
                isLoading: false,
                'columns':{
                    "id":"ID",
                    "user_name":"User name",
                    "full_name":"Họ tên",
                    // "password":"Mật khẩu",
                    "email":"Email",
                    "phone_number":"Số điện thoại",
                },
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
            };
        },
        computed:{
            ...mapGetters(['listInvestor', 'auth', 'currentUrl'])
        },
        mounted() {
            var self = this;
            let page = self.$route.query.page;
            self.onLoading();

            if (page === undefined) {
                self.getInvestor();
            } else {
                self.$store.dispatch('getInvestorByPage', page)
                .then((res) => {
                    if (res.data.data.length === 0) {
                        self.$router.push({path: '/user-info'}).then(r => {});
                        self.getInvestor();
                    } else {
                        self.offLoading();
                        self.numberStartDataPage = self.listInvestor.to;
                        self.numberTotalDataPage = self.listInvestor.total;
                        self.totalPage = res.data.last_page;
                    }
                });
            }
        },
        destroyed() {
            this.$store.commit("setlistInvestor", {});
        },
        methods: {
            getInvestor() {
                var self = this;

                self.$store.dispatch('getAllInvestor')
                .then((res) => {
                    self.offLoading();
                    self.numberStartDataPage = self.listInvestor.to;
                    self.numberTotalDataPage = self.listInvestor.total;
                    self.totalPage = res.data.last_page;
                });
            },
            onLoading() {
                var self = this;
                self.isLoading = true;
            },
            offLoading() {
                var self = this;
                self.isLoading = false;
            }
        }
    }
</script>
