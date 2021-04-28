<template>
    <a v-bind:href="'/'+locale+'/invest/'+companyInvest.lang_slug[locale]" class="company-invest-card overflow-hidden">
        <div class="company-invest-card__header">
            <img v-bind:src="domain + companyInvest.path_img_url" class="w-100 avatar-invest"/>
        </div>
        <div class="company-invest-card__body">
            <div class="w-100">
                <div class="company-invest-card__body--title">
                    <img class="company_avatar bg-white" v-if="companyInvest.company.img_url !== null" v-bind:src="domain + companyInvest.company.path_img_url"/>
                    <h3 class="title">{{companyInvest.lang_name[$i18n.locale]}}</h3>
                    <p class="text-description" v-if="companyInvest.lang_short_description !== null">
                        {{companyInvest.lang_short_description[$i18n.locale]}}
                    </p>
                </div>
            </div>
        </div>
    </a>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "CompanyInvestCard",
        props:[
            'companyInvest',
        ],
        computed:{
            ...mapGetters([
                'locale'
            ])
        },
        data() {
            return {
                domain: domain
            }
        },
    }
</script>

<style lang="scss" scoped>
    .avatar-invest {
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        height: 150px;
        max-height: 200px;
        object-fit: cover;
    }

    .company-invest-card {
        text-decoration: none!important;
        display: block;

        .company_avatar {
            max-width: 50px;
            margin-top:-40px;
            box-shadow: 0px 0px 14px -3px rgb(0 0 0 / 75%);
            z-index: 9;
        }

        .company-invest-card__body {
            position: relative;
            min-height: 150px;

            & > div {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                bottom: 0;
                min-height: 100%;
                position: absolute;
                background: white;
                border: solid #e9e9e9;
                border-width: 0 1px 1px;
                border-bottom-right-radius: 4px;
                border-bottom-left-radius: 4px;
                text-decoration: none;
                padding: 0 1.5rem;

                h3 {
                    &:first-letter {
                        text-transform: uppercase;
                    }
                }
            }
        }

        .company-invest-card__body--service {
            max-height: 0;
            opacity: 0;

            p {
                border-top: solid 1px #eee ;
                margin:0;
                padding:1rem 0;
            }
        }
        .company-invest-card__body--footer{
            max-height: 250px;
            opacity: 1;
        }
    }
    .company-invest-card:hover{
        .company-invest-card__body--service{
            max-height: 250px;
            opacity: 1;
            color: #999;
            font-size: 18px;
            transition: max-height 0.5s ease-in-out;
        }

        .company-invest-card__body--footer{
            max-height: 0;
            opacity: 0;
        }
    }

    .company-invest-card {
        transition: all 1s ease;
        transform: translateY(0%);
    }

    .company-invest-card:hover {
        transform: translateY(-2%);
        box-shadow: 0 3px 8px rgb(0 0 0 / 5%);
    }

    .title {
        color: #222;
        font-weight: bold;
        font-size: 23px;
        margin-top: 10px;
    }

    .text-description {
        color: #868686;
        font-size: 16px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

</style>

