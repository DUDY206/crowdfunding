<template>
    <div>
        <div class="container">
            <div class="row">
                <b-col cols="12" lg="12" class="title-filter">
                    <div class="title-home">
                        <h1>{{ $t('news.news') }}</h1>
                        <div class="small">{{ $t('news.des') }}</div>
                    </div>
                </b-col>
                <!-- <circle-progress v-if="isLoading" /> -->
                <list-news-skeleton v-if="isLoading" />
                <b-col v-else cols="12" lg="4" v-for="information in news.data" :key="information.id" class="content-page">
                    <a v-bind:href="'/' + locale + '/news/' + information.lang_slug[locale]" class="company-invest-card overflow-hidden">
                        <div class="company-invest-card__header">
                            <img v-bind:src="domain + url_forder + information.img_url" class="w-100 avatar-invest" />
                        </div>
                        <div class="company-invest-card__body">
                            <div class="wrapper-content">
                                <div class="company-invest-card__body-content">
                                    <h3 class="title short-text-1">{{ information.lang_name[locale] }}</h3>
                                    <small>{{ information.created_date }}</small>
                                    <p v-if="information.lang_description !== null" class="text-description short-text-1">
                                        {{ information.lang_description[locale] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </b-col>
            </div>

            <list-news-skeleton v-if="isLoadPage" />

            <div class="show-data" v-if="!isLoading && showBtnPaginate && !isLoadPage">
                <a @click="loadDataPaginate">
                    {{ $t('home.show_all') }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from "../../../commons/CircleProgress";
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;
    import ListNewsSkeleton from '../Skeleton/ListNewsSkeleton';

    export default {
        name: "News",
        components: {
            CircleProgress,
            ListNewsSkeleton,
        },
        computed:{
            ...mapGetters([
                'auth',
                'locale',
            ])
        },
        data() {
            return {
                domain: domain,
                isLoading: true,
                url_forder: '/storage/news/',
                news: {},
                currentPage: 1,
                isLoadPage: false,
                showBtnPaginate: true,
            }
        },
        mounted() {
            var self = this;

            if (self.locale === null) {
                self.locale = self.$route.params.locale;
            }

            self.getAllNews(self);
        },
        methods: {
            getAllNews(self) {
                self.$store.dispatch('getNews')
                .then((res) => {
                    self.news = res.data;

                    if (self.news.next_page_url === null) {
                        self.showBtnPaginate = false;
                    }

                    self.isLoading = false;
                })
                .catch((err) => {
                    self.isLoading = false;
                    self.$toast.error(self.$t('errors.error_1'));
                })
            },
            loadDataPaginate() {
                var self = this;
                self.checkPaginate = true;
                self.isLoadPage = true;

                self.currentPage++;
                self.$store.dispatch("getNewsByPaginate", self.currentPage)
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
                    self.news.data.push(item);
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
    .container {
        margin-bottom: 50px;

        .title-filter {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
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
        }

        .content-page {
            position: relative;
            margin-bottom: 20px;

            a {
                display: block;
                border-radius: 5px;
                text-decoration: none;
                box-shadow: 0 4px 24px rgb(0 0 0 / 8%);

                .company-invest-card__header {
                    img.w-100.avatar-invest {
                        height: 300px;
                        object-fit: cover;
                    }
                }

                .company-invest-card__body {
                    background: #f7f6f6;
                    height: 175px;

                    .wrapper-content {
                        padding: 10px;
                        font-size: 18px;
                        color: black;

                        h3.title {
                            font-size: 20px;
                            font-weight: 600;
                            font-family: sans-serif;
                            line-height: 25px;
                        }

                        small {
                            font-size: 14px;
                            color: #777;
                        }

                        p.text-description {
                            font-size: 16px;
                            font-family: Arial;
                            color: #4d4d4d;
                            line-height: 23px;
                            -webkit-line-clamp: 2 !important;
                        }
                    }
                }
            }

            a:hover, a:active {
                .company-invest-card__header {
                    img.w-100.avatar-invest {
                        opacity: 0.8;
                        transition: .5s ease all;
                    }
                }
            }

        //         .company-invest-card__body {
        //             visibility: hidden;
        //             position: absolute;
        //             top: 0;
        //             left: 0;
        //             bottom: 0;
        //             right: 0;
        //             height: 100%;
        //             margin: 0 auto;
        //             transition: 0.4s all ease;
        //             opacity: 0;

        //             .wrapper-content {
        //                 background: rgba(20, 20, 20, 0.85);
        //                 margin: 0 auto;
        //                 width: 350px;
        //                 border-radius: 1px;
        //                 height: -webkit-fill-available;
        //                 padding: 10px;

        //                 .company-invest-card__body-content {
        //                     color: white;

        //                     .title {
        //                         line-height: 36px;
        //                     }

        //                     .text-description {
        //                         margin-top: 10px;
        //                         line-height: 22px;
        //                     }
        //                 }
        //             }
        //         }
        //    }

            // a:hover, a:active {
            //     .company-invest-card__body {
            //         visibility: visible;
            //         opacity: 1;
            //     }
            // }
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
    }

    @media (max-width: 1200px) {
        .company-invest-card__body {
            .wrapper-content {
                width: 289px !important;
            }
        }
    }

    @media (max-width: 991px) {
        .content-page {
            margin-bottom: 10px !important;

            a {
                text-decoration: none;
                display: flex !important;
                border-radius: 5px !important;

                .company-invest-card__header {
                    img.w-100.avatar-invest {
                        // height: fit-content !important;
                        height: 300px !important;
                    }
                }

                .company-invest-card__body {
                    height: auto !important;
                    position: unset !important;
                    visibility: visible !important;
                    opacity: 1 !important;

                    .wrapper-content {
                        height: 100% !important;

                        .company-invest-card__body-content {
                            .title  {
                                -webkit-line-clamp: 5 !important;
                            }
                        }
                    }
                }
            }

            a:hover, a:active {
                opacity: 0.7 !important;
            }
        }
    }

    @media (max-width: 767px) {
        .content-page {
            a {
                .company-invest-card__body {
                    .wrapper-content {
                        .company-invest-card__body-content {
                            .title  {
                                -webkit-line-clamp: 3 !important;
                            }

                            .text-description {
                                white-space: nowrap !important;
                                display: block !important;
                            }
                        }
                    }
                }
            }
        }
    }


    @media (max-width: 550px) {
        .content-page {
            a {
                .company-invest-card__body {
                    .wrapper-content {
                        width: 100px !important;
                    }
                }
            }
        }
    }
</style>
