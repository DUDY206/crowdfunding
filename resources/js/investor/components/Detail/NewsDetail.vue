<template>
    <div>
        <circle-progress v-if="isLoading"></circle-progress>
        <div class="container" v-if="!isLoading">
            <div class="wrapper-components">
                <div class="tab-menu-title">
                    <a :href="domain + locale + '/news'">{{ $t('news.news') }}</a>
                </div>
                <div class="wrapper-layout">
                    <div class="theme">
                        <div class="theme-avatar">
                            <img :src="domain + url_forder + news.img_url" />
                        </div>
                        <div class="theme-info">
                            <div class="info-name">
                                {{ news.lang_name[locale] }}
                            </div>
                            <div class="info-created">
                                {{ $t('time.day') }}: <span>{{ news.created_date }}</span>
                            </div>
                            <div class="info-description">
                                {{ news.lang_description[locale] }}
                            </div>
                            <div class="reaction">
                                <a @click="reaction(1)" v-if="!isCheckLike">
                                    <i class="far fa-heart"></i>
                                    <span>{{ $t('news.like') }}</span>
                                </a>
                                <a @click="reaction(0)" class="rea-active" v-else>
                                    <i class="far fa-heart"></i>
                                    <span>{{ $t('news.un_like')  }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="content" v-html="news.lang_content[locale]">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import router from "../../routes";
    import CircleProgress from "../../../commons/CircleProgress";
    import DotProgress from "../../../commons/DotProgress";
    import FlashDotProgress from "../../../commons/FlashDotProgress";
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "NewsDetail",
        components:{
            Comment,
            CircleProgress,
            DotProgress,
            FlashDotProgress,
        },
        computed: {
            ...mapGetters([
                'locale', 'auth', 'news'
            ])
        },
        data() {
            return {
                domain: domain,
                isLoading: true,
                url_forder: '/storage/news/',
                isCheckLike: false,
            }
        },
        mounted() {
            var self = this;
            var locale = self.$store.state.locale;
            var slug = self.$route.params.slug;

            if (locale === null) {
                locale = self.$route.params.locale;
            }

            const params = {
                slug: slug,
                locale: locale,
            }

            self.$store.dispatch('getNewsBySlug', params)
            .then((res) => {
                self.isLoading = false;
            })
            .catch((err) => {
                self.isLoading = false;
                self.$toast.info(self.$t('errors.error_3'));
                self.$router.push({path: '/' + locale + '/news'}).then(r => {});
            })
        },
        methods: {
            reaction(status) {
                var self = this;

                if (status === 0) {
                    self.isCheckLike = false;
                } else {
                    self.isCheckLike = true;
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    $grayColor: #777;

    a {
        cursor: pointer;
        text-decoration: none;
    }

    img {
        width: 100%;
        object-fit: contain;
    }

    .container {
        max-width: 1500px;

        .wrapper-components {
            margin-bottom: 50px;

            .tab-menu-title {
                margin: 10px 0;

                a {
                    color: #898989;
                    font-size: 20px;
                }
            }

            .wrapper-layout {
                .theme {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 30px;

                    .theme-info {
                        width: 55%;
                        border-top: 1px solid #eee;

                        .info-name {
                            font-size: 40px;
                            line-height: 45px;
                            font-weight: 900;
                            letter-spacing: 1px;
                            color: #000;
                            margin-bottom: 10px;
                        }

                        .info-created {
                            color: black;
                            font-weight: bold;
                            margin-bottom: 20px;

                            span {
                                color: $grayColor;
                            }
                        }

                        .info-description {
                            font-size: 18px;
                            font-style: oblique;
                            margin-bottom: 10px;
                        }

                        .reaction {
                            margin: 10px 0;

                            a {
                                padding: 5px 10px;
                                background: #f98787;
                                border-radius: 5px;
                                color: white !important;
                                font-size: 15px;
                                font-weight: bold;
                            }

                            a:hover {
                                background: #f14b4b !important;
                            }

                            .rea-active {
                                background: #f14b4b !important;
                            }
                        }

                        .rea-active-fixed {
                            position: fixed;
                            left: 50px;
                            top: 80px;
                        }

                    }
                }

                .content {
                    img {
                        width: 30%;
                    }
                }

            }
        }
    }

    @media (max-width: 800px) {
        .container .wrapper-components .wrapper-layout .theme {
            flex-direction: column !important;

            .theme-info {
                width: 100% !important;
            }
        }
    }
</style>
