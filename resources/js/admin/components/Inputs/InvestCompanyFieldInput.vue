<template>
    <div v-if="isLoaded">
        <b-form  >
            <b-row>
                <b-col cols="3">
                    <div v-for="(field, index) in allInvestContractField" v-bind:key="index">
                        <input type="checkbox" :id="'checkbox-'+field.id" :value="field.id" v-model="selected" >
                        <label :for="'checkbox-'+field.id">{{field.lang_field.vi}}</label>
                    </div>
                </b-col>
                <b-col cols="9">
                    <div v-for="(id, index) in selected" v-bind:key="index">
                        <b-form-group  >
                            <p>{{allInvestContractField.find(o => o.id === id).lang_field.vi}} <span class="text-danger font-italic"></span></p>
                            <b-form-input
                                v-model="allInvestContractField.find(o => o.id === id).value"
                                type="text"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </div>
                </b-col>
            </b-row>
        </b-form>
        <b-row align-h="between">
            <b-col cols="3">
                <b-button class="mt-3" block @click="$bvModal.hide(modalName)">Đóng</b-button>
            </b-col>
            <b-col cols="3">
                <b-button class="mt-3" block @click="createForm">Cập nhật</b-button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        name: "InvestCompanyFieldInput",
        props:[
            'itemId',
            'modalName',
            'onLoading',
            'offLoading',
        ],
        data(){
            return {
                isLoaded : false,
                allInvestContractField:null,
                dbInvestContractField:null,
                selected:[]
            }
        },
        mounted() {
            var self = this;
            self.onLoading();

            let data = {
                route:'invest-contract-field',
            };

            self.$store.dispatch('getAllModel', data)
            .then(res => {
                self.offLoading();
                self.allInvestContractField = res.data
                for(var index = 0; index < self.allInvestContractField.length;index++){
                    self.allInvestContractField[index].selected = false
                    self.allInvestContractField[index].value = null
                }
                self.isLoaded = true;
            });

            data = {
                route:'invest-has-contract-field/' + self.$props.itemId,
            };

            self.$store.dispatch('getAllModel', data)
            .then(res => {
                self.offLoading();
                self.dbInvestContractField = res.data;

                for (var dbField of self.dbInvestContractField) {
                    self.allInvestContractField.find(o => o.id === dbField.id).selected = true;
                    self.allInvestContractField.find(o => o.id === dbField.id).value = dbField.pivot.value;
                    self.selected.push(dbField.id);
                }
            })
        },
        methods: {
            createForm() {
                var self = this;
                self.onLoading();
                let formData = new FormData();
                formData.append('invest_id', self.$props.itemId);

                for (var id of self.selected) {
                    formData.append('contract_value['+id+']',self.allInvestContractField.find(o => o.id === id).value);
                }

                let data = {
                    route: 'invest-contract-field-value',
                    form: formData
                };

                self.$store.dispatch('createModel', data)
                .then((res) => {
                    self.offLoading();
                    self.$toast.success('Sửa thông tin hợp đồng dự án thành công');
                    self.$bvModal.hide(self.$props.modalName);
                })
                .catch((err) => {
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err));
                    self.$toast.error('Không thể hoàn tác, vui lòng thử lại');
                });
            }
        }
    }
</script>

<style scoped lang="scss">
    input[type=checkbox]{
        -ms-transform: scale(2); /* IE */
        -moz-transform: scale(2); /* FF */
        -webkit-transform: scale(2); /* Safari and Chrome */
        -o-transform: scale(2); /* Opera */
        transform: scale(2);
        margin-right:1rem
    }
</style>
