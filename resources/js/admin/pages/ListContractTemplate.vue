<template>
    <div class="content" v-if="isLoaded">
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
                                     :data="listContractTemplate"
                                     :form="'ContractTemplateInput'"
                                     :formName="'HỢP ĐỒNG'"
                                     :model="'contract-template'"
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
    import LTable from "../components/Table";
    import Card from "../components/Cards/Card";

    export default {
        name: "ListContractTemplate",
        props:[
            'investTypeId'
        ],
        components: {
            LTable,
            Card
        },
        data(){
            return {
                'columns':{
                    "id":"ID",
                    "name":"Tên loại hợp đồng",
                    "diff_created_at":"Ngày tạo",
                    "diff_updated_at":"Cập nhật lần cuối",
                },
                isLoaded:false
            }
        },
        computed:{
            ...mapGetters([
                'listContractTemplate'
            ])
        },
        mounted() {
            let data = {
                route:'invest-has-contract-template/'+this.$props.investTypeId,
                setState:'setlistContractTemplate',
            }
            this.$store.dispatch('getAllModel',data).then(res=>{
                this.isLoaded = true
            })
            data = {
                route:'contract-has-input-field/'+this.$props.investTypeId,
                setState: 'setlistInputField'
            }
            this.$store.dispatch('getAllModel',data)

            this.$store.commit('setcurrentInvestType',this.$props.investTypeId)
        }
    }
</script>

<style scoped lang="scss">

</style>
