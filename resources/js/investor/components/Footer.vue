<template>
    <footer class="bg-blue py-5 mt-auto zInd99">
        <div class="container">
            <b-row class="d-space-event">
                <div class="col5">
                    <img :src="domain + '/investor/images/logo1.png'" alt="" class="w-100">
                    <p class="my-3 color-grey">
                        {{ $t('footer.under_logo') }}
                    </p>
                    <!-- <div class="socials">
                        <a href="https://www.facebook.com/bestbcrowdfunding/" class="color-grey text-decoration-none"><b-icon icon="facebook" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="instagram" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="twitter" scale="1"></b-icon></a>
                        <a href="#" class="color-grey text-decoration-none"><b-icon icon="twitch" scale="1"></b-icon></a>
                        <a href="https://www.youtube.com/channel/UCBM0oydZSdm9btfTrqFz0wQ" class="color-grey text-decoration-none"><b-icon icon="youtube" scale="1"></b-icon></a>
                    </div> -->
                </div>
                <div class="col5">
                    <p class="title line-h-40">
                        {{ $t('footer.social') }}
                    </p>
                    <a href="https://www.facebook.com/bestbcrowdfunding/" target="_blank" class="color-grey text-decoration-none">
                        <b-icon icon="facebook" scale="1"></b-icon>
                        <span class="mr-l-10">Facebook</span>
                    </a>
                    <a href="https://www.youtube.com/channel/UCBM0oydZSdm9btfTrqFz0wQ" target="_blank" class="color-grey text-decoration-none">
                        <b-icon icon="youtube" scale="1"></b-icon>
                        <span class="mr-l-10">Youtube</span>
                    </a>
                </div>
                <div class="col5">
                    <p class="title line-h-40">
                        {{ $t('footer.company') }}
                    </p>
                    <a :href="domain + locale + '/about-bestb'" class="color-grey text-decoration-none">
                        {{ $t('footer.about') }}
                    </a>
                    <a :href="domain + locale + '/contact-us'" class="color-grey text-decoration-none">
                        {{ $t('footer.contact') }}
                    </a>
                </div>
                <div class="col5 mcol-50">
                    <p class="title line-h-40">
                        {{ $t('footer.contact') }}
                    </p>
                    <a class="color-grey text-decoration-none">
                        <i class="fas fa-map-marker-alt"></i> {{ $t('infor_bestb.headquarters') + ': ' + $t('infor_bestb.address_hn') }} |
                        <br>

                        {{ $t('infor_bestb.address_hcm1') }}
                        <br>
                        <br>

                        <i class="fas fa-phone-alt"></i> {{ $t('infor_bestb.phone_1') }} - <i class="fas fa-phone-alt"></i> {{ $t('infor_bestb.phone_2') }}
                        <br>
                        <br>

                        <i class="fas fa-phone-alt"></i> {{ $t('infor_bestb.phone_3') }} - <i class="fas fa-envelope"></i> {{ $t('infor_bestb.email') }}
                    </a>
                </div>
            </b-row>
        </div>
    </footer>
</template>

<script>
    import env from '../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "Footer",
        data() {
            return {
                domain: domain,
                locale: this.$route.params.locale,
            }
        }
    }
</script>

<style lang="scss" scoped>
    .d-space-event {
        justify-content: space-evenly;
    }

    .col5 {
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

    .mcol-50 {
        max-width: 40% !important;
        flex: auto;
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

    .socials {
        display: flex;
        align-items: center;
        font-size: 20px;
    }

    .socials a {
        margin-left: 10px;
    }

    .socials a:first-child {
        margin-left: 0px;
    }
</style>
