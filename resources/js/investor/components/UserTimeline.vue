<template>
    <div class="container">
        <div class="py-5 investment">
            <div class="block-item">
                <h3>Investment</h3>
                <div class="mt-5">
                    <b-row>
                        <b-col lg="3" cols="12" v-for="(companyInvest,index) in listCompanyInvest.data" :key="companyInvest.id" class="mb-3" v-if="index <= 6">
                            <company-invest-card :company-invest="companyInvest"></company-invest-card>
                            <div class="mt-3">
                                <div class="d-flex flex-row">
                                    <img src="/investor/images/tmp.jpg" alt="" class="user-invest-avatar">
                                    <p class="color-grey pl-3 m-0">
                                        User invest <span class="text-dark">$ 1.000</span>
                                    </p>
                                </div>
                                <p class="pt-2">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores fugiat itaque laudantium molestiae quae voluptas.
                                </p>
                            </div>
                        </b-col>
                    </b-row>

                </div>
            </div>
        </div>
        <b-row class="pb-5">
            <b-col lg="8" sm="12">
                <div class="block-item">
                    <div v-if="isCurrentUser">
                        <h3>Post</h3>
                        <textarea name="" id="" cols="3" class="w-100"></textarea>

                        <b-button>Post</b-button>
                    </div>

                    <div class="mt-5">
                        <user-post v-for="index in 5"></user-post>
                    </div>
                </div>
            </b-col>
            <b-col lg="4" sm="12">
                <div class="block-item">
                    <h3>Following</h3>
                    <user-info-card v-for="index in total_followers" :key="index"></user-info-card>
                </div>

                <div class="block-item">
                    <h3>Followers</h3>
                    <user-info-card v-for="index in total_followers" :key="index"></user-info-card>
                </div>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import UserInfoCard from "./Card/UserInfoCard";
    import UserPost from "./UserInfo/UserPost";
    import CompanyInvestCard from "./Card/CompanyInvestCard";
    import {mapGetters} from "vuex";
    export default {
        name: "UserTimeline",
        props:[
            'isCurrentUser'
        ],
        data(){
            return {
                total_following:3,
                total_followers:3,
            }
        },
        components:{
            UserInfoCard,
            UserPost,
            CompanyInvestCard
        },
        computed:{
            ...mapGetters([
                'listCompanyInvest'
            ])
        }

    }
</script>

<style lang="scss" scoped>
    .block-item{
        h3{
            font-weight: bold;
            color:var(--main-grey);
        }
        margin-top: 1.5rem;
    }
    .user-invest-avatar{
        width: 30px;
        height: 30px;
        min-width: 30px!important;
        min-height: 30px!important;
        object-fit: cover;
        border-radius: 2px;
    }
    .investment{
        border-bottom: 1px solid #eee;
    }
</style>
