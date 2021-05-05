<template>
    <div>
        <circle-progress v-if="isLoading"></circle-progress>

        <!-- chọn hợp đồng -->
        <div class="container-show-option" v-if="isSelectContract && isLoading == false">
            <div class="wrapper-container">
                <div class="title">{{ $t('contract_show.select_contract') }}</div>
                <div class="box-items">
                    <div class="item" v-for="item, index in contract" v-bind:key="index">
                        <div class="short-text" @click="selectContract(item.id)">{{ item.name }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-3" v-if="isLoaded && isLoading == false && isSelectContract == false">
            <b-row>
                <b-col cols="12" lg="6">
                    <h1>
                        {{ $t('contract_form.invest_information') }}
                    </h1>
                    <b-form>
                        <b-form-group v-for="field, index in form" :label="extractInputTitle(field.title)" v-bind:key="index" >
                            <b-form-input
                                v-model="field.value"
                                type="date"
                                required
                                v-if="extractInputTitle(field.title) === 'Ngày cấp' || extractInputTitle(field.title) === 'Date received'"
                            ></b-form-input>

                            <b-form-input
                                v-model="field.value"
                                type="text"
                                required
                                v-if="extractInputTitle(field.title) !== 'Ngân hàng' && extractInputTitle(field.title) !== 'Bank' && extractInputTitle(field.title) !== 'Ngày cấp' && extractInputTitle(field.title) !== 'Date received'"
                            ></b-form-input>

                            <b-form-select v-model="selected" :options="configBankList" v-if="extractInputTitle(field.title) == 'Ngân hàng' || extractInputTitle(field.title) == 'Bank'"></b-form-select>
                        </b-form-group>

                        <b-form-group :label="$t('contract_form.number_invest') + ': (' + moneyFilter + ')'">
                            <b-form-input
                                @keypress="filterMoney"
                                @keyup="filterMoney"
                                v-model="money"
                                type="number"
                                min="0"
                                required
                            />
                        </b-form-group>
                        <p>
                            {{ $t('contract_form.message') }}
                        </p>

                        <b-button variant="primary" @click="submitForm">{{ $t('contract_form.submit') }}</b-button>
                    </b-form>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import configBankList from "../configBankList";
    import {mapGetters} from "vuex";
    import CircleProgress from '../../commons/CircleProgress';

    export default {
        name: "ContractForm",
        data() {
            return {
                isLoading: true,
                selected: null,
                isLoaded: false,
                contract: null,
                form: {

                },
                currentUser: {},
                configBankList: configBankList,
                money: null,
                moneyFilter: 0,
                isSelectContract: false,
            }
        },
        components: {
            CircleProgress
        },
        computed: {
            ...mapGetters([
                'tempFormContract', 'auth', 'locale'
            ])
        },
        mounted() {
            let slug = this.$route.params.companyInvest;
            let locale = this.$store.state.locale;
            let id = this.$route.params.investTypeId;
            var self = this;
            let data = {
                route: 'company-invest/' + slug + '/contract/' + id + '/' + locale
            }

            this.$store.dispatch('getAllModel', data)
            .then(res => {
                this.contract = res.data;
                this.isLoaded = true;

                if (this.contract.length > 1) {
                    this.isSelectContract = true;
                } else if (this.contract.length === 1) {
                    this.isSelectContract = false;
                    this.isLoaded = true;
                    this.contract = this.contract[0];

                    this.extractFieldInput();

                    for (var field of this.contract.input_label.split(',')) {
                        let b = field.split(':');

                        if (self.form[b[0]]['title'] === '"Số điện thoại"' || self.form[b[0]]['title'] === '"Phone"') {
                            self.form[b[0]]['value'] = self.auth.user.phone_number;
                        }

                        if (self.form[b[0]]['title'] === '"Họ tên"' || self.form[b[0]]['title'] === '"Full name"') {
                            self.form[b[0]]['value'] = self.auth.user.full_name;
                        }

                        if (self.form[b[0]]['title'] === '"Email"') {
                            self.form[b[0]]['value'] = self.auth.user.email;
                        }
                    }
                }
            })

            this.$store.dispatch("getCompanyInvestBySlug", {
                slug: slug,
                locale: locale,
            })
            .then((res) => {
                self.isLoading = false;
            })
        },
        methods: {
            selectContract(id) {
                var self = this;
                self.isSelectContract = false;
                self.isLoading = true;
                self.isLoaded = false;

                self.$store.dispatch('getContractById', id)
                .then((res) => {
                    self.contract = res.data;
                    self.isLoading = false;
                    self.isLoaded = true;
                    self.extractFieldInput();

                    for (var field of self.contract.input_label.split(',')) {
                        let b = field.split(':');

                        if (self.form[b[0]]['title'] === '"Số điện thoại"' || self.form[b[0]]['title'] === '"Phone"') {
                            self.form[b[0]]['value'] = self.auth.user.phone_number;
                        }

                        if (self.form[b[0]]['title'] === '"Họ tên"' || self.form[b[0]]['title'] === '"Full name"') {
                            self.form[b[0]]['value'] = self.auth.user.full_name;
                        }

                        if (self.form[b[0]]['title'] === '"Email"') {
                            self.form[b[0]]['value'] = self.auth.user.email;
                        }
                    }
                })
                .catch((err) => {
                    self.$toast.error(self.$t('errors.error_1'));
                    self.isLoaded = true;
                    self.isLoading = false;
                })
            },
            filterMoney(e) {
                var self = this;

                setTimeout(() => {
                    self.moneyFilter = self.money.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }, 10);
            },
            extractFieldInput() {
                let c = new Map();
                var self = this;

                for (var field of this.contract.input_label.split(',')) {
                    let b = field.split(':');
                    this.form[b[0]] = {};
                    if (self.locale === 'en') {
                        switch (b[1]) {
                            case '"Số điện thoại"':
                                b[1] = '"Phone"';
                                break;
                            case '"Họ tên"':
                                b[1] = '"Full name"';
                                break;
                            case '"Số CMND / CCCD"':
                                b[1] = '"ID / Citizen identification number"';
                                break;
                            case '"Ngày cấp"':
                                // b[1] = '"Date received (dd/mm/YYYY)"';
                                b[1] = '"Date received"';
                                break;
                            case '"Địa chỉ"':
                                b[1] = '"Address"';
                                break;
                            case '"Hộ khẩu thường trú"':
                                b[1] = '"Permanent residence"';
                                break;
                            case '"Số TK"':
                                b[1] = '"Bank account number"';
                                break;
                            case '"Ngân hàng"':
                                b[1] = '"Bank"';
                                break;
                        }
                    }

                    if (self.locale === 'vi') {
                        switch (b[1]) {
                            case '"Ngày cấp"':
                                // b[1] = '"Ngày cấp (dd/mm/YYYY)"';
                                b[1] = '"Ngày cấp"';
                                break;
                        }
                    }

                    this.form[b[0]]['title'] = b[1];
                    this.form[b[0]]['value'] = '';
                }
            },
            extractInputTitle(title) {
                return title.replaceAll("\"","");
            },
            async submitForm() {
                var form_submit = {};
                form_submit['money'] = "";
                var checkATM = false;
                var checkInput = false;

                for (var key in this.form) {
                    if (this.form[key].title !== "\"Ngân hàng\"") {
                        form_submit[key] = this.form[key].value;
                    }

                    if (this.form[key].title !== "\"Bank\"") {
                        form_submit[key] = this.form[key].value;
                    }

                    if (this.form[key].title === "\"Ngân hàng\"" || this.form[key].title === "\"Bank\"") {
                        this.configBankList.find(o => {
                            if (this.selected == null) {
                                checkATM = true;
                                this.$toast.error('Hãy chọn ngân hàng');

                                return checkATM;
                            } else {
                                form_submit[key] = this.configBankList.find(o => o.value === this.selected).text;
                            }
                        });
                    }
                }

                form_submit['money'] = this.money;

                for (var item in form_submit) {
                    if (form_submit[item] == "") {
                        checkInput = true;
                        this.$toast.error('Hãy nhập đầy đủ thông tin');

                        return checkInput;
                    } else {
                        checkInput = false;
                    }
                }

                if (!form_submit['money']) {
                    this.$toast.error('Hãy nhập số tiền đầu tư');
                } else {
                    this.$store.commit('settempFormContract', form_submit)

                    let slug = await this.$route.params.companyInvest;
                    let locale = await this.$store.state.locale;
                    let id = await this.$route.params.investTypeId;
                    let contractId = this.contract.id;

                    let path = '/' + locale + '/invest/' + slug + '/contract/' + id + '/confirm-contract-form/' + contractId;
                    this.$router.push({path: path}).then(res=>{})
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    .container-show-option {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: hsla(0,0%,8%,.85);
        z-index: 999999;

        .wrapper-container {
            width: 600px;
            margin: 0 auto;
            background: white;
            position: relative;
            top: 100px;
            padding: 20px;
            border-radius: 5px;

            .title {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .box-items {
                .item {
                    padding: 5px;

                    div {
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        padding: 5px;
                        cursor: pointer;
                    }

                    div:hover {
                        background: #ff0000ab;
                        color: white !important;
                    }
                }
            }

            .actions {
                .close {
                    float: none;
                    border: 1px solid #bd5c5c;
                    width: fit-content;
                    margin: 0 auto;
                    padding: 7px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 20px;
                }

                .close:hover {
                    background: #0f8ae0;
                    border-color: #0f8ae0 !important;
                    color: white;
                }
            }
        }
    }
</style>
