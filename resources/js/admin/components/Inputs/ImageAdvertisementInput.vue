<template>
    <div>
        <b-form  >
            <b-tabs content-class="mt-3">
                <div class="mt-3">Chọn ảnh <span class="text-danger font-italic text-bold">{{ errors.img }}</span></div>
                <input type="file" id="input_image_upload" ref="img" @change="previewImage('img', $event)" />
                <img class="preview" :src="img"
                    :style="{
                        width: '300px',
                        height: '300px',
                        objectFit: 'contain',
                    }"
                />

                <b-form-group >
                    <p>Chèn link</p>
                    <b-form-input
                        v-model="form.url"
                        type="text"
                    ></b-form-input>
                </b-form-group>

                <b-form-group >
                    <p>Sắp xếp</p>
                    <b-form-select v-model="form.sort_level" :options="sort_level_option"></b-form-select>
                </b-form-group>

                <b-form-group >
                    <p>Trạng thái</p>
                    <b-form-select v-model="form.status" :options="status_option"></b-form-select>
                </b-form-group>
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
    import mixin from "../../mixin/genMixins";

    export default {
        name: "ImageAdvertisementInput",
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
                    img: '',
                    url: '',
                    sort_level: 1,
                    status: 0,
                },
                sort_level_option: [
                    { value: 1, text: 'Level 1' },
                    { value: 2, text: 'Level 2' },
                    { value: 3, text: 'Level 3' },
                    { value: 4, text: 'Level 4' },
                    { value: 5, text: 'Level 5' },
                ],
                status_option: [
                    { value: 0, text: 'Hiển thị' },
                    { value: 1, text: 'Ẩn' },
                ],
                errors: {
                    img: '',
                },
                img: '',
            }
        },
        mounted() {
            var self = this;

            if (!self.$props.isAdd) {
                self.onLoading();
                self.$store.dispatch('showImageAdvertisement', self.item.id)
                .then((res) => {
                    self.form.img = res.data.img;
                    self.img = res.data.url_folder_img;
                    self.form.url = res.data.url;
                    self.form.sort_level = res.data.sort_level;

                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            }
        },
        computed: {
            ...mapGetters(['currentUrl'])
        },
        methods: {
            getAllImageAdvertisement(self) {
                self.$store.dispatch('getAllImageAdvertisement')
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    self.offLoading();
                })
            },
            getAllImageAdvertisementByPage(self, page) {
                self.$store.dispatch('getAllImageAdvertisementByPage', page)
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
                        if (id === 'img') {
                            this.img = e.target.result;
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }

                if (id === 'img') {
                    this.form.img = event.target.files[0];
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
                let formData = self.archiveForm();

                self.$store.dispatch('createImageAdvertisement', formData)
                .then((res) => {
                    self.getAllImageAdvertisement(self);
                    self.$toast.success('Thêm thông tin thành công');
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
            editForm() {
                var self = this;
                self.onLoading();

                let formData = {
                    id: self.item.id,
                    form: self.archiveForm()
                };

                this.$store.dispatch('updateImageAdvertisement', formData)
                    .then((res) => {
                        self.getAllImageAdvertisementByPage(self, self.currentUrl.current_page);
                        self.$toast.success('Cập nhật thành công');
                        self.$bvModal.hide(this.$props.modalName);
                    })
                    .catch((err) => {
                        self.offLoading();
                        let errorJson = JSON.parse(JSON.stringify(err))
                        this.$toast.error('Xin thử lại');
                        for (var key in errorJson) {
                            if (typeof errorJson[key] !== 'undefined') {
                                this.errors[key] = errorJson[key][0];
                            } else {
                                this.errors[key] = '';
                            }
                        }
                    });
            },
        },
    }
</script>
