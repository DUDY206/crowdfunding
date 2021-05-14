<template>
    <div class="invest-item main-border">
        <circle-progress class="progress-custom" v-if="isLoading"></circle-progress>
        <div v-if="!isLoading" v-for="category in listCategory" :key="category.id">
            <a :href="domain + locale + '/category/' + category.lang_slug[locale]" class="text-decoration-none">
                <div class="p-lg-3">
                    <div class="w-100 d-flex">
                        <img v-if="category.logo !== ''" :src="domain + url_folder + category.logo" class="normal-icon">
                        <img v-else src="/investor/images/tmp.jpg" class="normal-icon">

                        <div class="pl-lg-3 d-inline-block">
                            <p class="m-0">{{ category.lang_name[locale] }}</p>
                            <!-- <p class="descript short-text-1">{{ category.lang_description[locale] }}</p> -->
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div v-if="!isLoading" v-for="category, index of otherCategories" :key="index">
            <a @click="scrollToCategory" class="text-decoration-none">
                <div class="p-lg-3">
                    <div class="w-100 d-flex">
                        <img :src="domain + 'investor/images/tmp.jpg'" class="normal-icon">

                        <div class="pl-lg-3 d-inline-block">
                            <p class="m-0">{{ category.lang_name[locale] }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;
    import CircleProgress from "../../../commons/CircleProgress";

    export default {
        name: 'InvestHeaderCard',
        components: {
            CircleProgress
        },
        computed:{
            ...mapGetters([
                'locale', 'auth'
            ])
        },
        data() {
            return {
                domain: domain,
                url_folder: 'storage/categories/logo/',
                otherCategories: [
                    {
                        id: null,
                        img: '',
                        lang_name: {
                            vi: 'Ngành khác',
                            en: 'Other industry',
                        },
                        lang_description: {
                            vi: 'Đang cập nhật...',
                            en: 'Updating...',
                        },
                    },
                ],
                statusCategory: null,
                isLoading: true,
                listCategory: {},
            }
        },
        mounted() {
            var self = this;
            self.statusCategory = 1;

            self.$store.dispatch('getAllCategory', self.statusCategory)
            .then((res) => {
                self.listCategory = res.data
                self.isLoading = false;
            })
            .catch((err) => {
                self.isLoading = false;
            })
        },
        methods: {
            scrollToCategory() {
                var self = this;

                if (self.$route.name === 'Home') {
                    if (document.getElementById('category') !== null) {
                    document.getElementById('category').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
                    } else {
                        self.$toast.info(self.$t('loads.loading_1'));
                    }
                } else {
                    self.$toast.info(self.$t('header_banner.please_redirect'));
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .invest-item {
        background: white;
        position: absolute;
        top: 10px;
        z-index: 100;
        transform: translateY(-4%);
        transition: 0.5s all ease;
        display: grid;
        grid-template-columns: 280px 280px 280px;
        border-radius: 5px;

        .progress-custom {
            width: 840px;
            margin-top: 15px;
        }

        .p-lg-3:hover {
            background: #f5f5f5;
            height: 100%;
        }

        & > div{
            box-sizing: border-box;

            p {
                white-space: break-spaces;
            }
        }

        & > div:nth-child(3n+2) {
            border-left: solid 1px #eeeeee;
            border-right: solid 1px #eeeeee;
        }

        & > div:nth-child(3) ~ div {
            border-top: solid 1px #eeeeee;
        }

        .main-border {
            border: none;
        }

        p.m-0 {
            color: #222222;
            font-weight: bold;
            font-size: 18px;
        }

        p.descript {
            color: #a9a9a9;
            font-size: 13px;
        }
    }
</style>
