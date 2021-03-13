<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <card class="strpied-tabled-with-hover"
                          body-classes="table-full-width table-responsive"
                    >
                        <template slot="header">
                            <h4 class="card-title">Striped Table with Hover</h4>
                            <p class="card-category">Here is a subtitle for this table</p>
                        </template>
                        <l-table class="table-hover table-striped"
                                 :columns="columns"
                                 :data="listInvestType"
                                 :form="'InvestTypeInput'"
                                 :formName="'HÌNH THỨC ĐẦU TƯ'"
                                 :model="'invest-type'"
                        >
                            <div  slot-scope="{itemid}" class="d-flex flex-row">
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger"  v-bind:id="'constact-input-'+itemid" v-b-modal="'modal-constact-input-'+itemid">Trường input</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger"
                                          v-bind:id="'list-constact-template-'+itemid"
                                          v-b-modal="'modal-list-constact-template-'+itemid">Danh sách hợp đồng</b-button>
                            </div>
                        </l-table>

                        <b-modal hide-footer v-bind:id="'modal-constact-input-'+item.id" v-for="(item, index) in listInvestType" :key="'constact-input-'+index" size="xl" v-bind:title="'Truong nhap '+item.id" >
                            <div class="my-4" is="ContractHasInputFieldInput" :item="item" v-bind:modalName="'constact-input-'+item.id" :contract-id="item.id">Edit {{item.id}} </div>
                        </b-modal>

                        <b-modal hide-footer
                                 v-bind:id="'modal-list-constact-template-'+item.id"
                                 v-for="(item, index) in listInvestType"
                                 :key="'list-constact-template-'+index"
                                 size="xl"
                                 v-bind:title="'Truong nhap '+item.id" >
                            <div class="my-4" is="ListContractTemplate"
                                 v-bind:modalName="'list-constact-template-'+item.id"
                                 :invest-type-id="item.id">Edit {{item.id}} </div>
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

    export default {
        name: "ListInvestType",
        components: {
            LTable,
            Card
        },
        data(){
            return {
                'columns':{
                    "id":"ID",
                    "lang_name.vi":"Tên hình thức đầu tư",
                    "lang_short_description.vi":"Mô tả ngắn",
                },
            };
        },
        computed:{
            ...mapGetters(['listInvestType','auth'])
        },
        mounted() {
            this.$store.dispatch('getAllInvestType');
        },
    }
</script>

<style scoped>

</style>
