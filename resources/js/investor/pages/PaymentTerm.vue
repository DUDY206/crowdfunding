<template>
    <b-container fluid="lg">
        <div class="title-page">{{ $t('footer.payment_terms') }}</div>
        <div class="wrapper-boxs">
            <div class="box">
                <div class="title">{{ $t('payment_terms.title_1') }}</div>
                <div class="content">
                    {{ $t('payment_terms.content_1_1') }}
                    <br>
                    <br>

                    {{ $t('payment_terms.content_1_2') }}
                    <br>
                    <br>

                    {{ $t('payment_terms.content_1_3') }}
                    <br>
                    <br>

                    {{ $t('payment_terms.content_1_4') }}
                    <br>
                    <br>
                </div>
            </div>
            <hr />

            <div class="box">
                <div class="title">{{ $t('payment_terms.title_2') }}</div>
                <div class="content">
                    {{ $t('payment_terms.content_2_1') }}
                    <br>
                    <br>

                    {{ $t('payment_terms.content_2_2') }}
                    <br>
                    <br>

                    {{ $t('payment_terms.content_2_3') }}
                    <br>
                    <br>

                    {{ $t('payment_terms.content_2_4') }}
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
        name: "PaymentTerm"
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
