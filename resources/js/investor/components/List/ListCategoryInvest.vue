<template>
    <b-container fluid="lg">

        <circle-progress v-if="isLoading" />
        <!-- all invest -->
        <b-row v-else id="list-company-invest">
            <b-col cols="12" lg="12" class="title-filter mr-b-30">
                <div class="title-home">
                    <h1 class="pd-b-20">{{ $t('home.invest_now') }}</h1>
                    <div class="small">{{ $t('home.des_invest_now') }}</div>
                </div>
            </b-col>
            <b-col cols="12" lg="4" v-for="companyInvest in listCompanyInvest.data" :key="companyInvest.id" class="mb-5">
                <a v-bind:href="'/' + locale + '/invest/' + companyInvest.lang_slug[locale]" class="company-invest-card overflow-hidden">
                    <div class="company-invest-card__header">
                        <img v-bind:src="domain + companyInvest.path_img_url" class="w-100 avatar-invest" />
                    </div>
                    <div class="company-invest-card__body">
                        <div class="w-100">
                            <div class="company-invest-card__body--title">
                                <img class="company_avatar bg-white" v-if="companyInvest.company.img_url !== null" v-bind:src="domain + companyInvest.company.path_img_url" />
                                <h3 class="title">{{companyInvest.lang_name[locale]}}</h3>
                                <p v-if="companyInvest.lang_short_description !== null" class="text-description short-text">
                                    {{companyInvest.lang_short_description[locale]}}
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
                                    {{companyInvest.lang_location[locale]}}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </b-col>
            <b-col cols="12" lg="4" class="mb-3" v-if="listCompanyInvest.data.length === 0">
                {{ $t('home.not_information') }}
            </b-col>
        </b-row>
        <div class="load-paginate" v-if="isLoadPage">
            <circle-progress />
            <br />
        </div>
        <div class="show-data" v-if="!isLoading && showBtnPaginate && !isLoadPage">
            <a @click="loadDataPaginate">
                {{ $t('home.show_all') }}
            </a>
        </div>
    </b-container>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from "../../../commons/CircleProgress";
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;
    import QuestionCard from '../Card/QuestionCard';

    export default {
        name: "ListCompanyInvest",
        props: {
            offLoadingCover: Function
        },
        computed: {
            ...mapGetters([
                'auth',
            ])
        },
        components: {
            CircleProgress,
            QuestionCard
        },
        data() {
            return {
                domain: domain,
                locale: null,
                isLoading: true,
                numberData: null,
                checkPaginate: false,
                showBtnPaginate: true,
                isLoadPage: false,
                currentPage: 1,
                statusSortPage: null,
                checkNullData: false,
                listCompanyInvest: {},
            }
        },
        mounted() {
            var self = this;

            self.statusSortPage = 0;

            if (self.locale === null) {
                self.locale = self.$route.params.locale;
            }

            if (self.$route.params.locale === null) {
                self.locale = 'vi';
            }

            var params = {
                locale: self.$route.params.locale,
                slug: self.$route.params.slugCategory
            };

            self.callBackData(params);
        },
        methods: {
            callBackData(params) {
                var self = this;
                self.$store.dispatch("getInvestByCategory", params)
                .then((res) => {
                    self.isLoading = false;
                    self.listCompanyInvest = res.data.company_invest;
                    self.offLoadingCover(res.data.category);
                    self.getDataFromStore();

                    if (self.listCompanyInvest.length === 0) {
                        self.checkNullData = true;
                    }
                });
            },
            getDataFromStore() {
                var self = this;

                self.numberData = self.listCompanyInvest.data.length;
                self.currentPage = self.listCompanyInvest.current_page;

                if (self.listCompanyInvest.next_page_url === null) {
                    self.showBtnPaginate = false;
                }
            },
            clearPaginate() {
                var self = this;
                self.isLoading = true;
                self.showBtnPaginate = true;
                self.isLoadPage = false;
            },
            pushDataToDataPaginate(data, paginate) {
                var self = this;

                for (var item of data) {
                    self.listCompanyInvest.data.push(item);
                }

                self.isLoadPage = false;

                if (paginate.next_page_url === null) {
                    self.showBtnPaginate = false;
                }
            },
            loadDataPaginate() {
                var self = this;
                self.checkPaginate = true;
                self.isLoadPage = true;

                self.currentPage++;
                const params = {
                    slug: self.$route.params.slugCategory,
                    locale: self.$route.params.locale,
                    page: self.currentPage,
                };

                self.$store.dispatch("getInvestByCategoryByPaginate", params)
                .then((res) => {
                    self.currentPage = res.data.company_invest.current_page;
                    self.pushDataToDataPaginate(res.data.company_invest.data, res.data.company_invest);
                })
            },
        }
    }
</script>

<style lang="scss" scoped>
    .title-filter {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;

        .title-home {
            h1 {
                font-size: 50px;
                line-height: 1;
                font-weight: 900;
                letter-spacing: -.04em;
                color: #000;
            }

            .small {
                font-size: 25px;
                line-height: 1.3;
                font-weight: 300;
                color: #777;
            }
        }

        .filter-invest {
            position: relative;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 5px 45px;
            cursor: pointer;
            width: 220px;

            .drop-down-option {
                width: auto;

                a {
                    font-weight: bold;
                    text-decoration: none !important;
                }

                i {
                    position: absolute;
                    right: 15px;
                    top: 10px;
                }
            }

            .dropdown-content_wrapper {
                width: 100%;
                position: absolute;
                top: 90%;
                left: 50%;
                z-index: 70;
                padding-top: 16px;
                -webkit-transform: translateX(-50%);
                -ms-transform: translateX(-50%);
                transform: translateX(-50%);
                visibility: hidden;
                opacity: 0;
                -webkit-transition: all .2s ease-in-out;
                transition: all .2s ease-in-out;

                .dropdown-content {
                    position: relative;
                    border-radius: 6px;
                    font-size: 16px;
                    font-weight: 400;
                    text-align: left;
                    white-space: nowrap;
                    background-color: #fff;
                    box-shadow: 0 1px 2px rgb(0 0 0 / 20%), 0 -1px 0 rgb(0 0 0 / 2%);
                    display: flex;
                    flex-direction: column;

                    a {
                        display: block;
                        width: auto;
                        height: auto;
                        margin: 0;
                        line-height: 1.5;
                        color: #222;
                        padding: 10px 32px 10px 16px;
                        width: -webkit-fill-available;
                        text-decoration: none !important;
                    }

                    a:hover {
                        color: #0049ff;
                        background: rgba(0,0,0,.03);
                    }

                    .active-text {
                        color: #0049ff;
                    }

                    .active-br {
                        background: rgba(0,0,0,.03);
                    }
                }
            }

            .dropdown-content_wrapper:before {
                content: '';
                position: absolute;
                top: 0%;
                left: 50%;
                height: 0;
                width: 0;
                pointer-events: none;
                margin-left: -9px;
                border: 9px solid transparent;
                border-bottom-color: rgba(0,0,0,.05);
            }
        }

        .filter-invest:hover, .filter-invest:active {
            border-color: #0049ff !important;
            color: #0049ff;

            .dropdown-content_wrapper {
                visibility: visible;
                opacity: 1;
                top: 100%;
            }
        }
    }

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
        box-shadow: rgb(0 0 0 / 40%) 0px 0px 15px;
        border-radius: 10px;

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
            transition: .3s all ease;

            & > div {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                bottom: 0;
                min-height: 100%;
                position: absolute;
                background: white;
                // border: solid #e9e9e9;
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
            transition: .8s all ease;
            font-size: 18px;

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
            transition: 2s all ease;
        }
    }

    .company-invest-card:hover {
        .company-invest-card__body--service {
            max-height: 250px;
            opacity: 1;
            color: #999;
        }

        .company-invest-card__body--footer {
            max-height: 0;
            opacity: 0;
            transition: .1s all ease;
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
