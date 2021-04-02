<template>
    <div class="wrapper-box-load">
        <div class="box-load">
            <div class="loader"></div>
            <span>Loading...</span>
        </div>
    </div>
</template>

<script>
    export default {}
</script>

<style lang="scss" scoped>
    .wrapper-box-load {
        position: absolute;
        top: 30%;
        left: 0;
        right: 0;
        z-index: 999999;

        .box-load {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            background: white;
            width: 130px;
            margin: 0 auto;
            padding: 3px;
            border-radius: 10px;
            border: 1px solid #edecec;

            .loader {
                font-size: 10px;
                text-indent: -9999em;
                width: 2.5em;
                height: 2.5em;
                border-radius: 50%;
                background: #ede4e4;
                background: linear-gradient(to right, #c4b0b0 10%, rgb(167 104 104 / 0%) 42%);
                position: relative;
                -webkit-animation: load3-data-v-c93ff022 1.4s infinite linear;
                animation: load3-data-v-c93ff022 1.4s infinite linear;
                transform: translateZ(0);
            }

            .loader:before {
                width: 34%;
                height: 33%;
                border-radius: 100% 0 0 0;
                position: absolute;
                top: 0;
                left: 0;
                content: '';
            }

            .loader:after {
                background: white;
                width: 68%;
                height: 68%;
                border-radius: 50%;
                content: '';
                margin: auto;
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
            }

            @-webkit-keyframes load3 {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @keyframes load3 {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }
        }
    }
</style>
