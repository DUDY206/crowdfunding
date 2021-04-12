<template>
    <div>
        <b-form  >
            <b-row>
                <b-col cols="9">
                    <b-form-group  >
                        <p>Tên hợp đồng <span class="text-danger font-italic">{{errors.name}}</span></p>
                        <b-form-input
                            v-model="form.name"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group  >
                        <p>Nội dung hợp đồng <span class="text-danger font-italic">{{errors.template}}</span></p>
                        <ckeditor v-model="form.template" :config="config"></ckeditor>
                    </b-form-group>
                </b-col>
                <b-col cols="3">
                    <span class="text-danger">Copy các trường tương ứng vào hợp đồng <br/><i id="tooltip-target-1" class="text-primary">(Xem hướng dẫn)</i></span>
                    <b-tooltip target="tooltip-target-1" triggers="hover" v-html="">
                        <p class="text-left">
                            <b>----Trường đơn----</b><br/>
                            Họ và tên :[[1]] <br/>
                            Địa chỉ: [[2]] <br/>
                            <b>----Công thức----</b><br/>
                            Số lương: cal([[tiền]]/[[giá]])
                        </p>
                    </b-tooltip>

                    <h5 class="font-weight-bold mt-3">TRƯỜNG INPUT - DỰ ÁN</h5>
                    <table class="w-100" border="1" >
                        <tr>
                            <th>Tên trường</th>
                            <th>Label</th>
                        </tr>
                        <tr>
                            <td>Tên công ty</td>
                            <td>[[company_name]]</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ công ty</td>
                            <td>[[location]]</td>
                        </tr>
                        <tr v-for="field of allInvestContractField" :key="'invest-'+field.id">
                                <td>{{field.lang_field.vi}}</td>
                            <td v-html="'[[comp-'+field.id+']]'">
                            </td>

                        </tr>
                    </table>

                    <h5 class="font-weight-bold mt-3">TRƯỜNG INPUT - NHÀ ĐẦU TƯ</h5>
                    <table class="w-100" border="1">
                        <tr>
                            <th>Tên trường</th>
                            <th>Label</th>
                        </tr>
                        <tr v-for="(input,index) in listInputField" :key="'customer-'+index">
                            <td>{{input.lang_field.vi}}</td>
                            <td v-html="'[['+input.id+']]'">
                            </td>
                        </tr>
                        <tr>
                            <td>Số tiền đầu tư</td>
                            <td>[[money]]</td>
                        </tr>
                    </table>

                    <h5 class="font-weight-bold mt-3">CÔNG THỨC</h5>
                    <table class="w-100" border="1">
                        <tr>
                            <td>CÔNG THỨC</td>
                            <td>cal(...biểu thức)</td>
                        </tr>
                        <tr>
                            <td>Ví dự</td>
                            <td>cal([[tiền]]/[[giá]])</td>
                        </tr>
                    </table>

                </b-col>
            </b-row>
        </b-form>
        <b-row align-h="between">
            <b-col cols="3">
                <b-button class="mt-3" block @click="$bvModal.hide(modalName)">Đóng</b-button>
            </b-col>
            <b-col cols="3">
                <b-button class="mt-3" block @click="createForm" v-if="isAdd">Thêm mới</b-button>
                <b-button class="mt-3" block @click="editForm" v-else>Cập nhật</b-button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import globalCKeditorConfig from "../../globalCKeditorConfig";
    import {mapGetters} from "vuex";

    export default {
        name: "ContractTemplateInput",
        props:[
            'item',
            'isAdd',
            'modalName',
            'onLoading',
            'offLoading'
        ],
        computed:{
            ...mapGetters([
                'listInputField','currentInvestType'
            ])
        },
        data(){
            return {
                config: globalCKeditorConfig,

                form: {
                    name: '',
                    template: '',
                },
                errors: {
                    name: '',
                    template: '',
                },

                field_auto_gen:{

                },
                allInvestContractField:null,
            }
        },
        mounted() {
            var self = this;
            self.onLoading();

            if (!self.$props.isAdd) {
                self.form.name = self.$props.item.name;
                self.form.template = self.$props.item.template;
            }

            let data = {
                route:'invest-contract-field',
            }

            self.$store.dispatch('getAllModel', data)
            .then(res => {
                self.offLoading();
                self.allInvestContractField = res.data
            })

            self.config['height'] = "50em"
        },
        methods:{
            archiveForm() {
                let formData = new FormData();
                formData.append('invest_type_id', this.currentInvestType);
                let input_label = "";

                for (var index in this.listInputField) {
                    input_label += (this.listInputField[index].id +":\""+ this.listInputField[index].lang_field.vi + "\"");

                    if (parseInt(index) !== (this.listInputField.length - 1)) {
                        input_label += ",";
                    }
                }

                formData.append('input_label', input_label);
                formData.append('template', this.form.template);
                formData.append('name', this.form.name);

                return formData;
            },
            createForm() {
                var self = this;
                self.onLoading();

                let data = {
                    route: "contract-template",
                    form: self.archiveForm(),
                    state_field: "listContractTemplate",
                };

                self.$store.dispatch('createModel', data)
                .then((res) => {
                    self.offLoading();
                    self.$toast.success('Thêm hợp đồng mới thành công');
                    self.$bvModal.hide(self.$props.modalName);
                })
                .catch((err) => {
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err));

                    for (var key in errorJson) {
                        if (typeof errorJson[key] !== 'undefined') {
                            self.errors[key] = errorJson[key][0];
                        } else {
                            self.errors[key] = '';
                        }
                    }
                });
            },
            editForm() {
                var self = this;
                self.onLoading();

                let data = {
                    id: self.$props.item.id,
                    form: self.archiveForm(),
                    route: "contract-template",
                    model_id: self.$props.item.id,
                    routeGetAll: 'invest-has-contract-template/' + self.currentInvestType,
                    setState: 'setlistContractTemplate',
                };

                self.$store.dispatch('editModel', data)
                .then((res) => {
                    self.offLoading();
                    self.$toast.success('Sửa hợp đồng thành công');
                    self.$bvModal.hide(self.$props.modalName)
                })
                .catch((err) => {
                    self.offLoading();
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
            clearInput() {
                for (var key in this.form) {
                    this.form[key] = '';
                    this.errors[key] = '';
                }

                this.img_url = '';
            },
        }
    }
</script>

<style scoped lang="scss">
    td,th{
        padding-left: 1rem;
    }
</style>
