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
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Email <span class="text-danger font-italic">{{errors.email}}</span></p>
                        <b-form-input
                            v-model="form.email"
                            type="text"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group  >
                        <p>Số điện thoại <span class="text-danger font-italic">{{errors.phone_number}}</span></p>
                        <b-form-input
                            v-model="form.phone_number"
                            type="text"
                        ></b-form-input>
                    </b-form-group>

                    <div class="mt-3">Ảnh đại diện<span class="text-danger font-italic">{{errors.avatar}}</span></div>
                    <input  type="file" id="input_image_upload" ref="img_url" @change="previewImage('img_url',$event)"/>
                    <img class="preview" :src="avatar"  alt="">
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
        name: "AdminInput",
        props:[
            'item',
            'isAdd',
            'modalName'
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
        methods:{
            previewImage(id,event){
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
                if(id === 'img_url'){
                    this.form.avatar = event.target.files[0];
                    this.is_input_avata = true;
                }
            },
            archiveForm(){
                const formData = new FormData();
                for(var key in this.form){
                    if(this.form[key] !== null){
                        if((key !== 'avatar') || (key === 'avatar' && this.is_input_avata)){
                            formData.append(key,this.form[key]);
                        }
                    }
                }
                return formData
            },
            createForm(){
                let formData = this.archiveForm();
                this.$store.dispatch('createAdmin',formData)
                    .then((res) => {
                        this.$toast.success('Thêm admin thành công');
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
                this.$store.dispatch('editAdmin',formData)
                    .then((res) => {
                        this.$toast.success('Sửa admin thành công');
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
            if(!this.$props.isAdd){
                for(var key in this.form){
                    if(key !== 'avatar'){
                        this.form[key] = this.$props.item[key];
                    }
                }
                this.avatar = '/storage/admin/avata/' + this.$props.item.avatar;
            }
        }
    }
</script>

<style scoped>

</style>
