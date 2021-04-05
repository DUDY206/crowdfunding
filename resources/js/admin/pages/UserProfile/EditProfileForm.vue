<template>
    <card>
        <h4 slot="header" class="card-title">Edit Profile</h4>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <base-input type="text"
                        label="Username"
                        placeholder="Username"
                        v-model="form.user_name" >
                    </base-input>
                </div>
                <div class="col-md-6">
                    <base-input type="text"
                        label="Họ tên"
                        placeholder="Họ tên"
                        v-model="form.full_name" >
                    </base-input>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <base-input type="password"
                        label="Mật khẩu"
                        placeholder="******"
                        v-model="form.password" >
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
                    Cập nhật
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
                form: {
                    user_name:'',
                    full_name:'',
                    password:'',
                    email:'',
                    phone_number:'',
                },
                errors: {
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
                var self = this;

                let formData = {
                    id: self.auth.user.id,
                    form: self.archiveForm()
                }

                self.$store.dispatch('editAdmin', formData)
                .then((res) => {
                    self.$toast.success('Cập nhật thông tin thành công');
                    self.form.password = '';
                    self.$store.dispatch('getCurrentAdmin', self.auth.user.id);
                })
                .catch((err) => {
                    let errorJson = JSON.parse(JSON.stringify(err));
                    self.$toast.error('Xin thử lại');
                    console.log(err);

                    // for (var key in errorJson) {
                    //     if (typeof errorJson[key] !== 'undefined') {
                    //         self.errors[key] = errorJson[key][0];
                    //     } else {
                    //         self.errors[key] = '';
                    //     }
                    // }
                });
            },
            archiveForm() {
                const formData = new FormData();

                for (var key in this.form) {
                    if (this.form[key] !== null) {
                        formData.append(key,this.form[key]);
                    }
                }

                return formData;
            },
        },
        mounted() {
            var self = this;

            for (var key in self.form) {
                self.form[key] = self.auth.user[key];
            }
            self.form.password = '';
        }
    }

</script>
<style>

</style>
