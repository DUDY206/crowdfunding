<template>
    <b-container fluid="lg">
        <circle-progress v-if="isLoading"></circle-progress>
        <div v-else>
            Đây là giới thiệu
        </div>
    </b-container>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from "../../commons/CircleProgress.vue";

    export default {
        name: "AboutBestB",
        components: {
            CircleProgress
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

