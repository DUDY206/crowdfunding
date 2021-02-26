<template>
    <div>
        <div
            class="banner"
            :class="{'cover':(auth.user.cover_photo_path === null)}"
            v-bind:style="{
            'background-image': 'url(' + auth.user.cover_photo_path + ')' ,
            'background-size': '100% auto',
            'background-position': '50% 50%',
        }"
        >
            <div class=" py-5 container" :class="{'edit-user':isEditing}">
                <div v-if="isEditing" class="text-white" >
                    <h2>Edit my profile</h2>
                    <b-row >
                        <b-col lg="6" sm="12">
                            <h3>About you</h3>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Avatar</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="file" ref="avatar" @change="previewImage('avatar',$event)">
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Cover photo</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="file" ref="cover_photo" @change="previewImage('cover_photo',$event)">
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Full name</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" v-model="form.full_name">
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>User name</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" v-model="form.user_name">
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Email</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" v-model="form.email">
                                </b-col>
                            </b-row>
                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Phone</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" v-model="form.phone_number">
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Birth date</p>
                                </b-col>
                                <b-col cols="9">
                                    <input type="text" v-model="form.date_of_birth">
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Description</p>
                                </b-col>
                                <b-col cols="9">
                                    <textarea type="text" v-model="form.description" rows="3"></textarea>
                                </b-col>
                            </b-row>

                            <b-row class="input_field">
                                <b-col cols="3">
                                    <p>Slogan</p>
                                </b-col>
                                <b-col cols="9">
                                    <textarea type="text" v-model="form.slogan" rows="3"></textarea>
                                </b-col>
                            </b-row>

                        </b-col>
                        <b-col lg="6" sm="12">
                            <h3>Link</h3>
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
                        </b-col>
                    </b-row>
                    <div class="d-flex justify-content-end mt-3">
                        <b-button variant="light" class="mr-3" @click="isEditing = false">Cancel</b-button>
                        <b-button variant="danger" @click="editForm">Save</b-button>
                    </div>
                </div>
                <b-row v-else>
                    <b-col cols="12" lg="8">
                        <div class="d-flex flex-lg-row flex-column text-white">
                            <img v-bind:src="auth.user.avatar_path" alt="" class="avatar">
                            <div class="pl-lg-3">
                                <h1 class="font-weight-bold ">{{auth.user.full_name}}</h1>
                                <b-icon icon="clock">
                                </b-icon>
                                <p class="small-text">Member since {{auth.user.date_created_at}}</p>
                                <div>
                                    <b-badge variant="primary">Primary</b-badge>
                                    <b-badge variant="secondary">Secondary</b-badge>
                                    <b-badge variant="success">Success</b-badge>

                                    <a href="#"><img src="/investor/images/fb.png" alt="" class="tiny-icon"></a>
                                    <a href="#"><img src="/investor/images/linkin-icon.png" alt="" class="tiny-icon"></a>
                                    <a href="#"><img src="/investor/images/twiiter-icon.png" alt="" class="tiny-icon"></a>
                                </div>

                                <p class="description">{{auth.user.description}}</p>
                            </div>
                        </div>
                    </b-col>
                    <b-col cols="12" lg="4" >
                        <b-button variant="light" @click="isEditing = true" class="mt-lg-0 mt-5">Edit my profile</b-button>
                    </b-col>
                </b-row>
            </div>

        </div>
        <user-timeline :is-current-user="true" :user="auth.user"></user-timeline>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import UserTimeline from "../components/UserTimeline";
    import router from "../routes";

    export default {
        name: "UserInfo",
        components:{
            UserTimeline
        },
        data(){
            return {
                isEditing:false,
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
                    description:"",
                    slogan:"",
                },
                file:{
                    avatar:false,
                    cover_photo:false,
                }
            }
        },
        methods:{
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
            editForm(){
                let formData = {
                    id:this.auth.user.id,
                    form:this.archiveForm()
                }
                this.$store.dispatch('editUser',formData)
                    .then((res)=>{
                        this.isEditing = false;
                    }).catch((err)=>{
                        let errorJson = JSON.parse(JSON.stringify(err))
                        console.log(err)
                        this.$toast.error('Xin thử lại');
                        for(var key in errorJson){
                            if(typeof errorJson[key] !== 'undefined'){
                                this.errors[key] = errorJson[key][0];
                            }else{
                                this.errors[key] = '';
                            }
                        }
                })
            },
        },
        computed:{
            ...mapGetters(['auth'])
        },
        mounted() {
            for(var key in this.form){
                if(key !== 'avatar' && key !== 'cover_photo'){
                    this.form[key] = this.auth.user[key];
                }
            }
            if(this.$store.state.locale !== undefined){
                this.$i18n.locale = this.$store.state.locale;
                this.$store.commit("setLocale",this.$store.state.locale);
            }else{
                this.$i18n.locale = "en";
                this.$store.commit("setLocale","en");
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
    .description{
        max-height: 50px;
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
        border: 1px solid #ddd!important;
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
        border: 2px dashed rgba(0,73,255,.5);
    }
    .input_field{
        padding: 0.5rem 0;
        & > div{
            display: flex;
            align-items: center;
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
</style>
