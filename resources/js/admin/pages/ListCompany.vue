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
                            <b-button-group>
                                <b-button v-bind:href="currentUrl.links[0].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) - 1)">‹</b-button>
                                <b-button
                                    v-for="(item, index) in currentUrl.links.length - 1"
                                    v-if="index !== 0"
                                    v-bind:key="index"
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
    import {mapGetters} from "vuex";
    import LTable from '../components/Table.vue';
    import Card from "../components/Cards/Card";
    import DotSpaceProgress from "../../commons/DotSpaceProgress";

    export default {
        name: "ListCompany",
        components: {
            LTable,
            Card,
            DotSpaceProgress
        },
        data(){
            return {
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
            };
        },
        computed: {
            ...mapGetters(['listCompany', 'auth', 'currentUrl'])
        },
        mounted() {
            var self = this;
            let page = self.$route.query.page;
            self.onLoading();

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
        },
        destroyed() {
            this.$store.commit("setListCompany", {});
        },
        methods:{
            navigatePage(uri) {
                this.$store.dispatch('getCompanyByPage',uri)
            },
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
            }
        }
    }
</script>
