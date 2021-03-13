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
                                 :data="listContractInputField.data"
                                 :form="'ContractInputFieldInput'"
                                 :formName="'TRƯỜNG NHẬP HỢP ĐỒNG'"
                                 :model="'contract-input-field'"
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
    import LTable from "../components/Table";
    import Card from "../components/Cards/Card";
    import {mapGetters} from "vuex";

    export default {
        name: "ListContractInputField",
        components: {
            LTable,
            Card
        },
        data(){
            return {
                'columns':{
                    "id":"ID",
                    "lang_field.vi":"Tên trường VI",
                    "lang_field.en":"Tên trường EN",
                },
            };
        },
        computed:{
            ...mapGetters(['listContractInputField','auth','currentUrl'])
        },
        mounted() {
            let page = this.$route.query.page;
            if(page === undefined){
                this.$store.dispatch('getAllContractInputField');
            }else{
                this.$store.dispatch('getContractInputFieldByPage',page)
            }
        },
    }
</script>

<style scoped>

</style>
