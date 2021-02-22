<template>
    <div class="comment mb-3 main-border ">
        <div class="main-discussion__question p-3">
            <div class="user_info d-flex align-items-center">
                <img src="/investor/images/tmp.jpg" alt="" class="small-icon d-inline mr-lg-3">
                <div>
                    <p class="m-0">ten nv</p>
                    <span>times 10/20/2020</span>
                </div>
            </div>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, similique voluptate. A amet aut
                cupiditate est fuga iure labore laborum molestiae nihil perspiciatis quibusdam repellat rerum sed
                ullam voluptates, voluptatibus!
            </p>
            <b-button variant="link"><b-icon icon="suit-heart-fill" scale="1"></b-icon> {{$t('social.like')}} </b-button>
            <b-button variant="link" @click="replyComment"><b-icon icon="pencil-fill" scale="1"></b-icon> {{$t('social.comment')}} </b-button>
        </div>
        <div class="main-discussion__answers p-3 bg-smoke" v-for="index in 3" :key="index">
            <div class="user_info d-flex ">
                <img src="/investor/images/tmp.jpg" alt="" class="small-icon d-inline mr-lg-3">
                <div>
                    <p class="m-0">ten nv</p>
                    <span>times 10/20/2020</span>

                    <p class="m-0">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, similique voluptate. A amet aut
                        cupiditate est fuga iure labore laborum molestiae nihil perspiciatis quibusdam repellat rerum sed
                        ullam voluptates, voluptatibus!
                    </p>
                    <b-button variant="link"><b-icon icon="suit-heart-fill" scale="1"></b-icon> {{$t('social.like')}} </b-button>
                    <b-button variant="link" @click="replyComment"><b-icon icon="pencil-fill" scale="1"></b-icon> {{$t('social.comment')}} </b-button>
                </div>
            </div>

        </div>

        <div class="main-discussion__input_reply p-3 bg-smoke" v-if="isReplyComment">
            <div class="user_info d-flex align-items-center">
                <img src="/investor/images/tmp.jpg" alt="" class="small-icon d-inline mr-lg-3">
                <b-form-input v-bind:placeholder="$t('company_invest_detail.comment_placeholder')"
                              class="small-icon"></b-form-input>
                <b-button variant="primary" class="my-3  ml-3">Post</b-button>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "ReplyComment",
        data(){
             return{
                 isReplyComment:false
             }
        },
        methods:{
            replyComment(){
                this.isReplyComment = true;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .main-discussion__input_reply{
        border-top: 1px solid #ddd;
    }
</style>
