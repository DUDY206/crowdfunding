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
                                 :data="listCompany.data"
                                 :form="'CompanyInput'"
                                 :formName="'CÔNG TY'"
                                 :model="'company'"
                        >
                        </l-table>
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
    import {mapGetters} from "vuex";
    import LTable from '../components/Table.vue';
    import Card from "../components/Cards/Card";
    export default {
        name: "ListCompany",
        components: {
            LTable,
            Card
        },
        data(){
            return {
                'columns':{
                    "id":"ID",
                    "lang_name.vi":"Tên công ty",
                    "lang_description.vi":"Mô tả",
                    "lang_company_type.vi":"Loại công ty",
                    "account_id":"Người sở hữu",
                },
            };
        },
        computed:{
            ...mapGetters(['listCompany','auth','currentUrl'])
        },
        mounted() {
            let page = this.$route.query.page;
            console.log("page:",page);
            if(page === undefined){
                console.log("get all");
                this.$store.dispatch('getAllCompany');
            }else{
                console.log("get page");
                this.$store.dispatch('getCompanyByPage',page)
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
