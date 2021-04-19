<template>
    <footer class="bg-blue py-5 mt-auto">
        <div class="container">
            <b-row>
                <div class="col5">
                    <img src="/investor/images/logo.png" alt="" class="w-100">
                    <p class="my-3 color-grey">
                        {{ $t('footer.under_logo') }}
                    </p>
                    <div class="w-80 fs-20 m-0 d-flex flex-row justify-content-between pb-3">
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="facebook" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="instagram" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="twitter" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="twitch" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="youtube" scale="1"></b-icon></a>
                    </div>
                </div>
                <div class="col5">
                    <p class="title line-h-40">

                        {{ $t('footer.for_investor') }}
                    </p>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.why_invest') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.how_it_work') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.FAQ') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.Risks') }}
                    </a>
                </div>
                <div class="col5">
                    <p class="title line-h-40">
                        {{ $t('footer.for_startup') }}
                    </p>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.why_raise') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.learn') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.FAQ') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.instrument') }}
                    </a>
                </div>
                <div class="col5">
                    <p class="title line-h-40">
                        {{ $t('footer.crypto') }}
                    </p>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.for_investor') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.for_company') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.how_it_work') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.token_DPA') }}
                    </a>
                </div>
                <div class="col5">
                    <p class="title line-h-40">
                        {{ $t('footer.company') }}
                    </p>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.about') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.journal') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.event') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.contact') }}
                    </a>
                    <a href="#" class="color-grey text-decoration-none">
                        {{ $t('footer.we_hire') }}
                    !</a>
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
