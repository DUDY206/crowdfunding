<template>
    <div>
        <b-form>
            <b-tabs content-class="mt-3">
                <div class="mt-3">Chọn logo <span class="text-danger font-italic text-bold">{{errors.logo}}</span></div>
                <input type="file" id="input_image_upload" ref="logo" @change="previewImage('logo', $event)" />
                <img class="preview" :src="logo"
                    :style="{
                        width: '50px',
                        height: '50px',
                        objectFit: 'cover',
                    }"
                />

                <br>

                <div class="mt-3">
                    Chọn ảnh cover (kích thước phù hợp: 1140 x 600)
                    <a href="" @click="removeImgCover">Xóa ảnh cover</a>
                    <span class="text-danger font-italic text-bold">{{errors.img_cover}}</span>
                </div>
                <input type="file" id="input_image_upload" ref="img_cover" @change="previewImage('img_cover', $event)" />
                <img class="preview" :src="img_cover" />

                <br>
                <br>

                <b-tab title="VI" active>
                    <b-row>
                        <b-col cols="12">
                            <b-form-group>
                                <p>Tên thể loại ngành <span class="text-danger font-italic text-bold">{{errors.name_vi}}</span></p>
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
                        </b-col>
                    </b-row>
                </b-tab>
                <b-tab title="EN">
                    <b-row>
                        <b-col cols="12">
                            <b-form-group>
                                <p>Tên thể loại ngành <span class="text-danger font-italic text-bold">{{errors.name_en}}</span></p>
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
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "CategoryInput",
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
                form: {
                    logo: null,
                    img_cover: null,
                    name_vi: "",
                    name_en: "",
                    description_vi: "Đang cập nhật...",
                    description_en: "Updating...",
                },
                errors: {
                    logo: null,
                    img_cover: null,
                    name_vi: "",
                    name_en: "",
                    description_vi: "",
                    description_en: "",
                },
                logo: "",
                img_cover: "",
            }
        },
        computed: {
            ...mapGetters(['currentUrl'])
        },
        mounted() {
            var self = this;

            if (!self.$props.isAdd) {
                self.logo = '/storage/categories/logo/' + self.$props.item.logo;
                self.img_cover = '/storage/categories/cover/' + self.$props.item.img_cover;

                self.form.name_vi = self.$props.item.lang_name.vi;
                self.form.name_en = self.$props.item.lang_name.en;
                self.form.description_vi = self.$props.item.lang_description.vi;
                self.form.description_en = self.$props.item.lang_description.en;
            }
        },
        methods: {
            removeImgCover(e) {
                e.preventDefault();

                this.img_cover = '';
                this.form.img_cover = null;
            },
            getAllCategory() {
                var self = this;

                self.$store.dispatch('getAllCategory')
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            },
            getAllCategoryByPage(page) {
                var self = this;

                self.$store.dispatch('getAllCategoryByPage', page)
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
                        if (id === 'img_cover') {
                            this.img_cover = e.target.result;
                        }

                        if (id === 'logo') {
                            this.logo = e.target.result;
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }

                if (id === 'img_cover') {
                    this.form.img_cover = event.target.files[0];
                }

                if (id === 'logo') {
                    this.form.logo = event.target.files[0];
                }
            },
            archiveForm() {
                const formData = new FormData();

                for (var key in this.form) {
                    formData.append(key, this.form[key]);
                }

                return formData;
            },
            createForm() {
                var self = this;
                self.onLoading();
                const formData = self.archiveForm();

                self.$store.dispatch('createCategory', formData)
                .then((res) => {
                    self.getAllCategory();

                    if (self.currentUrl.current_page !== 1) {
                        self.$router.push({path: '/category'}).then(r => {});
                    }

                    self.$toast.success('Thêm thể loại ngành mới thành công');
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

                self.$store.dispatch('updateCategory', formData)
                .then((res) => {
                    if (self.$route.query.keySearch === undefined) {
                        self.getAllCategoryByPage(self.currentUrl.current_page);
                        self.$toast.success('Cập nhật tin tức thành công');
                        self.$bvModal.hide(self.$props.modalName);
                    } else {
                        let params = {
                            key: self.$route.query.keySearch,
                            page: self.currentUrl.current_page,
                        };

                        self.$store.dispatch("searchCategoryByPaginate", params)
                        .then((res) => {
                            self.offLoading();
                            self.$toast.success('Cập nhật tin tức thành công');
                            self.$bvModal.hide(self.$props.modalName);
                        })
                    }
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
