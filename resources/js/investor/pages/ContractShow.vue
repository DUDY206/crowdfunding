<template>
    <div>
        <div class="overlay-nt" v-if="isLoadingRequestOrder">
            <flash-dot-progress></flash-dot-progress>
        </div>
        <div class="message-send-mail" v-if="checkSendMail">
            <div class="content">{{ $t('contract_show.send_mail') }}</div>
            <div class="close-send-mail" v-if="checkCloseSendMail" @click="closeLoadingSendMail">Close</div>
        </div>
        <circle-progress v-if="isLoading"></circle-progress>
        <div class="container" v-if="isLoaded && isLoading == false">
            <h3>
                {{contract.name}}
            </h3>
            <p v-html="removeLabelContract()"></p>

            <h4>{{ $t('contract_show.sign_now') }}</h4>
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
                    <b-form-group  >
                        <p>{{ $t('contract_show.contract_receipt_email') }} <span class="text-danger font-italic">{{errors_mail}}</span></p>
                        <b-form-input
                            v-model="send_mail"
                            type="email"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-button variant="success" class="mb-3" @click="signLaterSubmit">{{ $t('contract_show.sign_laster') }}</b-button>
                </b-col>
            </b-row>

            <b-modal ref="my-modal" hide-footer title="Xác nhận chữ kí">
                <img :src="signature" alt="">
                <b-button variant="success" @click="submit('2')" class="mb-3">{{ $t('contract_show.payment_vnpay') }}</b-button> <br>

                <b-button variant="success" @click="submit('1')" class="mb-3">{{ $t('contract_show.transfer_laster') }}</b-button> <br>
            </b-modal>

            <b-modal ref="not-sign-my-modal" hide-footer :title="$t('contract_show.title_message')">
                {{ $t('contract_show.message') }}
            </b-modal>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from '../../commons/CircleProgress';
    import FlashDotProgress from '../../commons/FlashDotProgress';

    export default {
        name: "ContractShow",
        data() {
            return {
                isLoading: true,
                isLoaded: false,
                isLoadingRequestOrder: false,
                checkSendMail: false,
                contract: null,
                send_mail: null,
                errors_mail: null,
                checkCloseSendMail: false,
            }
        },
        components: {
            CircleProgress,
            FlashDotProgress
        },
        computed:{
            ...mapGetters([
                'tempFormContract', 'companyInvest', 'locale', 'signature', 'auth'
            ])
        },
        mounted() {
            var self = this;
            self.send_mail = self.auth.user.email;

            if (this.$store.state.tempFormContract === null) {
                let slug = this.$route.params.companyInvest;
                let locale = this.$store.state.locale;
                let id = this.$route.params.investTypeId;

                let path = '/' + locale + '/' + slug + '/contract/' + id + '/create-form';
                this.$route.push({path: path})
            }
            let slug = this.$route.params.companyInvest;
            let locale = this.$store.state.locale;
            let id = this.$route.params.investTypeId;
            let data = {
                route: 'company-invest/' + slug + '/contract/' + id + '/' + locale
            }
            this.$store.dispatch('getAllModel', data)
            .then(res => {
                this.contract = res.data
                this.isLoaded = true
            })

            setTimeout(() => {
                self.isLoading = false;
            }, 3000);
        },
        methods:{
            confirm(){
                const sign = this.getSignature();
                if(sign.isEmpty === false){
                    this.$store.commit('setsignature',sign.data)
                    this.$refs['my-modal'].show()
                }else{
                    this.$refs['not-sign-my-modal'].show()
                }
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

                template = template.replaceAll("[[company_name]]",this.companyInvest.company_name[this.locale]);
                template = template.replaceAll("[[location]]",this.companyInvest.company.lang_location[this.locale]);
                template = template.replaceAll("[[money]]",this.tempFormContract.money);

                // let reg = /\[\[[0-9]*([a-zA-Z]*(\_)*)*\]\]/ig
                //input hop dong
                if (this.companyInvest.contract_field.length === 0) {
                    this.$toast.error('Dự án chưa khả dụng');
                } else {
                    for(var field of this.companyInvest.contract_field){
                        let id = 'comp-'+field.id;
                        let reg = '\[\['+id+'\]\]';

                        let temp_input = field.pivot.value
                        template = template.replaceAll(reg, temp_input)
                    }
                }

                //xu ly cong thuc tinh toan
                let reg = /cal\(\S*\)/g;
                let array_reg = null;

                while ((array_reg = reg.exec(template)) !== null) {
                    let cal = array_reg[0]; //cal(1000000000/10000000)
                    cal = cal.replaceAll("cal(","");
                    cal = cal.slice(0, cal.length-1);
                    let equal = eval(cal);
                    template = template.replaceAll(array_reg[ 0],equal)
                }
                this.contract.template = template;

                return template
            },
            getSignature(){
                return this.$refs.signaturePad.saveSignature();
            },
            async submit(pay_method) {
                var self = this;
                self.isLoadingRequestOrder = true;
                var success = false;
                let formData = await this.archiveForm(false, pay_method);
                let data = {
                    route: 'payment/vnpay/create-payment',
                    form: formData
                }

                this.$store.dispatch('createModel', data)
                .then(res => {
                    success = true;
                    if (res.data.code === "00" ) {
                        location.href = res.data.redirect;
                    } else if (res.data.code === "001") {
                        console.log(res.data.message)
                    }
                })
                .catch(err => {
                    this.$toast.error('Lỗi kết nối, xin thử lại');
                })

                if (success) {
                    setTimeout(() => {
                        self.isLoadingRequestOrder = false;
                    }, 3000);
                }
            },
            resetSignature() {
                this.$refs.signaturePad.clearSignature();
            },
            async archiveForm(is_later, pay_method) {
                const formData = new FormData();
                formData.append('invest_id', this.companyInvest.id);
                formData.append('amount', this.tempFormContract.money);
                formData.append('invest_type_id', this.$route.params.investTypeId);

                let template = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>";
                template += "<style>" +" p{font-family: DejaVu Sans}" +"</style>";
                template += this.contract.template;
                const sign = this.getSignature();

                if (!is_later) {
                    //pay immediately
                    let sign_img = "<br/><img src='"+sign.data+"' alt=''>";
                    template += sign_img;
                    formData.append('signature', sign.data);
                    await formData.append('payment_method', pay_method);
                    formData.append('payment_status', 2);
                } else {
                    formData.append('payment_status', 1);
                    formData.append('send_mail', this.send_mail);
                }

                formData.append('contract_value', template);
                formData.append('locale', this.locale);

                return formData;
            },
            async signLaterSubmit() {
                var self = this;
                if (this.send_mail !== null) {
                    self.checkSendMail = true;
                    self.isLoadingRequestOrder = true;
                    let formData = await this.archiveForm(true, null);
                    let data = {
                        route: 'order',
                        form: formData
                    }

                    this.$store.dispatch('createModel', data)
                    .then((res) => {
                        self.isLoadingRequestOrder = false;
                        self.checkSendMail = false;
                        self.$toast.success('Hợp đồng đang được gửi vào mail của bạn');
                    })
                    .catch(err => {
                        self.checkCloseSendMail = true;
                        this.$toast.error('Lỗi kết nối, xin thử lại');
                    })
                } else {
                    this.errors_mail = 'Chưa nhập email'
                }
            },
            closeLoadingSendMail() {
                this.isLoadingRequestOrder = false;
                this.checkSendMail = false;
                this.checkCloseSendMail = false;
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
        z-index: 99999;
        background: hsl(0deg 0% 100% / 85%);
    }

    .message-send-mail {
        position: fixed;
        top: 100px;
        left: 0%;
        right: 0%;
        margin: 0 auto;
        width: fit-content;
        z-index: 999999;

        .content {
            background: repeating-linear-gradient(to right, red 0, #00f 50%, red 100%);
            background-size: 200% auto;
            padding: 0 10px;
            border-radius: 10px;
            color: white;
        }

        .close-send-mail {
            margin: 0 auto;
            line-height: 33px;
            text-align: center;
            width: 60px;
            cursor: pointer;
            margin-top: 10px;
            border: 1px solid #5839974a;
            border-radius: 10px;
        }

        .close-send-mail:hover {
            background: red;
            color: white;
        }
    }
</style>
