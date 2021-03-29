<template>
    <div class="container">
        <div class="py-5 investment">
            <div class="block-item">
                <h3>Investment</h3>
                <div class="mt-5">
                    <b-row>
                        <b-col lg="3" cols="12" v-for="companyInvest in listCompanyInvest.data" :key="companyInvest.id" class="mb-3">
                            <company-invest-card :company-invest="companyInvest"></company-invest-card>
                        </b-col>
                    </b-row>
                </div>
            </div>
        </div>
        <b-row class="pb-5">
            <b-col lg="8" sm="12">
                <div class="block-item">
                    <div class="mt-5 title-notifications">
                        <user-post></user-post>
                    </div>
                </div>
            </b-col>
            <b-col lg="4" sm="12">
                <div class="block-item">
                    <h3>Following</h3>
                    <user-info-card v-for="user in user_follow.follow_user" :key="user.id" :user="user"></user-info-card>
                </div>

                <div class="block-item">
                    <h3>Followers</h3>
                    <user-info-card v-for="user in user_follow.be_followed" :key="user.id" :user="user"></user-info-card>
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
            'isCurrentUser',
            'user'
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
                'listCompanyInvest', 'user_follow', 'auth', 'locale'
            ])
        },
        mounted() {
            let formData_follow = new FormData();
            formData_follow.append('user_id', this.$props.user.id);
            this.$store.dispatch('account_follow_user', formData_follow);

            let formData_befollow = new FormData();
            formData_befollow.append('user_id', this.$props.user.id);
            this.$store.dispatch('account_be_followed', formData_befollow);

            var param = {
                slug: this.auth.user.slug,
                locale: this.locale,
            };

            // this.$store.dispatch('getAllCompanyInvestByUser', param)
            // .then((res) => {
            //     console.log(res);
            // })
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

    .title-notifications {
        margin-top: 0 !important;
    }
</style>
