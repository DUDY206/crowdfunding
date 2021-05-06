<template>
    <div v-if="checkLogin">
        <div
            class="banner"
            :class="{'cover':(auth.user.cover_photo_path === null)}"
            v-bind:style="{
                'background-image': 'url(' + auth.user.cover_photo_path + ')' ,
                'background-position': '50% 50%',
                'object-fit': 'cover',
            }"
        >
            <div
                class=" py-5 container" :class="{'edit-user':isEditing}"
                v-bind:style="{
                    'background': 'hsla(0,0%,8%,.85)',
                }"
            >
                <div v-if="isEditing" class="text-white">
                    <h2>{{ $t('my_profile.edit_my_profile') }}</h2>
                    <b-row >
                        <b-col offset-lg="2" lg="7" sm="12">
                            <h4 class="title-under-edit">{{ $t('my_profile.about_you') }}</h4>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.avatar') }}</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="file" ref="avatar" @change="previewImage('avatar',$event)">
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.cover_photo') }}</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="file" ref="cover_photo" @change="previewImage('cover_photo',$event)">
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.fullname') }}</p>
                                </b-col>
                                <b-col cols="9" class="parent-inp">
                                    <input type="text" v-model="form.full_name">
                                    <div class="tooltip-nt" v-if="errors.full_name">
                                        <i class="far fa-times-circle"></i>
                                        <div class="error-message">{{errors.full_name}}</div>
                                    </div>
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.username') }}</p>
                                </b-col>
                                <b-col cols="9" class="parent-inp">
                                    <input type="text" v-model="form.user_name">
                                    <div class="tooltip-nt" v-if="errors.user_name">
                                        <i class="far fa-times-circle"></i>
                                        <div class="error-message">{{errors.user_name}}</div>
                                    </div>
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.email') }}</p>
                                </b-col>
                                <b-col cols="9" class="parent-inp">
                                    <input type="text" v-model="form.email">
                                    <div class="tooltip-nt" v-if="errors.email">
                                        <i class="far fa-times-circle"></i>
                                        <div class="error-message">{{errors.email}}</div>
                                    </div>
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.phone') }}</p>
                                </b-col>
                                <b-col cols="9" class="parent-inp">
                                    <input type="text" v-model="form.phone_number">
                                    <div class="tooltip-nt" v-if="errors.phone_number">
                                        <i class="far fa-times-circle"></i>
                                        <div class="error-message">{{errors.phone_number}}</div>
                                    </div>
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.birth_date') }}</p>
                                </b-col>
                                <b-col cols="9" class="parent-inp">
                                    <input type="date" v-model="form.date_of_birth">
                                    <div class="tooltip-nt" v-if="errors.date_of_birth">
                                        <i class="far fa-times-circle"></i>
                                        <div class="error-message">{{errors.date_of_birth}}</div>
                                    </div>
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.description') }}</p>
                                </b-col>
                                <b-col cols="9">
                                    <textarea type="text" v-model="form.description" rows="3"></textarea>
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.slogan') }}</p>
                                </b-col>
                                <b-col cols="9">
                                    <textarea type="text" v-model="form.slogan" rows="3"></textarea>
                                </b-col>
                            </b-row>
                        </b-col>
                        <!-- <b-col lg="6" sm="12">
                            <h4 class="title-under-edit">{{ $t('my_profile.link') }}</h4>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>AngelList</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" placeholder="https://angle.co/user-info">
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Facebook</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" placeholder="https://facebook.com/user-info">
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Twitter</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" placeholder="https://twitter.com/user-info">
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>LinkedIn</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" placeholder="https://linkedin.co/user-info" >
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Website</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" placeholder="https://website.com/user-info">
                                </b-col>
                            </b-row>
                        </b-col> -->
                    </b-row>
                    <div class="d-flex justify-content-end mt-3">
                        <b-button variant="light" class="mr-3" @click="isEditing = false">{{ $t('my_profile.cancel') }}</b-button>
                        <b-button variant="danger" @click="editForm" class="btn-edit-info" v-bind:class="{ 'unactive-btn loading': this.isLoading }">
                            <dot-progress v-if="isLoading"></dot-progress>
                            <div v-else>{{ $t('my_profile.save') }}</div>
                        </b-button>
                    </div>
                </div>
                <div v-if="isFormChangePassword" class="text-white">
                    <h2>{{ $t('my_profile.change_password') }}</h2>
                    <b-row >
                        <b-col offset-lg="2" lg="7" sm="12">
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.old_password') }}</p>
                                </b-col>
                                <b-col cols="9" class="parent-inp">
                                    <input type="password" v-model="formPassword.old_password">
                                    <!-- <div class="tooltip-nt" v-if="errors.user_name">
                                        <i class="far fa-times-circle"></i>
                                        <div class="error-message">{{errors.user_name}}</div>
                                    </div> -->
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.new_password') }}</p>
                                </b-col>
                                <b-col cols="9" class="parent-inp">
                                    <input type="password" v-model="formPassword.new_password">
                                    <!-- <div class="tooltip-nt" v-if="errors.user_name">
                                        <i class="far fa-times-circle"></i>
                                        <div class="error-message">{{errors.user_name}}</div>
                                    </div> -->
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>{{ $t('my_profile.repassword') }}</p>
                                </b-col>
                                <b-col cols="9" class="parent-inp">
                                    <input type="password" v-model="formPassword.repassword">
                                    <!-- <div class="tooltip-nt" v-if="errors.user_name">
                                        <i class="far fa-times-circle"></i>
                                        <div class="error-message">{{errors.user_name}}</div>
                                    </div> -->
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                    <div class="d-flex justify-content-end mt-3">
                        <b-button variant="light" class="mr-3" @click="isFormChangePassword = false">{{ $t('my_profile.cancel') }}</b-button>
                        <b-button variant="danger" class="btn-edit-info" @click="changePassword" v-bind:class="{ 'unactive-btn loading': this.isLoading }">
                            <dot-progress v-if="isLoading"></dot-progress>
                            <div v-else>{{ $t('my_profile.submit_change_password') }}</div>
                        </b-button>
                    </div>
                </div>
                <b-row v-if="!isEditing && !isFormChangePassword">
                    <b-col cols="12" lg="8">
                        <div class="d-flex flex-lg-row flex-column text-white">
                            <img v-if="auth.user.avatar !== ''" v-bind:src="domain + auth.user.avatar_path" alt="" class="avatar">
                            <img v-else v-bind:src="domain + 'admin/img/default_avatar.png'" alt="" class="avatar">
                            <div class="pl-lg-3 fs-information">
                                <h1 class="font-weight-bold ">
                                    {{auth.user.full_name}}
                                    <a variant="light" @click="openBoxOptionInformation" v-if="!isBoxOptionInformation">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <a variant="light" @click="closeBoxOptionInformation" v-if="isBoxOptionInformation">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </h1>
                                <p class="description">({{auth.user.slogan}})</p>
                                <p class="small-text">
                                    <b-icon icon="clock"></b-icon> {{ $t('my_profile.member_since') }} {{auth.user.date_created_at}}
                                </p>
                                <p class="description">{{auth.user.description}}</p>
                                <div class="box-setting-option" v-if="isBoxOptionInformation">
                                    <ul>
                                        <li>
                                            <a @click="isEditing = true">{{ $t('my_profile.edit_my_profile') }}</a>
                                        </li>
                                        <li>
                                            <a @click="openFormChangePassword">{{ $t('my_profile.change_password') }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- <div>
                                    <b-badge variant="primary">Primary</b-badge>
                                    <b-badge variant="secondary">Secondary</b-badge>
                                    <b-badge variant="success">Success</b-badge>

                                    <a href="#"><img src="/investor/images/fb.png" alt="" class="tiny-icon"></a>
                                    <a href="#"><img src="/investor/images/linkin-icon.png" alt="" class="tiny-icon"></a>
                                    <a href="#"><img src="/investor/images/twiiter-icon.png" alt="" class="tiny-icon"></a>
                                </div> -->
                            </div>
                        </div>
                    </b-col>
                    <b-col cols="12" lg="4" >
                        <!-- <b-button variant="light" @click="isEditing = true" class="mt-lg-0 mt-5"> -->
                        <!-- </b-button> -->
                    </b-col>
                </b-row>
            </div>
        </div>
        <user-timeline :is-current-user="true" :viewer="false" :user="auth.user"></user-timeline>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import UserTimeline from "../components/UserTimeline";
    import router from "../routes";
    import DotProgress from "../../commons/DotProgress";
    import env from '../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "UserInfo",
        components: {
            UserTimeline,
            DotProgress,
        },
        computed:{
            ...mapGetters(['auth', 'locale'])
        },
        mounted() {
            var self = this;

            if (self.auth.token === null) {
                self.checkLogin = false;
                self.$router.push({path: '/login'}).then(r => {});
            } else {
                self.checkLogin = true;
                for(var key in this.form){
                    if(key !== 'avatar' && key !== 'cover_photo'){
                        this.form[key] = this.auth.user[key];
                    }
                }

                if (this.$store.state.locale !== undefined){
                    this.$i18n.locale = this.$store.state.locale;
                    this.$store.commit("setLocale", this.$store.state.locale);
                } else {
                    this.$i18n.locale = "en";
                    this.$store.commit("setLocale", "en");
                }
            }

        },
        data() {
            return {
                domain: domain,
                isEditing: false,
                isLoading: false,
                isBoxOptionInformation: false,
                isFormChangePassword: false,
                checkLogin: false,
                form:{
                    avatar:"",
                    cover_photo:"",
                    full_name:"",
                    user_name:"",
                    email:"",
                    phone_number:"",
                    date_of_birth:"",
                    description:"",
                    slogan:"",
                },
                errors:{
                    avatar:"",
                    cover_photo:"",
                    full_name:"",
                    user_name:"",
                    email:"",
                    phone_number:"",
                    date_of_birth:"",
                },
                file:{
                    avatar:false,
                    cover_photo:false,
                },
                formPassword: {
                    old_password: "",
                    new_password: "",
                    repassword: "",
                },
            }
        },
        methods: {
            openBoxOptionInformation() {
                var self = this;
                self.isBoxOptionInformation = true;
            },
            closeBoxOptionInformation() {
                var self = this;
                self.isBoxOptionInformation = false;
                self.formPassword.old_password = '';
                self.formPassword.new_password = '';
                self.formPassword.repassword = '';
            },
            openFormChangePassword() {
                var self = this;
                self.isFormChangePassword = true;
            },
            previewImage(id,event){
                this.form[id] = event.target.files[0];
                this.file[id] = true
            },
            archiveForm(){
                const formData = new FormData();
                for(var key in this.form){
                    if(this.form[key] !== null){
                        if(key !== 'avatar' && key !== 'cover_photo'){
                            formData.append(key,this.form[key]);
                        }else if(key === 'avatar' && this.file.avatar){
                            formData.append('avatar',this.form.avatar);
                        }else if(key === 'cover_photo' && this.file.cover_photo){
                            formData.append(key,this.form.cover_photo);
                        }
                    }
                }
                return formData
            },
            clear() {
                this.errors.avatar = "";
                this.errors.cover_photo = "";
                this.errors.full_name = "";
                this.errors.user_name = "";
                this.errors.email = "";
                this.errors.phone_number = "";
                this.errors.date_of_birth = "";
            },
            editForm(){
                let formData = {
                    id: this.auth.user.id,
                    form: this.archiveForm()
                }
                var self = this;
                self.isLoading = true;

                this.$store.dispatch('editUser', formData)
                .then((res) => {
                    self.$store.dispatch('getUserById', formData.id)
                    .then((res) => {
                        self.isEditing = false;
                        self.isLoading = false;
                        self.clear();
                        self.$toast.success(self.$t('my_profile.update_info_success'));
                    })
                    .catch((err) => {
                        self.isEditing = false;
                        self.isLoading = false;
                        self.$toast.error(self.$t('errors.error_1'));
                    })
                })
                .catch((err)=>{
                    self.isLoading = false;

                    self.$toast.error(self.$t('my_profile.update_info_fail'));
                    let errorJson = JSON.parse(JSON.stringify(err.response.data.errors));

                    for (var key in errorJson) {
                        for (var error in this.errors) {
                            if (typeof errorJson[error] === 'undefined') {
                                this.errors[error] = '';
                            } else {
                                this.errors[key] = errorJson[key][0];
                            }
                        }
                    }
                })

                self.closeBoxOptionInformation();
            },
            changePassword() {
                var self = this;
                self.isLoading = true;
                const formData = new FormData();

                for (let key in self.formPassword) {
                    formData.append(key, self.formPassword[key]);
                }

                let data = {
                    id: this.auth.user.id,
                    form: formData
                };

                self.$store.dispatch('changePassword', data)
                .then((res) => {
                    self.isLoading = false;

                    if (res.data.status === false) {
                        self.$toast.error(self.$t("my_profile." + res.data.message));
                    } else {
                        self.isFormChangePassword = false;
                        self.$toast.success(self.$t('my_profile.change_pass_success'));
                    }
                })
                .catch((err) => {
                    self.isLoading = false;
                    self.$toast.error(self.$t('my_profile.change_pass_fail'));
                })
                self.closeBoxOptionInformation();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .avatar{
        width: 160px;
        height: 160px;
        min-width: 160px!important;
        min-height: 160px!important;
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid #fff;
    }

    h1:first-letter{
        text-transform: uppercase;
    }

    .font-weight-bold {
        display: flex;
        align-items: center;

        a {
            font-size: 25px;
            margin-left: 20px;
            margin-top: 3px;
            cursor: pointer;
        }

        a i:hover {
            color: #25b4d4;
        }
    }

    .description{
        // max-height: 50px;
    }
    .cover{
        background: rgb(21,42,119)!important;
        background: linear-gradient(0deg, rgba(21,42,119,1) 0%, rgba(39,74,177,1) 62%, rgba(21,42,119,1) 100%)!important;

    }
    .edit-user{
        background: rgba(0,0,0,0.5);
    }
    p{
        color: var(--main-grey);
        font-weight: bold;
        margin:0;
        font-size: 0.8rem;
    }
    input,textarea{
        box-sizing: border-box;
        padding:0.3rem ;
        border: 1px solid #ddd !important;
        border-radius: 3px;
        width: 100%;
        font-size: 15px;
    }
    input:focus,textarea:focus {
        box-sizing: border-box;
        border: 1px solid #0049ff;
        outline: none;
        box-shadow: 0 0 2px 2px rgb(85 85 85 / 5%);
    }
    input[type="file"]{
        border: 2px dashed rgba(0,73,255,.5) !important;
    }
    .input_field{
        padding: 0.5rem 0;
        & > div{
            display: flex;
            align-items: center;
        }
    }

    .parent-inp {
        position: relative;

        .tooltip-nt {
            position: absolute;
            top: 7px;
            right: 20px;
            color: red;

            .error-message {
                background: red;
                color: white;
                border-radius: 3px;
                padding: 4px 10px;
                font-size: 12px;
                position: absolute;
                top: -33px;
                left: -9px;
                width: max-content;
            }

            .error-message:before {
                content: "";
                width: 0px;
                height: 0px;
                border: 5px solid white;
                border-top: 6px solid transparent;
                position: absolute;
                left: 12px;
                top: 26px;
                background: red;
            }
        }
    }

    .btn-edit-info {
        position: relative;
    }

    .btn-edit-info:hover {
        background-color: #942310;
    }

    .unactive-btn {
        pointer-events: none;
        background: #942310;
    }

    .loading {
        height: 38px;
        width: 59px;
    }

    .title-under-edit {
        font-size: 0.8rem;
    }

    .fs-information {
        position: relative;

        .box-setting-option {
            position: absolute;
            top: 17px;
            right: -265px;
            border: 1px solid #ccc;
            background: white;
            border-radius: 5px;
            width: 250px;

            ul {
                list-style: none;
                margin: 0;
                width: 100%;
                display: flex;
                flex-direction: column;
                padding: 2px;

                li {
                    a {
                        display: block;
                        cursor: pointer;
                        text-decoration: none;
                        border-radius: 5px;
                        padding: 5px;
                        color: black;
                    }

                    a:hover {
                        background: rgba(0,0,0,.75);
                        color: white;
                    }
                }
            }
        }
    }

    @media only screen and (max-width: 988px) {
        .fs-information {
            .box-setting-option {
                top: 15px;
                right: 100px;
            }
        }
    }

    @media only screen and (max-width: 960px) {
        .banner{
            background-size: auto 100% !important;
            & > div{
                background: rgba(0,0,0,0.5)
            }
        }
    }

    @media only screen and (max-width: 768px) {
        .fs-information {
            .box-setting-option {
                left: 67px;
                top: 45px;
            }
        }
    }

    @media only screen and (max-width: 350px) {
        .fs-information {
            .box-setting-option {
                left: 67px;
                top: 75px;
            }
        }
    }
</style>
