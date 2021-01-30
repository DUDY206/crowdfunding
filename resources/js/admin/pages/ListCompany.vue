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
            ...mapGetters(['listCompany','auth'])
        },
        mounted() {
            this.$store.dispatch('getAllCompany');
        }
    }
</script>

<style scoped>

</style>
