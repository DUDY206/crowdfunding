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
                            <h4 class="card-title">Quản lý dự án</h4>
                            <p class="card-category">Danh sách tổng số {{numberStartDataPage}} / {{numberTotalDataPage}} dự án</p>
                            <SearchList
                                :isCheckSearch="isCheckSearch"
                                :onChangeFilter="onChangeFilter"
                                :keySearch="keySearch"
                                :isCheckFilterBtnSearch="isCheckFilterBtnSearch"
                                :search="search"
                                :placeholderName="'Nhập tên dự án'"
                                :routeMain="routeMain"
                                :routeMainNotSlash="routeMainNotSlash"
                            />
                        </template>
                        <l-table class="table-hover table-striped"
                            :columns="columns"
                            :data="listCompanyInvest.data"
                            :form="'CompanyInvestInput'"
                            :formName="'DỰ ÁN ĐẦU TƯ'"
                            :model="'company-invest'"
                            :onLoading="onLoading"
                            :offLoading="offLoading"
                        >
                            <div slot-scope="{itemid}" class="d-flex flex-row">
                                <!-- <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="itemid" v-b-modal="'modal-cpi-'+itemid">FAQ/Risks</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="'invest-type'+itemid" v-b-modal="'modal-investype-'+itemid">Hình thức đầu tư</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="'invest-contract-field'+itemid" v-b-modal="'modal-invest-contract-field-'+itemid">Thông tin hợp đồng</b-button> -->
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-b-modal="'modal-option-' + itemid" @click="showInvest(itemid)">Tùy chọn</b-button>
                            </div>
                        </l-table>

                        <b-modal hide-footer v-bind:id="'modal-option-' + item.id" v-for="(item, index) in listCompanyInvest.data" :key="'option-' + index" size="xl" v-bind:title="'Tùy chọn dự án số ' + item.id">
                            <div class="d-flex flex-row">
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="item.id" v-b-modal="'modal-cpi-' + item.id">FAQ/Risks</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="'invest-type' + item.id" v-b-modal="'modal-investype-' + item.id">Hình thức đầu tư</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="'invest-contract-field' + item.id" v-b-modal="'modal-invest-contract-field-' + item.id">Thông tin hợp đồng</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" @click="$router.push('/news/' + item.id)">Tin tức</b-button>
                            </div>
                        </b-modal>

                        <b-modal hide-footer v-bind:id="'modal-cpi-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'cpi-'+index" size="xl" v-bind:title="'FAQ/Risk dự án số ' + item.id" >
                            <div
                                class="my-4"
                                is="CompanyInvestFAQInput"
                                :item="invest"
                                :isAdd="false"
                                v-bind:modalName="'modal-faq-'+item.id"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            >
                                Edit {{item.id}}
                            </div>
                        </b-modal>

                        <b-modal hide-footer v-bind:id="'modal-investype-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'investtype-'+index" size="xl" v-bind:title="'Hình thức đầu tư dự án số ' + item.id" >
                            <div
                                class="my-4"
                                is="InvestTypeField"
                                :invest-id="invest.id"
                                v-bind:modalName="'modal-investype-'+item.id"
                                :array-invest-type="invest.array_invest_type"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            ></div>
                        </b-modal>

                        <b-modal hide-footer v-bind:id="'modal-invest-contract-field-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'invest-contract-field-'+index" size="xl" v-bind:title="'Thông tin hợp đồng dự án số ' + item.id" >
                            <div
                                class="my-4"
                                is="InvestCompanyFieldInput"
                                :item-id="invest.id"
                                v-bind:modalName="'modal-invest-contract-field-'+item.id"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            ></div>
                        </b-modal>

                        <!-- <b-modal hide-footer v-bind:id="'modal-invest-news-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'invest-news-'+index" size="xl" v-bind:title="'Tin tức dự án số ' + item.id" >
                            <div
                                class="my-4"
                                is="CompanyInvestNewsInput"
                                :item-id="item.id"
                                v-bind:modalName="'modal-invest-news-' + item.id"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            ></div>
                        </b-modal> -->

                        <div class="d-flex justify-content-center" v-if="totalPage > 1">
                            <PaginateList
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                                :dataList="'setListCompanyInvest'"
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
        name: "ListCompanyInvest",
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
                'columns': {
                    "id":"ID",
                    "lang_name.vi":"Tên dự án",
                    "lang_short_description.vi":"Mô tả ngắn",
                    "company.lang_name.vi":"Tên công ty",
                },
                isLoading: false,
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
                isCheckSearch: false,
                keySearch: '',
                isCheckFilterBtnSearch: false,
                invest: {},
                routeMain: '/company-invest',
                routeMainNotSlash: 'company-invest',
            };
        },
        computed: {
            ...mapGetters(['listCompanyInvest', 'auth', 'currentUrl'])
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
                    self.getCompanyInvest();
                } else {
                    self.getCompanyInvestByPage(page);
                }
            } else {
                self.keySearch = self.$route.query.keySearch;
                self.isCheckSearch = true;

                if (self.keySearch.length >=4) {
                    self.isCheckFilterBtnSearch = true;
                } else {
                    self.isCheckFilterBtnSearch = false;
                }

                if (page === undefined) {
                    self.$store.dispatch('searchCompanyInvest', self.keySearch)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listCompanyInvest.to;
                        self.numberTotalDataPage = self.listCompanyInvest.total;
                        self.totalPage = res.data.last_page;
                    })
                } else {
                    let params = {
                        key: self.keySearch,
                        page: page,
                    };

                    self.$store.dispatch('searchCompanyInvestByPaginate', params)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listCompanyInvest.to;
                        self.numberTotalDataPage = self.listCompanyInvest.total;
                        self.totalPage = res.data.last_page;
                    })
                }
            }
        },
        destroyed() {
            this.$store.commit("setListCompanyInvest", {});
        },
        methods: {
            setPaginagte(res) {
                var self = this;

                self.numberStartDataPage = self.listCompanyInvest.to;
                self.numberTotalDataPage = self.listCompanyInvest.total;
                self.totalPage = res.data.last_page;
            },
            getCompanyInvest() {
                var self = this;

                self.$store.dispatch('getAllCompanyInvest')
                .then((res) => {
                    self.offLoading();
                    self.setPaginagte(res);
                })
            },
            getCompanyInvestByPage(page) {
                var self = this;

                self.$store.dispatch('getAllCompanyInvestByPage', page)
                .then((res) => {
                    if (res.data.data.length === 0) {
                        self.$router.push({path: '/company-invest'}).then(r => {});
                        self.getCompanyInvest();
                    } else {
                        self.offLoading();
                        self.setPaginagte(res);
                    }
                });
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

                self.$store.dispatch('searchCompanyInvest', self.keySearch)
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
            showInvest(id) {
                var self = this;
                self.onLoading();

                self.$store.dispatch('showCompanyInvest', id)
                .then((res) => {
                    self.invest = res.data;
                    self.offLoading();
                })
                .catch((err) => {
                    self.$toast.error('Vui lòng thử lại');
                    self.offLoading();
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
