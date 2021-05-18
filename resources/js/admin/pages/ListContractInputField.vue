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
                            <h4 class="card-title">Các trường trong hợp đồng</h4>
                            <p class="card-category">Danh sách tổng số {{numberStartDataPage}} / {{numberTotalDataPage}} trường</p>
                        </template>
                        <l-table class="table-hover table-striped"
                            :columns="columns"
                            :data="listContractInputField.data"
                            :form="'ContractInputFieldInput'"
                            :formName="'TRƯỜNG NHẬP HỢP ĐỒNG'"
                            :model="'contract-input-field'"
                            :onLoading="onLoading"
                            :offLoading="offLoading"
                        >
                        </l-table>
                        <div class="d-flex justify-content-center" v-if="totalPage > 1">
                            <b-button-group>
                                <b-button v-bind:href="currentUrl.links[0].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) - 1)">‹</b-button>
                                <b-button
                                    v-for="(item,index) in currentUrl.links.length - 1"
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
        name: "ListContractInputField",
        components: {
            LTable,
            Card,
            DotSpaceProgress
        },
        data(){
            return {
                isLoading: false,
                'columns':{
                    "id":"ID",
                    "lang_field.vi":"Tên trường VI",
                    "lang_field.en":"Tên trường EN",
                },
                numberStartDataPage: null,
                numberTotalDataPage: null,
                totalPage: null,
            };
        },
        computed:{
            ...mapGetters(['listContractInputField','auth','currentUrl'])
        },
        mounted() {
            var self = this;
            let page = self.$route.query.page;
            self.onLoading();

            if (page === undefined) {
                self.getContractInputField();
            } else {
                self.$store.dispatch('getContractInputFieldByPage', page)
                .then((res) => {
                    if (res.data.data.length === 0) {
                        self.$router.push({path: '/contract-input-field'}).then(r => {});
                        self.getContractInputField();
                    } else {
                        self.offLoading();
                        self.numberStartDataPage = self.listContractInputField.to;
                        self.numberTotalDataPage = self.listContractInputField.total;
                        self.totalPage = res.data.last_page;
                    }
                });
            }
        },
        destroyed() {
            this.$store.commit("setlistContractInputField", {});
        },
        methods: {
            getContractInputField() {
                var self = this;

                self.$store.dispatch('getAllContractInputField')
                .then((res) => {
                    self.offLoading();
                    self.numberStartDataPage = self.listContractInputField.to;
                    self.numberTotalDataPage = self.listContractInputField.total;
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

<style scoped>

</style>
