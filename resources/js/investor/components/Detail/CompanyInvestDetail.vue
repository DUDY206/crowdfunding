<template>
    <div v-if="companyInvest !== null && companyInvest.company !== null" class="container">
        <div class="row">
            <div class="company-invest__title col-lg-8">
                <div>
                    <img v-bind:src="companyInvest.company.path_img_url" alt="" class="company-avata">
                    <h1 class="pl-3">{{companyInvest.company.lang_name[locale]}}</h1>
                </div>
                <p v-if="companyInvest.lang_short_description">{{companyInvest.lang_short_description[locale]}}</p>
                <div>
                    <b-badge variant="light" v-for="i in 5" class="mr-1 text-uppercase">tag {{i}}</b-badge>
                </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-end align-items-center">
                <b-icon icon="star" scale="2" class="mr-5"></b-icon>
                <b-icon icon="upload" scale="2"></b-icon>
            </div>
        </div>

        <b-row class="company-invest__thumbnail">
            <b-col cols="8">
                <img v-bind:src="companyInvest.path_img_url" alt="" class="w-100 mt-3">
            </b-col>
            <b-col cols="4">
                <div class="company-invest__thumbnail-1">
                    <p class="text-green font-weight-bold">$1.000.000.000</p>
                    <p>Lorem ipsum dolor sit.</p>
                </div>
                <div>
                    <p class="font-weight-bold">$1.000.000.000</p>
                    <p>Lorem ipsum dolor sit.</p>
                </div>
                <div>
                    <p class="font-weight-bold">$1.000.000.000</p>
                    <p>Lorem ipsum dolor sit.</p>
                </div>
                <div>
                    <b-button variant="primary" class="w-100 d-block">Invest</b-button>
                    <span> <i>Lorem ipsum dolor.</i></span>
                </div>
            </b-col>
        </b-row>

        <b-row>
            <b-col cols="8">
                <b-tabs content-class="mt-3" class="company-invest__detail mt-3">
                    <b-tab title="Pitch" active>
                        <div class="company-invest__detail__immutable__highlight"
                             v-if="companyInvest.immutable_field !== null">
                            <div v-for="field in immutable_field">
                                <p class="company-invest__detail-item-title">
                                    {{field.title[locale]}}
                                </p>
                                <div v-html="companyInvest.immutable_field[field.lang][locale]"
                                     v-if="companyInvest.immutable_field[field.lang] !== null">
                                </div>
                            </div>
                        </div>

                    </b-tab>
                    <b-tab title="Discussion"><p>I'm the second tab</p></b-tab>
                    <b-tab title="Updates"><p>I'm a disabled tab!</p></b-tab>
                    <b-tab title="Review"><p>I'm a disabled tab!</p></b-tab>
                </b-tabs>
            </b-col>
            <b-col cols="4">
                <div class="company-invest__detail_property" style="margin-top: 3rem">
                    <h2>{{$t('company_invest_detail.property_details')}}</h2>
                    <div class="d-flex flex-column">
                        <div class="item">
                            <div class="d-flex justify-content-between">
                                <p>Name</p>
                                <p class="font-weight-bold text-right">Lorem ipsum Lorem ipsum dolor.</p>
                            </div>
                            <div>
                                <p>
                                    Comment Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, quibusdam.
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="d-flex justify-content-between">
                                <p>Address</p>
                                <p class="font-weight-bold text-right">Lorem ipsum Lorem ipsum dolor.</p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi, reiciendis?</p>
                        </div>
                        <div class="item">
                            <div class="d-flex justify-content-between">
                                <p>Type</p>
                                <p class="font-weight-bold text-right">Lorem ipsum Lorem ipsum dolor.</p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt, sequi!</p>
                        </div>
                        <div class="item">
                            <div class="d-flex justify-content-between">
                                <p>Investment profile</p>
                                <p class="font-weight-bold text-right">Lorem ipsum Lorem ipsum dolor.</p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, illo?</p>
                        </div>
                        <div class="item">
                            <div class="d-flex justify-content-between">
                                <p>Year build</p>
                                <p class="font-weight-bold text-right">Lorem ipsum Lorem ipsum dolor.</p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, ducimus.</p>
                        </div>
                        <div class="item">
                            <div class="d-flex justify-content-between">
                                <p>Target IRR</p>
                                <p class="font-weight-bold text-right">Lorem ipsum Lorem ipsum dolor.</p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, veniam.</p>
                        </div>
                        <div class="item">
                            <div class="d-flex justify-content-between">
                                <p>Annual dividend</p>
                                <p class="font-weight-bold text-right">Lorem ipsum Lorem ipsum dolor.</p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita, labore.</p>
                        </div>
                        <div class="item">
                            <div class="d-flex justify-content-between">
                                <p>Total capitalization</p>
                                <p class="font-weight-bold text-right">Lorem ipsum Lorem ipsum dolor.</p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita, labore.</p>
                        </div>
                    </div>
                </div>

                <div class="company-invest__detail_property">
                    <h2>{{$t('company_invest_detail.property_details')}}</h2>
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-column py-3">
                            <span>Name</span>
                            <span class="font-weight-bold">$100</span>
                        </div>

                        <div class="d-flex flex-column py-3">
                            <span>Price per security</span>
                            <span class="font-weight-bold">$100</span>
                        </div>

                        <div class="d-flex flex-column py-3">
                            <span>Funding goal</span>
                            <span class="font-weight-bold">$100</span>
                        </div>

                        <div class="d-flex flex-column py-3">
                            <span>Deadline</span>
                            <span class="font-weight-bold">$100</span>
                        </div>
                    </div>
                </div>
            </b-col>
        </b-row>

        <hr/>
        <div class="company-invest__detail__company-info">
            <h3 class="text-center">{{companyInvest.company.lang_name[locale]}}</h3>
            <b-row>
                <b-col cols="4">
                    <p class="title">{{$t('company_invest_detail.legal_name')}}</p>
                    <p class="font-weight-bold">{{companyInvest.company.legal_name}}</p>

                    <p class="title">{{$t('company_invest_detail.founded')}}</p>
                    <p class="font-weight-bold">{{companyInvest.company.founded}}</p>

                    <p class="title">{{$t('company_invest_detail.form')}}</p>
                    <p class="font-weight-bold">{{companyInvest.company.lang_company_type[locale]}}</p>

                </b-col>
                <b-col cols="4">
                    <p class="title">{{$t('company_invest_detail.employees')}}</p>
                    <p class="font-weight-bold">{{companyInvest.company.total_employees}}</p>

                    <p class="title">{{$t('company_invest_detail.website')}}</p>
                    <a v-bind:href="companyInvest.company.website">{{companyInvest.company.website}}</a>

                    <p class="title mt-3">{{$t('company_invest_detail.social')}}</p>
                    <p class="font-weight-bold">{{companyInvest.company.social}}</p>
                </b-col>
                <b-col cols="4">
                    <p class="title">{{$t('company_invest_detail.social')}}</p>
                    <p class="font-weight-bold">{{companyInvest.company.social}}</p>
                </b-col>
            </b-row>
        </div>

        <hr/>
        <!--        member-->
        <div class="company-invest__detail__team">
            <h3 class="text-center">{{$t('company_invest_detail.team')}} Team</h3>
            <div class="main_member my-3">
                <b-row align-h="around">
                    <b-col cols="4" v-for="index of 3" :key="index"
                           class="justify-content-center d-flex flex-column align-items-center">
                        <img src="/investor/images/tmp.jpg" alt="" class="w-50">
                        <h5>ten nv</h5>
                        <p>chuc vu</p>
                        <span>mo ta Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur dolore doloribus illum in mollitia necessitatibus nobis non quaerat quas totam.</span>
                        <div class="member_social">
                            <a href="">
                                <b-icon icon="twitter" aria-hidden="true" variant="primary"></b-icon>
                            </a>
                            <a href="">
                                <b-icon icon="facebook" aria-hidden="true" variant="primary"></b-icon>
                            </a>
                        </div>
                    </b-col>
                </b-row>

            </div>

            <b-row class="other_member mb-3" align-h="around">
                <b-col cols="2" v-for="index in 10" :key="index"
                       class="justify-content-center d-flex flex-column align-items-center">
                    <img src="/investor/images/tmp.jpg" alt="" class="w-50">
                    <h5>ten nv2</h5>
                    <p>chuc vu2</p>
                </b-col>
            </b-row>
        </div>

        <hr/>
        <!--        news-->
        <div class="company-invest__detail__news">
            <h3 class="text-center">{{$t('company_invest_detail.news')}}</h3>
            <b-row>
                <b-col cols="4" v-for="index of 6" :key="index">
                    <a href="#" class="text-decoration-none">
                        <b-card
                            title="Card Title"
                            img-src="/investor/images/tmp.jpg"
                            img-alt="Image"
                            img-top
                            tag="article"
                            class="mb-3"
                        >
                            <b-card-sub-title>
                                <img src="/investor/images/tmp.jpg" alt="" class="tiny-icon">
                                Lorem ipsum dolor.
                            </b-card-sub-title>
                            <b-card-text>
                                Some quick example text to build on the card title and make up the bulk of the card's
                                content.
                            </b-card-text>

                        </b-card>
                    </a>
                </b-col>
            </b-row>

        </div>

        <!--    FAQ-->
        <div class="company-invest__detail__faq" v-if="companyInvest.faq.length !== 0">
            <hr/>

            <h3 class="text-center">{{$t('company_invest_detail.faq')}}</h3>
            <b-tabs pills card vertical nav-wrapper-class="w-33">
                <b-tab v-for="faq in companyInvest.faq" :key="faq.id" v-bind:title="faq.lang_question[locale]" >
                    <b-card-text>{{faq.lang_answer[locale]}}</b-card-text>
                </b-tab>

            </b-tabs>

        </div>

        <hr/>
        <!--        Risk-->
        <div class="company-invest__detail__risks" v-if="companyInvest.risks.length !== 0">
            <h3 class="text-center">{{$t('company_invest_detail.risks')}}</h3>
            <b-tabs pills card vertical nav-wrapper-class="w-33">
                <b-tab v-for="risk in companyInvest.risks" :key="risk.id" v-bind:title="risk.lang_risk[locale]" >
                    <b-card-text>{{risk.lang_solution[locale]}}</b-card-text>
                </b-tab>
            </b-tabs>

        </div>

        <hr/>
        <!--        Discussion-->
        <div class="company-invest__detail__discussion">
            <h3 class="text-center">{{$t('company_invest_detail.discussion')}}</h3>

            <div class="input_comment">
                <div class="d-flex align-items-center">
                    <img src="/investor/images/tmp.jpg" alt="" class="small-icon d-inline mx-3">
                    <b-form-input v-bind:placeholder="$t('company_invest_detail.comment_placeholder')"
                                  class="small-icon"></b-form-input>
                </div>
                <div class="d-flex flex-row-reverse ">
                    <b-button variant="primary" class="my-3 ">Post</b-button>
                </div>

            </div>

            <div class="main-discussion">
                <reply-comment v-for="index of 5" :key="index"></reply-comment>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import ReplyComment from "../Social/ReplyComment";

    export default {
        name: "CompanyInvestDetail",
        components:{ReplyComment},
        data() {
            return {
                companyInvest: null,
                immutable_field: [
                    {
                        title: {
                            vi: 'Nổi bật',
                            en: 'High light',
                        },
                        lang: 'lang_hight_light'
                    },
                    {
                        title: {
                            vi: 'Tổng quan ngành',
                            en: 'Overview Specialized',
                        },
                        lang: 'lang_overview_specialized'
                    },
                    {
                        title: {
                            vi: 'Tổng quan doanh nghiệp',
                            en: 'Overview Company',
                        },
                        lang: 'lang_overview_company'
                    },
                    {
                        title: {
                            vi: 'Tài chính quá khứ',
                            en: 'Financial Before',
                        },
                        lang: 'lang_financial_before'
                    },
                    {
                        title: {
                            vi: 'Tài chính tương lai',
                            en: 'Financial After',
                        },
                        lang: 'lang_financial_after'
                    },
                ]
            }
        },
        computed: {
            ...mapGetters([
                'locale'
            ])
        },
        mounted() {
            let slug = this.$route.params.companyInvest;
            let locale = this.$store.state.locale;

            this.$store.dispatch("getCompanyInvestBySlug", {
                slug: slug,
                locale: locale,
            }).then((res) => {
                this.companyInvest = res.data
            })
        }
    }
</script>

<style lang="scss" scoped>
    .company-invest__title {
        img.company-avata {
            max-height: 50px;
        }

        h1 {
            font-weight: 700;
        }

        h1::first-letter {
            text-transform: uppercase;
        }

        & > div {
            display: flex;
            align-items: baseline;
        }
    }

    .company-invest__thumbnail {
        & > div:nth-child(2) {
            div {
                margin-bottom: 2rem;
            }
        }
    }

    .company-invest__thumbnail-1 {
        border-bottom: solid 3px var(--main-green);
    }

    .company-invest__detail__company-info {
        .title {
            color: #333;
            margin:0
        }
    }
    .company-invest__detail_property{
        p{
            display: inline;
            margin:0;
        }
        .item{
            padding:1rem 0;
        }
        .item>div:last-child{
            max-height: 0;
            -webkit-transition: max-height .3s ease-in-out;
            -moz-transition: max-height .3s ease-in-out;
            -ms-transition: max-height .3s ease-in-out;
            -o-transition: max-height .3s ease-in-out;
            transition: max-height .3s ease-in-out;
            p{
                visibility: hidden;
            }
        }
        .item:hover>div:last-child{
            max-height: 200px;
            p{
                visibility: visible;
            }
        }
        &>div>div+div{
            border-top:solid 1px #aaa;
        }
    }
</style>
