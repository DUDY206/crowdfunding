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
                            <div class="filter-data pull-right">
                                <div class="filter-input mg-right-10 br-red">
                                    <a v-if="isCheckSearch" @click="refreshList" class="pointer">
                                        Làm mới
                                    </a>
                                </div>
                                <input type="text" v-on:keyup="onChangeFilter" v-model="keySearch" placeholder="Nhập tên dự án" />
                                <div class="filter-input mg-left-10">
                                    <a v-if="isCheckFilterBtnSearch" @click="searchCompanyInvest" class="pointer">Tìm kiếm</a>
                                    <a v-else class="none-filter not-allow-pointer">Tìm kiếm</a>
                                </div>
                            </div>
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
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="itemid" v-b-modal="'modal-cpi-'+itemid">FAQ/Risks</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger"  v-bind:id="'invest-type'+itemid" v-b-modal="'modal-investype-'+itemid">Hình thức đầu tư</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger"  v-bind:id="'invest-contract-field'+itemid" v-b-modal="'modal-invest-contract-field-'+itemid">Thông tin hợp đồng</b-button>
                            </div>
                        </l-table>
                        <b-modal hide-footer v-bind:id="'modal-cpi-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'cpi-'+index" size="xl" v-bind:title="'FAQ/Risk '+item.id" >
                            <div
                                class="my-4"
                                is="CompanyInvestFAQInput"
                                :item="item"
                                :isAdd="false"
                                v-bind:modalName="'modal-faq-'+item.id"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            >
                                Edit {{item.id}}
                            </div>
                        </b-modal>

                        <b-modal hide-footer v-bind:id="'modal-investype-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'investtype-'+index" size="xl" v-bind:title="'Danh sách hình thức đầu tư '+item.id" >
                            <div
                                class="my-4"
                                is="InvestTypeField"
                                :invest-id="item.id"
                                v-bind:modalName="'modal-investype-'+item.id"
                                :array-invest-type="item.array_invest_type"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            ></div>
                        </b-modal>

                        <b-modal hide-footer v-bind:id="'modal-invest-contract-field-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'invest-contract-field-'+index" size="xl" v-bind:title="'Thông tin hợp đồng DA '+item.id" >
                            <div
                                class="my-4"
                                is="InvestCompanyFieldInput"
                                :item-id="item.id"
                                v-bind:modalName="'modal-invest-contract-field-'+item.id"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            ></div>
                        </b-modal>

                        <div class="d-flex justify-content-center" v-if="totalPage > 1">
                            <b-button-group>
                                <b-button v-bind:href="currentUrl.links[0].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) - 1)">‹</b-button>
                                <b-button
                                    v-for="(item, index) in currentUrl.links.length - 1"
                                    v-bind:key="index"
                                    v-if="index !== 0"
                                    v-bind:href="'?page=' + currentUrl.links[index].url.split('=')[1]"
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
    import env from "../../env";
    const domain = env.ADMIN_DOMAIN;

    export default {
        name: "ListCompanyInvest",
        components: {
            LTable,
            Card,
            DotSpaceProgress
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
            };
        },
        computed: {
            ...mapGetters(['listCompanyInvest', 'auth', 'currentUrl'])
        },
        mounted() {
            var self = this;
            let page = self.$route.query.page;
            self.onLoading();

            if (page === undefined) {
                self.getCompanyInvest();
            } else {
                self.getCompanyInvestByPage(page);
            }
        },
        methods: {
            navigatePage(uri) {
                this.$store.dispatch('getCompanyByPage', uri)
            },
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
            refreshList(e) {
                e.preventDefault();
                var self = this;
                self.onLoading();
                self.isCheckSearch = false;
                self.keySearch = '';
                self.getCompanyInvest();
            },
            onChangeFilter() {
                var self = this;

                if (self.keySearch.length >= 5) {
                    self.isCheckFilterBtnSearch = true;
                } else {
                    self.isCheckFilterBtnSearch = false;
                }
            },
            searchCompanyInvest(e) {
                e.preventDefault();
                var self = this;
                self.onLoading();

                self.$store.dispatch('searchCompanyInvest', self.keySearch)
                .then((res) => {
                    self.offLoading();
                    self.isCheckSearch = true;
                    self.setPaginagte(res);
                })
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
