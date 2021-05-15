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
                            <!-- <div class="filter-data pull-right">
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
                            </div> -->
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
                            <b-button-group>
                                <b-button v-bind:href="currentUrl.links[0].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) - 1)">‹</b-button>
                                <div>
                                    <b-button
                                        v-for="(item, index) in currentUrl.links.length - 1"
                                        v-bind:key="index"
                                        v-bind:href="
                                            '?page=' + ((currentUrl.links[index].label !== '...') ? currentUrl.links[index].label : currentUrl.links[index-1].label + 1)
                                        "
                                        v-bind:class="{ 'active-paginate': currentUrl.links[index].active }"
                                        v-if="index !== 0"
                                    >
                                        {{currentUrl.links[index].label}}
                                    </b-button>
                                </div>
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
        name: 'ListOrder',
        components: {
            LTable,
            Card,
            DotSpaceProgress
        },
        data() {
            return {
                domain: domain,
                invest_id: '',
                'columns': {
                    "id": "ID",
                    "company_invest.lang_name.vi": "Dự án",
                    "user.full_name": "Tên nhà đầu tư",
                    "amount": "Số tiền đầu tư",
                    "pay_method": "Hình thức thanh toán",
                    "pay_status": "Trạng thái thanh toán",
                    "created_at": "Ngày đầu tư",
                },
                isLoading: false,
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
            };
        },
        computed: {
            ...mapGetters(['auth', 'currentUrl', 'listOrder'])
        },
        mounted() {
            var self = this;
            let page = self.$route.query.page;
            self.onLoading();

            if (page === undefined) {
                self.getAllOrder(self);
            } else {
                self.getAllOrderByPage(self, page);
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
            }
        }
    }
</script>
