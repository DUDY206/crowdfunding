<template>
    <footer class="py-5 mt-auto zInd99">
        <div class="container">
            <b-row class="d-space-event">
                <div class="col5">
                    <img :src="domain + '/investor/images/logo2.png'" alt="" class="w-100">
                    <p class="my-3 text">
                        {{ $t('footer.under_logo') }}
                    </p>
                    <p class="my-3 text">
                        {{ $t('footer.under_logo1') }}
                    </p>
                    <!-- <div class="socials">
                        <a href="https://www.facebook.com/bestbcrowdfunding/" class=" text-decoration-none"><b-icon icon="facebook" scale="1"></b-icon></a>
                        <a href="#" class=" text-decoration-none"><b-icon icon="instagram" scale="1"></b-icon></a>
                        <a href="#" class=" text-decoration-none"><b-icon icon="twitter" scale="1"></b-icon></a>
                        <a href="#" class=" text-decoration-none"><b-icon icon="twitch" scale="1"></b-icon></a>
                        <a href="https://www.youtube.com/channel/UCBM0oydZSdm9btfTrqFz0wQ" class=" text-decoration-none"><b-icon icon="youtube" scale="1"></b-icon></a>
                    </div> -->
                </div>
                <div class="col5">
                    <p class="title line-h-40 text">
                        {{ $t('footer.social') }}
                    </p>
                    <a href="https://www.facebook.com/bestbcrowdfunding/" target="_blank" class="text text-decoration-none">
                        <b-icon icon="facebook" scale="1"></b-icon>
                        <span class="mr-l-10">Facebook</span>
                    </a>
                    <a href="https://www.youtube.com/channel/UCBM0oydZSdm9btfTrqFz0wQ" target="_blank" class="text text-decoration-none">
                        <b-icon icon="youtube" scale="1"></b-icon>
                        <span class="mr-l-10">Youtube</span>
                    </a>
                </div>
                <div class="col5">
                    <p class="title line-h-40 text">
                        {{ $t('footer.company') }}
                    </p>
                    <a :href="domain + locale + '/about-bestb'" class="text text-decoration-none">
                        <i class="fas fa-info"></i>
                        <span class="mr-l-10">{{ $t('footer.about') }}</span>
                    </a>
                    <a :href="domain + locale + '/contact-us'" class="text text-decoration-none">
                        <i class="fas fa-phone-alt"></i>
                        <span class="mr-l-10">{{ $t('footer.contact') }}</span>
                    </a>
                    <a :href="domain + locale + '/privacy-policies'" class="text text-decoration-none">
                        <i class="fas fa-passport"></i>
                        <span class="mr-l-10">{{ $t('footer.privacy_policies') }}</span>
                    </a>
                    <a :href="domain + locale + '/payment-terms'" class="text text-decoration-none">
                        <i class="fas fa-credit-card"></i>
                        <span class="mr-l-10">{{ $t('footer.payment_terms') }}</span>
                    </a>
                    <a :href="domain + locale + '/service-terms'" class="text text-decoration-none">
                        <i class="fab fa-servicestack"></i>
                        <span class="mr-l-10">Quy định sử dụng dịch vụ</span>
                    </a>
                </div>
                <div class="col5 mcol-50">
                    <p class="title line-h-40 text">
                        {{ $t('footer.contact') }}
                    </p>
                    <a class="text-decoration-none">
                        <p class="text">
                            <i class="fas fa-building"></i> 
                            {{ $t('infor_bestb.name_company1') }}
                        </p>

                        <p class="text">
                            <i class="fas fa-sticky-note"></i> 
                            {{ $t('infor_bestb.sticky') }}
                        </p>

                        <p class="text">
                            <i class="fas fa-map-marker-alt"></i> 
                            {{ $t('infor_bestb.address_main') }}
                        </p>

                        <p class="text">
                            <i class="fas fa-map-marker-alt"></i> 
                            {{ $t('infor_bestb.vpgd_hn') + ': ' + $t('infor_bestb.address_hn') }}
                        </p>

                        <p class="text">
                            <i class="fas fa-map-marker-alt"></i> 
                            {{ $t('infor_bestb.vpgd_hcm') + ': ' + $t('infor_bestb.address_hcm2') }}
                        </p>

                        <p class="text">
                            <i class="fas fa-phone-alt"></i> {{ $t('infor_bestb.phone_1') }} - <i class="fas fa-phone-alt"></i> {{ $t('infor_bestb.phone_2') }}
                        </p>

                        <p class="text">
                            <i class="fas fa-phone-alt"></i> {{ $t('infor_bestb.phone_3') }} - <i class="fas fa-envelope"></i> {{ $t('infor_bestb.email') }}
                        </p>
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
    footer {
        background-color: var(--main-dark-blue);

        .text {
            color: white;

            i, svg, span {
                color: white;
            }
        }

        .text:hover {
            color: var(--main-light-green) !important;

            i, svg, span {
                color: var(--main-light-green) !important;
            }
        }
    }

    .d-space-event {
        justify-content: space-evenly;
    }

    .col5 {
        width: 100%;

        .title {
            border-bottom: solid 1px var(--main-grey);
        }

        a {
            display: table;

            i {
                width: 20px;
            }
        }

        a, p {
            font-weight: bold;
        }

        img {
            max-width: 180px !important;
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

    @media only screen and (max-width: 991px) {
        .mcol-50 {
            max-width: 100% !important;
        }
    }
</style>
