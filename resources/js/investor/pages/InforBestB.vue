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
            <b>{{ $t('infor_bestb.title_address') }}</b>
            <br>
            &ensp;&ensp; - {{ $t('infor_bestb.address_hn') }}
            <br>
            &ensp;&ensp; - {{ $t('infor_bestb.address_hcm1') }}
        </p>
        <p>
            <b>{{ $t('infor_bestb.title_phone') }}</b>
            (+84) 968.988.608 - (+84) 933 995 126
        </p>
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
            <a :href="domain + 'contact-us'">
                {{ $t('header_banner.contact_us') }}
            </a>
        </p>
        <br>
        <p>{{ $t('infor_bestb.confirm_order') }}</p>
    </div>
</template>

<script>
    import env from '../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: 'InforBestB',
        props: {
            checkPage: Boolean,
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
