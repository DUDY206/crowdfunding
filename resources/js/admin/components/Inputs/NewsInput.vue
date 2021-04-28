<template>
    <div>
        <b-form>
            <b-tabs content-class="mt-3">
                <div class="mt-3">Ảnh đại diện (kích thước phù hợp: 1140 x 600) <span class="text-danger font-italic text-bold">{{errors.img_url}}</span></div>
                <input type="file" id="input_image_upload" ref="img_url" @change="previewImage('img_url', $event)" />
                <img class="preview" :src="img_url" />

                <br>
                <br>

                <b-form-group>
                    <p>
                        ID dự án
                        <a class="pl-icon pointer" @click="openModalCompanyInvest">
                            <i class="fas fa-plus"></i>
                        </a>
                        <span class="text-danger font-italic text-bold">{{errors.invest_id}}</span>
                    </p>
                    <!-- <b-form-input
                        v-model="form.invest_id"
                        type="text"
                        required
                    ></b-form-input> -->

                    <div class="wrapper-multiple" v-if="listInvestId.length > 0">
                        <div class="box" v-for="item of listInvestId" v-bind:key="item">
                            <div class="mul w-content">{{ item }}</div>
                            <div class="mul w-action">
                                <a class="pointer" @click="removeInvestId(item)">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </b-form-group>

                <b-tab title="VI" active>
                    <b-row>
                        <b-col cols="12">
                            <b-form-group>
                                <p>Tên bài viết <span class="text-danger font-italic text-bold">{{errors.name_vi}}</span></p>
                                <b-form-input
                                    v-model="form.name_vi"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group>
                                <p>Mô tả <span class="text-danger font-italic text-bold">{{errors.description_vi}}</span></p>
                                <b-form-input
                                    v-model="form.description_vi"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group>
                                <p>Nội dung <span class="text-danger font-italic text-bold">{{errors.content_vi}}</span></p>
                                <ckeditor v-model="form.content_vi" :config="config"></ckeditor>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-tab>
                <b-tab title="EN">
                    <b-row>
                        <b-col cols="12">
                            <b-form-group>
                                <p>Tên bài viết <span class="text-danger font-italic text-bold">{{errors.name_en}}</span></p>
                                <b-form-input
                                    v-model="form.name_en"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group>
                                <p>Mô tả <span class="text-danger font-italic text-bold">{{errors.description_en}}</span></p>
                                <b-form-input
                                    v-model="form.description_en"
                                    type="text"
                                    required
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group>
                                <p>Nội dung <span class="text-danger font-italic text-bold">{{errors.content_en}}</span></p>
                                <ckeditor v-model="form.content_en" :config="config"></ckeditor>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-tab>
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
        <modal-company-invest
            v-if="isModalCompanyInvest"
            :closeModalCompanyInvest="closeModalCompanyInvest"
            :listInvestId="listInvestId"
            :removeInvestId="removeInvestId"
        />
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import globalCKeditorConfig from "../../globalCKeditorConfig";
    import ModalCompanyInvest from "../../components/Modal-Dialog/ModalCompanyInvest";

    export default {
        name: "NewsInput",
        components: {
            ModalCompanyInvest,
        },
        props: [
            'item',
            'isAdd',
            'modalName',
            'onLoading',
            'offLoading',
            'updatePaginate',
        ],
        data() {
            return {
                config: globalCKeditorConfig,
                form: {
                    invest_id: [],
                    img_url: null,
                    name_vi: "",
                    name_en: "",
                    description_vi: "",
                    description_en: "",
                    content_vi: "",
                    content_en: "",
                },
                errors: {
                    invest_id: null,
                    img_url: null,
                    name_vi: "",
                    name_en: "",
                    content_vi: "",
                    content_en: "",
                },
                img_url: "",
                isModalCompanyInvest: false,
                listInvestId: [],
            }
        },
        computed: {
            ...mapGetters(['currentUrl'])
        },
        mounted() {
            var self = this;

            if (!self.$props.isAdd) {
                self.img_url = '/storage/news/' + self.$props.item.img_url;

                for (var invest of self.$props.item.company_invest) {
                    self.listInvestId.push(invest.id);
                }

                self.form.name_vi = self.$props.item.lang_name.vi;
                self.form.name_en = self.$props.item.lang_name.en;
                self.form.description_vi = self.$props.item.lang_description.vi;
                self.form.description_en = self.$props.item.lang_description.en;
                self.form.content_vi = self.$props.item.lang_content.vi;
                self.form.content_en = self.$props.item.lang_content.en;
            } else {
                if (typeof self.$route.params.investId !== 'undefined') {
                    self.listInvestId.push(parseInt(self.$route.params.investId));
                }
            }
        },
        methods: {
            getAllNews() {
                var self = this;

                self.$store.dispatch('getAllNews')
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            },
            getAllNewsOfInvest(investId) {
                var self = this;

                self.$store.dispatch('getAllNewsOfInvest', investId)
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            },
            getAllNewsByPage(page) {
                var self = this;

                self.$store.dispatch('getAllNewsByPage', page)
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            },
            getAllNewsOfInvestByPage(params) {
                var self = this;

                self.$store.dispatch('getAllNewsOfInvestByPage', params)
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            },
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
            archiveForm() {
                const formData = new FormData();

                this.form.invest_id = this.listInvestId;

                for (var key in this.form) {
                    if (key === 'invest_id') {
                        formData.append(key, '[' + this.form.invest_id + ']');
                    } else {
                        formData.append(key, this.form[key]);
                    }
                }

                return formData;
            },
            openModalCompanyInvest() {
                var self = this;

                self.isModalCompanyInvest = true;
            },
            closeModalCompanyInvest() {
                var self = this;

                self.isModalCompanyInvest = false;
            },
            removeInvestId(investId) {
                var self = this;

                const index = self.listInvestId.indexOf(investId);

                if (index > -1) {
                    self.listInvestId.splice(index, 1);
                }
            },
            createForm() {
                var self = this;
                self.onLoading();
                const formData = self.archiveForm();

                self.$store.dispatch('createNews', formData)
                .then((res) => {

                    if (typeof self.$route.params.investId === 'undefined') {
                        self.getAllNews();

                        if (self.currentUrl.current_page !== 1) {
                            self.$router.push({path: '/news'}).then(r => {});
                        }
                    } else {
                        self.getAllNewsOfInvest(self.$route.params.investId);

                        if (self.currentUrl.current_page !== 1) {
                            self.$router.push({path: '/news/' + self.$route.params.investId}).then(r => {});
                        }
                    }

                    self.$toast.success('Thêm tin tức mới thành công');
                    self.$bvModal.hide(self.$props.modalName);
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
                })
            },
            editForm() {
                var self = this;
                self.onLoading();

                let formData = {
                    id: self.$props.item.id,
                    form: self.archiveForm()
                };

                self.$store.dispatch('updateNews', formData)
                .then((res) => {
                    if (typeof self.$route.params.investId === 'undefined') {
                        self.getAllNewsByPage(self.currentUrl.current_page);
                    } else {
                        let params = {
                            investId: self.$route.params.investId,
                            page: self.currentUrl.current_page
                        };

                        self.getAllNewsOfInvestByPage(params);
                    }

                    self.$toast.success('Cập nhật tin tức thành công');
                    self.$bvModal.hide(self.$props.modalName);
                })
                .catch((err) => {
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err));

                    for (var key in errorJson) {
                        for (var error in self.errors) {
                            if (typeof errorJson[error] === 'undefined') {
                                self.errors[error] = '';
                            } else {
                                self.errors[key] = errorJson[key][0];
                            }
                        }
                    }

                    self.$toast.error('Xin thử lại');
                })
            }
        }
    }
</script>

<style scoped lang="scss">
    img {
        width: 400px;
    }

    .mul {
        color: white;
    }

    .pl-icon {
        margin-left: 5px;
    }

    .pl-icon:hover {
        color: #0a98b5;
    }

    .modal-dialog {
        z-index: 999999;
    }

    .wrapper-multiple {
        background-color: #FFFFFF;
        border: 1px solid #E3E3E3;
        border-radius: 4px;
        color: #565656;
        box-shadow: none;
        position: relative;
        align-items: center;
        overflow: auto;

        .box {
            display: flex;
            background: #007bffa6;
            border-radius: 5px;
            padding: 0 10px;
            margin: 5px;
            width: fit-content;
            float: left;

            .w-action {
                a {
                    background: #f0fff4;
                    margin-left: 10px;
                    padding: 0px 3px;
                    border-radius: 50%;
                    color: red;
                    font-weight: bold;
                }

                a:hover {
                    background: red !important;
                    color: white !important;
                }
            }
        }
    }
</style>
