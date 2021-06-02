<template>
    <b-container fluid="lg">
        <b-row>
            <b-col cols="12" lg="12" class="container-main">
                <div class="title-page">{{ $t('investment_guide.title_guide') }}</div>
                <b-tabs content-class="mt-3" class="company-invest__detail mt-3">
                    <b-tab active :title="$t('investment_guide.by_video')">
                        <p v-if="srcVideo === ''">{{ $t('investment_guide.not_tutorial') }}</p>
                        <div class="wrapper-box-list">
                            <LazyYoutube
                                v-if="srcVideo !== ''"
                                :src="srcVideo"
                                max-width="100%"
                                aspect-ratio="16:9"
                                thumbnail-quality="standard"
                            />
                        </div>
                    </b-tab>

                    <b-tab :title="$t('investment_guide.by_image')">
                        <p>{{ $t('investment_guide.not_tutorial') }}</p>
                        <div class="wrapper-box-list">
                            <div class="boxes">
                                <div class="box one">
                                    <p>{{ $t('investment_guide.B') }} 1:</p>
                                    <p>- {{ $t('investment_guide.B1_content_1') }}</p>
                                </div>
                                <div class="box two">
                                    <inner-image-zoom :src="domain + url_folder + 'B1.png'" />
                                </div>
                            </div>
                            <div class="boxes">
                                <div class="box one">
                                    <p>{{ $t('investment_guide.B') }} 2:</p>
                                    <p>- {{ $t('investment_guide.B2_content_1') }}</p>
                                    <p>- {{ $t('investment_guide.B2_content_2') }}</p>
                                    <p>- {{ $t('investment_guide.B2_content_3') }}</p>
                                </div>
                                <div class="box two">
                                    <inner-image-zoom :src="domain + url_folder + 'B2.png'" />
                                    <hr>
                                    <inner-image-zoom :src="domain + url_folder + 'B2-1.png'" />
                                    <hr>
                                    <inner-image-zoom :src="domain + url_folder + 'B2-2.png'" />
                                </div>
                            </div>
                            <div class="boxes">
                                <div class="box one">
                                    <p>{{ $t('investment_guide.B') }} 3:</p>
                                    <p>- {{ $t('investment_guide.B3_content_1') }}</p>
                                    <p>- {{ $t('investment_guide.B3_content_2') }}</p>
                                </div>
                                <div class="box two">
                                    <inner-image-zoom :src="domain + url_folder + 'B3.png'" />
                                </div>
                            </div>
                            <div class="boxes">
                                <div class="box one">
                                    <p>{{ $t('investment_guide.B') }} 4:</p>
                                    <p>- {{ $t('investment_guide.B4_content_1') }}</p>
                                    <p>- {{ $t('investment_guide.B4_content_2') }}</p>
                                    <p>- {{ $t('investment_guide.B4_content_3') }}</p>
                                </div>
                                <div class="box two">
                                    <inner-image-zoom :src="domain + url_folder + 'B4.png'" />
                                </div>
                            </div>
                            <div class="boxes">
                                <div class="box one">
                                    <p>{{ $t('investment_guide.B') }} 5:</p>
                                    <p>- {{ $t('investment_guide.B5_content_1') }}</p>
                                    <p>- {{ $t('investment_guide.B5_content_2') }}</p>
                                </div>
                                <div class="box two">
                                    <inner-image-zoom :src="domain + url_folder + 'B5.png'" />
                                </div>
                            </div>
                            <div class="boxes">
                                <div class="box one">
                                    <p>{{ $t('investment_guide.B') }} 6:</p>
                                    <p>- {{ $t('investment_guide.B6_content_1') }}</p>
                                    <p>- {{ $t('investment_guide.B6_content_2') }}</p>
                                    <p>- {{ $t('investment_guide.B6_content_3') }}</p>
                                </div>
                                <div class="box two">
                                    <inner-image-zoom :src="domain + url_folder + 'B6.png'" />
                                    <hr>
                                    <inner-image-zoom :src="domain + url_folder + 'B6-1.png'" />
                                    <hr>
                                    <inner-image-zoom :src="domain + url_folder + 'B6-2.png'" />
                                </div>
                            </div>
                            <div class="boxes">
                                <div class="box one">
                                    <p>{{ $t('investment_guide.B') }} 7:</p>
                                    <p>- {{ $t('investment_guide.B7_content_1') }}</p>
                                </div>
                                <div class="box two">
                                    <inner-image-zoom :src="domain + url_folder + 'B7.png'" />
                                    <hr>
                                    <inner-image-zoom :src="domain + url_folder + 'B7-1.png'" />
                                </div>
                            </div>
                        </div>
                    </b-tab>
                </b-tabs>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import { LazyYoutube, LazyVimeo } from "vue-lazytube";
    import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
    import InnerImageZoom from 'vue-inner-image-zoom';
    import env from "../../env";
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "InvestmentGuide",
        components: {
            LazyYoutube,
            LazyVimeo,
            InnerImageZoom,
        },
        data() {
            return {
                domain: domain,
                url_folder: 'images/investment-guide/',
                srcVideo: 'https://www.youtube.com/watch?v=UqcypLhmtxY',
            }
        }
    }
</script>

<style lang="scss" scoped>
    $boder: 1px solid #e4dede;

    .title-page {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
        border-bottom: 2px solid #a91f23;
        border-radius: 3px;
        width: -webkit-fit-content;
        width: -moz-fit-content;
        width: fit-content;
    }

    .container-main {
        margin-bottom: 50px;

        .wrapper-box-list {
            border: $boder;
            border-bottom: none;

            .boxes {
                display: flex;
                border-bottom: $boder;

                .box {
                    width: 50%;
                    padding: 10px;

                    img {
                        width: 100%;
                    }
                }

                .box.one {
                    border-right: $boder;
                }
            }
        }
    }
</style>
