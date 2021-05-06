<template>
    <div class="invest-item main-border">
        <div v-for="category of categories" :key="category.id">
            <a href="#" class="text-decoration-none">
                <div class="p-lg-3">
                    <div class="w-100 d-flex">
                        <img v-if="category.img !== ''" :src="domain + url_folder + category.img" class="normal-icon">
                        <img v-else src="/investor/images/tmp.jpg" class="normal-icon">

                        <div class="pl-lg-3 d-inline-block">
                            <p class="m-0">{{ category.lang_name[locale] }}</p>
                            <p class="descript">{{ category.lang_des[locale] }}</p>
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

    export default {
        name: 'InvestHeaderCard',
        computed:{
            ...mapGetters([
                'locale', 'auth'
            ])
        },
        data() {
            return {
                domain: domain,
                url_folder: 'investor/images/',
                categories: [
                    {
                        id: 1,
                        img: 'vatlieu.jpeg',
                        lang_name: {
                            vi: 'Vật liệu xây dựng',
                            en: 'Construction materials industry',
                        },
                        lang_des: {
                            vi: 'Đang cập nhật...',
                            en: 'Updating...',
                        },
                    },
                    {
                        id: 2,
                        img: 'vantai.jpeg',
                        lang_name: {
                            vi: 'Vận tải',
                            en: 'Transportation industry',
                        },
                        lang_des: {
                            vi: 'Đang cập nhật...',
                            en: 'Updating...',
                        },
                    },
                    {
                        id: 3,
                        img: 'congnghe.jpeg',
                        lang_name: {
                            vi: 'Công nghệ',
                            en: 'Technology industry',
                        },
                        lang_des: {
                            vi: 'Đang cập nhật...',
                            en: 'Updating...',
                        },
                    },
                    {
                        id: 4,
                        img: 'go.jpeg',
                        lang_name: {
                            vi: 'Gỗ',
                            en: 'Wood industry',
                        },
                        lang_des: {
                            vi: 'Đang cập nhật...',
                            en: 'Updating...',
                        },
                    },
                    {
                        id: 5,
                        img: 'thuongmaidientu.jpeg',
                        lang_name: {
                            vi: 'Thương mại điện tử',
                            en: 'E-commerce industry',
                        },
                        lang_des: {
                            vi: 'Đang cập nhật...',
                            en: 'Updating...',
                        },
                    },
                    {
                        id: 6,
                        img: '',
                        lang_name: {
                            vi: 'Ngành khác',
                            en: 'Other industry',
                        },
                        lang_des: {
                            vi: 'Đang cập nhật...',
                            en: 'Updating...',
                        },
                    },
                ]
            }
        },
        mounted() {
        }
    }
</script>

<style lang="scss" scoped>
    .invest-item {
        background: white;
        position: absolute;
        top: 7px;
        z-index: 100;
        transform: translateY(-4%);
        transition: 0.5s all ease;
        display: grid;
        grid-template-columns: 280px 280px 280px;
        border-radius: 5px;

        .p-lg-3:hover {
            background: #f5f5f5;
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
