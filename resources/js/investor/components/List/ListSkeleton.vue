<template>
    <div class="skeleton">
        <b-col cols="12" lg="4" v-for="index in 3" :key="index" class="mb-5">
            <div class="content">
                <div class="content-header pulsate"></div>
                <div class="content-body">
                    <div class="w-100">
                        <div class="content-body-title">
                            <h3 class="title pulsate"></h3>
                            <p class="text-description short-text pulsate"></p>
                        </div>
                        <div class="content-body-footer">
                            <p class="pulsate"></p>
                        </div>
                    </div>
                </div>
            </div>
        </b-col>
    </div>
</template>

<script>
    export default {
        name: 'ListSkeleton',
    }
</script>

<style lang="scss" scoped>
    $background: #F2F2F2;

    .skeleton {
        width: 100%;
        margin-bottom: 40px;
        display: flex;

        .content {
            height: 450px;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgb(0 0 0 / 8%);

            .content-header {
                height: 200px;
                border-top-right-radius: 10px;
                border-top-left-radius: 10px;
            }

            .content-body {
                height: 250px;
                background: #fdfdfd;
                margin-top: -8px;
                border-bottom-right-radius: 10px;
                border-bottom-left-radius: 10px;

                .w-100 {
                    height: 100%;
                    padding: 0.5rem 1.5rem;
                    position: relative;

                    .content-body-title {
                        height: auto;

                        h3.title {
                            height: 25px;
                            width: 60%;
                        }

                        p.text-description.short-text {
                            height: 25px;
                        }
                    }

                    .content-body-footer {
                        position: absolute;
                        bottom: 10px;
                        left: 0;
                        width: 100%;

                        p {
                            height: 25px;
                            width: 300px;
                            margin: 0 auto;
                            margin-bottom: 0;
                        }
                    }
                }
            }
        }
    }

    .pulsate {
        background: linear-gradient(-45deg, #DDDDDD, #F0F0F0, #DDDDDD, #F0F0F0);
        background-size: 400% 400%;
        -webkit-animation: Gradient 2.25s ease infinite;
        -moz-animation: Gradient 2.25s ease infinite;
        animation: Gradient 2.25s ease infinite;
    }

    @-webkit-keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @-moz-keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @keyframes Gradient {
        0% {
            background-position: 0% 50%
        }
        50% {
            background-position: 100% 50%
        }
        100% {
            background-position: 0% 50%
        }
    }

    @media only screen and (max-width: 1200px) {
        .skeleton {
            .content {
                .content-body {
                    .w-100 {
                        .content-body-footer {
                            p {
                                width: 240px;
                            }
                        }
                    }
                }
            }
        }
    }

    @media only screen and (max-width: 991px) {
        .skeleton {
            flex-direction: column;
            .content {
                .content-body {
                    .w-100 {
                        .content-body-footer {
                            p {
                                width: 90%;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
