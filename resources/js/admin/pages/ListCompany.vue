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
                            <h4 class="card-title">Quản lý công ty</h4>
                            <p class="card-category">Danh sách tổng số {{numberStartDataPage}} / {{numberTotalDataPage}} công ty</p>
                            <SearchList
                                :isCheckSearch="isCheckSearch"
                                :onChangeFilter="onChangeFilter"
                                :keySearch="keySearch"
                                :isCheckFilterBtnSearch="isCheckFilterBtnSearch"
                                :search="search"
                                :placeholderName="'Nhập tên công ty'"
                                :routeMain="routeMain"
                                :routeMainNotSlash="routeMainNotSlash"
                            />
                        </template>
                        <l-table class="table-hover table-striped"
                            :columns="columns"
                            :data="listCompany.data"
                            :form="'CompanyInput'"
                            :formName="'CÔNG TY'"
                            :model="'company'"
                            :onLoading="onLoading"
                            :offLoading="offLoading"
                        >
                        </l-table>
                        <div class="d-flex justify-content-center" v-if="totalPage > 1">
                            <PaginateList
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                                :dataList="'setListCompany'"
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
    import {mapGetters} from "vuex";
    import LTable from '../components/Table.vue';
    import Card from "../components/Cards/Card";
    import DotSpaceProgress from "../../commons/DotSpaceProgress";
    import SearchList from "../components/Search/SearchList";
    import PaginateList from "../components/Paginate/PaginateList";
    import env from "../../env";
    const domain = env.ADMIN_DOMAIN;

    export default {
        name: "ListCompany",
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
                'columns': {
                    "id": "ID",
                    "lang_name.vi": "Tên công ty",
                    "lang_description.vi": "Mô tả",
                    "lang_company_type.vi": "Loại công ty",
                    "owner.full_name": "Người sở hữu",
                },
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
                keySearch: '',
                isCheckFilterBtnSearch: false,
                isCheckSearch: false,
                routeMain: '/all-company',
                routeMainNotSlash: 'all-company',
            };
        },
        computed: {
            ...mapGetters(['listCompany', 'auth', 'currentUrl'])
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
                    self.getCompany();
                } else {
                    self.$store.dispatch('getCompanyByPage', page)
                    .then((res) => {
                        if (res.data.data.length === 0) {
                            self.$router.push({path: '/all-company'}).then(r => {});
                            self.getCompany();
                        } else {
                            self.offLoading();
                            self.numberStartDataPage = self.listCompany.to;
                            self.numberTotalDataPage = self.listCompany.total;
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
                    self.$store.dispatch('searchCompany', self.keySearch)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listCompany.to;
                        self.numberTotalDataPage = self.listCompany.total;
                        self.totalPage = res.data.last_page;
                    })
                } else {
                    let params = {
                        key: self.keySearch,
                        page: page,
                    };

                    self.$store.dispatch('searchCompanyByPaginate', params)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listCompany.to;
                        self.numberTotalDataPage = self.listCompany.total;
                        self.totalPage = res.data.last_page;
                    })
                }
            }
        },
        destroyed() {
            this.$store.commit("setListCompany", {});
        },
        methods: {
            getCompany() {
                var self = this;

                self.$store.dispatch('getAllCompany')
                .then((res) => {
                    self.offLoading();
                    self.numberStartDataPage = self.listCompany.to;
                    self.numberTotalDataPage = self.listCompany.total;
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

                self.$store.dispatch('searchCompany', self.keySearch)
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
