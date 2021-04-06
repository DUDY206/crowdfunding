<template>
    <card>
        <h4 slot="header" class="card-title">Edit Profile</h4>
        <form>
            <div class="row">
                <div class="col-md-6 ck-error">
                    <base-input type="text"
                        label="Username"
                        placeholder="Username"
                        v-model="form.user_name" >
                    </base-input>
                    <div class="error-input" v-if="errors.user_name != ''">{{errors.user_name}}</div>
                </div>
                <div class="col-md-6 ck-error">
                    <base-input type="text"
                        label="Họ tên"
                        placeholder="Họ tên"
                        v-model="form.full_name" >
                    </base-input>
                    <div class="error-input" v-if="errors.full_name != ''">{{errors.full_name}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 ck-error">
                    <base-input type="password"
                        label="Mật khẩu"
                        placeholder="******"
                        v-model="form.password" >
                    </base-input>
                    <div class="error-input" v-if="errors.password != ''">{{errors.password}}</div>
                </div>
                <div class="col-md-4 ck-error">
                    <base-input type="text"
                        label="Email"
                        placeholder="Email"
                        v-model="form.email">
                    </base-input>
                    <div class="error-input" v-if="errors.email != ''">{{errors.email}}</div>
                </div>
                <div class="col-md-4 ck-error">
                    <base-input type="text"
                        label="Số điện thoại"
                        placeholder="113"
                        v-model="form.phone_number">
                    </base-input>
                    <div class="error-input" v-if="errors.phone_number != ''">{{errors.phone_number}}</div>
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
    import {mapGetters} from "vuex";
    import Card from '../../components/Cards/Card.vue';
    import DotSpaceProgress from '../../../commons/DotSpaceProgress.vue';

    export default {
        components: {
            Card,
            DotSpaceProgress
        },
        props: {
            onLoading: Function,
            offLoading: Function,
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
                self.onLoading();

                let formData = {
                    id: self.auth.user.id,
                    form: self.archiveForm()
                }

                self.$store.dispatch('editAdmin', formData)
                .then((res) => {
                    self.errors.user_name = '';
                    self.errors.full_name = '';
                    self.errors.password = '';
                    self.errors.email = '';
                    self.errors.phone_number = '';
                    self.$toast.success('Cập nhật thông tin thành công');
                    self.form.password = '';
                    self.$store.dispatch('getCurrentAdmin', self.auth.user.id);
                    self.offLoading();
                })
                .catch((err) => {
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

                    self.offLoading();
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
<style lang="scss">
    .ck-error {
        position: relative;

        .error-input {
            background: #ff030391;
            border-radius: 5px;
            padding: 5px;
            width: fit-content;
            color: white;
            position: absolute;
            top: 65px;
        }

        .error-input:before {
            content: '';
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid #ff030391;
            position: absolute;
            top: -5px;
            left: 10px;
        }
    }
</style>
