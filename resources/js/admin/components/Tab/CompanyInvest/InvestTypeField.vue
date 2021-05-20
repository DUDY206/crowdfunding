<template>
    <div v-if="!isLoading">
        <h3>Danh sách các loại hình thức đầu tư</h3>
        <b-form-checkbox-group
            id="checkbox-group-2"
            v-model="selected"
            class="d-flex flex-column"
        >
            <b-form-checkbox :value="investType.id" v-for="(investType, index) in listInvestType.data" v-bind:key="index">{{investType.lang_name.vi}}</b-form-checkbox>
        </b-form-checkbox-group>
        <div class="mt-3">
            <b-button @click="$router.push('invest-type')" variant="primary">Danh sách loại hợp đồng</b-button>
            <b-button @click="saveInvestHasType" variant="danger" >Cập nhật</b-button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "InvestTypeField",
        props: [
            'investId',
            'modalName',
            'arrayInvestType',
            'onLoading',
            'offLoading',
        ],
        computed:{
            ...mapGetters([
                'listInvestType'
            ])
        },
        data() {
            return {
                selected: this.$props.arrayInvestType,
                isLoading: false,
            }
        },
        mounted() {
            var self = this;
            self.onLoading();
            self.isLoading = true;

            self.$store.dispatch('getAllInvestType')
            .then((res) => {
                self.offLoading();
                self.isLoading = false;
            })

            let data = {
                route: 'invest-has-type/' + self.investId,
            };

            self.$store.dispatch('getAllModel', data)
            .then(res => {
                self.offLoading();
                self.selected = res.data;
            })
        },
        methods:{
            archiveForm() {
                const formData = new FormData();
                formData.append('invest_id', this.$props.investId);
                let index = 0;

                for (let id in this.selected) {
                    formData.append('invest_type['+index+']', this.selected[id]);
                    index++;
                }

                return formData;
            },
            saveInvestHasType() {
                var self = this;
                let formData = this.archiveForm();
                self.onLoading();

                self.$store.dispatch("syncInvestHasType", formData)
                .then(res => {
                    self.offLoading();
                    self.$bvModal.hide(self.$props.modalName);
                    self.$toast.success('Cập nhật hình thức đầu tư thành công');
                    let index = self.$store.state.listCompanyInvest.data.findIndex(e => e.id === self.$props.investId);
                    self.$store.state.listCompanyInvest.data[index].array_invest_type = self.selected;
                })
                .catch((err) => {
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err));
                    console.log(errorJson);
                    this.$toast.error('Xin thử lại');
                });
            }
        },
    }
</script>
