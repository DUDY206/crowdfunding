<template>
    <div class="container-sign-up-now">
        <div class="wrapper-sun">
            <div class="couple" v-if="auth.token === null">
                <div class="title">{{ $t('sign_up_now_under_list.title') }}</div>
                <div class="description">{{ $t('sign_up_now_under_list.des') }}</div>
                <div class="filter-btn">
                    <input type="submit" class="btn-primary" @click="nextLogin" :value="$t('cover.become_investor')" />
                </div>
                <!-- <div class="small-tip">{{ $t('sign_up_now_under_list.tips') }}</div> -->
            </div>
            <div class="simple">
                <div class="title">{{ $t('sign_up_now_under_list.title_qs') }}</div>
                <div class="content">
                    <div class="list-box-1 border-topl">
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs1') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans1') }}
                                <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans1_1') }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs2') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans2') }}
                            </div>
                        </div>
                        <!-- <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs3') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans3') }}
                                <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans3_1') }}
                            </div>
                        </div> -->
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs4') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans4') }}
                                <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans4_1') }}
                                <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans4_2') }}
                                <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans4_3') }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs5') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans5') }}
                                <!-- <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans5_1') }} -->
                            </div>
                        </div>
                    </div>
                    <div class="list-box-2 border-topl">
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs6') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans6') }}
                                <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans6_1') }}
                            </div>
                        </div>
                        <!-- <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs7') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans7') }}
                            </div>
                        </div> -->
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs8') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans8') }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs9') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans9') }}
                                <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans9_1') }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs10') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans10') }}
                                <br>
                                <br>
                                {{ $t('sign_up_now_under_list.ans10_1') }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="name-qs">{{ $t('sign_up_now_under_list.qs11') }}</div>
                            <div class="box-ans">
                                {{ $t('sign_up_now_under_list.ans11') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from "../../../env";
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: 'QuestionCard',
        computed:{
            ...mapGetters([
                'auth',
                'startEmail',
            ])
        },
        data() {
            return {
                domain: domain
            }
        },
        methods: {
            nextLogin() {
                window.location.href = domain + 'login';
            }
        }
    }
</script>

<style lang="scss" scoped>
    .container-sign-up-now {
        border-top: 1px solid #eee;

        .wrapper-sun {
            margin: 0 auto;
            padding: 70px 10px;

            .couple {
                text-align: center;

                .title {
                    font-size: 45px;
                    line-height: 48px;
                    font-weight: 900;
                    letter-spacing: -0.04em;
                    margin-top: 15px;
                    cursor: pointer;
                    margin-bottom: 10px;
                }

                .description {
                    color: black;
                    font-size: 18px;
                    line-height: 1.3;
                    font-weight: 350;
                    margin: 30px 0;
                }

                .filter-btn {
                    input {
                        width: fit-content;
                        border: 1px solid #ddd;
                        padding: 13px 13px;
                        font-size: 16px;
                        border-radius: 6px;
                        outline: none;
                        margin-bottom: 10px;
                        font-weight: bold;
                    }
                }

                .small-tip {
                    font-size: 13px;
                    color: #666;
                    width: 243.75px;
                    margin: 0 auto;
                }
            }

            .simple {
                margin-top: 50px;

                .title {
                    font-size: 25px;
                    line-height: 1.2;
                    font-weight: 800;
                    letter-spacing: -.028em;
                    color: #777;
                    margin-bottom: 32px;
                }

                .content {
                    display: flex;
                    justify-content: space-between;

                    .border-topl {
                        border-top: 1.5px solid #eee;
                    }

                    .list-box-1 {
                        width: 45%;
                    }

                    .list-box-2 {
                        width: 45%;
                    }

                    .item {
                        padding: 15px 0;
                        border-bottom: 1px solid #eee;
                        position: relative;
                        cursor: pointer;

                        .name-qs {
                            color: #222;
                            font-size: 17px;
                        }

                        .box-ans {
                            opacity: 0;
                            visibility: hidden;
                            margin-top: 15px;
                            transition: 0.5s all ease;
                            height: 50px;
                            position: absolute;
                        }
                    }

                    .item:hover .name-qs , .item:active .name-qs {
                        color: #3a72ff;
                    }

                    .item:hover .box-ans, .item:active .box-ans {
                        opacity: 1;
                        visibility: visible;
                        height: fit-content;
                        position: unset;
                    }
                }
            }
        }
    }
</style>
