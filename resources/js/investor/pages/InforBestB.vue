<template>
    <div class="title-message">
        <p>
            <b>{{ $t('infor_bestb.title_name_company') }}</b>
            {{ $t('infor_bestb.name_company') }}
        </p>
        <p>
            <b>{{ $t('infor_bestb.title_mst') }}</b>
            0108776101
        </p>
        <p>
            <b>{{ $t('infor_bestb.headquarters') }}:</b>
            <br>
            <i class="fas fa-map-marker-alt"></i> {{ $t('infor_bestb.address_hn') }}
            <br>
            <i class="fas fa-map-marker-alt"></i> {{ $t('infor_bestb.address_hcm1') }}
        </p>
        <p>
            <b>{{ $t('infor_bestb.title_phone') }}</b>
            <br>
            <i class="fas fa-phone-alt"></i> {{ $t('infor_bestb.phone_1') }} - {{ $t('infor_bestb.phone_2') }}
            <br>
            <i class="fas fa-phone-alt"></i> {{ $t('infor_bestb.phone_3') }} - <i class="fas fa-envelope"></i> {{ $t('infor_bestb.email') }}
        </p>
        <p>
            <b>{{ $t('infor_bestb.account_holder') }}</b>
            {{ $t('infor_bestb.name_account_holder') }}
        <p>
        <p>
            <b>{{ $t('infor_bestb.title_number_account') }}</b>
            {{ $t('infor_bestb.number_account') }}
        <p>
            <b>{{ $t('infor_bestb.title_representative') }}</b>
            {{ $t('infor_bestb.representative') }}
        </p>
        <p>
            <b>{{ $t('infor_bestb.title_position') }}</b>
            {{ $t('infor_bestb.position') }}
        </p>
        <p v-if="!checkPage">
            <b>{{ $t('infor_bestb.contact_page') }}</b>
            <a :href="domain + locale + '/contact-us'" target="_blank">
                {{ $t('header_banner.contact_us') }}
            </a>
        </p>
        <br>
        <p>{{ $t('infor_bestb.confirm_order') }}</p>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from '../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: 'InforBestB',
        props: {
            checkPage: Boolean,
        },
        computed:{
            ...mapGetters([
                'locale'
            ])
        },
        data() {
            return {
                domain: domain,
            }
        },
        mounted() {
        }
    }
</script>
