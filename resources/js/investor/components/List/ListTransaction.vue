<template>
    <b-container fluid="lg">
        <b-row>
            <payment-contact
                :isLoading="isLoading"
            />
            <b-col cols="12" lg="12" class="container-main">
                <BoxProgress v-if="isLoading" />
                <b-tabs content-class="mt-3" class="company-invest__detail mt-3" v-if="!isLoading">
                    <b-tab active :title="$t('transaction.unfinish')">
                        <div class="wrapper-box-list">
                            <div class="boxes" v-if="checkUnfinish">{{ $t('transaction.not_transaction') }}</div>
                            <div class="boxes" v-for="item of listTransaction" v-bind:key="item.id" v-if="item.payment_status === 1">
                                <div class="title">
                                    {{ $t('transaction.bill') }} {{ item.id }}
                                </div>
                                <div class="content">
                                    <table>
                                        <tr>
                                            <th>{{ $t('transaction.regis_date') }}</th>
                                            <th>{{ $t('transaction.invest') }}</th>
                                            <th>{{ $t('transaction.amount_invest') }}</th>
                                            <th>{{ $t('transaction.contract') }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{ item.created_at }}</td>
                                            <td>
                                                <div class="short-text">
                                                    <a :href="domain + locale + '/invest/' + item.company_invest.lang_slug[locale]" target="_blank">
                                                        {{ item.company_invest.lang_name[locale] }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ item.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} đ</td>
                                            <td>
                                                <a :href="domain + item.contract_url" target="_blank">{{ $t('transaction.contract') }}</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="actions-footer">
                                    <a :href="domain + locale + '/order/' + item.id" target="_blank" class="cursor-pointer">
                                        {{ $t('transaction.continue') }}
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </b-tab>

                    <b-tab :title="$t('transaction.unpaid')">
                        <div class="wrapper-box-list">
                            <div class="boxes" v-if="checkUnPaid">{{ $t('transaction.not_transaction') }}</div>
                            <div class="boxes" v-for="item of listTransaction" v-bind:key="item.id" v-if="item.payment_status === 2">
                                <div class="title">
                                    {{ $t('transaction.bill') }} {{ item.id }}
                                </div>
                                <div class="content">
                                    <table>
                                        <tr>
                                            <th>{{ $t('transaction.regis_date') }}</th>
                                            <th>{{ $t('transaction.invest') }}</th>
                                            <th>{{ $t('transaction.amount_invest') }}</th>
                                            <th>{{ $t('transaction.payment_method') }}</th>
                                            <th>{{ $t('transaction.contract') }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{ item.created_at }}</td>
                                            <td>
                                                <div class="short-text">
                                                    <a :href="domain + locale + '/invest/' + item.company_invest.lang_slug[locale]" target="_blank">
                                                        {{ item.company_invest.lang_name[locale] }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ item.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} đ</td>
                                            <td>{{ item.pay_method }}</td>
                                            <td>
                                                <a :href="domain + item.contract_url" target="_blank">{{ $t('transaction.contract') }}</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="actions-footer">
                                    <a :href="domain + locale + '/contact-us'" target="_blank" class="cursor-pointer">
                                        {{ $t('transaction.pay') }}
                                        <i class="fas fa-money-bill-wave"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </b-tab>

                    <b-tab :title="$t('transaction.paid')">
                        <div class="wrapper-box-list">
                            <div class="boxes" v-if="checkPaid">{{ $t('transaction.not_transaction') }}</div>
                            <div class="boxes" v-for="item of listTransaction" v-bind:key="item.id" v-if="item.payment_status === 3">
                                <div class="title">
                                    {{ $t('transaction.bill') }} {{ item.id }}
                                </div>
                                <div class="content">
                                    <table>
                                        <tr>
                                            <th>{{ $t('transaction.regis_date') }}</th>
                                            <th>{{ $t('transaction.invest') }}</th>
                                            <th>{{ $t('transaction.amount_invest') }}</th>
                                            <th>{{ $t('transaction.payment_method') }}</th>
                                            <th>{{ $t('transaction.contract') }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{ item.created_at }}</td>
                                            <td>
                                                <div class="short-text">
                                                    <a :href="domain + locale + '/invest/' + item.company_invest.lang_slug[locale]" target="_blank">
                                                        {{ item.company_invest.lang_name[locale] }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ item.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} đ</td>
                                            <td>{{ item.pay_method }}</td>
                                            <td>
                                                <a :href="domain + item.contract_url" target="_blank">{{ $t('transaction.contract') }}</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="actions-footer">
                                    <a class="success cursor-pointer">
                                        {{ $t('transaction.paid') }}
                                        <i class="fas fa-check"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </b-tab>
                </b-tabs>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import {mapGetters} from "vuex";
    import BoxProgress from "../../../commons/BoxProgress";
    import PaymentContact from "../Card/PaymentContact";
    import env from "../../../env";
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: 'ListTransaction',
        computed: {
            ...mapGetters([
                'locale', 'auth'
            ])
        },
        components: {
            BoxProgress,
            PaymentContact,
        },
        data() {
            return {
                domain: domain,
                isLoading: true,
                listTransaction: {},
                checkUnfinish: true,
                checkUnPaid: true,
                checkPaid: true,
            }
        },
        mounted() {
            var self = this;

            self.getTransaction(self);
        },
        methods: {
            getTransaction(self) {
                self.$store.dispatch('getAllOrderByCurrentLoginAccount')
                .then((res) => {
                    self.listTransaction = res.data;
                    for (var transaction of self.listTransaction) {
                        if (transaction.payment_status === 1) {
                            self.checkUnfinish = false;
                        }

                        if (transaction.payment_status === 2) {
                            self.checkUnPaid = false;
                        }

                        if (transaction.payment_status === 3) {
                            self.checkPaid = false;
                        }
                        self.isLoading = false;
                    }
                })
                .catch((err) => {
                    self.$toast.error(self.$t('errors.error_1'));
                    self.isLoading = false;
                })
            },
        }
    }
</script>

<style lang="scss" scoped>
    .container-main {
        margin-bottom: 50px;

        .nav-item {
            font-weight: bold;
            font-size: 18px;
            color: black;

            .nav-item .nav-link {
                color: black;
            }

            .nav-item .nav-link.active {
                color: white;
                background: #0049ff;
            }
        }

        .boxes {
            background: #fbf8f8;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #eee;
            border-radius: 5px;

            .title {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 15px;
            }

            .content {
                table {
                    border-collapse: collapse;
                    width: 100%;
                    text-align: center;

                    tr {
                        line-height: 40px;

                        th {
                            background: #efefef;
                        }

                        th, td {
                            padding: 0 10px;

                            .short-text {
                                width: 300px;
                                margin: 0 auto;
                            }
                        }
                    }
                }
            }

            .actions-footer {
                margin-top: 10px;
                display: flex;
                justify-content: flex-end;

                a {
                    background: #f53b3b;
                    border-radius: 5px;
                    font-size: 15px;
                    color: white;
                    text-decoration: none;
                    padding: 6px;
                }

                a:hover {
                    background: red;
                }

                a.success {
                    background: #46a75a !important;
                }

                a.success:hover {
                    background: #46a75a !important;
                }
            }
        }
    }

    @media only screen and (max-width: 680px) {
        .container-main {
            .boxes {
                .content {
                    table {
                        tr {
                            th, td {
                                .short-text {
                                    width: 100px;
                                    -webkit-line-clamp: 2;
                                    display: -webkit-box;
                                    -webkit-box-orient: vertical;
                                    white-space: unset;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    @media only screen and (max-width: 485px) {
        .container-main {
            .boxes {
                .content {
                    table {
                        tr {
                            th, td {
                                padding: 0 0;

                                .short-text {
                                    width: 20px;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>
