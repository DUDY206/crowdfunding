<template>
    <div>
        <div
            class="banner"
            :class="{'cover':(user.cover_photo_path === null)}"
            v-bind:style="{
            'background-image': 'url(' + user.cover_photo_path + ')' ,
            'background-size': '100% auto',
            'background-position': '50% 50%',
        }"
        >
            <div class=" py-5 container" >
                <b-row>
                    <b-col cols="12" lg="8">
                        <div class="d-flex flex-lg-row flex-column text-white">
                            <img v-bind:src="user.avatar_path" alt="" class="avatar">
                            <div class="pl-lg-3">
                                <h1 class="font-weight-bold ">{{user.full_name}}</h1>
                                <b-icon icon="clock">
                                </b-icon>
                                <p class="small-text">Member since {{user.date_created_at}}</p>
                                <div>
                                    <b-badge variant="primary">Primary</b-badge>
                                    <b-badge variant="secondary">Secondary</b-badge>
                                    <b-badge variant="success">Success</b-badge>

                                    <a href="#"><img src="/investor/images/fb.png" alt="" class="tiny-icon"></a>
                                    <a href="#"><img src="/investor/images/linkin-icon.png" alt="" class="tiny-icon"></a>
                                    <a href="#"><img src="/investor/images/twiiter-icon.png" alt="" class="tiny-icon"></a>
                                </div>

                                <p class="description">{{user.description}}</p>
                            </div>
                        </div>
                    </b-col>
                    <b-col cols="12" lg="4" v-if="user.id !== auth.user.id">
                        <b-button variant="light" @click="followAction(0)" class="mt-lg-0 mt-5" v-if="isCanLike">Follow</b-button>
                        <b-button variant="light"  @click="followAction(1)" class="mt-lg-0 mt-5" v-else>Following</b-button>
                    </b-col>
                </b-row>
            </div>

        </div>
        <user-timeline :is-current-user="false" :user="user" :key="user.id" v-if="user.id !== 0"></user-timeline>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import UserTimeline from "../components/UserTimeline";
    import mixin from "../mixin/genMixins";
    import router from "../routes";

    export default {
        name: "UserInfoSlug",
        components:{
            UserTimeline
        },
        data(){
            return {
                user:{
                    id:0
                },
                isCanLike:false,
            }
        },
        computed:{
            ...mapGetters(['auth'])
        },
        methods:{
            followAction(isFollowed){
                if(this.$store.state.auth.token == null){
                    this.$route.push({path: '/login'}).then(r => {});
                }else{
                    let formData = new FormData();
                    formData.append('is_liked',isFollowed);
                    formData.append('model_id',this.user.id);
                    formData.append('model_type','user');
                    this.$store.dispatch('likeModel',formData)
                        .then((res)=>{
                            this.user.is_like_by_current_user = !this.user.is_like_by_current_user;
                            this.isCanLike=!this.isCanLike;
                        }).catch(err=>{
                        console.log(err)
                    })
                    ;
                }
            },
            isEmptyModel(){
                return  mixin.methods.isEmptyObject(this.user);
            },
        },
        mounted() {
            if(this.$store.state.locale !== null){
                this.$i18n.locale = this.$store.state.locale;
                this.$store.commit("setLocale",this.$store.state.locale);
            }else{
                this.$i18n.locale = "en";
                this.$store.commit("setLocale","en");
            }
            this.$store.dispatch('getUserBySlug',this.$route.params.slug)
                .then((res)=>{
                    this.user = res.data
                    if(this.auth.user.id === this.user.id){
                        this.isCanLike = false
                        console.log('current')
                        router.push({path: '/'+this.$i18n.locale+'/user-info'}).then(r => {});
                    }else
                        this.isCanLike = !this.user.is_like_by_current_user;
                }).catch((err)=>{
                    console.log(err)
            })
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
