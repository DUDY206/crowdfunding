<template>
    <div>
        <b-form  >
            <b-row>
                <b-col cols="6">
                    <b-form-group  >
                        <p>User name <span class="text-danger font-italic">{{errors.user_name}}</span></p>
                        <b-form-input
                            v-model="form.user_name"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group  >
                        <p>Họ tên <span class="text-danger font-italic">{{errors.full_name}}</span></p>
                        <b-form-input
                            v-model="form.full_name"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group  >
                        <p>Mật khẩu <span class="text-danger font-italic">{{errors.password}}</span></p>
                        <b-form-input
                            v-model="form.password"
                            type="password"
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Email <span class="text-danger font-italic">{{errors.email}}</span></p>
                        <b-form-input
                            v-model="form.email"
                            type="email"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group  >
                        <p>Số điện thoại <span class="text-danger font-italic">{{errors.phone_number}}</span></p>
                        <b-form-input
                            v-model="form.phone_number"
                            type="number"
                        ></b-form-input>
                    </b-form-group>

                    <div class="mt-3">Ảnh đại diện<span class="text-danger font-italic">{{errors.avatar}}</span></div>
                    <input  type="file" id="input_image_upload" ref="img_url" @change="previewImage('img_url', $event)"/>
                    <img class="preview" :src="avatar" alt="">
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

    export default {
        name: "AdminInput",
        props: [
            'item',
            'isAdd',
            'modalName',
            'onLoading',
            'offLoading'
        ],
        data(){
            return {
                form:{
                    user_name:'',
                    full_name:'',
                    password:'',
                    email:'',
                    phone_number:'',
                    avatar:'',
                },
                errors:{
                    user_name:'',
                    full_name:'',
                    password:'',
                    email:'',
                    phone_number:'',
                    avatar:'',
                },
                avatar:'',
                is_input_avata:false,
            }
        },
        computed: {
            ...mapGetters(['auth', 'currentUrl'])
        },
        methods:{
            previewImage(id, event) {
                const input = event.target;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if(id === 'img_url'){
                            this.avatar = e.target.result;
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                if (id === 'img_url') {
                    this.form.avatar = event.target.files[0];
                    this.is_input_avata = true;
                }
            },
            archiveForm(){
                const formData = new FormData();
                for (var key in this.form) {
                    if (this.form[key] !== null) {
                        if ((key !== 'avatar') || (key === 'avatar' && this.is_input_avata)) {
                            formData.append(key,this.form[key]);
                        }
                    }
                }

                return formData;
            },
            createForm(){
                var self = this;
                self.onLoading();
                let formData = self.archiveForm();

                self.$store.dispatch('createAdmin', formData)
                .then((res) => {
                    self.$store.dispatch('getAllAdmin')
                    .then((res) => {
                        self.offLoading();
                        self.clearInput();
                        self.$toast.success('Thêm admin thành công');
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

                self.$store.dispatch('editAdmin', formData)
                .then((res) => {
                    if (self.auth.user.id === self.$props.item.id) {
                        self.$toast.info('Đang cập nhật thông tin đang đăng nhập');
                        self.$store.dispatch("getCurrentAdmin", self.$props.item.id)
                        .then((res) => {
                            self.$store.dispatch("getAdminByPage", self.currentUrl.current_page)
                            .then((res) => {
                                self.offLoading();
                                self.$toast.success('Cập nhật admin thành công');
                                self.$bvModal.hide(self.$props.modalName);
                            })
                        });
                    } else {
                        self.$store.dispatch("getAdminByPage", self.currentUrl.current_page)
                        .then((res) => {
                            self.offLoading();
                            self.$toast.success('Cập nhật admin thành công');
                            self.$bvModal.hide(self.$props.modalName);
                        })
                    }
                })
                .catch((err) => {
                    var self = this;
                    self.offLoading();
                    let errorJson = JSON.parse(JSON.stringify(err))
                    console.log(err);

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
                for (var key in this.form) {
                    if (key !== 'avatar') {
                        this.form[key] = this.$props.item[key];
                    }

                    if (key === 'password') {
                        this.form[key] = '';
                    }
                }
                this.avatar = '/storage/admin/avata/' + this.$props.item.avatar;
            }
        }
    }
</script>
