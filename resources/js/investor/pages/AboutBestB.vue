<template>
    <b-container fluid="lg">
        <circle-progress v-if="isLoading"></circle-progress>
        <div v-if="!isLoading" class="title-page">{{ $t('header_banner.about') }}</div>
        <div v-if="!isLoading" class="wrapper-boxs">
            <div class="box">
                <div class="title">{{ $t('about.bestb') }}</div>
                <div class="content">
                    {{ $t('about.content_bestb_1') }}
                    <br>
                    <br>

                    {{ $t('about.content_bestb_2') }}
                    <br>
                    <br>

                    <div class="content-child">
                        - {{ $t('about.content_bestb_2_li_1') }}
                        <br>
                        <br>

                        - {{ $t('about.content_bestb_2_li_2') }}
                        <br>
                        <br>

                        - {{ $t('about.content_bestb_2_li_3') }}
                        <br>
                        <br>

                        - {{ $t('about.content_bestb_2_li_4') }}
                        <br>
                        <br>
                    </div>

                    {{ $t('about.content_bestb_3') }}
                    <br>
                    <br>

                    <div class="content-child">
                        - {{ $t('about.content_bestb_3_li_1') }}
                        <br>
                        <br>

                        - {{ $t('about.content_bestb_3_li_2') }}
                        <br>
                        <br>

                        - {{ $t('about.content_bestb_3_li_3') }}
                        <br>
                        <br>
                    </div>

                    {{ $t('about.content_bestb_4') }}
                </div>
            </div>
            <hr />
            <div class="box">
                <div class="title">{{ $t('about.crowd') }}</div>
                <div class="content">
                    <img :src="domain + 'images/about/about.png'" alt="">
                    <br>
                    <br>
                    
                    {{ $t('about.content_crowd') }}
                </div>
            </div>
            <hr />
            <div class="box">
                <div class="title">{{ $t('about.vision') }}</div>
                <div class="content">
                    {{ $t('about.content_vision') }}
                </div>
            </div>
            <hr />
        </div>
    </b-container>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from "../../env";
    const domain = env.INVESTOR_DOMAIN;
    import CircleProgress from "../../commons/CircleProgress.vue";

    export default {
        name: "AboutBestB",
        components: {
            CircleProgress
        },
        data() {
            return {
                isLoading: true,
                domain: domain,
            }
        },
        mounted() {
            var self = this;

            self.isLoading = false;
        },
    }
</script>

<style lang="scss" scoped>
    .title-page {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
        border-bottom: 2px solid #a91f23;
        border-radius: 3px;
        width: fit-content;
    }

    .wrapper-boxs {
        margin-bottom: 20px;

        hr {
            width: 25%;
        }

        .box {
            padding: 15px 0;

            .title {
                margin: 5px 0 10px;
                padding-left: 15px;
                border-left: 3px solid #ff5252;
                font-size: 19px;
                line-height: 30px;
                text-transform: uppercase;
                transition: border-color .25s;
                font-weight: bold;
                color: #2e2ee6;
                // -webkit-animation: colorchange 5s infinite alternate;
            }

            // @-webkit-keyframes colorchange {
            //     0% {

            //         color: blue;
            //     }

            //     10% {

            //         color: #8e44ad;
            //     }

            //     20% {

            //         color: #1abc9c;
            //     }

            //     30% {

            //         color: #d35400;
            //     }

            //     40% {

            //         color: blue;
            //     }

            //     50% {

            //         color: #34495e;
            //     }

            //     60% {

            //         color: blue;
            //     }

            //     70% {

            //         color: #2980b9;
            //     }
            //     80% {

            //         color: #f1c40f;
            //     }

            //     90% {

            //         color: #2980b9;
            //     }

            //     100% {

            //         color: pink;
            //     }
            // }

            .content {
                font-size: 15px;
                color: #737373;

                .content-child {
                    margin-left: 20px;
                }

                img {
                    width: 100%;
                }
            }
        }
    }
</style>
