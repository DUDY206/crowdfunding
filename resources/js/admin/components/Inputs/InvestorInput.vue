<template>
    <div>
        <b-form  >
            <b-row>
                <b-col cols="6">
                    <b-form-group>
                        <p>User name <span class="text-danger font-italic">{{errors.user_name}}</span></p>
                        <b-form-input
                            v-model="form.user_name"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group>
                        <p>Họ tên <span class="text-danger font-italic">{{errors.full_name}}</span></p>
                        <b-form-input
                            v-model="form.full_name"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group>
                        <p>Ngày sinh<span class="text-danger font-italic">{{errors.date_of_birth}}</span></p>
                        <b-form-input
                            v-model="form.date_of_birth"
                            type="date"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group>
                        <p>Mô tả <span class="text-danger font-italic">{{errors.description}}</span></p>
                        <b-form-textarea
                            v-model="form.description"
                            rows="3"
                            max-rows="6"
                            class="w-100"
                        ></b-form-textarea>
                    </b-form-group>

                    <div class="mt-3">Xác nhận tài khoản<span class="text-danger font-italic">{{errors.is_verify}}</span></div>
                    <b-form-select v-model="form.is_verify" :options="options.is_verify"></b-form-select>

                    <div class="mt-3">Ảnh bìa<span class="text-danger font-italic">{{errors.cover_photo}}</span></div>
                    <input type="file" id="input_image_upload2" ref="cover_photo" @change="previewImage('cover_photo', $event)"/>
                    <img class="preview w-100" :src="cover_photo"  alt="" >

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

                    <b-form-group  >
                        <p>Mật khẩu <span class="text-danger font-italic">{{errors.password}}</span></p>
                        <b-form-input
                            v-model="form.password"
                            type="password"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group  >
                        <p>Slogan <span class="text-danger font-italic">{{errors.slogan}}</span></p>
                        <b-form-textarea
                            v-model="form.slogan"
                            rows="3"
                            max-rows="6"
                            class="w-100"
                        ></b-form-textarea>
                    </b-form-group>

                    <div class="mt-3">Độ tin cậy<span class="text-danger font-italic">{{errors.is_reliable_investor}}</span></div>
                    <b-form-select v-model="form.is_reliable_investor" :options="options.is_reliable_investor"></b-form-select>

                    <div class="mt-3">Ảnh đại diện<span class="text-danger font-italic">{{errors.avatar}}</span></div>
                    <input type="file" id="input_image_upload" ref="avatar" @change="previewImage('avatar', $event)"/>
                    <img class="preview w-100" :src="avatar"  alt="" >
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
    export default {
        name: "InvestorInput",
        props:[
            'item',
            'isAdd',
            'modalName'
        ],
        data(){
            return {
                form:{
                    avatar:"",
                    cover_photo:"",
                    full_name:"",
                    user_name:"",
                    email:"",
                    password:"",
                    phone_number:"",
                    date_of_birth:"",
                    description:"",
                    slogan:"",
                    is_reliable_investor:"",
                    is_verify:""
                },
                errors:{
                    avatar:"",
                    cover_photo:"",
                    full_name:"",
                    user_name:"",
                    email:"",
                    password:"",
                    phone_number:"",
                    date_of_birth:"",
                    description:"",
                    slogan:"",
                    is_reliable_investor:"",
                    is_verify:""
                },
                avatar:'',
                cover_photo:"",
                file:{
                    avatar:false,
                    cover_photo:false,
                },
                options:{
                    is_verify:[
                        {
                            value:1,
                            text: 'Đã xác nhận'
                        },
                        {
                            value:0,
                            text: 'Chưa xác nhận'
                        },
                    ],
                    is_reliable_investor:[
                        {
                            value:1,
                            text: 'Nhà đầu tư tin cậy'
                        },
                        {
                            value:0,
                            text: 'Nhà đầu tư phổ thông'
                        },
                    ]
                }
            }
        },
        methods:{
            previewImage(id, event) {
                const input = event.target;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        console.log(e);
                        if (id === 'avatar') {
                            this.avatar = e.target.result;
                        }
                        if(id === 'cover_photo'){
                            this.cover_photo = e.target.result;
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }

                if (id === 'avatar') {
                    this.form.avatar = event.target.files[0];
                    this.file.avatar = true;
                }
                if(id === 'cover_photo'){
                    this.form.cover_photo = event.target.files[0];
                    this.file.cover_photo = true;
                }
            },
            archiveForm(){
                const formData = new FormData();
                for (var key in this.form) {
                    if (this.form[key] !== null) {
                        if (key !== 'avatar' && key !== 'cover_photo') {
                            formData.append(key, this.form[key]);
                        } else if (key === 'avatar' && this.file.avatar) {
                            formData.append(key, this.form[key]);
                        } else if (key === 'cover_photo' && this.file.cover_photo) {
                            formData.append(key, this.form[key]);
                        }
                    }
                }

                return formData;
            },
            createForm(){
                let formData = this.archiveForm();
                this.$store.dispatch('createInvestor', formData)
                    .then((res) => {
                        this.$toast.success('Thêm investor thành công');
                        this.clearInput();
                        this.$bvModal.hide(this.$props.modalName)
                    })
                    .catch((err) => {
                        let errorJson = JSON.parse(JSON.stringify(err))
                        console.log(errorJson)
                        this.$toast.error('Xin thử lại');
                        for(var key in errorJson){
                            if(typeof errorJson[key] !== 'undefined'){
                                this.errors[key] = errorJson[key][0];
                            }else{
                                this.errors[key] = '';
                            }
                        }
                    });
            },
            editForm(){
                let formData = {
                    id:this.$props.item.id,
                    form:this.archiveForm()
                }
                this.$store.dispatch('editInvestor',formData)
                    .then((res) => {
                        this.$toast.success('Sửa investor thành công');
                        this.$bvModal.hide(this.$props.modalName)
                    })
                    .catch((err) => {
                        let errorJson = JSON.parse(JSON.stringify(err))
                        console.log(errorJson)
                        this.$toast.error('Xin thử lại');
                        for(var key in errorJson){
                            if(typeof errorJson[key] !== 'undefined'){
                                this.errors[key] = errorJson[key][0];
                            }else{
                                this.errors[key] = '';
                            }
                        }
                    });
            },
            clearInput(){
                for(var key in this.form){
                    this.form[key] = '';
                    this.errors[key] = '';
                }
                this.avatar = '';

            }
        },
        mounted() {
            if (!this.$props.isAdd) {
                console.log(this.$props.item);
                for(var key in this.form){
                    if(key !== 'avatar'){
                        this.form[key] = this.$props.item[key];
                    }
                }
                this.avatar = '/storage/investor/avatar/' + this.$props.item.avatar;
                this.cover_photo = '/storage/investor/cover_photo/' + this.$props.item.cover_photo;
            }
        }
    }
</script>

<style scoped>

</style>
