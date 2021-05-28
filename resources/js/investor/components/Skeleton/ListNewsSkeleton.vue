<template>
    <div class="skeleton">
        <b-col cols="12" lg="4" v-for="index in 3" :key="index" class="space-bottom-10">
            <div class="content">
                <div class="content-header pulsate"></div>
                <div class="content-body">
                    <div class="wrapper-content">
                        <h3 class="title pulsate"></h3>
                        <div class="time pulsate"></div>
                        <p class="des pulsate"></p>
                    </div>
                </div>
            </div>
        </b-col>
    </div>
</template>

<script>
    export default {
        name: "ListNewsSkeleton",
    }
</script>

<style lang="scss" scoped>
    $background: #F2F2F2;

    .skeleton {
        width: 100%;
        margin-bottom: 40px;
        display: flex;

        .content {
            height: 475px;
            border-radius: 5px;
            box-shadow: 0 4px 24px rgb(0 0 0 / 8%);

            .content-header {
                height: 63.16%;
                border-top-right-radius: 5px;
                border-top-left-radius: 5px;
            }

            .content-body {
                background: #fdfdfd;
                height: 36.85%;

                .wrapper-content {
                    padding: 1rem;
                    position: relative;

                    h3.title {
                        height: 25px;
                        width: 100%;
                    }

                    .time {
                        height: 25px;
                        width: 25%;
                        margin-top: 10px;
                    }

                    .des {
                        height: 25px;
                        margin-top: 60px;
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

    @media only screen and (max-width: 991px) {
        .skeleton {
            flex-direction: column;

            .content {
                display: flex;
                height: 300px;

                .content-header {
                    height: 100%;
                    width: 100%;
                    border-top-right-radius: 0px;
                    border-bottom-left-radius: 5px;
                }

                .content-body {
                    width: 72%;
                }
            }
        }
    }

    @media only screen and (max-width: 767px) {
        .skeleton {
            .content {
                .content-header {
                    width: 55%;
                }
            }
        }
    }

    @media only screen and (max-width: 550px) {
        .skeleton {
            .content {
                .content-header {
                    width: 100%;
                }

                .content-body {
                    width: 24%;

                    .wrapper-content {
                        .time {
                            width: 90%;
                        }
                    }
                }
            }
        }
    }
</style>
