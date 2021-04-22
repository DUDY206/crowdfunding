<template>
    <div class="container">
        <div class="py-5 investment" v-if="typeof listCompanyInvestByUser === 'undefined'">
            <a @click="refreshPage" class="text-blue cursor-pointer">{{ $t('errors.error_1') }}</a>
        </div>
        <div class="py-5 investment" v-else>
            <div class="block-item">
                <h3>{{ $t('my_profile.investment') }}</h3>
                <div class="mt-5">
                    <circle-progress v-if="isLoadingInvestment"></circle-progress>
                    <b-row v-if="listCompanyInvestByUser.length !== 0 && isLoadingInvestment == false">
                        <b-col lg="3" cols="12" v-for="companyInvest in listCompanyInvestByUser" :key="companyInvest.id" class="mb-3">
                            <company-invest-card :company-invest="companyInvest"></company-invest-card>
                        </b-col>
                    </b-row>
                    <div v-if="listCompanyInvestByUser.length === 0 && isLoadingInvestment == false" class="text-center">
                        {{ $t('my_profile.no_investment') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="loading-notifi-follow" v-if="isLoadingNotification_Follow">
            <circle-progress></circle-progress>
        </div>
        <b-row v-else class="pb-5">
            <b-col lg="8" sm="12" v-if="!viewer">
                <div class="block-item">
                    <div class="mt-5 title-notifications">
                        <user-post></user-post>
                    </div>
                </div>
            </b-col>
            <b-col lg="4" sm="12">
                <div class="block-item">
                    <h3>{{ $t('my_profile.following') }}</h3>
                    <div class="empty-follow-box" v-if="user_follow.follow_user.length === 0">
                        {{ user.full_name }} {{ $t('my_profile.not_follow') }}
                    </div>
                    <user-info-card v-else v-for="user in user_follow.follow_user" :key="user.id" :type_card="$t('my_profile.following')" :user="user"></user-info-card>
                    <div v-if="user_follow.follow_user.length !== 0" class="view-all">
                        <a @click="openModalFollow('following')">{{ $t('my_profile.view_all') }}</a>
                    </div>
                </div>
                <div class="block-item">
                    <h3>{{ $t('my_profile.follower') }}</h3>
                    <div class="empty-follow-box" v-if="user_follow.be_followed.length === 0">
                        {{ user.full_name }} {{ $t('my_profile.not_follower') }}
                    </div>
                    <user-info-card v-else v-for="user in user_follow.be_followed" :key="user.id" :type_card="$t('my_profile.follower')" :user="user"></user-info-card>
                    <div v-if="user_follow.be_followed.length !== 0" class="view-all">
                        <a @click="openModalFollow('beFollowed')">{{ $t('my_profile.view_all') }}</a>
                    </div>
                </div>
            </b-col>
        </b-row>
        <modal-user-follow v-if="isOpenModalFollow" :type_form="typeFollowForm" :closeModalFollow="closeModalFollow"></modal-user-follow>

        <div class="loading-follow-modal modal-overlay-flash-dot background-overlay" v-if="isLoadingFlash">
            <div class="text-center">
                <flash-dot-progress></flash-dot-progress>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import UserInfoCard from "./Card/UserInfoCard";
    import UserPost from "./UserInfo/UserPost";
    import CompanyInvestCard from "./Card/CompanyInvestCard";
    import ModalUserFollow from "../pages/ModalUserFollow";
    import CircleProgress from "../../commons/CircleProgress";
    import FlashDotProgress from "../../commons/FlashDotProgress";

    export default {
        name: "UserTimeline",
        props: [
            'isCurrentUser',
            'user',
            'type_form',
            'type_card',
            'viewer'
        ],
        data() {
            return {
                isLoadingInvestment: false,
                isLoadingNotification_Follow: false,
                total_following: 3,
                total_followers: 3,
                isOpenModalFollow: false,
                typeFollowForm: "",
                isLoadingFlash: false,
            }
        },
        components:{
            UserInfoCard,
            UserPost,
            CompanyInvestCard,
            CircleProgress,
            ModalUserFollow,
            FlashDotProgress
        },
        computed:{
            ...mapGetters([
                'listCompanyInvest', 'listCompanyInvestByUser', 'user_follow', 'auth', 'locale',
            ])
        },
        mounted() {
            var self = this;
            self.isLoadingInvestment = true;
            self.isLoadingNotification_Follow = true;

            var paramInvestUser = {
                slug: self.auth.user.slug,
                locale: self.locale,
            };

            if (self.$router.currentRoute.params.slug) {
                paramInvestUser.slug = self.$router.currentRoute.params.slug;
            }

            this.$store.dispatch('getAllCompanyInvestByUser', paramInvestUser)
            .then((res) => {
                self.isLoadingInvestment = false;
            })
            .catch((err) => {
                self.isLoadingInvestment = false;
                self.$toast.info(self.$t('errors.error_1'));
            })

            let formData_follow = new FormData();
            formData_follow.append('user_id', this.$props.user.id);
            var paramFollow = {
                form: formData_follow,
                status: 1
            };
            this.$store.dispatch('account_follow_user', paramFollow)
            .then((res) => {
                self.isLoadingNotification_Follow = false;
            });

            let formData_befollow = new FormData();
            formData_befollow.append('user_id', this.$props.user.id);
            var paramBeFollow = {
                form: formData_befollow,
                status: 1
            };
            this.$store.dispatch('account_be_followed', paramBeFollow);

        },
        methods: {
            refreshPage() {
                var self = this;
                self.$router.go();
            },
            openModalFollow(type) {
                var self = this;
                self.isLoadingFlash = true;

                if (type === "following") {
                    self.typeFollowForm = "Following";
                    let formData_follow = new FormData();
                    formData_follow.append('user_id', this.$props.user.id);
                    var paramFollow = {
                        form: formData_follow,
                        status: 0
                    };
                    this.$store.dispatch('account_follow_user', paramFollow)
                    .then((res) => {
                        self.isOpenModalFollow = true;
                        self.isLoadingFlash = false;
                    })
                    .catch((err) => {
                        self.isOpenModalFollow = true;
                        self.isLoadingFlash = false;
                        self.$toast.info(self.$t('errors.error_1'));
                    });
                }

                if (type === "beFollowed") {
                    self.typeFollowForm = "Followers";
                    let formData_befollow = new FormData();
                    formData_befollow.append('user_id', this.$props.user.id);
                    var paramFollow = {
                        form: formData_befollow,
                        status: 0
                    };
                    this.$store.dispatch('account_be_followed', paramFollow)
                    .then((res) => {
                        self.isOpenModalFollow = true;
                        self.isLoadingFlash = false;
                    })
                    .catch((err) => {
                        self.isOpenModalFollow = true;
                        self.isLoadingFlash = false;
                        self.$toast.info(self.$t('errors.error_1'));
                    });
                }

            },
            closeModalFollow() {
                var self = this;
                self.isOpenModalFollow = false;
            }
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

    .empty-follow-box {
        padding: 23px;
        color: #999;
        border: 1px solid #eee;
        text-align: center;
        margin-top: 30px;
    }

    .loading-notifi-follow {
        margin: 30px 0;
    }

    .view-all {
        margin-top: 15px;
        border: 1px solid #eee;
        border-radius: 5px;
        line-height: 35px;
        text-align: center;
        width: 200px;

        a {
            display: block;
            text-decoration: none;
            color: var(--main-grey);
            font-weight: 500;
        }

        a:hover {
            color: #7b7be1;
        }
    }

    .view-all:hover {
        border: 1px solid #7b7be1;
        cursor: pointer;
    }
</style>
