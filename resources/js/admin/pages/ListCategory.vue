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
                            <h4 class="card-title">Quản lý thể loại ngành</h4>
                            <p class="card-category">Danh sách tổng số {{numberStartDataPage}} / {{numberTotalDataPage}} thể loại ngành</p>
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
                            :data="listCategory.data"
                            :form="'CategoryInput'"
                            :formName="'THỂ LOẠI NGÀNH'"
                            :model="'category'"
                            :onLoading="onLoading"
                            :offLoading="offLoading"
                        >
                            <div slot-scope="{itemid}" class="d-flex flex-row">
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-b-modal="'modal-option-' + itemid">Tùy chọn</b-button>
                            </div>
                        </l-table>

                        <b-modal hide-footer v-bind:id="'modal-option-' + item.id" v-for="(item, index) in listCategory.data" :key="'option-' + index" size="xl" v-bind:title="'Tùy chọn ngành số ' + item.id">
                            <div class="d-flex flex-row">
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger">Thêm dự án cho ngành</b-button>
                            </div>
                        </b-modal>

                        <div class="d-flex justify-content-center" v-if="listCategory.last_page > 1">
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
        name: 'ListCategory',
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
                    "lang_name.vi": "Tên thể loại ngành",
                    "lang_description.vi": "Mô tả ngắn",
                },
                isLoading: false,
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
            };
        },
        computed: {
            ...mapGetters(['auth', 'currentUrl', 'listCategory'])
        },
        mounted() {
            var self = this;
            var investId = self.$route.params.investId;
            let page = self.$route.query.page;
            self.onLoading();

            if (page === undefined) {
                self.getAllCategory();
            } else {
                self.getAllCategoryByPage(page);
            }
        },
        methods: {
            setPaginagte(res) {
                this.numberStartDataPage = this.listCategory.to;
                this.numberTotalDataPage = this.listCategory.total;
                this.totalPage = res.data.last_page;
            },
            getAllCategory() {
                var self = this;

                self.$store.dispatch('getAllCategory')
                .then((res) => {
                    self.setPaginagte(res);
                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            },
            getAllCategoryByPage(page) {
                var self = this;

                self.$store.dispatch('getAllCategoryByPage', page)
                .then((res) => {
                    if (res.data.data.length === 0) {
                        self.$router.push({path: '/news'}).then(r => {});
                        self.getAllCategory();
                    } else {
                        self.setPaginagte(res);
                        self.offLoading();
                    }
                })
                .catch((err) => {
                    console.log(err);
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
