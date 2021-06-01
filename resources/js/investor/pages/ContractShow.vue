<template>
    <div>
        <div class="overlay-nt" v-if="isLoadingRequestOrder">
            <flash-dot-progress></flash-dot-progress>
        </div>
        <circle-progress v-if="isLoading"></circle-progress>

        <!-- chờ xử lý -->
        <div class="message-send-request" v-if="checkSendRequest">
            <div class="content" v-if="visibleWaiting">{{ $t('contract_show.progressing') }}</div>
            <div class="content" v-if="sendFail">{{ $t('contract_show.send_fail') }}</div>
            <div class="close-send-request" v-if="checkCloseLoading" @click="closeLoading">{{ $t('contract_show.close') }}</div>
        </div>

        <!-- kết thúc giao dich -->
        <div class="container-show-option" v-if="isCheckEndRequest">
            <div class="wrapper-container">
                <div class="title-message">
                    <p>{{ $t('contract_show.sending_mail') }}</p>
                    <p>{{ $t('contract_show.please_check_mail') }}</p>
                </div>
                <div class="actions">
                    <div class="close" @click="redirectInvest">{{ $t('contract_show.end_transfer') }}</div>
                </div>
            </div>
        </div>

        <!-- hiển thị thông tin để trả sau -->
        <div class="container-show-option" v-if="isShowInfoBank">
            <div class="wrapper-container" :style="{ width: '1000px' }">
                <div class="title">{{ $t('contract_show.information_transfer') }}</div>
                <infor-best-b></infor-best-b>
                <div class="actions">
                    <div class="close" @click="redirectInvest">{{ $t('contract_show.end_transfer') }}</div>
                </div>
            </div>
        </div>

        <!-- hợp đồng -->
        <div class="container" v-if="isLoaded && isLoading == false">
            <h3>
                {{contract.name}}
            </h3>
            <p v-html="removeLabelContract()"></p>

            <b-tabs content-class="mt-3" class="company-invest__detail mt-3">
                <b-tab active :title="$t('contract_show.confirm_payment')">
                    <b-col>
                        <b-tabs cols="12" lg="5">
                            <b-tab active :title="$t('contract_show.tab_signature')">
                                <br>
                                <h4>{{ $t('contract_show.sign_now') }}</h4>
                                <b-col cols="12" lg="6">
                                    <div style="" class="signature">
                                        <VueSignaturePad width="500px" height="25vh" ref="signaturePad" />
                                        <br>

                                        <b-button variant="success" @click="resetSignature" class="mb-3">{{ $t('contract_show.delete_signature') }}</b-button>
                                    </div>
                                </b-col>
                            </b-tab>

                            <b-tab :title="$t('contract_show.tab_file_image_signature')">
                                <br>
                                <h4>{{ $t('contract_show.resize_image') }}</h4>
                                <b-col cols="12" lg="6">
                                    <br>

                                    <img :src="(signatureImage !== null) ? signatureImage : null" style="width: 100%">
                                    <br>

                                    <input  type="file" id="input_image_upload" ref="signatureImage" @change="previewImage('signatureImage', $event)"/>
                                </b-col>
                                <br>
                            </b-tab>
                            <br>

                            <b-button variant="success" @click="confirm" class="mb-3">{{ $t('contract_show.confirm_payment') }}</b-button>
                        </b-tabs>
                    </b-col>

                    <b-modal ref="my-modal" hide-footer :title="$t('contract_show.confirm_signature')">
                        <img :src="(signature === null) ? signatureImage : signature" style="width: 100%">
                        <!-- <b-button variant="success" class="mb-3" @click="submit('2')">{{ $t('contract_show.payment_vnpay') }}</b-button>
                        <b-button variant="success" class="mb-3">{{ $t('contract_show.payment_vnpay') }}</b-button>
                        ({{ $t('maintenance.main_1') }}) -->
                        <br>
                        <br>

                        <b-button variant="success" @click="submit('1')" class="mb-3">{{ $t('contract_show.transfer_laster') }}</b-button>
                    </b-modal>

                    <b-modal ref="not-sign-my-modal" hide-footer :title="$t('contract_show.title_message')">
                        {{ $t('contract_show.message') }}
                    </b-modal>
                </b-tab>

                <b-tab :title="$t('contract_show.sign_laster')">
                    <b-col cols="6" lg="6">
                        <b-form-group>
                            <p>{{ $t('contract_show.contract_receipt_email') }} <span class="text-danger font-italic">{{errors_mail}}</span></p>
                            <b-form-input
                                v-model="send_mail"
                                type="email"
                                required
                                disabled
                            ></b-form-input>
                        </b-form-group>
                        <b-button variant="success" class="mb-3" @click="signLaterSubmit">{{ $t('contract_show.sign_laster') }}</b-button>
                    </b-col>
                </b-tab>
            </b-tabs>

            <!-- <h4>{{ $t('contract_show.sign_now') }}</h4>
            <b-row class="mb-3">
                <b-col cols="12" lg="6">
                    <div style="" class="signature">
                        <VueSignaturePad width="500px" height="25vh" ref="signaturePad" />
                        <b-button variant="success" @click="resetSignature" class="mb-3">{{ $t('contract_show.delete_signature') }}</b-button> <br>
                    </div>
                </b-col>
                <b-col cols="12" lg="6">
                    <span class="text-danger"><i>{{ $t('contract_show.check_contract') }}</i></span>
                    <b-button variant="success" @click="confirm" class="mb-3">{{ $t('contract_show.confirm_payment') }}</b-button> <br>
                    <b-form-group>
                        <p>{{ $t('contract_show.contract_receipt_email') }} <span class="text-danger font-italic">{{errors_mail}}</span></p>
                        <b-form-input
                            v-model="send_mail"
                            type="email"
                            required
                            disabled
                        ></b-form-input>
                    </b-form-group>
                    <b-button variant="success" class="mb-3" @click="signLaterSubmit">{{ $t('contract_show.sign_laster') }}</b-button>
                </b-col>
            </b-row>
            <b-modal ref="my-modal" hide-footer :title="$t('contract_show.confirm_signature')">
                <img :src="signature" style="width: 100%">
                <b-button variant="success" class="mb-3" @click="submit('2')">{{ $t('contract_show.payment_vnpay') }}</b-button>
                <b-button variant="success" class="mb-3">{{ $t('contract_show.payment_vnpay') }}</b-button>
                ({{ $t('maintenance.main_1') }})
                <br>

                <b-button variant="success" @click="submit('1')" class="mb-3">{{ $t('contract_show.transfer_laster') }}</b-button>
                <br>
            </b-modal>

            <b-modal ref="not-sign-my-modal" hide-footer :title="$t('contract_show.title_message')">
                {{ $t('contract_show.message') }}
            </b-modal> -->
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from '../../commons/CircleProgress';
    import FlashDotProgress from '../../commons/FlashDotProgress';
    import env from '../../env';
    const domain = env.INVESTOR_DOMAIN;
    import InforBestB from './InforBestB';

    export default {
        name: "ContractShow",
        data() {
            return {
                domain: domain,
                isLoading: true,
                isLoaded: false,
                isLoadingRequestOrder: false,
                contract: null,
                send_mail: null,
                errors_mail: null,
                checkCloseLoading: false,
                checkSendRequest: false,
                visibleWaiting: false,
                sendFail: false,
                isCheckEndRequest: false,
                isShowInfoBank: false,
                contractId: null,
                form: {
                    signatureImage: null,
                },
                signatureImage: null,
            }
        },
        components: {
            CircleProgress,
            FlashDotProgress,
            InforBestB
        },
        computed:{
            ...mapGetters([
                'tempFormContract', 'companyInvest', 'locale', 'signature', 'auth'
            ])
        },
        mounted() {
            var self = this;
            this.$store.commit("setsignature", null);

            let slug = self.$route.params.companyInvest;
            let locale = self.$store.state.locale;
            let investTypeId = self.$route.params.investTypeId;
            self.contractId = self.$route.params.contractId;
            self.send_mail = self.auth.user.email;

            if (self.$store.state.tempFormContract === null) {
                let path = '/' + locale + '/invest/' + slug + '/contract/' + investTypeId + '/create-form';
                self.$route.push({path: path})
            }

            self.selectContract(self.contractId);
        },
        methods:{
            redirectInvest() {
                let slug = this.$route.params.companyInvest;
                let locale = this.$store.state.locale;

                if (locale === null) {
                    locale = 'en';
                }

                let path = locale + '/invest/' + slug;

                window.location.href = domain + path;
            },
            previewImage(id, event) {
                const input = event.target;

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        if(id === 'signatureImage'){
                            this.signatureImage = e.target.result;
                        }
                    }

                    reader.readAsDataURL(input.files[0]);
                }

                if (id === 'signatureImage') {
                    this.form.signatureImage = event.target.files[0];
                }
            },
            confirm(){
                const sign = this.getSignature();

                if (sign.isEmpty === false) {
                    this.$store.commit('setsignature', sign.data);
                    this.$refs['my-modal'].show();
                } else {
                    if (this.form.signatureImage !== null) {
                        this.$refs['my-modal'].show();
                    } else {
                        this.$refs['not-sign-my-modal'].show();
                    }
                }
            },
            selectContract(id) {
                var self = this;
                self.isLoading = true;
                self.isLoaded = false;

                self.$store.dispatch('getContractById', id)
                .then((res) => {
                    self.contract = res.data;
                    self.isLoading = false;
                    self.isLoaded = true;
                })
                .catch((err) => {
                    self.$toast.error(self.$t('errors.error_1'));
                    self.isLoaded = true;
                    self.isLoading = false;
                })
            },
            removeLabelContract() {
                let template = this.contract.template;

                //input nguoi dung
                for (var field of this.contract.input_label.split(',')) {
                    let id = field.split(':')[0];
                    let reg = '\[\['+id+'\]\]';
                    let temp_input = this.tempFormContract[id];
                    template = template.replaceAll(reg, temp_input);
                }

                template = template.replaceAll("[[company_name]]", this.companyInvest.company_name[this.locale]);
                template = template.replaceAll("[[location]]", this.companyInvest.company.lang_location[this.locale]);
                template = template.replaceAll("[[money]]", this.tempFormContract.money);

                // let reg = /\[\[[0-9]*([a-zA-Z]*(\_)*)*\]\]/ig
                //input hop dong
                if (this.companyInvest.contract_field.length === 0) {
                    this.$toast.error(this.$t('contract_show.invalid_invest'));
                    this.$router.push({path: '/' + this.$store.state.locale + '/invest/' + this.$route.params.companyInvest});
                } else {
                    for(var field of this.companyInvest.contract_field){
                        let id = 'comp-'+field.id;
                        let reg = '\[\['+id+'\]\]';

                        let temp_input = field.pivot.value;
                        template = template.replaceAll(reg, temp_input);
                    }

                    //xu ly cong thuc tinh toan
                    let reg = /cal\(\S*\)/g;
                    let array_reg = null;

                    try {
                        while ((array_reg = reg.exec(template)) !== null) {
                            let cal = array_reg[0]; //cal(1000000000/10000000)
                            cal = cal.replaceAll("cal(","");
                            cal = cal.slice(0, cal.length-1);
                            let equal = eval(cal);
                            template = template.replaceAll(array_reg[0],equal);
                        }
                        this.contract.template = template;

                        return template;
                    } catch(err) {
                        this.$toast.error(this.$t('contract_show.invalid_invest'));
                        this.$router.push({path: '/' + this.$store.state.locale + '/invest/' + this.$route.params.companyInvest});
                    }
                }
            },
            getSignature(){
                return this.$refs.signaturePad.saveSignature();
            },
            resetSignature() {
                this.$store.commit("setsignature", null);
                this.$refs.signaturePad.clearSignature();
            },
            async submit(pay_method) {
                var self = this;
                var success = false;
                self.isLoading = true;
                self.isLoadingRequestOrder = true;
                self.checkSendRequest = true;
                self.visibleWaiting = true;

                let formData = await this.archiveForm(false, pay_method);
                let data = {
                    route: 'payment/vnpay/create-payment',
                    form: formData
                }

                this.$store.dispatch('createModel', data)
                .then(res => {
                    success = true;
                    self.checkSendRequest = false;
                    self.visibleWaiting = false;

                    if (pay_method == 1) {
                        self.isLoadingRequestOrder = false;
                        self.isShowInfoBank = true;
                    }

                    if (pay_method == 2) {
                        self.isLoading = false;
                        if (res.data.code === "00") {
                            location.href = res.data.redirect;
                        } else if (res.data.code === "001") {
                            console.log(res.data.message)
                        }
                    }
                })
                .catch(err => {
                    self.checkCloseLoading = true;
                    self.visibleWaiting = false;
                    self.sendFail = true;
                    self.isLoadingRequestOrder = false;
                    this.$toast.error(self.$t('errors.error_1'));
                })

                if (success) {
                    setTimeout(() => {
                        self.isLoadingRequestOrder = false;
                    }, 3000);
                }
            },
            async archiveForm(is_later, pay_method) {
                const formData = new FormData();
                formData.append('invest_id', this.companyInvest.id);
                formData.append('amount', this.tempFormContract.money);
                formData.append('invest_type_id', this.$route.params.investTypeId);

                let template = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>";
                template += "<style>" +" p{font-family: DejaVu Sans}" +"</style>";
                template += this.contract.template;

                if (!is_later) {
                    const sign = this.getSignature();
                    //pay immediately
                    var sign_img = "";

                    if (sign.isEmpty === false) {
                        sign_img = "<br/><img src='" + sign.data + "' style='width: 30%'>";
                        formData.append('signature', sign.data);
                    } else {
                        sign_img = "<br/><img src='" + this.signatureImage + "' style='width: 30%'>";
                        formData.append('signature', this.signatureImage);
                    }

                    template += sign_img;
                    await formData.append('payment_method', pay_method);
                    formData.append('payment_status', 2);
                } else {
                    formData.append('payment_method', 3);
                    formData.append('payment_status', 1);
                    formData.append('send_mail', this.auth.user.email);
                }

                formData.append('contract_value', template);
                formData.append('locale', this.locale);

                return formData;
            },
            async signLaterSubmit() {
                var self = this;
                self.isLoading = true;

                if (this.send_mail !== null) {
                    self.isLoadingRequestOrder = true;
                    self.checkSendRequest = true;
                    self.visibleWaiting = true;

                    let formData = await this.archiveForm(true, null);
                    let data = {
                        route: 'order',
                        form: formData
                    }

                    this.$store.dispatch('createModel', data)
                    .then((res) => {
                        self.isLoadingRequestOrder = false;
                        self.checkSendRequest = false;
                        self.visibleWaiting = false;
                        self.isCheckEndRequest = true;
                        self.$toast.success(self.$t('contract_show.sending_mail'));
                        self.$toast.info(self.$t('contract_show.please_check_mail'));
                    })
                    .catch(err => {
                        self.checkCloseLoading = true;
                        self.visibleWaiting = false;
                        self.sendFail = true;
                        this.$toast.error(self.$t('errors.error_1'));
                    })
                } else {
                    self.errors_mail = self.$t('contract_show.empty_mail');
                }
            },
            closeLoading() {
                this.isLoadingRequestOrder = false;
                this.checkCloseLoading = false;
                this.checkSendRequest = false;
                this.visibleWaiting = false;
                this.sendFail = false;
                this.isLoading = false;
            }
        }
    }
</script>

<style scoped lang="scss">
    .signature > div{
        border: solid 1px black;
    }

    .overlay-nt {
        position: fixed;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100vh;
        z-index: 99999999;
        background: hsl(0deg 0% 100% / 85%);
    }

    .message-send-request {
        position: fixed;
        top: 100px;
        left: 0%;
        right: 0%;
        margin: 0 auto;
        width: fit-content;
        z-index: 999999999;

        .content {
            background: repeating-linear-gradient(to right, red 0, #00f 50%, red 100%);
            background-size: 200% auto;
            padding: 0 10px;
            border-radius: 10px;
            color: white;
        }

        .close-send-request {
            margin: 0 auto;
            line-height: 33px;
            text-align: center;
            width: 60px;
            cursor: pointer;
            margin-top: 10px;
            border: 1px solid #5839974a;
            border-radius: 10px;
        }

        .close-send-request:hover {
            background: red;
            color: white;
        }
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

    @media only screen and (max-height: 695px) {
        .container-show-option {
            .wrapper-container {
                top: 20px;
            }
        }

    }
</style>
