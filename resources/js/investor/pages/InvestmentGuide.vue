<template>
    <b-container fluid="lg">
        <b-row>
            <b-col cols="12" lg="12" class="container-main">
                <div class="title-page">Hướng dẫn đầu tư</div>
                <b-tabs content-class="mt-3" class="company-invest__detail mt-3">
                    <b-tab active :title="$t('investment_guide.by_video')">
                        <div class="wrapper-box-list">
                            <LazyYoutube
                                v-if="srcVideo !== ''"
                                :src="srcVideo"
                                max-width="100%"
                                aspect-ratio="16:9"
                                thumbnail-quality="standard"
                            />
                            <p v-else>{{ $t('investment_guide.not_tutorial') }}</p>
                        </div>
                    </b-tab>

                    <b-tab :title="$t('investment_guide.by_image')">
                        <div class="wrapper-box-list">
                            <p>{{ $t('investment_guide.not_tutorial') }}</p>
                        </div>
                    </b-tab>
                </b-tabs>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import { LazyYoutube, LazyVimeo } from "vue-lazytube";

    export default {
        name: "InvestmentGuide",
        components: {
            LazyYoutube,
            LazyVimeo,
        },
        data() {
            return {
                srcVideo: '',
            }
        }
    }
</script>

<style lang="scss" scoped>
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
    }
</style>
