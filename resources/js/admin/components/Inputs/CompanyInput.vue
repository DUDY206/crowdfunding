<template>
    <div>
        <b-form  >
            <b-tabs content-class="mt-3">
                <b-tab title="Tiếng Việt" active>
                    <!--TIẾNG VIỆT-->
                    <b-form-group >
                        <p>Tên công ty (VI) <span class="text-danger font-italic">{{errors.name_vi}}</span></p>
                        <b-form-input
                            v-model="form.name_vi"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group >
                        <p>Mô tả (VI) <span class="text-danger font-italic">{{errors.description_vi}}</span></p>
                        <b-form-input
                            v-model="form.description_vi"
                            type="text"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group >
                        <p>Loại công ty (VI) <span class="text-danger font-italic">{{errors.company_type_vi}}</span></p>
                        <b-form-input
                            v-model="form.company_type_vi"
                            type="text"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group >
                        <p>Địa chỉ công ty (VI) <span class="text-danger font-italic">{{errors.location_vi}}</span></p>
                        <b-form-input
                            v-model="form.location_vi"
                            type="text"
                        ></b-form-input>
                    </b-form-group>
                </b-tab>
                <!--TIẾNG ANH-->
                <b-tab title="English">
                    <b-form-group >
                        <p>Tên công ty (EN)<span class="text-danger font-italic">{{errors.name_en}}</span></p>
                        <b-form-input
                            v-model="form.name_en"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group >
                        <p>Mô tả (EN) <span class="text-danger font-italic">{{errors.description_en}}</span></p>
                        <b-form-input
                            v-model="form.description_en"
                            type="text"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group >
                        <p>Loại công ty (EN) <span class="text-danger font-italic">{{errors.company_type_en}}</span></p>
                        <b-form-input
                            v-model="form.company_type_en"
                            type="text"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group  >
                        <p>Địa chỉ công ty (EN) <span class="text-danger font-italic">{{errors.location_en}}</span></p>
                        <b-form-input
                            v-model="form.location_en"
                            type="text"
                        ></b-form-input>
                    </b-form-group>
                </b-tab>
            </b-tabs>

            <!--KHÔNG ĐA NGÔN NGỮ-->
            <b-row>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Chủ sở hữu (ID) <span class="text-danger font-italic">{{errors.account_id}}</span></p>
                        <b-form-input
                            v-model="form.account_id"
                            type="number"
                            required
                            min="0"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group   >
                        <p>Tên pháp lý <span class="text-danger font-italic">{{errors.legal_name}}</span></p>
                        <b-form-input
                            v-model="form.legal_name"
                            type="text"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group >
                        <p>Video giới thiệu (URL) <span class="text-danger font-italic">{{errors.video_url}}</span></p>
                        <b-form-input
                            v-model="form.video_url"
                            type="text"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Thành lập <span class="text-danger font-italic">{{errors.founded}}</span></p>
                        <b-form-input
                            v-model="form.founded"
                            type="date"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group >
                        <p>Số lượng nhân viên <span class="text-danger font-italic">{{errors.total_employees}}</span></p>
                        <b-form-input
                            v-model="form.total_employees"
                            type="text"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group >
                        <p>Website <span class="text-danger font-italic">{{errors.website}}</span></p>
                        <b-form-input
                            v-model="form.website"
                            type="text"
                        ></b-form-input>
                    </b-form-group>

                    <div class="mt-3">
                        Ảnh công ty
                        <span class="text-danger font-italic">{{errors.name_vi}}</span>
                    </div>

                    <input type="file" id="input_image_upload" ref="img_url" @change="previewImage('img_url', $event)" />
                    <img class="preview" :src="img_url" />
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
    import mixin from "../../mixin/genMixins";

    export default {
        name: "CompanyInput",
        props: [
            'item',
            'isAdd',
            'modalName',
            'onLoading',
            'offLoading'
        ],
        data() {
            return {
                form: {
                    name_vi:'',
                    name_en:'',
                    img_url:null,
                    account_id:'',
                    description_vi:'',
                    description_en:'',
                    company_type_vi:'',
                    company_type_en:'',
                    video_url:'',
                    legal_name:'',
                    founded:null,
                    total_employees:'',
                    website:'',
                    location_vi:'',
                    location_en:''
                },
                errors: {
                    name_vi:'',
                    name_en:'',
                    img_url:null,
                    account_id:'',
                    description_vi:'',
                    description_en:'',
                    company_type_vi:'',
                    company_type_en:'',
                    video_url:'',
                    legal_name:'',
                    founded:null,
                    total_employees:'',
                    website:'',
                    location_vi:'',
                    location_en:''
                },
                img_url:'',
            }
        },
        mounted() {
            if (!this.$props.isAdd) {
                this.form.name_vi = this.$props.item.lang_name.vi;
                this.form.name_en = this.$props.item.lang_name.en;
                this.img_url = '/storage/company/img/' + this.$props.item.img_url;
                this.form.account_id = this.$props.item.account_id;
                this.form.description_vi = this.$props.item.lang_description.vi;
                this.form.description_en = this.$props.item.lang_description.en;
                this.form.company_type_vi = this.$props.item.lang_company_type.vi;
                this.form.company_type_en = this.$props.item.lang_company_type.en;
                this.form.video_url = this.$props.item.video_url;
                this.form.legal_name = this.$props.item.legal_name;
                this.form.founded = this.$props.item.founded;
                this.form.total_employees = this.$props.item.total_employees;
                this.form.website = this.$props.item.website;
                this.form.location_vi = this.$props.item.lang_location.vi;
                this.form.location_en = this.$props.item.lang_location.en;
            }
        },
        computed: {
            ...mapGetters(['currentUrl'])
        },
        methods: {
            previewImage(id,event) {
                const input = event.target;

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        if (id === 'img_url') {
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
                    if (this.form[key] !== null) {
                        if ((key !== 'img_url') || (key === 'img_url' && this.isInputImage)) {
                            formData.append(key,this.form[key]);
                        }
                    }
                }

                return formData;
            },
            createForm() {
                var self = this;
                self.onLoading();
                let formData = self.archiveForm();

                self.$store.dispatch('createCompany', formData)
                .then((res) => {
                    self.$store.dispatch('getAllCompany')
                    .then((res) => {
                        self.offLoading();
                        self.clearInput();
                        self.$toast.success('Thêm công ty thành công');
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
            editForm() {
                var self = this;
                self.onLoading();

                let formData = {
                    id: self.$props.item.id,
                    form: self.archiveForm()
                };

                self.$store.dispatch('editCompany', formData)
                .then((res) => {
                    if (self.$route.query.keySearch === undefined) {
                        self.$store.dispatch("getCompanyByPage", self.currentUrl.current_page)
                        .then((res) => {
                            self.offLoading();
                            self.$toast.success('Cập nhật công ty thành công');
                            self.$bvModal.hide(self.$props.modalName);
                        })
                    } else {
                        let params = {
                            key: self.$route.query.keySearch,
                            page: self.currentUrl.current_page,
                        };

                        self.$store.dispatch("searchCompanyByPaginate", params)
                        .then((res) => {
                            self.offLoading();
                            self.$toast.success('Cập nhật công ty thành công');
                            self.$bvModal.hide(self.$props.modalName);
                        })
                    }
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

                this.img_url = '';
            }
        },
    }
</script>
