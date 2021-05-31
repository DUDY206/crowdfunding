<template>
    <div>
        <circle-progress v-if="isLoading"></circle-progress>
        <div v-if="!isLoading && companyInvest !== undefined && companyInvest.company !== null" class="container">
            <div class="row title-filter">
                <div class="company-invest__title col-lg-8">
                    <div class="invest-logo-name gd-lg-flex align-items-lg-baseline align-items-baseline">
                        <img v-bind:src="domain + companyInvest.company.path_img_url" alt="" class="company-avata">
                        <h1 class="pl-3">{{companyInvest.lang_name[locale]}}</h1>
                    </div>
                    <p class="short-description" v-if="companyInvest.lang_short_description">{{companyInvest.lang_short_description[locale]}}</p>
                </div>
                <div class="col-lg-4 d-flex justify-content-end align-items-center">
                    <span @click="like_invest" class="interactive text-decoration-none"
                        :class="{
                            'text-blue': islike,
                            'text-black': !islike,
                            'icon-invest': true
                        }"
                    >
                        <i class="far fa-star"></i>
                    </span>
                    <div class="tooltip-interactive">
                        {{
                            (islike) ? $t('social.dislike_invest') : $t('social.like_invest')
                        }}
                    </div>
                </div>
            </div>

            <b-row class="company-invest__thumbnail">
                <b-col cols="12" lg="8">
                    <img v-bind:src="domain + companyInvest.path_img_url" alt="" class="w-100 mt-3" v-if="companyInvest.video_url === null">
                    <LazyYoutube
                        v-else
                        :src="companyInvest.video_url"
                        max-width="720px"
                        aspect-ratio="16:9"
                        thumbnail-quality="standard"
                    />
                </b-col>
                <b-col cols="12" lg="4">
                    <div class="company-invest__thumbnail-1">
                        <p class="price-invest text-green font-weight-bold">{{companyInvest.total_invested_money.toLocaleString()}} VND</p>
                        <p class="des-invest">{{ $t('company_invest_detail.total_invested') }}</p>
                    </div>
                    <hr class="bar-under-price-invest" />
                    <div class="event-times">
                        <p class="invest-item font-weight-bold">{{companyInvest.total_investor.toLocaleString()}}</p>
                        <p class="des-invest">{{ $t('company_invest_detail.investor') }}</p>
                    </div>
                    <div>
                        <b-button variant="primary" class="invest-btn-nt w-100 d-block" v-if="auth.token != null" v-b-modal="'modal-invest-type'">{{ $t('company_invest_detail.join_invest') }}</b-button>
                        <b-button variant="primary" class="invest-btn-nt w-100 d-block" v-else @click="nextLogin">{{ $t('company_invest_detail.join_invest') }}</b-button>
                        <b-modal id="modal-invest-type" :title="$t('company_invest_detail.invest_type')" size="xl" :hide-footer="true" v-bind:style="{zIndex: '99999999'}">
                            <b-row v-if="companyInvest.invest_type.length === 0" class="p-3 d-flex flex-column h-100 justify-content-between text-center">
                                {{ $t('company_invest_detail.not_invest_type') }}
                            </b-row>
                            <b-row v-else>
                                <b-col v-for="investType in companyInvest.invest_type" :key="'invest-type-'+investType.id" cols="12" :lg="parseInt(12/companyInvest.invest_type.length)" class="invest-type-option">
                                    <div class="p-3  d-flex flex-column h-100 justify-content-between">
                                        <div>
                                            <h3 class="text-center py-3">{{investType.lang_name[locale]}}</h3>
                                            <span v-html="investType.lang_short_description[locale]"></span>
                                        </div>
                                        <b-button variant="primary" class="w-100 d-block mt-3 align-self-end" @click="$router.push({path:'/' + locale + '/invest/' + $route.params.companyInvest + '/contract/' + investType.id + '/create-form'}).then(r=>{})">
                                            {{ $t('company_invest_detail.join_invest') }}
                                        </b-button>
                                        <!-- <b-button variant="primary" class="w-100 d-block mt-3 align-self-end">
                                            {{ $t('maintenance.main_1') }}
                                        </b-button> -->
                                    </div>
                                </b-col>
                            </b-row>
                        </b-modal>

                        <br />

                        <b-button variant="primary" class="invest-btn-nt w-100 d-block" v-if="auth.token != null" v-b-modal="'modal-schedule-contact'">
                            {{ $t('company_invest_detail.make_appointment_investment') }}
                        </b-button>
                        <b-modal id="modal-schedule-contact" :title="$t('company_invest_detail.make_appointment')" size="xl" :hide-footer="true" v-bind:style="{zIndex: '99999999'}">
                            <b-row>
                                <b-col cols="6" lg="6" class="container-main">
                                    <b-form>
                                        <b-form-group>
                                            {{ $t('company_invest_detail.choose_time') }}
                                            <b-form-timepicker
                                                :locale="locale"
                                                :placeholder="$t('company_invest_detail.appointment_time')"
                                                v-model="form_schedule.time"
                                            />
                                            <br>

                                            {{ $t('company_invest_detail.choose_date') }}
                                            <b-form-datepicker
                                                :locale="locale"
                                                :placeholder="$t('company_invest_detail.appointment_date')"
                                                v-model="form_schedule.date"
                                            />
                                            <br>

                                            {{ $t('company_invest_detail.note_schedule') }}
                                            <b-form-textarea
                                                v-model="form_schedule.note"
                                                rows="3"
                                                max-rows="6"
                                            />
                                        </b-form-group>
                                    </b-form>
                                </b-col>
                                <b-col cols="6" lg="6" class="container-main">
                                    <b-form>
                                        <b-form-group>
                                            {{ $t('authenticator.full_name') }}
                                            <b-form-input
                                                disabled
                                                class="pointer-none"
                                                v-model="form_schedule.full_name"
                                            />
                                            <br>

                                            {{ $t('authenticator.email') }}
                                            <b-form-input
                                                disabled
                                                class="pointer-none"
                                                v-model="form_schedule.email"
                                            />
                                            <br>

                                            {{ $t('authenticator.phone_number') }}
                                            <b-form-input
                                                type="number"
                                                v-model="form_schedule.phone_number"
                                            />
                                        </b-form-group>
                                        <b-button variant="primary" @click="makeAppointment('modal-schedule-contact')" v-if="!isCheckBtnSchedule">
                                            {{ $t('company_invest_detail.confirm_schedule') }}
                                            </b-button>
                                        <b-button variant="info pointer-none" v-if="isCheckBtnSchedule">
                                            {{ $t('company_invest_detail.confirm_schedule') }}
                                        </b-button>
                                    </b-form>
                                </b-col>
                            </b-row>
                        </b-modal>
                    </div>
                </b-col>
            </b-row>

            <b-row>
                <b-col lg="8" cols="12">
                    <div class="company-invest__detail mt-3" id="information-invest" ref="informationInvest">
                        <div class="">
                            <ul class="nav nav-tabs" id="tab-list-header" ref="tabListHeader" v-bind:class="{ 'in-header': isActiveTabListHeader && isCheckTabListHeader }">
                                <li role="presentation" class="nav-item">
                                    <a role="tab" class="nav-link" @click="activeTabList(1)" v-bind:class="{ 'active': tabList.informationInvest }">
                                        {{ $t('company_invest_detail.information') }}
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item" v-if="companyInvest.video_url === null">
                                    <a role="tab" class="nav-link" @click="activeTabList(5)" v-bind:class="{ 'active': tabList.video }">
                                        {{ $t('company_invest_detail.video') }}
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a role="tab" class="nav-link" @click="activeTabList(2)" v-bind:class="{ 'active': tabList.company }">
                                        {{ $t('company_invest_detail.company') }}
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a role="tab" class="nav-link" @click="activeTabList(3)" v-bind:class="{ 'active': tabList.team }">
                                        {{ $t('company_invest_detail.team') }}
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a role="tab" class="nav-link" @click="activeTabList(4)" v-bind:class="{ 'active': tabList.news }">
                                        {{ $t('company_invest_detail.news') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content mt-3">
                            <div class="tab-pane active">
                                <div class="company-invest__detail__immutable__highlight" v-if="companyInvest.immutable_field !== null">
                                    <div v-for="field, index in immutable_field" v-bind:key="index">
                                        <p class="company-invest__detail-item-title general-text" v-if="companyInvest.immutable_field[field.lang][locale] !== null">
                                            {{field.title[locale]}}
                                        </p>
                                        <div v-html="companyInvest.immutable_field[field.lang][locale]"
                                            v-if="companyInvest.immutable_field[field.lang] !== null"
                                            class="content-company-invest"
                                        >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
                <b-col lg="4" cols="12">
                    <div class="company-invest__detail_property" style="margin-top: 5rem">
                        <h2 class="general-text">{{$t('company_invest_detail.deal_term')}}</h2>
                        <div class="d-flex flex-column">
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">{{ $t('company_invest_detail.valuation_caps') }}</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.valuation_cap.toLocaleString() }} đ</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                    </p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                    <p class="grey-color size-forty">{{ $t('company_invest_detail.minimum_investment') }}</p>
                                    <p class="grey-black-color font-weight-bold text-right">{{ companyInvest.min_invest.toLocaleString() }} đ</p>
                                </div>
                                <div>
                                    <p class="grey-color three-font-bold">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="company-invest__detail_bonus" style="margin-top: 50px">
                        <h2 class="general-text">{{$t('company_invest_detail.bonus') }}</h2>
                        <div class="description grey-color space-bottom-10">{{$t('company_invest_detail.des_bonus') + companyInvest.lang_name[locale] }}</div>
                        <div class="d-flex flex-column">
                            <div class="item-box">
                                <div class="header">
                                    <div class="top-header">
                                        <div class="left">{{ $t('company_invest_detail.invest') }}</div>
                                        <!-- <div class="right">30 investors</div> -->
                                    </div>
                                    <div class="bottom-header">
                                        <div class="price">500.000đ</div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="top-content">{{ $t('company_invest_detail.receive_bonus') }}</div>
                                    <div class="body-content">
                                        {{ $t('maintenance.updating') }}
                                    </div>
                                </div>
                                <div class="footer">
                                    <button>{{ $t('company_invest_detail.invest') }} 500.000đ</button>
                                </div>
                            </div>
                            <div class="item-box">
                                <div class="header">
                                    <div class="top-header">
                                        <div class="left">{{ $t('company_invest_detail.invest') }}</div>
                                        <!-- <div class="right">30 investors</div> -->
                                    </div>
                                    <div class="bottom-header">
                                        <div class="price">1.000.000đ</div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="top-content">{{ $t('company_invest_detail.receive_bonus') }}</div>
                                    <div class="body-content">
                                        {{ $t('maintenance.updating') }}
                                    </div>
                                </div>
                                <div class="footer">
                                    <button>{{ $t('company_invest_detail.invest') }} 1.000.000đ</button>
                                </div>
                            </div>
                            <div class="item-box">
                                <div class="header">
                                    <div class="top-header">
                                        <div class="left">{{ $t('company_invest_detail.invest') }}</div>
                                        <!-- <div class="right">30 investors</div> -->
                                    </div>
                                    <div class="bottom-header">
                                        <div class="price">2.000.000đ</div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="top-content">{{ $t('company_invest_detail.receive_bonus') }}</div>
                                    <div class="body-content">
                                        {{ $t('maintenance.updating') }}
                                    </div>
                                </div>
                                <div class="footer">
                                    <button>{{ $t('company_invest_detail.invest') }} 2.000.000đ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
            </b-row>
            <hr/>

            <!--        information company-->
            <div class="company-invest__detail__company-info" id="company" ref="company">
                <h3 class="after-under text-center title-theme grey-color">
                    {{companyInvest.company.lang_name[locale]}}
                </h3>
                <b-row>
                    <b-col cols="6">
                        <p class="title grey-color">{{$t('company_invest_detail.legal_name')}}</p>
                        <p class="font-weight-bold">{{ companyInvest.company.lang_name[locale] }}</p>

                        <p class="title grey-color">{{$t('company_invest_detail.founded')}}</p>
                        <p class="font-weight-bold">{{companyInvest.company.date_founded}}</p>

                        <p class="title grey-color" v-if="companyInvest.company.lang_company_type[locale] !== null">{{$t('company_invest_detail.form')}}</p>
                        <p class="font-weight-bold">{{companyInvest.company.lang_company_type[locale]}}</p>
                    </b-col>
                    <b-col cols="6">
                        <p class="title grey-color" v-if="companyInvest.company.lang_location[locale] !== null">{{$t('company_invest_detail.address')}}</p>
                        <p class="font-weight-bold">{{companyInvest.company.lang_location[locale]}}</p>

                        <p class="title grey-color" v-if="companyInvest.company.total_employees !== null">{{$t('company_invest_detail.employees')}}</p>
                        <p class="font-weight-bold">{{companyInvest.company.total_employees}}</p>

                        <p class="title grey-color" v-if="companyInvest.company.website !== null">{{$t('company_invest_detail.website')}}</p>
                        <a v-bind:href="companyInvest.company.website" target="_blank">{{companyInvest.company.website}}</a>
                    </b-col>
                </b-row>
            </div>
            <hr/>

            <!--        video-->
            <div class="company-invest__detail__team" id="video" ref="video" v-if="companyInvest.video_url === null">
                <h3 class="after-under text-center title-theme grey-color">
                    {{ $t('company_invest_detail.video') }}
                </h3>
                <div class="main_member my-3">
                    <b-row align-h="around">
                        <b-row v-if="companyInvest.video_url === null" class="p-3 d-flex flex-column h-100 justify-content-between text-center">
                            {{ $t('company_invest_detail.not_video') }}
                        </b-row>
                        <b-col v-else class="space-bottom-10 justify-content-center d-flex flex-column align-items-center">
                            <LazyYoutube
                                :src="companyInvest.video_url"
                                max-width="720px"
                                aspect-ratio="16:9"
                                thumbnail-quality="standard"
                            />
                        </b-col>
                    </b-row>
                </div>
            </div>
            <hr v-if="companyInvest.video_url === null" />

            <!--        member-->
            <div class="company-invest__detail__team" id="team" ref="company">
                <h3 class="after-under text-center title-theme grey-color">
                    {{ companyInvest.company.lang_name[locale] }} {{ $t('company_invest_detail.team') }}
                    <p class="title-theme-desciption">{{ $t('company_invest_detail.helping_build') }} {{ companyInvest.company.lang_name[locale] }}</p>
                </h3>
                <div class="main_member my-3">
                    <b-row align-h="around">
                        <b-row v-if="accountInInvest.data.length === 0" class="p-3 d-flex flex-column h-100 justify-content-between text-center">
                            {{ $t('company_invest_detail.not_team') }}
                        </b-row>
                        <b-col lg="4" cols="6" v-for="keyUser, index in accountInInvest.data" :key="index" class="space-bottom-10 justify-content-center d-flex flex-column align-items-center">
                            <div class="avatar-member">
                                <img v-if="keyUser.avatar !== null" v-bind:src="domain + 'storage/investor/avatar/' + keyUser.avatar" class="img-contain" />
                                <img v-else v-bind:src="domain + keyUser.avatar_path" class="img-contain" />
                            </div>
                            <h5 class="space-top-10">{{ keyUser.full_name }}</h5>
                            <span class="size-forty short-text auto-width-center">
                                {{ keyUser.description }}
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
            <div class="company-invest__detail__news" id="news" ref="company">
                <h3 class="after-under text-center title-theme grey-color">{{$t('company_invest_detail.news')}}</h3>
                <div class="wrapper-box-article" v-if="companyInvest.news.length === 0">
                    <div class="text-center w-100">
                        {{ $t('company_invest_detail.not_news') }}
                    </div>
                </div>
                <div v-else class="wrapper-box-article">
                    <div class="article" v-for="itemNews, index in companyInvest.news" :key="index">
                        <a :href="domain + locale + '/news/' + itemNews.lang_slug[locale]">
                            <div class="image">
                                <img :src="domain + 'storage/news/' + itemNews.img_url" />
                            </div>
                            <div class="content">
                                <div class="title">{{ itemNews.lang_name[locale] }}</div>
                                <div class="author">
                                    <!-- <img src="/investor/images/tmp.jpg" />
                                    <div class="name-insv-st">BevNET.com</div>
                                    <div class="dot">·</div> -->
                                    <div class="name-insv-st">{{ $t('company_invest_detail.created_at') }}:</div>
                                    <div class="time">{{ itemNews.created_date }}</div>
                                </div>
                                <div class="description short-text-1">
                                    {{ itemNews.lang_description[locale] }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <hr/>

            <!--    FAQ-->
            <div class="company-invest__detail__faq" v-if="companyInvest.faq.length !== 0">
                <h3 class="after-under text-center title-theme grey-color">{{$t('company_invest_detail.faq')}}</h3>
                <b-tabs pills card vertical nav-wrapper-class="w-33" class="d-none d-lg-flex">
                    <b-tab v-for="faq in companyInvest.faq" :key="faq.id" v-bind:title="faq.lang_question[locale]" >
                        <b-card-text>{{faq.lang_answer[locale]}}</b-card-text>
                    </b-tab>
                </b-tabs>
                <div>
                    <div v-for="faq in companyInvest.faq" :key="faq.id" class="d-block d-lg-none tab-menus">
                        <a v-b-toggle="'collapse-faq-'+faq.id" class="text-decoration-none cursor-pointer d-block">{{faq.lang_question[locale]}}?</a>
                        <b-collapse v-bind:id="'collapse-faq-'+faq.id" class="mt-2">
                            <p>{{faq.lang_answer[locale]}}</p>
                        </b-collapse>
                    </div>
                </div>
            </div>
            <hr v-if="companyInvest.faq.length !== 0" />

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
                        <div v-for="risk in companyInvest.risks" :key="risk.id" class="d-block d-lg-none tab-menus">
                            <a v-b-toggle="'collapse-risk-'+risk.id" class="text-decoration-none cursor-pointer d-block">{{risk.lang_risk[locale]}}?</a>
                            <b-collapse v-bind:id="'collapse-risk-'+risk.id" class="mt-2">
                                <p>{{risk.lang_solution[locale]}}</p>
                            </b-collapse>
                        </div>
                    </div>
                </div>
            </div>
            <hr v-if="companyInvest.risks.length !== 0" />

            <!--        Discussion-->
            <div class="company-invest__detail__discussion">
                <h3 class="after-under text-center title-theme grey-color">{{$t('company_invest_detail.discussion')}}</h3>
                <div class="input_comment mr-auto-80" v-if="this.auth.token != null">
                    <div class="d-flex align-items-center">
                        <img v-if="auth.avatar !== null" :src="domain + auth.user.avatar_path" alt="" class="small-icon d-inline mr-r-10">
                        <img v-else :src="domain + 'admin/img/default_avatar.png'" alt="" class="small-icon d-inline mr-r-10">
                        <b-form-input
                            v-bind:placeholder="$t('company_invest_detail.comment_placeholder')"
                            class="small-icon" v-model="comment_content">
                        </b-form-input>
                    </div>
                    <div class="d-flex flex-row-reverse ">
                        <b-button variant="primary" class="my-3" v-bind:class="{ 'btn-none-event': isLoadingComment }" @click="post_comment">
                            <dot-progress v-if="isLoadingComment"></dot-progress>
                            <div v-else>{{ $t('social.comment') }}</div>
                        </b-button>
                    </div>
                </div>
                <div class="main-discussion mr-auto-80" v-if="companyInvest.social_comment.length !== 0 ">
                    <comment v-for="comment in companyInvest.social_comment" :key="comment.id" :comment="comment"></comment>
                </div>
                <div class="main-discussion mr-auto-80" v-else>
                    <div class="text-center w-100">
                        {{ $t('company_invest_detail.not_comment') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="logout-loading" v-if="isLoadingLogin">
            <flash-dot-progress></flash-dot-progress>
        </div>
        <div class="tst-top-page detail-close-option" v-if="isActiveTabListHeader">
            <a v-if="!isCheckTabListHeader" @click="isCheckTabListHeader = true">
                <i class="fas fa-plus"></i>
            </a>
            <a v-else @click="isCheckTabListHeader = false">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import Comment from "../Social/Comment";
    import router from "../../routes";
    import CircleProgress from "../../../commons/CircleProgress";
    import DotProgress from "../../../commons/DotProgress";
    import FlashDotProgress from "../../../commons/FlashDotProgress";
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;
    import { LazyYoutube, LazyVimeo } from "vue-lazytube";

    export default {
        name: "CompanyInvestDetail",
        components:{
            Comment,
            CircleProgress,
            DotProgress,
            FlashDotProgress,
            LazyYoutube,
            LazyVimeo,
        },
        computed: {
            ...mapGetters([
                'locale', 'auth', 'companyInvest'
            ])
        },
        data() {
            return {
                domain: domain,
                isLoading: true,
                isLoadingComment: false,
                isLoadingLogin: false,
                comment_content:'',
                accountInInvest: null,
                heightTabList: null,
                isActiveTabListHeader: false,
                isCheckTabListHeader: true,
                tabList: {
                    informationInvest: false,
                    company: false,
                    team: false,
                    news: false,
                    video: false,
                },
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
                isCheckBtnSchedule: false,
                form_schedule: {
                    date: '',
                    time: '',
                    note: '',
                    full_name: '',
                    email: '',
                    phone_number: '',
                    invest_name: '',
                },
                form_schedule_errors: {
                    date: '',
                    time: '',
                    note: '',
                    full_name: '',
                    email: '',
                    phone_number: '',
                    invest_name: '',
                },
            }
        },
        mounted() {
            var self = this;
            let slug = this.$route.params.companyInvest;
            let locale = this.$store.state.locale;

            if (locale === null) {
                locale = self.$route.params.locale;
            }

            self.tabList.informationInvest = true;

            if (self.auth.token !== null) {
                self.form_schedule.full_name = self.auth.user.full_name;
                self.form_schedule.email = self.auth.user.email;
                self.form_schedule.phone_number = self.auth.user.phone_number;
                self.form_schedule.invest_name = self.companyInvest.lang_name['vi'];
            }

            this.$store.dispatch("getCompanyInvestBySlug", {
                slug: slug,
                locale: locale,
            })
            .then((res) => {
                self.isLoading = false;

                if (res.data.status == false) {
                    self.$toast.info(self.$t('errors.error_2'));
                    self.$router.push({path: '/' + locale}).then(r => {});
                } else {
                    self.accountInInvest = self.companyInvest.user_in_invest;
                    self.islike = res.data.is_like_by_current_user;

                    setTimeout(() => {
                        self.heightTabList = self.matchTabListHeader();
                    }, 100)
                }
            })
            .catch((error) => {
                self.$toast.error(self.$t('errors.error_1'));
                self.isLoading = false;
                self.isLoaded = true;
            });

            window.addEventListener('scroll', (e) => {
                if (Math.round(window.scrollY) >= self.heightTabList) {
                    self.isActiveTabListHeader = true;
                } else {
                    self.isActiveTabListHeader = false;
                }
            });
        },
        methods: {
            matchTabListHeader() {
                return this.$refs.tabListHeader.scrollHeight * 10 + 150;
            },
            activeTabList(number) {
                var self = this;

                switch (number) {
                    case 1:
                        self.tabList.informationInvest = true;
                        self.tabList.company = false;
                        self.tabList.team = false;
                        self.tabList.news = false;
                        self.tabList.video = false;
                        document.getElementById('information-invest').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
                        break;
                    case 2:
                        self.tabList.informationInvest = false;
                        self.tabList.company = true;
                        self.tabList.team = false;
                        self.tabList.news = false;
                        self.tabList.video = false;
                        document.getElementById('company').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
                        break;
                    case 3:
                        self.tabList.informationInvest = false;
                        self.tabList.company = false;
                        self.tabList.team = true;
                        self.tabList.news = false;
                        self.tabList.video = false;
                        document.getElementById('team').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
                        break;
                    case 4:
                        self.tabList.informationInvest = false;
                        self.tabList.company = false;
                        self.tabList.team = false;
                        self.tabList.news = true;
                        self.tabList.video = false;
                        document.getElementById('news').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
                        break;
                    case 5:
                        self.tabList.informationInvest = false;
                        self.tabList.company = false;
                        self.tabList.team = false;
                        self.tabList.news = false;
                        self.tabList.video = true;
                        document.getElementById("video").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
                        break;
                    default:
                        self.$toast.error(self.$t('errors.error_1'));
                        break;
                }
            },
            nextLogin() {
                var self = this;

                if (this.auth.token == null) {
                    self.isLoadingLogin = true;

                    self.isLoadingLogin = false;
                    self.$router.push({path: '/login'}).then(r => {});
                }
            },
            post_comment() {
                var self = this;
                self.isLoadingComment = true;

                if (this.$store.state.auth.token == null) {
                    self.isLoadingLogin = true;

                    self.isLoadingLogin = false;
                    self.$router.push({path: '/login'}).then(r => {});
                } else {
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
                        this.$toast.error(self.$t('errors.error_1'));
                    })
                }
            },
            like_invest() {
                var self = this;

                if (self.$store.state.auth.token == null) {
                    self.isLoadingLogin = true;

                    self.isLoadingLogin = false;
                    self.$router.push({path: '/login'}).then(r => {});
                } else {
                    let formData = new FormData();

                    if (self.islike) {
                        self.islike = false;
                    } else {
                        self.islike = true;
                    }

                    formData.append('is_liked', self.companyInvest.is_like_by_current_user ? 1: 0);
                    formData.append('model_id', self.companyInvest.id);
                    formData.append('model_type','investment');
                    self.$store.dispatch('likeModel', formData)
                    .then((res)=>{
                        self.companyInvest.is_like_by_current_user = !self.companyInvest.is_like_by_current_user;
                        self.islike = self.companyInvest.is_like_by_current_user;
                        if (self.islike) {
                            self.$toast.success(self.$t('social.you_liked_invest'));
                        } else {
                            self.$toast.success(self.$t('social.you_disliked_invest'));
                        }
                    }).catch(err=>{
                        console.log(err)
                    });
                }
            },
            makeAppointment(modal) {
                var self = this;

                self.isCheckBtnSchedule = true;
                self.$store.dispatch('makeAppoinmentForInvest', self.form_schedule)
                .then((res) => {
                    self.$toast.success(self.$t('company_invest_detail.sent_email_schedule'));
                    self.isCheckBtnSchedule = false;
                    self.$bvModal.hide(modal);
                })
                .catch((err) => {
                    let errorJson = JSON.parse(JSON.stringify(err));
                    for (var key in errorJson) {
                        if (typeof errorJson[key] !== 'undefined') {
                            self.$toast.error(self.$t('company_invest_detail.form_validate_schedule.' + errorJson[key][0]));
                        } else {
                            self.$toast.error(self.$t('errors.error_1'));
                        }
                    }
                    self.isCheckBtnSchedule = false;
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    .title-filter {
        align-items: flex-start;
    }
    .modal-xl {
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
        color: #777;
        font-size: 24px;
    }
    .interactive:hover {
        color: #0049ff !important;
    }

    .tooltip-interactive {
        position: absolute;
        top: -50px;
        background: black;
        color: white;
        padding: 5px 10px;
        border-radius: 5px 5px 3px 4px;
        transition: .2s all ease-in-out;
        visibility: hidden;
        opacity: 0;
    }

    .tooltip-interactive:before {
        content: '';
        position: absolute;
        bottom: -50%;
        right: 5px;
        height: 0;
        width: 0;
        pointer-events: none;
        margin-left: -9px;
        border: 9px solid transparent;
        border-top-color: black;
    }

    .interactive:hover + .tooltip-interactive, .interactive:active + .tooltip-interactive {
        visibility: visible;
        opacity: 1;
        top: -40px;
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
        font-size: 18px;
        color: #777;
    }

    .invest-btn-nt {
        line-height: 40px;
        border-radius: 7px;
        background: #0049ff;
        font-weight: bold;
        font-size: 19px;
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

        img {
            object-fit: contain;
        }
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
        margin-top: 50px;
    }

    .after-under:after {
        content: '';
        position: absolute;
        bottom: -15px;
        background: #0049ff;
        height: 2px;
        width: 50%;
        max-width: 60px;
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
        object-fit: cover;
        width: 100%;
        height: 100%;
        border-radius: 5px;
    }

    .logout-loading {
        position: fixed;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100vh;
        z-index: 99999999999;
        background: hsl(0deg 0% 100% / 85%);
    }

    .wrapper-box-article {
        display: flex;
        flex-flow: wrap;

        .article {
            width: 31.33333%;
            border: 1px solid #e9e9e9;
            border-radius: 4px;
            margin: 15px 10px 0 10px;
            transition: .7s all ease;
            transform: translateY(0%);

            a {
                text-decoration: none;

                .image {
                    img {
                        width: 100%;
                        height: 220px;
                        object-fit: cover;
                    }
                }

                .content {
                    padding: 15px;

                    .title {
                        color: #222222;
                        font-weight: 600;
                        font-size: 20px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }

                    .author {
                        display: flex;
                        margin: 5px 0;
                        font-size: 14px;
                        align-items: center;

                        img {
                            width: 7%;
                            height: 20px;
                            object-fit: contain;
                        }

                        .name-insv-st {
                            color: #606060;
                        }

                        .dot {
                            margin: 0 5px;
                            font-size: 22px;
                            color: #b6b6b6;
                        }

                        .time {
                            color: #888888;
                            font-weight: 450;
                            margin-left: 5px;
                        }
                    }

                    .description {
                        color: #444444;
                        font-size: 14px;
                    }
                }
            }
        }

        .article:hover {
            transform: translateY(-1%);
            box-shadow: 0 3px 8px rgb(0 0 0 / 5%);
        }
    }

    .in-header {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999;
        background: white;
        width: 100%;
    }

    .company-invest__detail {
        .nav-tabs {
            transition: 1s all ease;

            .nav-link {
                color: #b3b3b3;
                font-size: 18px;
                font-weight: bold;
                cursor: pointer;
                border: none;
            }

            .nav-link.active {
                color: #0049ff;
                font-weight: bold;
                box-shadow: 0 -4px 0 0 #0049ff inset;
                border: none;
                margin-bottom: 0 !important;
                padding-bottom: 15px;
            }

            .nav-link:hover, .nav-link:focus {
                border: none;
                color: #0049ff !important;
            }
        }
    }

    .company-invest__detail__team {
        .avatar-member {
            width: 125px;
            min-width: 125px;
            height: 125px;
        }
    }

    .company-invest__detail__faq, .company-invest__detail__risks {
        .tab-menus {
            border: 1px solid #0049ff;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 5px 10px;
            background: #0049ff;

            a {
                color: white;
            }
        }

        .collapse.show {
            background: white;
            border-radius: 5px;
            padding: 10px;
        }
    }

    .company-invest__detail_bonus {
        .item-box {
            border-left: 1px solid #eee;
            border-right: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 15px;

            .header {
                display: flex;
                flex-direction: column;

                .top-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    color: #666;

                    .left {
                        font-size: 16px;
                        font-weight: bold;
                    }

                    .right {
                        font-size: 13px;
                    }
                }

                .bottom-header {
                    .price {
                        color: #0049ff;
                        font-size: 30px;
                        margin: 10px 0 20px 0;
                    }
                }
            }

            .content {
                color: #666;
                line-height: 25px;
                margin-bottom: 20px;

                .top-content {
                    font-size: 16px;
                    font-weight: bold;
                }

                .body-content {
                    font-size: 15px;
                }
            }

            .footer {
                text-align: center;

                button {
                    width: 97%;
                    background: none;
                    outline: none;
                    border: 1px solid #dcd8d8;
                    padding: 10px;
                    border-radius: 6px;
                    font-weight: bold;
                    font-size: 17px;
                }

                button:hover, button:active {
                    border-color: #0049ff;
                    color: #0049ff;
                }
            }
        }

        .item-box:first-child {
            border-top: 1px solid #eee;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
        }

        .item-box:last-child {
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .item-box:hover {
            background: #f7f6f6;
        }
    }

    .detail-close-option {
        bottom: 157px;
    }

    @media (max-width: 1200px) {
        .company-invest__detail__news {
            .wrapper-box-article {
                .article {
                    width: 47.77777%;
                }
            }
        }
    }

    @media (max-width: 992px) {
        .company-invest__detail__news {
            .wrapper-box-article {
                .article {
                    width: 50.77777%;
                    margin: 0 auto;
                    margin-bottom: 15px;
                }
            }
        }

        .tooltip-interactive {
            top: -45px !important;
        }

        .interactive:hover + .tooltip-interactive, .interactive:active + .tooltip-interactive {
            top: -40px !important;
        }
    }

</style>
