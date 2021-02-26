<template>
    <card>
        <h4 slot="header" class="card-title">Edit Profile</h4>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <base-input type="text"
                                label="Username"
                                placeholder="Username"
                                v-model="form.user_name"

                    >
                    </base-input>
                </div>
                <div class="col-md-6">
                    <base-input type="text"
                                label="Họ tên"
                                placeholder="Họ tên"
                                v-model="form.full_name"
                    >
                    </base-input>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <base-input type="text"
                                label="Mật khẩu"
                                placeholder="******"
                                v-model="form.password">
                    </base-input>
                </div>
                <div class="col-md-4">
                    <base-input type="text"
                                label="Email"
                                placeholder="Email"
                                v-model="form.email">
                    </base-input>
                </div>
                <div class="col-md-4">
                    <base-input type="text"
                                label="Số điện thoại"
                                placeholder="113"
                                v-model="form.phone_number">
                    </base-input>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-info btn-fill float-right" @click.prevent="updateProfile">
                    Update Profile
                </button>
            </div>
            <div class="clearfix"></div>
        </form>
    </card>
</template>
<script>
    import Card from '../../components/Cards/Card.vue'
    import {mapGetters} from "vuex";

    export default {
        components: {
            Card
        },
        data() {
            return {
                form:{
                    user_name:'',
                    full_name:'',
                    password:'',
                    email:'',
                    phone_number:'',
                },
                errors:{
                    user_name:'',
                    full_name:'',
                    password:'',
                    email:'',
                    phone_number:'',
                },
            }
        },
        computed:{
            ...mapGetters(['auth'])
        },
        methods: {
            updateProfile() {
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
            archiveForm(){
                const formData = new FormData();
                for(var key in this.form){
                    if(this.form[key] !== null){
                        formData.append(key,this.form[key]);
                    }
                }
                return formData
            },
        },
        mounted() {
            for(var key in this.form){
                this.form[key] = this.auth.user[key];
            }
        }
    }

</script>
<style>

</style>
