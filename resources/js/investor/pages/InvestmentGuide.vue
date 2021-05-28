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
                            <!-- <div class="boxes">
                                <div class="box one">
                                    <p>Bước 1: </p>
                                </div>
                                <div class="box two">
                                    <inner-image-zoom :src="domain + url_folder + 'home.png'" />
                                </div>
                            </div> -->
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
                srcVideo: '',
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
