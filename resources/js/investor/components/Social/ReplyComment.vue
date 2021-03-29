<template>
    <div class="main-discussion__answers p-3 bg-smoke space-left-10">
        <div class="user_info d-flex ">
            <img :src="'/storage/investor/avatar/' + rep_comment.user.avatar" alt="" class="small-icon d-inline mr-lg-3">
            <div>
                <p class="m-0">{{ rep_comment.user.full_name }}</p>
                <span class="timestamp">{{rep_comment.diff_created_at}}</span>

                <p class="m-0" v-html="rep_comment.content">
                </p>
                <b-button variant="link" v-bind:class="{'color-pink':isLikedByCurrentUser,'color-grey':!isLikedByCurrentUser} " @click="likeComment"><b-icon icon="suit-heart-fill" scale="1"></b-icon> {{rep_comment.total_liked +' '+ $t('social.like')}} </b-button>
                <!-- <b-button v-if="this.auth.token != null" variant="link" v-on:click="$emit('replyComment')" class="color-grey"><b-icon icon="pencil-fill" scale="1"></b-icon> {{$t('social.comment')}} </b-button> -->
            </div>
        </div>

    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "ReplyComment",
        props:[
            'rep_comment'
        ],
        computed: {
            ...mapGetters([
                'locale', 'auth'
            ])
        },
        data(){
            return{
                isLikedByCurrentUser:this.$props.rep_comment.is_like_by_current_user,
            }
        },
        methods:{
            likeComment(){
                if(this.$store.state.auth.token == null){
                    this.$route.push({path: '/'+state.locale}).then(r => {});
                }else{
                    let formData = new FormData();
                    if(this.isLikedByCurrentUser){
                        formData.append('is_liked',1);
                    }else{
                        formData.append('is_liked',0);
                    }
                    formData.append('model_id',this.$props.rep_comment.id);
                    formData.append('model_type','social_comment');
                    this.$store.dispatch('likeModel',formData)
                        .then((res)=>{
                            if(this.isLikedByCurrentUser){
                                this.$props.rep_comment.total_liked = this.$props.rep_comment.total_liked -1;
                            }else{
                                this.$props.rep_comment.total_liked = this.$props.rep_comment.total_liked +1;
                            }
                            this.isLikedByCurrentUser = !this.isLikedByCurrentUser;
                        }).catch(err=>{
                        console.log(err)
                    })
                    ;
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .main-discussion__input_reply {
        border-top: 1px solid #ddd;
    }

    .timestamp {
        font-size: 0.75rem;
        color:var(--main-grey)
    }

    img {
        border-radius: 3px;
    }

    .btn-link {
        text-decoration: none!important;
    }

    .btn-link:hover {
        text-decoration: none!important;
        color: var(--main-pink)!important;
    }

    .space-left-10 {
        margin-left: 10px;
    }
</style>
