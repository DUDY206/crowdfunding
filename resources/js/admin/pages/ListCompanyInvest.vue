<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <card class="strpied-tabled-with-hover"
                          body-classes="table-full-width table-responsive"
                    >
                        <template slot="header">
                            <h4 class="card-title">Company investments</h4>
<!--                            <p class="card-category">Here is a subtitle for this table</p>-->
                        </template>
                        <l-table class="table-hover table-striped"
                                 :columns="columns"
                                 :data="listCompanyInvest.data"
                                 :form="'CompanyInvestInput'"
                                 :formName="'DỰ ÁN ĐẦU TƯ'"
                                 :model="'company-invest'"
                        >
                            <div  slot-scope="{itemid}" class="d-flex flex-row">
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" v-bind:id="itemid" v-b-modal="'modal-cpi-'+itemid">FAQ/Risks</b-button>
                                <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger"  v-bind:id="'invest-type'+itemid" v-b-modal="'modal-investype-'+itemid">Loại HĐ</b-button>
                            </div>
                        </l-table>
                        <b-modal hide-footer v-bind:id="'modal-cpi-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'cpi-'+index" size="xl" v-bind:title="'FAQ/Risk '+item.id" >
                            <div class="my-4" is="CompanyInvestFAQInput" :item="item" :isAdd="false" v-bind:modalName="'modal-faq-'+item.id">Edit {{item.id}} </div>
                        </b-modal>

                        <b-modal hide-footer v-bind:id="'modal-investype-'+item.id" v-for="(item, index) in listCompanyInvest.data" :key="'investtype-'+index" size="xl" v-bind:title="'Loại hợp đồng '+item.id" >
                            <div class="my-4" is="InvestTypeField" :invest-id="item.id" v-bind:modalName="'modal-investype-'+item.id" :array-invest-type="item.array_invest_type"> </div>
                        </b-modal>


                        <div class="d-flex justify-content-center">
                            <b-button-group>
                                <b-button v-bind:href="currentUrl.links[0].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) - 1)">‹</b-button>
                                <b-button
                                    v-for="(item,index) in currentUrl.links.length - 1"
                                    v-if="index!==0"
                                    v-bind:href="'?page='+currentUrl.links[index].url.split('=')[1]">
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

    export default {
        name: "ListCompanyInvest",
        components: {
            LTable,
            Card
        },
        data(){
            return {
                'columns':{
                    "id":"ID",
                    "lang_name.vi":"Tên dự án",
                    "lang_short_description.vi":"Mô tả ngắn",
                    "company.lang_name.vi":"Tên công ty",
                    "account_id":"Người sở hữu",
                },
            };
        },
        computed:{
            ...mapGetters(['listCompanyInvest','auth','currentUrl'])
        },
        mounted() {
            let page = this.$route.query.page;
            console.log("page:",page);
            if(page === undefined){
                this.$store.dispatch('getAllCompanyInvest');
            }else{
                this.$store.dispatch('getAllCompanyInvestByPage',page)
            }
        },
        methods:{
            navigatePage(uri){
                this.$store.dispatch('getCompanyByPage',uri)
            }
        }
    }
</script>

<style scoped>

</style>
