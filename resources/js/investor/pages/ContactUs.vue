<template>
    <b-container fluid="lg">
        <circle-progress v-if="isLoading"></circle-progress>
        <div v-if="!isLoading" class="title-page">{{ $t('header_banner.contact_us') }}</div>

        <div v-if="!isLoading" class="wrapper-boxs">
            <infor-best-b
                :checkPage=true
            />
        </div>
    </b-container>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from "../../commons/CircleProgress.vue";
    import InforBestB from './InforBestB';

    export default{
        name: 'ContactUs',
        components: {
            CircleProgress,
            InforBestB
        },
        data() {
            return {
                isLoading: true,
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
    }
</style>
