<template>
    <b-container fluid="lg">
        <circle-progress v-if="isLoading"></circle-progress>
        <b-row v-else>
            <b-col cols="12" lg="4" v-for="companyInvest in listCompanyInvest.data" :key="companyInvest.id" class="mb-3">
                <a v-bind:href="'/' + locale + '/' + companyInvest.lang_slug[locale]" class="company-invest-card overflow-hidden">
                    <div class="company-invest-card__header">
                        <img v-bind:src="companyInvest.path_img_url" class="w-100 avatar-invest" />
                    </div>
                    <div class="company-invest-card__body">
                        <div class="w-100">
                            <div class="company-invest-card__body--title">
                                <img class="company_avatar bg-white" v-bind:src="companyInvest.company.path_img_url" />
                                <h3 class="title">{{companyInvest.lang_name[$i18n.locale]}}</h3>
                                <p v-if="companyInvest.lang_short_description !== null" class="text-description">
                                    {{companyInvest.lang_short_description[$i18n.locale]}}
                                </p>
                            </div>
                            <div class="company-invest-card__body--service">
                                <p class="">
                                    <span class="font-weight-bold">{{ companyInvest.total_investor }}</span> {{ $t('home.investor') }}
                                </p>
                                <p>
                                    <span class="font-weight-bold">{{ companyInvest.min_invest.toLocaleString() }}</span> {{ $t('home.min_invest') }}
                                </p>
                                <p>
                                    <span class="font-weight-bold">{{ companyInvest.valuation_cap.toLocaleString() }}</span> {{ $t('home.valuation_cap') }}
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
        <b-row class="data-pagin" v-if="checkPaginate">
            <b-col cols="12" lg="4" v-for="companyInvest in dataPaginate" :key="companyInvest.id" class="mb-3">
                <a v-bind:href="'/' + locale + '/' + companyInvest.lang_slug[locale]" class="company-invest-card overflow-hidden">
                    <div class="company-invest-card__header">
                        <img v-bind:src="companyInvest.path_img_url" class="w-100 avatar-invest" />
                    </div>
                    <div class="company-invest-card__body">
                        <div class="w-100">
                            <div class="company-invest-card__body--title">
                                <img class="company_avatar bg-white" v-bind:src="companyInvest.company.path_img_url" />
                                <h3 class="title">{{companyInvest.lang_name[$i18n.locale]}}</h3>
                                <p v-if="companyInvest.lang_short_description !== null" class="text-description">
                                    {{companyInvest.lang_short_description[$i18n.locale]}}
                                </p>
                            </div>
                            <div class="company-invest-card__body--service">
                                <p class="">
                                    <span class="font-weight-bold">{{ companyInvest.total_investor }}</span> {{ $t('home.investor') }}
                                </p>
                                <p>
                                    <span class="font-weight-bold">{{ companyInvest.min_invest }}</span> {{ $t('home.min_invest') }}
                                </p>
                                <p>
                                    <span class="font-weight-bold">{{ companyInvest.valuation_cap }}</span> {{ $t('home.valuation_cap') }}
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
        <div class="load-paginate" v-if="isLoadPage">
            <circle-progress></circle-progress>
            <br />
        </div>
        <div class="show-data" v-if="!isLoading && showBtnPaginate && !isLoadPage">
            <a @click="loadDataPaginate">
                {{ $t('home.show_all') }}
                <div class="total">{{ numberData }}</div>
            </a>
        </div>
    </b-container>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from "../../../commons/CircleProgress";

    export default {
        name: "ListCompanyInvest",
        computed:{
            ...mapGetters([
                'listCompanyInvest',
                'listCompanyInvestPaginate',
                'auth'
            ])
        },
        components: {
            CircleProgress
        },
        data() {
            return {
                locale: this.$store.state.locale,
                isLoading: true,
                numberData: null,
                checkPaginate: false,
                showBtnPaginate: true,
                isLoadPage: false,
                currentPage: 1,
                dataPaginate: "",
            }
        },
        mounted() {
            var self = this;

            self.locale = self.$route.params.locale;

            self.$store.dispatch("getAllCompanyInvestByPaginateNull");

            this.$store.dispatch("getAllCompanyInvest")
            .then((res) => {
                self.isLoading = false;
                self.numberData = self.listCompanyInvest.data.length;
                self.currentPage = self.listCompanyInvest.current_page;

                if (self.listCompanyInvest.next_page_url === null) {
                    self.showBtnPaginate = false;
                }
            });
        },
        methods: {
            loadDataPaginate() {
                var self = this;
                self.checkPaginate = true;
                self.isLoadPage = true;

                this.currentPage++;
                this.$store.dispatch("getAllCompanyInvestByPaginate", this.currentPage)
                .then((res) => {
                    self.currentPage = res.data.current_page;

                    if (self.dataPaginate.length == 0) {
                        self.dataPaginate = res.data.data;
                    } else {
                        for (var item of res.data.data) {
                            self.dataPaginate.push(item);
                        }
                    }

                    self.isLoadPage = false;

                    if (res.data.next_page_url === null) {
                        self.showBtnPaginate = false;
                    }
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .avatar-invest {
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        height: 200px;
        object-fit: cover;
    }

    .company-invest-card {
        text-decoration: none!important;
        height: 100%;
        min-height: 100%;
        display: block;
        transition: all 1s ease;

        .company_avatar {
            width: 60px;
            margin-top:-40px;
            box-shadow: 0px 0px 14px -3px rgb(0 0 0 / 75%);
            z-index: 9;
            border-radius: 4px;
        }

        .company-invest-card__body {
            position: relative;
            min-height: 250px;

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
                    color: #222;
                    font-weight: bold;
                    font-size: 24px;
                    margin-top: 10px;
                    &:first-letter {
                        text-transform: uppercase;
                    }
                }

                .text-description {
                    color: #868686;
                    font-size: 18px;
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

        .company-invest-card__body--footer {
            max-height: 250px;
            opacity: 1;
            color: #999;
            font-size: 18px;
        }
    }

    .company-invest-card:hover {
        .company-invest-card__body--service {
            max-height: 250px;
            opacity: 1;
            color: #999;
            font-size: 18px;
            transition: max-height 0.5s ease-in-out;
        }

        .company-invest-card__body--footer {
            max-height: 0;
            opacity: 0;
        }
    }

    .show-data {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        cursor: pointer;

        a {
            position: relative;
            display: flex;
            justify-content: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            line-height: 45px;
            text-decoration: none;
            color: #222;
            font-weight: bold;
            font-size: 16px;

            .total {
                position: absolute;
                right: 10px;
                font-size: 13px;
                font-weight: 500;
                color: #ababab;
            }
        }

        a:hover {
            color: #0049ff;
            box-shadow: inset 0 0 0 1px #0049ff;
        }
    }

</style>
