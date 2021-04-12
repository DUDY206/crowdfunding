<template>
    <div>
        <b-form  >
            <b-row>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Tên trường (VI) <span class="text-danger font-italic">{{errors.field_vi}}</span></p>
                        <b-form-input
                            v-model="form.field_vi"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Tên trường (EN) <span class="text-danger font-italic">{{errors.field_en}}</span></p>
                        <b-form-input
                            v-model="form.field_en"
                            type="text"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-form>
        <b-row align-h="between">
            <b-col cols="3">
                <b-button class="mt-3" block @click="$bvModal.hide(modalName)">Close</b-button>
            </b-col>
            <b-col cols="3">
                <b-button class="mt-3" block @click="createForm" v-if="isAdd">Save</b-button>
                <b-button class="mt-3" block @click="editForm" v-else>Save</b-button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "ContractInputFieldInput",
        props:[
            'item',
            'isAdd',
            'modalName',
            'onLoading',
            'offLoading'
        ],
        data(){
            return {
                form:{
                    field_vi:'',
                    field_en:'',
                },
                errors:{
                    field_vi:'',
                    field_en:'',
                },
            }
        },
        computed: {
            ...mapGetters(['auth', 'currentUrl'])
        },
        mounted() {
            if(!this.$props.isAdd){
                this.form.field_vi = this.$props.item.lang_field.vi;
                this.form.field_en = this.$props.item.lang_field.en;
            }
        },
        methods:{
            archiveForm(){
                const formData = new FormData();
                for(var key in this.form){
                    formData.append(key,this.form[key]);
                }
                return formData
            },
            createForm(){
                var self = this;
                self.onLoading();
                let formData = self.archiveForm();

                this.$store.dispatch('createContractInputField', formData)
                .then((res) => {
                    self.$store.dispatch('getAllContractInputField')
                    .then((res) => {
                        self.offLoading();
                        self.clearInput();
                        self.$toast.success('Thêm trường nhập hợp đồng thành công');
                        self.$bvModal.hide(self.$props.modalName)
                    });
                })
                .catch((err) => {
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err))
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
            editForm(){
                var self = this;
                self.onLoading();

                let formData = {
                    id: this.$props.item.id,
                    form: this.archiveForm()
                };

                self.$store.dispatch('editContractInputField', formData)
                .then((res) => {
                    self.$store.dispatch("getContractInputFieldByPage", self.currentUrl.current_page)
                    .then((res) => {
                        self.offLoading();
                        self.$toast.success('Sửa trường nhập hợp đồng thành công');
                        self.$bvModal.hide(self.$props.modalName);
                    })
                })
                .catch((err) => {
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err))
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

                this.avatar = '';
            }
        }
    }
</script>
