<template>
    <div style="width: 100%">
        <box-progress v-if="isLoadingCategory" />

        <b-col cols="12" lg="12" id="category" class="menu-options" v-if="!isLoadingCategory">
            <div class="wrapper-boxes">
                <div :class="'box ' + category.background" v-for="category in listAllCategory" :key="category.id">
                    <a class="item" :href="domain + locale + '/category/' + category.lang_slug[locale]">
                        {{ category.lang_name[locale] }}
                    </a>
                </div>
            </div>
        </b-col>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import BoxProgress from "../../../commons/BoxProgress";
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "AllCategory",
        computed: {
            ...mapGetters([
                'auth', 'locale'
            ])
        },
        components: {
            BoxProgress,
        },
        data() {
            return {
                domain: domain,
                isLoadingCategory: true,
                listAllCategory: {},
                listRandomBackground: [
                    'background-one',
                    'background-two',
                    'background-three',
                    'background-four',
                ],
            }
        },
        mounted() {
            var self = this;

            self.getAllCategory(self);
        },
        methods: {
            getAllCategory(self) {
                self.$store.dispatch('getAllCategory', 0)
                .then((res) => {
                    self.listAllCategory = res.data;
                    self.isLoadingCategory = false;

                    for (const category of self.listAllCategory) {
                        const random = Math.floor(Math.random() * self.listRandomBackground.length);
                        category['background'] = self.listRandomBackground[random]
                    }
                })
                .catch((err) => {
                    self.$toast.error(self.$t('errors.error_1'));
                    self.isLoadingCategory = false;
                })
            },
        }
    }
</script>

<style lang="scss" scoped>
    .menu-options {
        .wrapper-boxes {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px 0 50px 0;

            .box {
                margin-bottom: 15px;
                margin-right: 10px;
                margin-left: 12px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                background-color: #f7f6f6;
                padding: 0 10px;
                border-radius: 20px;
                border: none;
                line-height: 55px;
                width: 255px;
                text-align: center;
                transition: .3s all ease;
                position: relative;
                transform: translateY(0%);
                box-shadow: 0 4px 24px rgb(0 0 0 / 11%);

                .item {
                    font-size: 20px;
                    font-weight: 600;
                    cursor: pointer;
                    font-family: inherit;
                    color: black;
                    display: block;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    text-decoration: none;
                }
            }

            .box:hover, .box:active {
                opacity: 0.7;
                transform: translateY(5%) !important;
            }

            .background-one {
                background-color: rgb(255, 251, 231) !important;
            }

            .background-two {
                background-color: rgb(218, 226, 255) !important;
            }

            .background-three {
                background-color: rgb(255, 225, 225) !important;
            }

            .background-four {
                background-color: rgb(206, 246, 255) !important;
            }

            // .box:first-child {
            //     margin-left: 0px;
            // }
        }
    }
</style>
