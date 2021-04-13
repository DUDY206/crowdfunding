<template>
    <div>
        <circle-progress v-if="isLoading"></circle-progress>
        <div class="container mb-3" v-if="isLoaded && isLoading == false">
            <b-row>
                <b-col cols="12" lg="6">
                    <h1>
                        {{ $t('contract_form.invest_information') }}
                    </h1>
                    <b-form>
                        <b-form-group v-for="field, index in form" :label="extractInputTitle(field.title)" v-bind:key="index" >
                            <b-form-input
                                v-model="field.value"
                                type="text"
                                required
                                v-if="extractInputTitle(field.title) !== 'Ngân hàng' && extractInputTitle(field.title) !== 'Bank'"
                            ></b-form-input>

                            <b-form-select v-model="selected" :options="configBankList" v-if="extractInputTitle(field.title) == 'Ngân hàng' || extractInputTitle(field.title) == 'Bank'"></b-form-select>
                        </b-form-group>

                        <b-form-group :label="$t('contract_form.number_invest')" >
                            <b-form-input
                                v-model="money"
                                type="text"
                                required
                            />
                        </b-form-group>
                        <p>
                            {{ $t('contract_form.message') }}
                        </p>

                        <b-button variant="primary" @click="submitForm">{{ $t('contract_form.submit') }}</b-button>
                    </b-form>
                </b-col>

                <b-col cols="12" lg="6">

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
                                b[1] = '"Date received (dd/mm/YYYY)"';
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
                                b[1] = '"Ngày cấp (dd/mm/YYYY)"';
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

                // for (var key in this.form) {
                //     if (this.form[key].title !== "\"Ngân hàng\"") {
                //         form_submit[key] = this.form[key].value
                //     } else {
                //         form_submit[key] = this.configBankList.find(o => o.value === this.selected).text
                //     }
                // }

                // form_submit['money'] = this.money;
                // this.$store.commit('settempFormContract', form_submit)

                // let slug = await this.$route.params.companyInvest;
                // let locale = await this.$store.state.locale;
                // let id = await this.$route.params.investTypeId;

                // let path = '/' + locale + '/' + slug + '/contract/' + id + '/confirm-contract-form'
                // this.$router.push({path:path}).then(res=>{})

                for (var key in this.form) {
                    if (this.form[key].title !== "\"Ngân hàng\"" && this.form[key].title !== "\"Bank\"") {
                        form_submit[key] = this.form[key].value;
                    }

                    if (this.form[key].title === "\"Ngân hàng\"" && this.form[key].title === "\"Bank\"") {
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

                    let path = '/' + locale + '/' + slug + '/contract/' + id + '/confirm-contract-form'
                    this.$router.push({path:path}).then(res=>{})
                }
            }
        }
    }
</script>
