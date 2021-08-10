<template>
    <div class="box-list-wrapper">

        <!-- <circle-progress v-if="isLoading" /> -->
        <list-invest-skeleton v-if="isLoading" />

        <b-row id="list-company-invest" v-if="!isLoading && isLoaded">
            <b-col cols="12" lg="12" class="title-filter">
                <div class="title-home">
                    <h1>{{ $t('home.liked_invest') }}</h1>
                </div>
            </b-col>

            <b-col cols="12" lg="4" v-for="companyInvest in listCompanyInvestByMe.data" :key="companyInvest.id" class="mb-5 pd-t-30">
                <a v-bind:href="'/' + locale + '/invest/' + companyInvest.lang_slug[locale]" class="company-invest-card overflow-hidden">
                    <div class="company-invest-card__header">
                        <img v-bind:src="domain + companyInvest.path_img_url" class="w-100 avatar-invest" />
                    </div>
                    <div class="company-invest-card__body">
                        <div class="w-100">
                            <div class="company-invest-card__body--title">
                                <img class="company_avatar bg-white" v-if="companyInvest.company.img_url !== null" v-bind:src="domain + companyInvest.company.path_img_url" />
                                <h3 class="title">{{companyInvest.lang_name[$i18n.locale]}}</h3>
                                <p v-if="companyInvest.lang_short_description !== null" class="text-description short-text">
                                    {{companyInvest.lang_short_description[$i18n.locale]}}
                                </p>
                            </div>
                            <div class="company-invest-card__body--service">
                                <!-- <p class="">
                                    <span class="font-weight-bold">{{ companyInvest.total_investor }}</span> {{ $t('home.investor') }}
                                </p> -->
                                <p>
                                    <span class="font-weight-bold">{{ companyInvest.min_invest.toLocaleString() }}</span> {{ $t('home.min_invest') }}
                                </p>
                                <!-- <p>
                                    <span class="font-weight-bold">{{ companyInvest.valuation_cap.toLocaleString() }}</span> {{ $t('home.valuation_cap') }}
                                </p> -->
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

        <!-- <div class="load-paginate" v-if="isLoadPage">
            <circle-progress></circle-progress>
            <br />
        </div> -->

        <b-row v-if="isLoadPage">
            <list-invest-skeleton />
        </b-row>

        <div class="show-data" v-if="!isLoading && showBtnPaginate && !isLoadPage && isLoaded">
            <a @click="loadDataPaginate">
                {{ $t('home.show_all') }}
            </a>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from "../../../commons/CircleProgress";
    import env from "../../../env";
    const domain = env.INVESTOR_DOMAIN;
    import ListInvestSkeleton from '../Skeleton/ListInvestSkeleton';

    export default {
        name: 'ListCompanyInvestByMe',
        computed: {
            ...mapGetters([
                'locale', 'auth'
            ])
        },
        components: {
            CircleProgress,
            ListInvestSkeleton,
        },
        data() {
            return {
                domain: domain,
                isLoading: true,
                listCompanyInvestByMe: {},
                numberData: null,
                currentPage: 1,
                showBtnPaginate: true,
                isLoadPage: false,
                isLoaded: false,
            }
        },
        mounted() {
            var self = this;

            if (self.auth.token !== null) {
                self.callBackDataInvest(self);
            }
        },
        methods: {
            callBackDataInvest(self) {
                self.$store.dispatch("getAllCompanyInvestBeLikedByUser")
                .then((res) => {
                    self.isLoading = false;
                    self.listCompanyInvestByMe = res.data;
                    if (res.data.status === false) {
                        self.isLoaded = false;
                    } else {
                        if (self.listCompanyInvestByMe.data.length !== 0) {
                            self.isLoaded = true;
                        } else {
                            self.isLoaded = false;
                        }

                        self.getDataFromStore(self);
                    }
                })
                .catch((err) => {
                    self.$toast.error(self.$t('errors.error_1'));
                    self.isLoading = false;
                })
            },
            getDataFromStore(self) {
                self.numberData = self.listCompanyInvestByMe.data.length;
                self.currentPage = self.listCompanyInvestByMe.current_page;

                if (self.listCompanyInvestByMe.next_page_url === null) {
                    self.showBtnPaginate = false;
                }
            },
            loadDataPaginate() {
                var self = this;
                self.checkPaginate = true;
                self.isLoadPage = true;
                self.currentPage++;

                self.$store.dispatch("getAllCompanyInvestBeLikedByUserByPaginate", self.currentPage)
                .then((res) => {
                    self.currentPage = res.data.current_page;
                    self.pushDataToDataPaginate(res.data.data, res.data);
                })
                .catch((err) => {
                    self.$toast.error(self.$t('errors.error_1'));
                })
            },
            pushDataToDataPaginate(data, paginate) {
                var self = this;

                for (var item of data) {
                    self.listCompanyInvestByMe.data.push(item);
                }

                self.isLoadPage = false;

                if (paginate.next_page_url === null) {
                    self.showBtnPaginate = false;
                }
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
        box-shadow: 0 4px 24px rgb(0 0 0 / 8%);
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
            // transition: .8s all ease;
            transition: .5s all ease;
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
            // max-height: 250px;
            max-height: 50px;
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
