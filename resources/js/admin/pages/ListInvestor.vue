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
                            <SearchList
                                :isCheckSearch="isCheckSearch"
                                :onChangeFilter="onChangeFilter"
                                :keySearch="keySearch"
                                :isCheckFilterBtnSearch="isCheckFilterBtnSearch"
                                :search="search"
                                :placeholderName="'Nhập tên người dùng'"
                                :routeMain="routeMain"
                                :routeMainNotSlash="routeMainNotSlash"
                            />
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
                            <PaginateList
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                                :dataList="'setlistInvestor'"
                                :routeMain="routeMain"
                                :routeMainNotSlash="routeMainNotSlash"
                                :isCheckSearch="isCheckSearch"
                            />
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
    import SearchList from "../components/Search/SearchList";
    import PaginateList from "../components/Paginate/PaginateList";
    import env from "../../env";
    const domain = env.ADMIN_DOMAIN;

    export default {
        name: "ListInvestor",
        components: {
            LTable,
            Card,
            DotSpaceProgress,
            SearchList,
            PaginateList,
        },
        data(){
            return {
                domain: domain,
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
                keySearch: '',
                isCheckFilterBtnSearch: false,
                isCheckSearch: false,
                routeMain: '/user-info',
                routeMainNotSlash: 'user-info',
            };
        },
        computed:{
            ...mapGetters(['listInvestor', 'auth', 'currentUrl'])
        },
        beforeMount() {
            var self = this;

            if (self.$route.query.keySearch !== undefined) {
                self.keySearch = self.$route.query.keySearch;
            }
        },
        mounted() {
            var self = this;
            self.onLoading();
            let page = self.$route.query.page;

            if (self.$route.query.keySearch === undefined) {

                // Xử lý danh sách đang ở chế độ bình thường

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
            } else {

                // Xử lý danh sách đang ở chế độ search

                self.keySearch = self.$route.query.keySearch;
                self.isCheckSearch = true;

                if (self.keySearch.length >=4) {
                    self.isCheckFilterBtnSearch = true;
                } else {
                    self.isCheckFilterBtnSearch = false;
                }

                if (page === undefined) {
                    self.$store.dispatch('searchInvestor', self.keySearch)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listInvestor.to;
                        self.numberTotalDataPage = self.listInvestor.total;
                        self.totalPage = res.data.last_page;
                    })
                } else {
                    let params = {
                        key: self.keySearch,
                        page: page,
                    };

                    self.$store.dispatch('searchInvestorByPaginate', params)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listInvestor.to;
                        self.numberTotalDataPage = self.listInvestor.total;
                        self.totalPage = res.data.last_page;
                    })
                }
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
            },
            onChangeFilter(key) {
                var self = this;
                self.keySearch = key;

                if (self.keySearch.length >= 4) {
                    self.isCheckFilterBtnSearch = true;
                } else {
                    self.isCheckFilterBtnSearch = false;
                }
            },
            search(e) {
                e.preventDefault();
                var self = this;
                self.onLoading();

                self.$store.dispatch('searchInvestor', self.keySearch)
                .then((res) => {
                    self.isCheckSearch = true;
                    self.offLoading();
                })
                .catch((err) => {
                    self.isCheckSearch = false;
                    self.offLoading();
                    self.$toast.error('Đã xảy ra lỗi, vui lòng thử lại');
                })
            },
        }
    }
</script>
