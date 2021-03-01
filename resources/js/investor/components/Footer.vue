<template>
    <footer class="bg-blue py-5">
        <div class="container">
            <b-row>
                <div class="col5">
                    <img src="/investor/images/logo.png" alt="" class="w-100">
                    <p class="my-3 color-grey">Lorem ipsum dolor sit amet.</p>
                    <div class="m-0 d-flex flex-row justify-content-between pb-3">
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="facebook" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="instagram" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="twitter" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="twitch" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="youtube" scale="1"></b-icon></a>
                    </div>
                </div>
                <div class="col5">
                    <p class="title">For Investor</p>
                    <a href="#" class="text-white text-decoration-none">Why invest</a>
                    <a href="#" class="text-white text-decoration-none">How it work</a>
                    <a href="#" class="text-white text-decoration-none">FAQ</a>
                    <a href="#" class="text-white text-decoration-none">Risks</a>
                </div>
                <div class="col5">
                    <p class="title">For Startup</p>
                    <a href="#" class="text-white text-decoration-none">Why invest</a>
                    <a href="#" class="text-white text-decoration-none">How it work</a>
                    <a href="#" class="text-white text-decoration-none">FAQ</a>
                    <a href="#" class="text-white text-decoration-none">Risks</a>
                </div>
                <div class="col5">
                    <p class="title">Company</p>
                    <a href="#" class="text-white text-decoration-none">Why invest</a>
                    <a href="#" class="text-white text-decoration-none">How it work</a>
                    <a href="#" class="text-white text-decoration-none">FAQ</a>
                    <a href="#" class="text-white text-decoration-none">Risks</a>
                </div>
                <div class="col5">
                    <p class="title">????</p>
                    <a href="#" class="text-white text-decoration-none">Why invest</a>
                    <a href="#" class="text-white text-decoration-none">How it work</a>
                    <a href="#" class="text-white text-decoration-none">FAQ</a>
                    <a href="#" class="text-white text-decoration-none">Risks</a>
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
        .title{
            color:var(--main-grey);
            border-bottom: solid 1px var(--main-grey);
        }
        a{
            display: table;
        }
        a,p{
            font-weight: bold;
        }
        img{
            max-width: 120px!important;
        }
    }
</style>
