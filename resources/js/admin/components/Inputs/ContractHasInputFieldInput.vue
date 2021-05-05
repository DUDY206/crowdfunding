<template>
    <div v-if="isLoaded">
        <h3>Danh sách các trường nhập vào hợp đồng</h3>
        <b-form-checkbox-group
            id="checkbox-group-2"
            v-model="selected"
            class="d-flex flex-column"
        >
            <b-form-checkbox :value="input_field.id" v-for="(input_field, index) in listContractInputField.data" v-bind:key="index">
                {{input_field.lang_field.vi}}
            </b-form-checkbox>
        </b-form-checkbox-group>
        <div class="mt-3">
            <b-button @click="createForm"  variant="danger" >Cập nhật</b-button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "ContractHasInputFieldInput",
        props:[
            'contractId',
            'onLoading',
            'offLoading'
        ],
        data(){
            return {
                isLoaded : false,
                selected:[],
            }
        },
        computed:{
            ...mapGetters(['listContractInputField'])
        },
        mounted() {
            var self = this;
            self.onLoading();

            self.$store.dispatch('getAllContractInputField')
            .then((res) => {
                self.offLoading();
            });

            let data = {
                route:'contract-has-input-field/' + self.$props.contractId,
            };

            self.$store.dispatch('getAllModel', data)
            .then(res => {
                self.offLoading();

                for (var index in res.data) {
                    self.selected.push(res.data[index].id)
                }
                self.isLoaded = true;
            })
        },
        methods:{
            archiveForm(){
                const formData = new FormData();
                formData.append('invest_type_id', this.$props.contractId);
                let index = 0;

                for (let id in this.selected) {
                    formData.append('contract_field['+index+']',this.selected[id]);
                    index++;
                }

                return formData;
            },
            createForm(){
                var self = this;
                self.onLoading();

                let formData = self.archiveForm();
                let data = {
                    route: 'contract-has-input-field',
                    form: formData
                };

                self.$store.dispatch('createModel', data)
                .then((res) => {
                    self.offLoading();
                    self.$toast.success('Cập nhật trường nhập thành công');
                    self.clearInput();
                    self.$bvModal.hide(self.$props.modalName);
                })
                .catch((err) => {
                    let errorJson = JSON.parse(JSON.stringify(err));
                    self.$toast.error('Xin thử lại');
                    for (var key in errorJson) {
                        if (typeof errorJson[key] !== 'undefined') {
                            self.errors[key] = errorJson[key][0];
                        } else {
                            self.errors[key] = '';
                        }
                    }
                });
            },
            clearInput(){
                for (var key in this.form) {
                    this.form[key] = '';
                    this.errors[key] = '';
                }

                this.avatar = '';
            }
        }
    }
</script>
