<template>
    <b-container fluid="lg">
        <div class="title-page">{{ $t('footer.privacy_policies') }}</div>
        <div class="wrapper-boxs">
            <div class="box">
                <div class="title">{{ $t('privacy_policies.title_1') }}</div>
                <div class="content">
                    {{ $t('privacy_policies.content_1_1') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_1_2') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_1_3') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_1_4') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_1_5') }}
                    <br>
                    <br>
                </div>
            </div>
            <hr />

            <div class="box">
                <div class="title">{{ $t('privacy_policies.title_2') }}</div>
                <div class="content">
                    {{ $t('privacy_policies.content_2_1') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_2_2') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_2_3') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_2_4') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_2_5') }}
                    <br>
                    <br>
                </div>
            </div>
            <hr />

            <div class="box">
                <div class="title">{{ $t('privacy_policies.title_3') }}</div>
                <div class="content">
                    {{ $t('privacy_policies.content_3_1') }}
                </div>
            </div>
            <hr />

            <div class="box">
                <div class="title">{{ $t('privacy_policies.title_4') }}</div>
                <div class="content">
                    {{ $t('privacy_policies.content_4_1') }}
                </div>
            </div>
            <hr />

            <div class="box">
                <div class="title">{{ $t('privacy_policies.title_5') }}</div>
                <div class="content">
                    {{ $t('privacy_policies.content_5_1') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_5_2') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_5_3') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_5_4') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_5_5') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_5_6') }}
                    <br>
                    <br>
                </div>
            </div>
            <hr />

            <div class="box">
                <div class="title">{{ $t('privacy_policies.title_6') }}</div>
                <div class="content">
                    {{ $t('privacy_policies.content_6_1') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_6_2') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_6_3') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_6_4') }}
                    <br>
                    <br>
                </div>
            </div>
            <hr />

            <div class="box">
                <div class="title">{{ $t('privacy_policies.title_7') }}</div>
                <div class="content">
                    {{ $t('privacy_policies.content_7_1') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_7_2') }}
                    <br>
                    <br>

                    {{ $t('privacy_policies.content_7_3') }}
                    <br>
                    <br>
                </div>
            </div>
            <hr />
        </div>
    </b-container>
</template>

<script>
    export default {
        name: "PrivacyPolicy"
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
