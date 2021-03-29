<template>
    <footer class="bg-blue py-5 mt-auto">
        <div class="container">
            <b-row>
                <div class="col5">
                    <img src="/investor/images/logo.png" alt="" class="w-100">
                    <p class="my-3 color-grey">Lorem ipsum dolor sit amet.</p>
                    <div class="w-80 fs-20 m-0 d-flex flex-row justify-content-between pb-3">
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="facebook" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="instagram" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="twitter" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="twitch" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="youtube" scale="1"></b-icon></a>
                    </div>
                </div>
                <div class="col5">
                    <p class="title line-h-40">For Investor</p>
                    <a href="#" class="color-grey text-decoration-none">Why invest</a>
                    <a href="#" class="color-grey text-decoration-none">How it work</a>
                    <a href="#" class="color-grey text-decoration-none">FAQ</a>
                    <a href="#" class="color-grey text-decoration-none">Risks</a>
                </div>
                <div class="col5">
                    <p class="title line-h-40">For Startup</p>
                    <a href="#" class="color-grey text-decoration-none">Why raise</a>
                    <a href="#" class="color-grey text-decoration-none">Learn</a>
                    <a href="#" class="color-grey text-decoration-none">FAQ</a>
                    <a href="#" class="color-grey text-decoration-none">Instruments</a>
                </div>
                <div class="col5">
                    <p class="title line-h-40">Crypto</p>
                    <a href="#" class="color-grey text-decoration-none">For investors</a>
                    <a href="#" class="color-grey text-decoration-none">For companies</a>
                    <a href="#" class="color-grey text-decoration-none">How it works</a>
                    <a href="#" class="color-grey text-decoration-none">Token DPA</a>
                </div>
                <div class="col5">
                    <p class="title line-h-40">Company</p>
                    <a href="#" class="color-grey text-decoration-none">About</a>
                    <a href="#" class="color-grey text-decoration-none">Journal</a>
                    <a href="#" class="color-grey text-decoration-none">Events</a>
                    <a href="#" class="color-grey text-decoration-none">Contact</a>
                    <a href="#" class="color-grey text-decoration-none">We're hiring!</a>
                </div>

            </b-row>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer"
    }
</script>

<style lang="scss" scoped>
    .col5{
        width: 100%;

        .title {
            color: rgba(255,255,255,.3);
            border-bottom: solid 1px var(--main-grey);
        }

        a {
            display: table;
        }

        a, p {
            font-weight: bold;
        }

        a:hover {
            color: white !important;
        }

        img{
            max-width: 120px!important;
        }
    }

    .w-80 {
        width: 80%;

        a .b-icon:hover {
            color: white;
        }
    }

    .fs-20 {
        font-size: 20px;
    }
</style>
