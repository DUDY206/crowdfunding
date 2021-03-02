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
                                 :formName="'INVESTOR'"
                                 :model="'invest-type'"
                        >
                        </l-table>

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
                    "lang_name.vi":"Tên loại hợp đồng",
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
