<template>
    <div>
        <b-form  >
            <b-tabs content-class="mt-3">
                <b-tab title="Thông tin cơ bản" active>
                    <b-row>
                        <b-col cols="6">
                            <b-form-group >
                                <p>Tên dự án (VI) <span class="text-danger font-italic">{{errors.name_vi}}</span></p>
                                <b-form-input
                                    v-model="form.name_vi"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group >
                                <p>Mô tả ngắn (VI) <span class="text-danger font-italic">{{errors.short_description_vi}}</span></p>
                                <b-form-input
                                    v-model="form.short_description_vi"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group >
                                <p>Địa chỉ (VI) <span class="text-danger font-italic">{{errors.location_vi}}</span></p>
                                <b-form-input
                                    v-model="form.location_vi"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group >
                                <p>Trạng thái <span class="text-danger font-italic">{{errors.status}}</span></p>
                                <b-form-select v-model="form.status" :options="status_option"></b-form-select>
                                <!-- <b-form-option
                                    v-model="form.status"
                                    type="checkbox"
                                    required
                                ></b-form-option> -->
                            </b-form-group>

                            <b-form-group >
                                <p>Định giá doanh nghiệp <span class="text-danger font-italic">{{errors.min_invest}}</span></p>
                                <b-form-input
                                    v-model="form.min_invest"
                                    type="number"
                                    min="1"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <div class="mt-3">Ảnh dự án (kích thước phù hợp: 1140 x 600) <span class="text-danger font-italic">{{errors.img_url}}</span></div>
                            <input type="file" id="input_image_upload" ref="img_url" @change="previewImage('img_url', $event)" />
                            <img class="preview" :src="img_url" />
                        </b-col>

                        <b-col cols="6">
                            <b-form-group >
                                <p>Tên dự án (EN) <span class="text-danger font-italic">{{errors.name_en}}</span></p>
                                <b-form-input
                                    v-model="form.name_en"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group >
                                <p>Mô tả ngắn (EN) <span class="text-danger font-italic">{{errors.short_description_en}}</span></p>
                                <b-form-input
                                    v-model="form.short_description_en"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group >
                                <p>Địa chỉ (EN) <span class="text-danger font-italic">{{errors.location_en}}</span></p>
                                <b-form-input
                                    v-model="form.location_en"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group >
                                <p>Giá trị đầu tư tối thiểu: <span class="text-danger font-italic">{{errors.valuation_cap}}</span></p>
                                <b-form-input
                                    v-model="form.valuation_cap"
                                    type="number"
                                    min="1"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group >
                                <p>ID công ty <span class="text-danger font-italic">{{errors.company_id}}</span></p>
                                <b-form-input
                                    v-model="form.company_id"
                                    type="number"
                                    min="1"
                                    required
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group >
                                <p>Video url <span class="text-danger font-italic">{{errors.video_url}}</span></p>
                                <b-form-input
                                    v-model="form.video_url"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-tab>
                <b-tab title="Mô tả">
                    <b-tabs content-class="mt-3">
                        <b-tab title="VI" active>
                            <p class="font-weight-bold mt-lg-3 ">Đặc điểm nổi bật (vi) <span class="text-danger font-italic">{{errors.immutable_field.hight_light_vi}}</span></p>
                            <ckeditor v-model="form.immutable_field.hight_light_vi" :config="config"></ckeditor>

                            <p class="font-weight-bold mt-lg-3 ">Tổng quan ngành (vi) <span class="text-danger font-italic">{{errors.immutable_field.overview_specialized_vi}}</span></p>
                            <ckeditor v-model="form.immutable_field.overview_specialized_vi" :config="config"></ckeditor>

                            <p class="font-weight-bold mt-lg-3 ">Tổng quan doanh nghiệp (vi) <span class="text-danger font-italic">{{errors.immutable_field.overview_company_vi}}</span></p>
                            <ckeditor v-model="form.immutable_field.overview_company_vi" :config="config"></ckeditor>

                            <p class="font-weight-bold mt-lg-3 ">Tài chính quá khứ (vi) <span class="text-danger font-italic">{{errors.immutable_field.financial_before_vi}}</span></p>
                            <ckeditor v-model="form.immutable_field.financial_before_vi" :config="config"></ckeditor>

                            <p class="font-weight-bold mt-lg-3 ">Tài chính tương lai(vi) <span class="text-danger font-italic">{{errors.immutable_field.financial_after_vi}}</span></p>
                            <ckeditor v-model="form.immutable_field.financial_after_vi" :config="config"></ckeditor>

                        </b-tab>
                        <b-tab title="EN">
                            <p class="font-weight-bold mt-lg-3 ">Đặc điểm nổi bật (en) <span class="text-danger font-italic">{{errors.immutable_field.hight_light_en}}</span></p>
                            <ckeditor v-model="form.immutable_field.hight_light_en" :config="config"></ckeditor>

                            <p class="font-weight-bold mt-lg-3 ">Tổng quan ngành (en) <span class="text-danger font-italic">{{errors.immutable_field.overview_specialized_en}}</span></p>
                            <ckeditor v-model="form.immutable_field.overview_specialized_en" :config="config"></ckeditor>

                            <p class="font-weight-bold mt-lg-3 ">Tổng quan doanh nghiệp (en) <span class="text-danger font-italic">{{errors.immutable_field.overview_company_en}}</span></p>
                            <ckeditor v-model="form.immutable_field.overview_company_en" :config="config"></ckeditor>

                            <p class="font-weight-bold mt-lg-3 ">Tài chính quá khứ (en) <span class="text-danger font-italic">{{errors.immutable_field.financial_before_en}}</span></p>
                            <ckeditor v-model="form.immutable_field.financial_before_en" :config="config"></ckeditor>

                            <p class="font-weight-bold mt-lg-3 ">Tài chính tương lai(en) <span class="text-danger font-italic">{{errors.immutable_field.financial_after_en}}</span></p>
                            <ckeditor v-model="form.immutable_field.financial_after_en" :config="config"></ckeditor>

                        </b-tab>
                    </b-tabs>
                    <b-form-group >
                        <p>Hight light (vi)<span class="text-danger font-italic">{{errors.name_en}}</span></p>
                    </b-form-group>

                </b-tab>
                <b-tab title="Thông tin thêm">
                    <b-button variant="success" class="my-lg-3" @click="addMoreMutableField">Thêm</b-button>
                    <b-card no-body >
                        <b-tabs :key="total_mutable_field" pills card vertical active-nav-item-class="font-weight-bold text-uppercase bg-primary">
                            <mutable-field
                                v-for="(value, name) in getMutableField"
                                v-bind:key="name"
                                v-bind:title="extractTitleMutableFieldTab(name)"
                                @mutabletab="(datafield) => {form.mutable_field[name] = datafield}"
                                :datafield="form.mutable_field[name]"
                            >
                                <b-button @click="removeThisField(name)">Xoa</b-button>
                            </mutable-field>
                        </b-tabs>
                    </b-card>
                </b-tab>

                <!-- <b-tab title="Các loại hơp đồng" v-if="!isAdd">
                    <invest-type-field  :invest-id="item.id"></invest-type-field>
                </b-tab> -->
            </b-tabs>
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
    import MutableField from "../Tab/CompanyInvest/MutableField";
    import InvestTypeField from "../Tab/CompanyInvest/InvestTypeField";
    import globalCKeditorConfig from "../../globalCKeditorConfig";

    export default {
        name: "CompanyInvestInput",
        components: {MutableField,InvestTypeField},
        props: [
            'item',
            'isAdd',
            'modalName',
            'onLoading',
            'offLoading'
        ],
        data() {
            return {
                config: globalCKeditorConfig,
                total_mutable_field: 1,
                status_option: [
                    { value: 0, text: 'Ẩn dự án' },
                    { value: 1, text: 'Hiển thị dự án' },
                ],
                form: {
                    name_vi: "",
                    short_description_vi: "",
                    location_vi: "",
                    status: null,
                    min_invest: "",
                    img_url:null,
                    name_en: "",
                    short_description_en: "",
                    location_en: "",
                    valuation_cap: "",
                    company_id: "",
                    video_url: "",
                    immutable_field: {
                        hight_light_vi: "",
                        hight_light_en: "",
                        overview_specialized_vi: "",
                        overview_company_vi: "",
                        financial_before_vi: "",
                        financial_after_vi: "",
                        overview_specialized_en: "",
                        overview_company_en: "",
                        financial_before_en: "",
                        financial_after_en: "",
                    },
                    mutable_field: {
                        s1: {
                            title_vi: "",
                            title_en: "",
                            content_vi: "",
                            content_en: "",
                            position: ""
                        },
                    }
                },
                errors: {
                    name_vi: "",
                    short_description_vi: "",
                    location_vi: "",
                    status: "",
                    min_invest: "",
                    img_url: null,
                    name_en: "",
                    short_description_en: "",
                    location_en: "",
                    valuation_cap: "",
                    company_id: "",
                    video_url: "",
                    immutable_field: {
                        hight_light_vi: "",
                        hight_light_en: "",
                        overview_specialized_vi: "",
                        overview_company_vi: "",
                        financial_before_vi: "",
                        financial_after_vi: "",
                        overview_specialized_en: "",
                        overview_company_en: "",
                        financial_before_en: "",
                        financial_after_en: "",
                    },
                },
                img_url: "",
            }
        },
        computed: {
            getMutableField() {
                return this.form.mutable_field;
            },
            ...mapGetters(['currentUrl'])
        },
        mounted() {
            var self = this;

            if (!this.$props.isAdd) {
                self.onLoading();
                const root_lang = ['name','short_description','location'];

                for (var field of root_lang) {
                    if (this.$props.item['lang_'+field] !== null) {
                        this.form[field+'_vi'] = this.$props.item['lang_'+field]['vi']
                        this.form[field+'_en'] = this.$props.item['lang_'+field]['en']
                    }
                }

                this.form.status=this.$props.item.status;
                this.form.min_invest=this.$props.item.min_invest;
                this.form.valuation_cap=this.$props.item.valuation_cap;
                this.form.company_id=this.$props.item.company_id;
                this.form.video_url=this.$props.item.video_url;
                this.img_url = '/storage/companyInvest/img/' + this.$props.item.img_url;
                const lang_immutable_field = ['hight_light', 'overview_specialized', 'overview_company', 'financial_before', 'financial_after'];

                for (var field of lang_immutable_field) {
                    if (this.$props.item.immutable_field !== null && this.$props.item.immutable_field['lang_'+field] !== null) {
                        this.form.immutable_field[field+'_vi'] = this.$props.item.immutable_field['lang_'+field]['vi']
                        this.form.immutable_field[field+'_en'] = this.$props.item.immutable_field['lang_'+field]['en']
                    }
                }

                const lang_mutable_field = ['title','content'];
                for (var index in this.$props.item.mutable_field) {
                    var key = parseInt(index)+1;
                    this.form.mutable_field["s"+key] = {};

                    for (var field of lang_mutable_field) {
                        if (this.$props.item.mutable_field[index]['lang_'+field] !== null) {
                            this.form.mutable_field["s"+key][field+'_vi'] = this.$props.item.mutable_field[index]['lang_'+field]['vi'];
                            this.form.mutable_field["s"+key][field+'_en'] = this.$props.item.mutable_field[index]['lang_'+field]['en'];
                        }
                    }

                    this.form.mutable_field["s" + key]['position'] = this.$props.item.mutable_field[index]['position'];
                }

                setTimeout(() => {
                    self.offLoading()
                }, 2000);
            }
        },
        methods: {
            previewImage(id, event) {
                const input = event.target;

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if(id === 'img_url'){
                            this.img_url = e.target.result;
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                if (id === 'img_url') {
                    this.form.img_url = event.target.files[0];
                }
            },
            isInputImage() {
                return this.img_url === '';
            },
            archiveForm() {
                const formData = new FormData();

                for (var key in this.form) {
                    if (this.form[key] !== null && key !== 'immutable_field' && key !== 'mutable_field') {
                        if ((key !== 'img_url') || (key === 'img_url' && this.isInputImage)) {
                            formData.append(key, this.form[key]);
                        }
                    }

                    if (key === 'immutable_field') {
                        for (var immutable_key in this.form.immutable_field) {
                            formData.append(key + '['+immutable_key + ']',this.form.immutable_field[immutable_key]);
                        }
                    }

                    if (key === 'mutable_field') {
                        let arr = [];
                        var index = 0;

                        for (var mutable_key in this.form.mutable_field) {
                            var isEdit = false;

                            for (var field in this.form.mutable_field[mutable_key]) {
                                if (this.form.mutable_field[mutable_key][field] !== "") {
                                    isEdit = true;
                                    formData.append('mutable_field['+index+']['+field+']',this.form.mutable_field[mutable_key][field]);
                                    // break;
                                }
                            }

                            if (!isEdit) {
                                formData.delete('mutable_field['+index+']');
                            }

                            index++;
                        }
                    }
                }

                return formData;
            },
            createForm() {
                var self = this;
                self.onLoading();
                let formData = self.archiveForm();

                self.$store.dispatch('createCompanyInvest', formData)
                .then((res) => {
                    self.$store.dispatch('getAllCompanyInvest')
                    .then((res) => {
                        self.offLoading();
                        self.$toast.success('Thêm thông tin dự án thành công');
                        self.$bvModal.hide(self.$props.modalName);
                    })
                })
                .catch((err) => {
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err));
                    self.$toast.error('Xin thử lại');

                    for (var key in errorJson) {
                        for (var error in self.errors) {
                            if (typeof errorJson[error] === 'undefined') {
                                self.errors[error] = '';
                            } else {
                                self.errors[key] = errorJson[key][0];
                            }
                        }
                    }
                });
            },
            editForm() {
                var self = this;
                self.onLoading();
                let formData = {
                    id: self.$props.item.id,
                    form: self.archiveForm()
                };

                self.$store.dispatch('updateCompanyInvest', formData)
                .then((res) => {
                    self.$toast.success('Sửa thông tin dự án thành công');
                    self.$bvModal.hide(self.$props.modalName);
                    self.$store.dispatch("getAllCompanyInvestByPage", self.currentUrl.current_page)
                    .then((res) => {
                        self.offLoading();
                    })
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err));
                    self.$toast.error('Xin thử lại');

                    for (var key in errorJson) {
                        for (var error in self.errors) {
                            if (typeof errorJson[error] === 'undefined') {
                                self.errors[error] = '';
                            } else {
                                self.errors[key] = errorJson[key][0];
                            }
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
            extractTitleMutableFieldTab(title) {
                return title.replace("s", "");
            },
            addMoreMutableField() {
                let max_index = this.getMaxIndexMutableField();
                console.log("max_index",max_index);

                this.total_mutable_field++;
                this.form.mutable_field[max_index] = {
                    title_vi: "",
                    title_en: "",
                    content_vi: "",
                    content_en: "",
                    position: ""
                }
            },
            getNumberMutableField() {
                return (Object.keys(this.form.mutable_field).length);
            },
            getMaxIndexMutableField() {
                let max = 0;
                for (var key in this.form.mutable_field) {
                    let num_key = parseInt(key.replace("s",""));
                    if (num_key > max)
                        max = num_key;
                }
                ++max;

                return "s" + max;
            },
            removeThisField(name) {
                if (confirm('Xac nhan xoa')) {
                    this.total_mutable_field--;
                    delete this.form.mutable_field[name];
                }
            },
            mutable_tab(params) {
                console.log("mutable_tab change:", params);
                this.form.mutable_field.s1 = params;
            },

        },
    }
</script>
