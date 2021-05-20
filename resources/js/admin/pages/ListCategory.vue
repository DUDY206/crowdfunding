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
                            <SearchList
                                :isCheckSearch="isCheckSearch"
                                :onChangeFilter="onChangeFilter"
                                :keySearch="keySearch"
                                :isCheckFilterBtnSearch="isCheckFilterBtnSearch"
                                :search="search"
                                :placeholderName="'Nhập tên thể loại ngành'"
                                :routeMain="routeMain"
                                :routeMainNotSlash="routeMainNotSlash"
                            />
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
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="item.id" v-b-modal="'modal-category-invest-' + item.id">Thêm dự án cho ngành</b-button>
                            </div>
                        </b-modal>

                        <!-- modal thêm dự án vào thể loại -->
                        <b-modal hide-footer v-bind:id="'modal-category-invest-'+item.id" v-for="(item, index) in listCategory.data" :key="'category-invest-'+index" size="xl" v-bind:title="'Thêm dự án vào ngành số ' + item.id" >
                            <div
                                class="my-4"
                                is="CategoryInvestInput"
                                :item-id="item.id"
                                v-bind:modalName="'modal-category-invest-'+item.id"
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                                :item="item"
                            ></div>
                        </b-modal>

                        <div class="d-flex justify-content-center" v-if="listCategory.last_page > 1">
                            <PaginateList
                                :onLoading="onLoading"
                                :offLoading="offLoading"
                                :dataList="'setListCategory'"
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
        name: 'ListCategory',
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
                    "lang_name.vi": "Tên thể loại ngành",
                    "lang_description.vi": "Mô tả ngắn",
                },
                isLoading: false,
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
                keySearch: '',
                isCheckFilterBtnSearch: false,
                isCheckSearch: false,
                routeMain: '/category',
                routeMainNotSlash: 'category',
            };
        },
        computed: {
            ...mapGetters(['auth', 'currentUrl', 'listCategory'])
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
            var investId = self.$route.params.investId;
            let page = self.$route.query.page;

            if (self.$route.query.keySearch === undefined) {

                // Xử lý danh sách đang ở chế độ bình thường

                if (page === undefined) {
                    self.getAllCategory();
                } else {
                    self.getAllCategoryByPage(page);
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
                    self.$store.dispatch('searchCategory', self.keySearch)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listCategory.to;
                        self.numberTotalDataPage = self.listCategory.total;
                        self.totalPage = res.data.last_page;
                    })
                } else {
                    let params = {
                        key: self.keySearch,
                        page: page,
                    };

                    self.$store.dispatch('searchCategoryByPaginate', params)
                    .then((res) => {
                        self.offLoading();
                        self.numberStartDataPage = self.listCategory.to;
                        self.numberTotalDataPage = self.listCategory.total;
                        self.totalPage = res.data.last_page;
                    })
                }
            }
        },
        destroyed() {
            this.$store.commit("setListCategory", {});
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

                self.$store.dispatch('searchCategory', self.keySearch)
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
