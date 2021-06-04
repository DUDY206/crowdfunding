<template>
    <div>
        <b-form>
            <b-row>
                <b-col cols="12">
                    <b-form-group>
                        <p>Số tiền đầu tư</p>
                        <b-form-input
                            v-model="form.price"
                            type="number"
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group>
                        <p>Tên hình thức đầu tư (VI) <span class="text-danger font-italic">{{errors.name_vi}}</span></p>
                        <b-form-input
                            v-model="form.name_vi"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group>
                        <p>Mô tả (VI) <span class="text-danger font-italic">{{errors.short_description_vi}}</span></p>
                        <ckeditor v-model="form.short_description_vi" :config="config"></ckeditor>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group>
                        <p>Tên hình thức đầu tư (EN) <span class="text-danger font-italic">{{errors.name_en}}</span></p>
                        <b-form-input
                            v-model="form.name_en"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group>
                        <p>Mô tả (EN) <span class="text-danger font-italic">{{errors.short_description_en}}</span></p>
                        <ckeditor v-model="form.short_description_en" :config="config"></ckeditor>
                    </b-form-group>

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
    import {mapGetters} from "vuex";
    import globalCKeditorConfig from "../../globalCKeditorConfig";

    export default {
        name: "InvestTypeInput",
        props:[
            'item',
            'isAdd',
            'modalName',
            'onLoading',
            'offLoading'
        ],
        data(){
            return {
                config:globalCKeditorConfig,
                form:{
                    name_vi:'',
                    short_description_vi:'',
                    name_en:'',
                    short_description_en:'',
                    price: null,
                },
                errors:{
                    name_vi:'',
                    short_description_vi:'',
                    name_en:'',
                    short_description_en:'',
                },
            }
        },
        computed: {
            ...mapGetters(['currentUrl'])
        },
        methods:{
            archiveForm(){
                const formData = new FormData();

                for (var key in this.form) {
                    if (this.form[key] !== null) {
                        formData.append(key, this.form[key]);
                    }
                }

                return formData;
            },
            createForm() {
                var self = this;
                self.onLoading();
                let formData = self.archiveForm();

                self.$store.dispatch('createInvestType', formData)
                .then((res) => {
                    self.$store.dispatch('getAllInvestType')
                    .then((res) => {
                        self.offLoading();
                        self.$toast.success('Thêm loại hợp đồng thành công');
                        self.clearInput();
                        self.$bvModal.hide(self.$props.modalName)
                    });
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
            editForm(){
                var self = this;
                self.onLoading();

                let formData = {
                    id: self.$props.item.id,
                    form: self.archiveForm()
                };

                self.$store.dispatch('editInvestType',formData)
                .then((res) => {
                    self.$store.dispatch("getInvestTypeByPage", self.currentUrl.current_page)
                    .then((res) => {
                        self.offLoading();
                        self.$toast.success('Sửa loại hợp đồng thành công');
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
        },
        mounted() {
            if (!this.$props.isAdd) {
                const lang = ['name','short_description'];

                for (var field of lang) {
                    this.form[field+'_vi'] = this.$props.item['lang_'+field]['vi'];
                    this.form[field+'_en'] = this.$props.item['lang_'+field]['en'];
                }

                this.form['price'] = this.$props.item['price'];
            }
        }
    }
</script>

<style scoped>

</style>
