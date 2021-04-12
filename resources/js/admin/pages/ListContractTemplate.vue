<template>
    <div class="content" v-if="isLoaded">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <card class="strpied-tabled-with-hover" body-classes="table-full-width table-responsive">
                        <template slot="header">
                            <h4 class="card-title">Danh sách hợp đồng</h4>
                        </template>
                        <l-table class="table-hover table-striped"
                            :columns="columns"
                            :data="listContractTemplate"
                            :form="'ContractTemplateInput'"
                            :formName="'HỢP ĐỒNG'"
                            :model="'contract-template'"
                            :onLoading="onLoading"
                            :offLoading="offLoading"
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
    import DotSpaceProgress from "../../commons/DotSpaceProgress";

    export default {
        name: "ListContractTemplate",
        props: [
            'investTypeId',
            'onLoading',
            'offLoading'
        ],
        components: {
            LTable,
            Card,
            DotSpaceProgress
        },
        data() {
            return {
                'columns': {
                    "id":"ID",
                    "name":"Tên loại hợp đồng",
                    "diff_created_at":"Ngày tạo",
                    "diff_updated_at":"Cập nhật lần cuối",
                },
                isLoaded: false,
            }
        },
        computed:{
            ...mapGetters([
                'listContractTemplate'
            ])
        },
        mounted() {
            var self = this;
            self.onLoading();

            let data = {
                route: 'invest-has-contract-template/' + this.$props.investTypeId,
                setState: 'setlistContractTemplate',
            };

            this.$store.dispatch('getAllModel', data)
            .then(res => {
                self.isLoaded = true;
                self.offLoading();
            });

            data = {
                route: 'contract-has-input-field/' + this.$props.investTypeId,
                setState: 'setlistInputField'
            }

            this.$store.dispatch('getAllModel', data)
            .then(res => {
                self.isLoaded = true;
                self.offLoading();
            });

            this.$store.commit('setcurrentInvestType', this.$props.investTypeId);
        },
    }
</script>
