<template>
    <div class="nt-follow-modal">
        <div class="content">
            <div class="wrapper-container">
                <div class="title">
                    {{ type_form }}
                    <a @click="closeModalFollow">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="wp-container scroll-y" v-if="type_form === 'Following'">
                    <div class="item" v-for="user in all_user_follow.follow_user" :key="user.id">
                        <img v-if="user.avatar !== ''" v-bind:src="user.avatar_path" alt="bestb" />
                        <img v-else v-bind:src="domain + 'admin/img/default_avatar.png'" alt="bestb" />
                        <div class="name">{{ user.full_name }}</div>
                        <div class="actions">
                            <a v-bind:href="'/' + $i18n.locale + '/user/' + user.slug" class="text-decoration-none">{{ $t('company_invest_detail.profile') }}</a>
                        </div>
                    </div>
                </div>
                <div class="wp-container scroll-y" v-if="type_form === 'Followers'">
                    <div class="item" v-for="user in all_user_follow.be_followed" :key="user.id">
                        <img v-if="user.avatar !== ''" v-bind:src="user.avatar_path" alt="bestb" />
                        <img v-else v-bind:src="domain + 'admin/img/default_avatar.png'" alt="bestb" />
                        <div class="name">{{ user.full_name }}</div>
                        <div class="actions">
                            <a v-bind:href="'/' + $i18n.locale + '/user/' + user.slug" class="text-decoration-none">{{ $t('company_invest_detail.profile') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from '../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "ModalUserFollow",
        props: [
            'type_form',
            'closeModalFollow',
            'all_user_follow',
        ],
        computed:{
            ...mapGetters([
                'auth'
            ])
        },
        data() {
            return {
                domain: domain,
                user: {
                    id: 0
                },
                isCanLike:false,
            }
        },
        mounted() {
            var self = this;
        },
        methods: {
        }
    }
</script>

<style lang="scss" scoped>
    .nt-follow-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: hsla(0,0%,8%,.85);
        z-index: 999999999999;

        .content {
            z-index: 100;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;

            .wrapper-container {
                background: white;
                height: 600px;
                width: 450px;
                border-radius: 5px;
                padding: 10px;

                .title {
                    font-size: 17px;
                    font-weight: 600;
                    color: var(--main-grey);
                    text-align: center;
                    margin-bottom: 10px;
                    position: relative;

                    a {
                        position: absolute;
                        left: 20px;
                        cursor: pointer;

                        i:hover {
                            color: blue;
                        }
                    }
                }

                .wp-container {
                    padding: 0 20px;
                    height: 553px;

                    .item {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        border-bottom: 1px solid #f6f0f0;
                        padding: 10px 0;

                        img {
                            width: 10%;
                            height: 40px;
                            object-fit: cover;
                            border-radius: 50%;
                        }

                        .name {
                            width: 240px;
                            font-size: 17px;
                            font-weight: 600;
                        }

                        .actions {
                            border: 1px solid #c1dbf6;
                            border-radius: 5px;
                            line-height: 25px;
                            text-align: center;
                            width: 90px;
                            cursor: pointer;

                            a {
                                font-size: 15px;
                                display: block;
                            }
                        }

                        .actions:hover {
                            border: 1px solid #0000ff61;
                        }
                    }

                    .item:first-child {
                        border-top: 1px solid #f6f0f0;
                    }
                }
            }
        }
    }

    ::-webkit-scrollbar {
        width: 7px;
    }

        /* Track */
    ::-webkit-scrollbar-track {
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgb(92, 79, 79);
        border-radius: 10px;
    }

    @media only screen and(max-height: 600px){
        .nt-follow-modal {
            .content {
                .wrapper-container {
                    height: 400px;

                    .wp-container {
                        height: 355px;
                    }
                }
            }
        }
    }
</style>
