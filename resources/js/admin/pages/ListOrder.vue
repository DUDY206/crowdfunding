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
                    <card class="strpied-tabled-with-hover" body-classes="table-full-width table-responsive">
                        <template slot="header">
                            <h4 class="card-title">Quản lý thanh toán</h4>
                            <p class="card-category">Danh sách tổng số {{numberStartDataPage}} / {{numberTotalDataPage}} số đầu</p>
                            <SearchList
                                :isCheckSearch="isCheckSearch"
                                :onChangeFilter="onChangeFilter"
                                :keySearch="keySearch"
                                :isCheckFilterBtnSearch="isCheckFilterBtnSearch"
                                :search="search"
                                :placeholderName="'Nhập tên nhà đầu tư'"
                                :routeMain="routeMain"
                                :routeMainNotSlash="routeMainNotSlash"
                            />
                        </template>
                        <l-table class="table-hover table-striped"
                            :columns="columns"
                            :data="listOrder.data"
                            :form="'OrderInput'"
                            :formName="'THANH TOÁN'"
                            :model="'order'"
                            :onLoading="onLoading"
                            :offLoading="offLoading"
                            updateData="updateData"
                        >
                        </l-table>

                        <div class="d-flex justify-content-center" v-if="listOrder.last_page > 1">
                            <PaginateList
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                                :dataList="'setListOrder'"
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
        name: 'ListOrder',
        components: {
            LTable,
            Card,
            DotSpaceProgress,
            SearchList,
            PaginateList,
        },
        data() {
            return {
                domain: domain,
                invest_id: '',
                'columns': {
                    "id": "ID",
                    "company_invest.lang_name.vi": "Dự án",
                    "user.full_name": "Tên nhà đầu tư",
                    "pay_method": "Hình thức thanh toán",
                    "pay_status": "Trạng thái thanh toán",
                    "created_at": "Ngày đầu tư",
                },
                isLoading: false,
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
                keySearch: '',
                isCheckFilterBtnSearch: false,
                isCheckSearch: false,
                routeMain: '/orders',
                routeMainNotSlash: 'orders',
            };
        },
        computed: {
            ...mapGetters(['auth', 'currentUrl', 'listOrder'])
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
                    self.getAllOrder(self);
                } else {
                    self.getAllOrderByPage(self, page);
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
                    self.$store.dispatch('searchOrder', self.keySearch)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listOrder.to;
                        self.numberTotalDataPage = self.listOrder.total;
                        self.totalPage = res.data.last_page;
                    })
                } else {
                    let params = {
                        key: self.keySearch,
                        page: page,
                    };

                    self.$store.dispatch('searchOrderByPaginate', params)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listOrder.to;
                        self.numberTotalDataPage = self.listOrder.total;
                        self.totalPage = res.data.last_page;
                    })
                }
            }
        },
        destroyed() {
            this.$store.commit("setListOrder", {});
        },
        methods: {
            setPaginagte(self, data) {
                self.numberStartDataPage = data.to;
                self.numberTotalDataPage = data.total;
                self.totalPage = data.last_page;
            },
            getAllOrder(self) {
                self.$store.dispatch('getAllOrder')
                .then((res) => {
                    self.setPaginagte(self, res.data);
                    self.offLoading();
                })
                .catch((err) => {
                    self.offLoading();
                })
            },
            getAllOrderByPage(self, page) {
                self.$store.dispatch('getAllOrderByPage', page)
                .then((res) => {
                    if (res.data.data.length === 0) {
                        self.$router.push({path: '/orders'}).then(r => {});
                        self.getAllOrder(self);
                    } else {
                        self.offLoading();
                        self.setPaginagte(self, res.data);
                    }
                })
                .catch((err) => {
                    self.offLoading();
                })
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

                self.$store.dispatch('searchOrder', self.keySearch)
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
