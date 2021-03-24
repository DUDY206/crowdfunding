<template>
    <b-container fluid="lg">
        <circle-progress v-if="isLoading"></circle-progress>
        <b-row v-else>
            <b-col cols="12" lg="4" v-for="companyInvest in listCompanyInvest.data" :key="companyInvest.id" class="mb-3">
                <a v-bind:href="'/'+locale+'/'+companyInvest.lang_slug[locale]" class="company-invest-card overflow-hidden">
                    <div class="company-invest-card__header">
                        <img v-bind:src="companyInvest.path_img_url" class="w-100 avatar-invest"></img>
                    </div>
                    <div class="company-invest-card__body">
                        <div class="w-100">
                            <div class="company-invest-card__body--title">
                                <img class="company_avatar bg-white" v-bind:src="companyInvest.company.path_img_url"></img>
                                <h3>{{companyInvest.lang_name[$i18n.locale]}}</h3>
                                <p v-if="companyInvest.lang_short_description !== null">
                                    {{companyInvest.lang_short_description[$i18n.locale]}}
                                </p>
                            </div>
                            <div class="company-invest-card__body--service">
                                <p class="">
                                    <span class="font-weight-bold">1.000.000</span> investor
                                </p>
                                <p>
                                    <span class="font-weight-bold">1.000.000</span> min invest
                                </p>
                                <p>
                                    <span class="font-weight-bold">1.000.000</span> valuation cap
                                </p>
                            </div>
                            <div class="company-invest-card__body--footer">
                                <p v-if="companyInvest.lang_location !== null">
                                    {{companyInvest.lang_location[$i18n.locale]}}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from "../../../commons/CircleProgress";

    export default {
        name: "ListCompanyInvest",
        computed:{
            ...mapGetters([
                'listCompanyInvest'
            ])
        },
        components: {
            CircleProgress
        },
        data() {
            return {
                locale: this.$store.state.locale,
                isLoading: true,
            }
        },
        mounted() {
            var self = this;

            setTimeout(function() {
                self.isLoading = false;
            }, 3000);

            this.$store.dispatch("getAllCompanyInvest");
        },
    }
</script>

<style lang="scss" scoped>
    .avatar-invest{
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        max-height: 250px;
        object-fit: cover;
    }
    .company-invest-card{
        text-decoration: none!important;
        height: 100%;
        min-height: 100%;
        display: block;
        .company_avatar{
            max-width: 80px;
            margin-top:-40px;
            box-shadow: 0px 0px 14px -3px rgb(0 0 0 / 75%);
            z-index: 9;
        }
        .company-invest-card__body{
            position: relative;
            min-height: 250px;
            &>div{
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
                h3{
                    &:first-letter{
                        text-transform: uppercase;
                    }
                }
            }
        }
        .company-invest-card__body--service{
            max-height: 0;
            opacity: 0;
            -webkit-transition: max-height .3s ease-in-out;
            -moz-transition: max-height .3s ease-in-out;
            -ms-transition: max-height .3s ease-in-out;
            -o-transition: max-height .3s ease-in-out;
            transition: max-height .3s ease-in-out;
            p{
                border-top: solid 1px #eee ;
                margin:0;
                padding:1rem 0;
            }
        }
        .company-invest-card__body--footer{
            max-height: 250px;
            opacity: 1;
        }
        /*.company-invest-card__body--footer,.company-invest-card__body--service{*/
        /*    */
        /*}*/
    }
    .company-invest-card:hover{
        .company-invest-card__body--service{
            max-height: 250px;
            opacity: 1;

        }
        .company-invest-card__body--footer{
            max-height: 0;
            opacity: 0;
        }
        /*.company-invest-card__body--footer,.company-invest-card__body--service{*/
        /*    -webkit-transition: max-height .3s ease-in-out;*/
        /*    -moz-transition: max-height .3s ease-in-out;*/
        /*    -ms-transition: max-height .3s ease-in-out;*/
        /*    -o-transition: max-height .3s ease-in-out;*/
        /*    transition: max-height .3s ease-in-out;*/
        /*}*/

    }

</style>
