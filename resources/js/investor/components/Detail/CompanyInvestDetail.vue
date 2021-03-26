<template>
    <div>
        <circle-progress v-if="isLoading"></circle-progress>
        <div v-if="companyInvest !== null && companyInvest.company !== null && isLoading == false" class="container">
            <div class="row">
                <div class="company-invest__title col-lg-8">
                    <div class="invest-logo-name gd-lg-flex align-items-lg-baseline align-items-baseline">
                        <img v-bind:src="companyInvest.company.path_img_url" alt="" class="company-avata">
                        <h1 class="pl-3">{{companyInvest.company.lang_name[locale]}}</h1>
                    </div>
                    <p class="short-description" v-if="companyInvest.lang_short_description">{{companyInvest.lang_short_description[locale]}}</p>
                    <div>
                        <!-- <b-badge variant="light" v-for="i in 5" class="mr-1 text-uppercase">tag {{i}}</b-badge> -->
                        123
                    </div>
                </div>
                <div class="col-lg-4 d-flex justify-content-end align-items-center">
                    <!-- <b-icon icon="star" scale="2" class="mr-5" v-bind:variant="companyInvest.is_like_by_current_user ? 'warning' : 'secondary'"></b-icon> -->
                    <span @click="like_invest" class="interactive text-decoration-none"
                    :class="{
                            'text-yellow':islike,
                            'text-black':!islike,
                            'icon-invest':true
                    }"
                    >
                        <i class="fas fa-star"></i>
                    </span>
                    <span href="" class="interactive text-decoration-none icon-invest" >
                        <i class="fas fa-cloud-upload-alt"></i>
                    </span>
                </div>
            </div>

            <b-row class="company-invest__thumbnail">
                <b-col cols="12" lg="8">
                    <img v-bind:src="companyInvest.path_img_url" alt="" class="w-100 mt-3">
                </b-col>
                <b-col cols="12" lg="4">
                    <div class="company-invest__thumbnail-1">
                        <p class="price-invest text-green font-weight-bold">{{companyInvest.total_invested_money.toLocaleString()}} VND</p>
                        <p class="des-invest">Total invested</p>
                    </div>
                    <hr class="bar-under-price-invest" />
                    <div class="event-times">
                        <p class="invest-item font-weight-bold">{{companyInvest.total_investor.toLocaleString()}}</p>
                        <p class="des-invest">Investor</p>
                    </div>
                    <div>
                        <p class="invest-item font-weight-bold">{{companyInvest.date_expired_diff}} days</p>
                        <p class="des-invest">Left to invest</p>
                    </div>
                    <div>
                        <b-button variant="primary" class="invest-btn-nt w-100 d-block" v-b-modal="'modal-invest-type'">Invest</b-button>
                        <b-modal id="modal-invest-type" size="xl" :hide-footer="true">
                            <b-row v-if="companyInvest.invest_type.length === 0" class="p-3 d-flex flex-column h-100  justify-content-between text-center">
                                Không có hình thức đầu tư nào
                            </b-row>
                            <b-row v-else>
                                <b-col v-for="investType in companyInvest.invest_type" :key="'invest-type-'+investType.id" cols="12" :lg="parseInt(12/companyInvest.invest_type.length)" class="invest-type-option">
                                    <div class="p-3  d-flex flex-column h-100  justify-content-between">
                                        <div>
                                            <h3 class="text-center py-3">{{investType.lang_name[locale]}}</h3>
                                            <span v-html="investType.lang_short_description[locale]"></span>
                                        </div>
                                        <b-button variant="primary" class="w-100 d-block mt-3 align-self-end" @click="$router.push({path:'/' + locale + '/' + $route.params.companyInvest + '/contract/' + investType.id + '/create-form'}).then(r=>{})">
                                            Invest
                                        </b-button>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-modal>
                    </div>
                </b-col>
            </b-row>

            <b-row>
                <b-col lg="8" cols="12">
                    <b-tabs content-class="mt-3" class="company-invest__detail mt-3">
                        <b-tab title="Pitch" active>
                            <div class="company-invest__detail__immutable__highlight"
                                v-if="companyInvest.immutable_field !== null">
                                <div v-for="field, index in immutable_field" v-bind:key="index">
                                    <p class="company-invest__detail-item-title general-text">
                                        {{field.title[locale]}}
                                    </p>
                                    <div v-html="companyInvest.immutable_field[field.lang][locale]"
                                        v-if="companyInvest.immutable_field[field.lang] !== null"
                                        class="content-company-invest"
                                    >
                                    </div>
                                </div>
                            </div>
                        </b-tab>
                        <b-tab title="Discussion"><p>I'm the second tab</p></b-tab>
                        <b-tab title="Updates"><p>I'm a disabled tab!</p></b-tab>
                        <b-tab title="Review"><p>I'm a disabled tab!</p></b-tab>
                    </b-tabs>
                </b-col>
                <b-col lg="4" cols="12">
                    <div class="company-invest__detail_property" style="margin-top: 5rem">
                        <h2 class="general-text">{{$t('company_invest_detail.property_details')}}</h2>
                        <div class="d-flex flex-column">
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">Name</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.company.lang_name[locale] }}</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                        Comment Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, quibusdam.
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">Address</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.company.lang_location[locale] }}</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                        What is this?
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">Type</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.company.lang_company_type[locale] }}</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                        What is this?
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">Year build</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.company.created_at }}</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                        What is this?
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">Valuation caps</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.valuation_cap }}</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                        What is this?
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">Minimum investment</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.min_invest }}</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                        What is this?
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">Deadline</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.expired_date }}</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                        What is this?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="company-invest__detail_property">
                        <h2>{{$t('company_invest_detail.property_details')}}</h2>
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-column py-3">
                                <span>Valuation caps</span>
                                <span class="font-weight-bold">{{companyInvest.valuation_cap}}</span>
                            </div>

                            <div class="d-flex flex-column py-3">
                                <span>Minimum investment</span>
                                <span class="font-weight-bold">{{companyInvest.min_invest}}</span>
                            </div>

                            <div class="d-flex flex-column py-3">
                                <span>Dead line</span>
                                <span class="font-weight-bold">{{companyInvest.expired_date}}</span>
                            </div>

                        </div>
                    </div> -->
                </b-col>
            </b-row>

            <hr/>

            <!--        information company-->
            <div class="company-invest__detail__company-info">
                <h3 class="after-under text-center title-theme grey-color">
                    {{companyInvest.company.lang_name[locale]}}
                    <p class="title-theme-desciption">Everyone helping build {{ companyInvest.company.lang_name[locale] }}</p>
                </h3>
                <b-row>
                    <b-col cols="4">
                        <p class="title grey-color">{{$t('company_invest_detail.legal_name')}}</p>
                        <p class="font-weight-bold">{{ companyInvest.company.lang_name[locale] }}</p>

                        <p class="title grey-color">{{$t('company_invest_detail.founded')}}</p>
                        <p class="font-weight-bold">{{companyInvest.company.founded}}</p>

                        <p class="title grey-color">{{$t('company_invest_detail.form')}}</p>
                        <p class="font-weight-bold">{{companyInvest.company.lang_company_type[locale]}}</p>
                    </b-col>
                    <b-col cols="4">
                        <p class="title grey-color">{{$t('company_invest_detail.employees')}}</p>
                        <p class="font-weight-bold">{{companyInvest.company.total_employees}}</p>

                        <p class="title grey-color">{{$t('company_invest_detail.website')}}</p>
                        <a v-bind:href="companyInvest.company.website">{{companyInvest.company.website}}</a>

                        <!-- <p class="title grey-color mt-3">{{$t('company_invest_detail.social')}}</p>
                        <p class="font-weight-bold">{{ companyInvest.company.social }}</p> -->
                    </b-col>
                    <!-- <b-col cols="4">
                        <p class="title grey-color">{{$t('company_invest_detail.social')}}</p>
                        <p class="font-weight-bold">{{companyInvest.company.social}}</p>
                    </b-col> -->
                </b-row>
            </div>

            <hr/>
            <!--        member-->
            <div class="company-invest__detail__team">
                <h3 class="after-under text-center title-theme grey-color">{{ companyInvest.company.lang_name[locale] }} Team</h3>
                <div class="main_member my-3">
                    <b-row align-h="around">
                        <b-col lg="4" cols="6" v-for="keyUser, index in accountInInvest" :key="index" class="space-bottom-10 justify-content-center d-flex flex-column align-items-center">
                            <img v-bind:src="'/storage/investor/avatar/' + keyUser.user.avatar" class="img-contain border-circle-img" />
                            <h5 class="space-top-10">{{ keyUser.user.full_name }}</h5>
                            <span class="size-forty">
                                {{ keyUser.user.description }}
                            </span>
                            <!-- <div class="member_social">
                                <a href="">
                                    <b-icon icon="twitter" aria-hidden="true" variant="primary"></b-icon>
                                </a>
                                <a href="">
                                    <b-icon icon="facebook" aria-hidden="true" variant="primary"></b-icon>
                                </a>
                            </div> -->
                        </b-col>
                    </b-row>
                </div>
            </div>

            <hr/>
            <!--        news-->
            <div class="company-invest__detail__news">
                <h3 class="c">{{$t('company_invest_detail.news')}}</h3>
                <b-row>
                    <b-col lg="4" cols="12" v-for="index of 6" :key="index">
                        <a href="#" class="text-decoration-none">
                            <b-card
                                title="Card Title"
                                img-src="/storage/news/macca_banner_yen_mach_cacao.jpg"
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
                <h3 class="after-under text-center title-theme grey-color">{{$t('company_invest_detail.faq')}}</h3>
                <b-tabs pills card vertical nav-wrapper-class="w-33" class="d-none d-lg-flex">
                    <b-tab v-for="faq in companyInvest.faq" :key="faq.id" v-bind:title="faq.lang_question[locale]" >
                        <b-card-text>{{faq.lang_answer[locale]}}</b-card-text>
                    </b-tab>

                </b-tabs>

                <div>
                    <div v-for="faq in companyInvest.faq" :key="faq.id" class="d-block d-lg-none">
                        <a v-b-toggle="'collapse-faq-'+faq.id" class="text-decoration-none">{{faq.lang_question[locale]}}?</a>
                        <b-collapse v-bind:id="'collapse-faq-'+faq.id" class="mt-2">
                            <p>{{faq.lang_answer[locale]}}</p>
                        </b-collapse>
                    </div>
                </div>

            </div>

            <hr/>
            <!--        Risk-->
            <div class="company-invest__detail__risks" v-if="companyInvest.risks.length !== 0">
                <div>
                    <h3 class="after-under text-center title-theme grey-color">{{$t('company_invest_detail.risks')}}</h3>
                    <b-tabs pills card vertical nav-wrapper-class="w-33" class="d-none d-lg-flex">
                        <b-tab v-for="risk in companyInvest.risks" :key="risk.id" v-bind:title="risk.lang_risk[locale]" >
                            <b-card-text>{{risk.lang_solution[locale]}}</b-card-text>
                        </b-tab>
                    </b-tabs>

                    <div>
                        <div v-for="risk in companyInvest.risks" :key="risk.id" class="d-block d-lg-none">
                            <a v-b-toggle="'collapse-risk-'+risk.id" class="text-decoration-none">{{risk.lang_risk[locale]}}?</a>
                            <b-collapse v-bind:id="'collapse-risk-'+risk.id" class="mt-2">
                                <p>{{risk.lang_solution[locale]}}</p>
                            </b-collapse>
                        </div>
                    </div>
                </div>


            </div>

            <hr/>
            <!--        Discussion-->
            <div class="company-invest__detail__discussion">
                <h3 class="after-under text-center title-theme grey-color">{{$t('company_invest_detail.discussion')}}</h3>
                <div class="input_comment">
                    <div class="d-flex align-items-center">
                        <img src="/investor/images/tmp.jpg" alt="" class="small-icon d-inline mx-3">
                        <b-form-input
                            v-bind:placeholder="$t('company_invest_detail.comment_placeholder')"
                            class="small-icon" v-model="comment_content">
                        </b-form-input>
                    </div>
                    <div class="d-flex flex-row-reverse ">
                        <b-button variant="primary" class="my-3" v-bind:class="{ 'btn-none-event': isLoadingComment }" @click="post_comment">
                            <dot-progress v-if="isLoadingComment"></dot-progress>
                            <div v-else>Post</div>
                        </b-button>
                    </div>

                </div>
                <div class="main-discussion" v-if="companyInvest.social_comment.length !== 0 ">
                    <comment v-for="comment in companyInvest.social_comment" :key="comment.id" :comment="comment"></comment>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import Comment from "../Social/Comment";
    import router from "../../routes";
    import CircleProgress from "../../../commons/CircleProgress";
    import DotProgress from "../../../commons/DotProgress";

    export default {
        name: "CompanyInvestDetail",
        components:{
            Comment,
            CircleProgress,
            DotProgress
        },
        data() {
            return {
                isLoading: true,
                isLoadingComment: false,
                comment_content:'',
                companyInvest: null,
                accountInInvest: null,
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
                ],
                islike: false,
                commentError: '',
            }
        },
        computed: {
            ...mapGetters([
                'locale', 'auth'
            ])
        },
        mounted() {
            let slug = this.$route.params.companyInvest;
            let locale = this.$store.state.locale;
            var self = this;

            this.$store.dispatch("getCompanyInvestBySlug", {
                slug: slug,
                locale: locale,
            }).then((res) => {
                this.companyInvest = res.data;
                this.accountInInvest = this.companyInvest.order;
                this.islike = res.data.is_like_by_current_user;
                self.isLoading = false;
            })
        },
        methods:{
            post_comment() {
                var self = this;

                if (this.$store.state.auth.token == null) {
                    router.push({path: '/login'}).then(r => {});
                } else {
                    self.isLoadingComment = true;
                    let formData = new FormData();
                    formData.append('content',this.comment_content);
                    formData.append('invest_id',this.companyInvest.id);
                    this.$store.dispatch('createComment',formData)
                    .then((res) => {
                        this.companyInvest.social_comment.push(res.data);
                        this.comment_content = '';
                        self.isLoadingComment = false;
                    }).catch((err) => {
                        self.isLoadingComment = false;
                        this.$toast.error('Hãy nhập nội dung')
                    })
                }
            },

            like_invest() {
                if (this.$store.state.auth.token == null) {
                    router.push({path: '/login'}).then(r => {});
                } else {
                    let formData = new FormData();

                    formData.append('is_liked',this.companyInvest.is_like_by_current_user ? 1: 0);
                    formData.append('model_id',this.companyInvest.id);
                    formData.append('model_type','investment');
                    this.$store.dispatch('likeModel',formData)
                        .then((res)=>{
                            this.companyInvest.is_like_by_current_user = !this.companyInvest.is_like_by_current_user
                            this.islike = this.companyInvest.is_like_by_current_user
                        }).catch(err=>{
                        console.log(err)
                    });
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .modal-xl{
        min-width: 80%!important;
    }

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

    .company-invest__detail__company-info {
        .title {
            color: #333;
            margin:0
        }
    }

    .company-invest__detail_property {
        p {
            display: inline;
            margin:0;
        }

        .item {
            padding: 1rem 0;
        }

        .item:first-child {
            border-top: 1px solid #eeeeee;
        }

        .item > div:last-child {
            max-height: 0;
            -webkit-transition: max-height .3s ease-in-out;
            -moz-transition: max-height .3s ease-in-out;
            -ms-transition: max-height .3s ease-in-out;
            -o-transition: max-height .3s ease-in-out;
            transition: max-height .3s ease-in-out;

            p {
                visibility: hidden;
            }
        }

        .item:hover > div:last-child {
            max-height: 200px;

            p {
                visibility: visible;
            }
        }

        & > div > div + div {
            border-top:solid 1px #eeeeee;
        }
    }

    .icon-invest {
        font-size: 30px;
        cursor: pointer;
    }

    .icon-invest:hover {
        color: var(--main-yellow);
    }

    .my-3 {
        position: relative;
    }

    .btn-none-event {
        pointer-events: none;
        background: #00c4ff;
        height: 39px;
        width: 57px;
    }

    .interactive {
        margin-left: 15px;
    }

    .price-invest {
        font-size: 30px;
        font-weight: 800 !important;
        margin-bottom: 0px;
    }

    .des-invest {
        color: #777777;
        font-size: 18px;
    }

    .bar-under-price-invest {
        height: 6px;
        background: #19c157;
        border-radius: 4px;
    }

    .invest-item {
        font-size: 30px;
        color: black;
        font-weight: 800 !important;
        margin-bottom: 0;
    }

    .event-times {
        border-bottom: 1px solid #eee;
    }

    .invest-logo-name {
        display: flex !important;
        align-items: center !important;
    }

    .short-description {
        font-size: 20px;
        color: #777;
    }

    .invest-btn-nt {
        line-height: 40px;
        border-radius: 7px;
        background: #0049ff;
        font-weight: bold;
        font-size: 22px;
    }

    .invest-btn-nt:hover {
        background: #2966ff;
    }

    .general-text {
        color: #666;
        font-size: 25px;
        font-weight: 800;
    }

    h2.general-text {
        margin-bottom: 1.5rem;
    }

    .content-company-invest {
        font-size: 20px;
        color: #515151;
        font-weight: 100;
    }

    .grey-color {
        color: #919191 !important;
    }

    .grey-black-color {
        color: #444444 !important;
    }

    .three-font-bold {
        font-weight: 300px;
    }

    .size-forty {
        font-size: 14px;
    }

    .after-under {
        position: relative;
        margin-bottom: 50px;
    }

    .after-under:after {
        content: '';
        position: absolute;
        bottom: -15px;
        background: #0049ff;
        height: 2px;
        width: 50%;
        max-width: 100px;
        left: 50%;
        transform: translateX(-50%);
    }

    .title-theme {
        line-height: .92;
        font-weight: 900;
        letter-spacing: -.03em;
    }

    p.title-theme-desciption {
        display: flex;
        justify-content: center;
        font-weight: 400;
        font-size: 15px;
        margin-top: 15px;
    }

    .border-circle-img {
        border-radius: 50%;
    }

    .img-contain {
        height: 150px;
        width: 150px;
        object-fit: cover;
    }

    .space-top-10 {
        margin-top: 10px;
    }

    .space-bottom-10 {
        margin-bottom: 10px;
    }

</style>
