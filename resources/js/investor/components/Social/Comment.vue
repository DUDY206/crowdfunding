<template>
    <div class="comment mb-3 main-border ">
        <div class="main-discussion__question p-3">
            <div class="user_info d-flex align-items-center">
                <img src="/investor/images/tmp.jpg" alt="" class="small-icon d-inline mr-3">
                <div>
                    <p class="m-0 font-weight-bold">{{comment.user.full_name}}</p>
                    <span class="timestamp">{{comment.diff_created_at}}</span>
                </div>
            </div>
            <p v-html="comment.content">
            </p>
            <b-button variant="link" v-bind:class="{'color-pink':isLikedByCurrentUser,'color-grey':!isLikedByCurrentUser} " @click="likeComment"><b-icon icon="suit-heart-fill" scale="1" ></b-icon> {{comment.total_liked +' '+ $t('social.like')}} </b-button>
            <b-button variant="link" @click="isReplyComment = true" class="color-grey"><b-icon icon="pencil-fill" scale="1"></b-icon> {{$t('social.comment')}} </b-button>
        </div>
        <reply-comment v-for="rep_comment in comment.reply_comments" :key="rep_comment.id" :rep_comment="rep_comment" v-on:replyComment="isReplyComment = true">
        </reply-comment>

        <div class="main-discussion__input_reply p-3 bg-smoke" v-if="isReplyComment">
            <div class="user_info d-flex align-items-center">
                <img src="/investor/images/tmp.jpg" alt="" class="small-icon d-inline mr-lg-3">
                <b-form-input v-bind:placeholder="$t('company_invest_detail.comment_placeholder')"
                              class="small-icon" v-model="comment_content"></b-form-input>
                <b-button variant="primary" class="my-3  ml-3" @click="post_comment">Post</b-button>
            </div>

        </div>
    </div>
</template>

<script>
    import ReplyComment from "./ReplyComment";
    import router from "../../routes/index";
    export default {
        name: "Comment",
        components:{ReplyComment},
        props:[
            'comment'
        ],
        data(){
             return{
                 isReplyComment:false,
                 comment_content:'',
                 isLikedByCurrentUser:this.$props.comment.is_like_by_current_user,
             }
        },
        methods:{
            post_comment(){
                if(this.$store.state.auth.token == null){
                    router.push({path: '/login'}).then(r => {});
                }else{
                    let formData = new FormData();
                    formData.append('content',this.comment_content);
                    formData.append('reply_comment_id',this.comment.id);
                    this.$store.dispatch('createComment',formData).then((res)=>{
                        this.$props.comment.reply_comments.push(res.data);
                        this.comment_content = '';
                    }).catch((err)=>{
                        console.log(err)
                    })
                }
            },
            likeComment(){
                if(this.$store.state.auth.token == null){
                    router.push({path: '/login'}).then(r => {});
                }else{
                    let formData = new FormData();
                    if(this.isLikedByCurrentUser){
                        formData.append('is_liked',1);
                    }else{
                        formData.append('is_liked',0);
                    }
                    formData.append('model_id',this.$props.comment.id);
                    formData.append('model_type','social_comment');
                    console.log(formData)
                    this.$store.dispatch('likeModel',formData)
                        .then((res)=>{
                            if(this.isLikedByCurrentUser){
                                this.$props.comment.total_liked = this.$props.comment.total_liked -1;
                            }else{
                                this.$props.comment.total_liked = this.$props.comment.total_liked +1;
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
    .main-discussion__input_reply{
        border-top: 1px solid #ddd;
    }
    .timestamp{
        font-size: 0.75rem;
        color:var(--main-grey)
    }
    img{
        border-radius: 3px;
    }
    .btn-link{
        text-decoration: none!important;
    }
    .btn-link:hover{
        text-decoration: none!important;
        color: var(--main-pink)!important;
    }
</style>
