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
                            <h4 class="card-title">Quản lý hình thức đầu tư</h4>
                            <p class="card-category">Danh sách tổng số {{numberStartDataPage}} / {{numberTotalDataPage}} người dùng</p>
                        </template>
                        <l-table class="table-hover table-striped"
                            :columns="columns"
                            :data="listInvestType.data"
                            :form="'InvestTypeInput'"
                            :formName="'HÌNH THỨC ĐẦU TƯ'"
                            :model="'invest-type'"
                            :onLoading="onLoading"
                            :offLoading="offLoading"
                        >
                            <div slot-scope="{itemid}" class="d-flex flex-row">
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger"  v-bind:id="'constact-input-'+itemid" v-b-modal="'modal-constact-input-'+itemid">Trường nhập</b-button>
                                <b-button
                                    class="ml-lg-3 bg-danger text-white border-0"
                                    variant="danger"
                                    v-bind:id="'list-constact-template-'+itemid"
                                    v-b-modal="'modal-list-constact-template-'+itemid"
                                >
                                    Danh sách hợp đồng
                                </b-button>
                            </div>
                        </l-table>
                        <div class="d-flex justify-content-center" v-if="totalPage > 1">
                            <b-button-group>
                                <b-button v-bind:href="currentUrl.links[0].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) - 1)">‹</b-button>
                                <b-button
                                    v-for="(item, index) in currentUrl.links.length - 1"
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

                        <b-modal hide-footer v-bind:id="'modal-constact-input-'+item.id" v-for="(item, index) in listInvestType.data" :key="'constact-input-'+index" size="xl" v-bind:title="'Trường nhập số '+item.id" >
                            <div
                                class="my-4"
                                is="ContractHasInputFieldInput"
                                :item="item"
                                v-bind:modalName="'constact-input-'+item.id"
                                :contract-id="item.id"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            >
                                Edit {{item.id}}
                            </div>
                        </b-modal>

                        <b-modal
                            hide-footer
                            v-bind:id="'modal-list-constact-template-'+item.id"
                            v-for="(item, index) in listInvestType.data"
                            :key="'list-constact-template-'+index"
                            size="xl"
                            v-bind:title="'Truong nhap '+item.id"
                        >
                            <div
                                class="my-4"
                                is="ListContractTemplate"
                                v-bind:modalName="'list-constact-template-'+item.id"
                                :invest-type-id="item.id"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                            >
                                Edit {{item.id}}
                            </div>
                        </b-modal>
                        <b-button variant="primary" @click="$router.push('/contract-input-field')" class="bg-primary ml-3 text-white">DANH SÁCH TRƯỜNG NHẬP CÓ SẴN</b-button>
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
        name: "ListInvestType",
        components: {
            LTable,
            Card,
            DotSpaceProgress
        },
        data() {
            return {
                isLoading: false,
                'columns': {
                    "id": "ID",
                    "lang_name.vi": "Tên hình thức đầu tư",
                    "lang_short_description.vi": "Mô tả ngắn",
                },
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
            };
        },
        computed: {
            ...mapGetters(['listInvestType', 'auth', 'currentUrl'])
        },
        mounted() {
            var self = this;
            let page = self.$route.query.page;
            self.onLoading();

            if (page === undefined) {
                self.getInvestType();
            } else {
                self.$store.dispatch('getInvestTypeByPage', page)
                .then((res) => {
                    if (res.data.data.length === 0) {
                        self.$router.push({path: '/user-info'}).then(r => {});
                        self.getInvestType();
                    } else {
                        self.offLoading();
                        self.numberStartDataPage = self.listInvestType.to;
                        self.numberTotalDataPage = self.listInvestType.total;
                        self.totalPage = res.data.last_page;
                    }
                });
            }
        },
        destroyed() {
            this.$store.commit("setlistInvestType", {});
        },
        methods: {
            getInvestType() {
                var self = this;

                self.$store.dispatch('getAllInvestType')
                .then((res) => {
                    self.numberStartDataPage = self.listInvestType.to;
                    self.numberTotalDataPage = self.listInvestType.total;
                    self.totalPage = res.data.last_page;

                    self.$store.commit("setCurrentUrl", {
                        links: res.data.links,
                        current_page: res.data.current_page,
                        page: res.data.page,
                    });
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

<style scoped>

</style>
