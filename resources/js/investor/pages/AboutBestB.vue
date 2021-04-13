<template>
    <b-container fluid="lg">
        <circle-progress v-if="isLoading"></circle-progress>
        <div v-if="!isLoading" class="title-page">{{ $t('header_banner.about') }}</div>
        <div v-if="!isLoading" class="wrapper-boxs">
            <div class="box">
                <div class="title">Hệ sinh thái Doanh nghiệp BestB</div>
                <div class="content">
                    Với mục tiêu phát triển hệ sinh thái doanh nghiệp Việt đã luôn cố gắng, nỗ lực đồng hành cùng các doanh nghiệp Việt, các nhà đầu tư trong và ngoài nước. Chúng tôi luôn hướng tới cung cấp những giá trị tốt đẹp góp phần kiến tạo giá trị doanh nghiệp Việt
                </div>
            </div>
            <hr />
            <div class="box">
                <div class="title">BestB Crowdfunding</div>
                <div class="content">
                    Là một kênh tài chính tiềm năng, là một trang gọi vốn cộng đồng nhằm kết nối các doanh nghiệp StartUp, Doanh nghiệp SMEs, doanh nghiệp cần gọi vốn và các nhà đầu tư với nhau. Các dự án gọi vốn cộng đồng được gửi tới BestB Crowdfunding gồm đa dạng các lĩnh vực khác nhau như: Thương mại điện tử, công nghệ thanh toán, thiết bị y tế, hàng tiêu dùng, nền tảng vận chuyển thông minh, Logistic, nông sản xuất khẩu, nền tảng giáo dục giới thiệu việc làm thông minh, cung ứng xe hơi, công nghệ sinh học, nhà thông minh....
                </div>
            </div>
            <hr />
            <div class="box">
                <div class="title">Tầm nhìn</div>
                <div class="content">
                    Với tầm nhìn sẽ trở thành một trong những trang mạng gọi vốn cộng đồng lớn nhất tại Việt Nam. Sẽ là một trong những trang Crowdfunding kết nối các doanh nghiệp với Nhà đầu tư đáng tin cậy và hiệu quả nhất. Giải quyết vấn đề tài chính cho doanh nghiệp, đem đến cho các Nhà đầu tư những doanh nghiệp tiềm năng từ đó doanh nghiệp có thể phát triển lớn mạnh, nhà đầu tư gia tăng vốn và đầu tư cho các doanh nghiệp khác giúp cho các thương hiệu Việt kiến thiết tương lai - Vươn tầm Quốc tế.
                </div>
            </div>
            <hr />
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
                -webkit-animation: colorchange 5s infinite alternate;
            }

            @-webkit-keyframes colorchange {
                0% {

                    color: blue;
                }

                10% {

                    color: #8e44ad;
                }

                20% {

                    color: #1abc9c;
                }

                30% {

                    color: #d35400;
                }

                40% {

                    color: blue;
                }

                50% {

                    color: #34495e;
                }

                60% {

                    color: blue;
                }

                70% {

                    color: #2980b9;
                }
                80% {

                    color: #f1c40f;
                }

                90% {

                    color: #2980b9;
                }

                100% {

                    color: pink;
                }
            }

            .content {
                font-size: 15px;
                color: #737373;
            }
        }
    }
</style>
