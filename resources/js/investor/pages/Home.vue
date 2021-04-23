<template>
    <div class="d-flex flex-column min-vh-100">
        <not-found-page v-if="!checkPage"></not-found-page>
        <banner v-if="checkPage"></banner>
        <div
            v-if="checkPage && showCover"
            class="image-cover"
            v-bind:style="{
                background: 'url(' + domain + 'investor/images/cover.png)',
                backgroundRepeat: 'no-repeat',
                backgroundPosition: 'right',
                backgroundSize: 'contain',
            }"
        >
            <div class="s-container">
                <div class="header-cover">
                    <p>{{ $t('cover.header') }}</p>
                    <img :src="domain + '/investor/images/logo.png'">
                </div>
                <div class="title-cover">{{ $t('cover.title') }}</div>
                <div class="description-cover">{{ $t('cover.description') }}</div>
            </div>
        </div>
        <router-view v-if="checkPage"></router-view>
        <b-footer v-if="checkPage"></b-footer>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import router from "../routes";
    import NotFoundPage from "./NotFoundPage";
    import env from "../../env";
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "Home",
        components: {
            NotFoundPage,
        },
        computed: {
            ...mapGetters(['auth'])
        },
        data() {
            return {
                domain: domain,
                checkPage: true,
                showCover: false,
            }
        },
        mounted() {
            if (this.$route.name === 'Home') {
                this.showCover = true;
            }

            if (this.$route.params.locale !== 'en' && this.$route.params.locale !== 'vi') {
                this.checkPage = false;
            } else {
                this.checkPage = true;
                if (this.$route.params.locale !== undefined){
                    this.$i18n.locale = this.$route.params.locale;
                    this.$store.commit("setLocale", this.$route.params.locale);
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .image-cover {
        display: none;
        height: 320px;
        padding: 50px 0;
        width: 100%;
        margin-bottom: 20px;
        background-color: #ceeaff !important;
        border-bottom: 1px solid #eee;

        .s-container {
            width: 65%;
            margin-left: 30px;

            .header-cover {
                display: flex;
                align-items: center;

                p {
                    margin-bottom: 0;
                    margin-right: 15px;
                    font-size: 13px;
                    color: rgba(0,0,0,.6);
                }

                img {
                    width: 75px;
                    height: 25px;
                }
            }

            .title-cover {
                font-size: 40px;
                line-height: 48px;
                font-weight: 900;
                letter-spacing: -0.04em;
                margin-top: 15px;
                background: #CA4246;
                background-color: #CA4246;
                background: conic-gradient(
                    #CA4246 16.666%,
                    #E16541 16.666%,
                    #E16541 33.333%,
                    #F18F43 33.333%,
                    #F18F43 50%,
                    #8B9862 50%,
                    #8B9862 66.666%,
                    #476098 66.666%,
                    #476098 83.333%,
                    #A7489B 83.333%);
                background-size: 57%;
                background-repeat: repeat;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: rainbow-text-animation-rev 0.5s ease forwards;
                cursor: pointer;
            }

            .title-cover:hover {
                animation: rainbow-text-animation 0.5s ease forwards;
            }

            @keyframes rainbow-text-animation {
                0% {
                    background-size: 57%;
                    background-position: 0 0;
                }
                20% {
                    background-size: 57%;
                    background-position: 0 1em;
                }
                100% {
                    background-size: 300%;
                    background-position: -9em 1em;
                }
            }

            @keyframes rainbow-text-animation-rev {
                0% {
                    background-size: 300%;
                    background-position: -9em 1em;
                }
                20% {
                    background-size: 57%;
                    background-position: 0 1em;
                }
                100% {
                    background-size: 57%;
                    background-position: 0 0;
                }
            }

            .description-cover {
                font-size: 19px;
                line-height: 1.3;
                font-weight: 300;
                color: #777;
                margin-top: 10px;
            }
        }
    }

    @media only screen and (max-width: 900px) {
        .image-cover {
            display: block;
        }
    }

    @media only screen and (max-width: 670px) {
        .image-cover {
            background-position: right top !important;
            height: 300px !important;

            .s-container {
                .header-cover {
                    display: none !important;
                }

                .title-cover {
                    margin-top: 0 !important;
                }

                .description-cover {
                    margin-top: 20px;
                    position: absolute;
                }
            }
        }
    }

    @media only screen and (max-width: 550px) {
        .image-cover {
            background-position: right bottom !important;

            .s-container {
                .description-cover {
                    display: none;
                }
            }
        }
    }
</style>
