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

        <div class="container" v-if="isLoaded && isLoading == false">
            <div v-if="authorize">
                <div class="title">{{ $t('contract_pdf.my_contract') }}</div>
                <div v-for="i in numPages"
                    :key="i"
                    class="pagePDF"
                >
                    <pdf
                        :src="src"
                        :page="i"
                        style="display: inline-block; width: 100%"
                    ></pdf>
                    <p class="text-center">{{ $t('contract_pdf.page') }} {{i}}/{{numPages}}</p>
                </div>

                <a :href="domain + order.contract_url" download>{{ $t('contract_pdf.download') }}</a>

                <!-- <b-row class="mb-3" v-if="order.payment_status === 1">
                    <b-col cols="12" lg="6">
                        <div style="" class="signature">
                            <VueSignaturePad width="500px" height="25vh" ref="signaturePad" />
                            <b-button variant="success" @click="resetSignature" class="mb-3">{{ $t('contract_show.delete_signature') }}</b-button> <br>
                        </div>
                    </b-col>
                    <b-col cols="12" lg="6">
                        <span class="text-danger"><i>{{ $t('contract_show.check_contract') }}</i></span>
                        <b-button variant="success" @click="confirm" class="mb-3">{{ $t('contract_show.confirm_payment') }}</b-button> <br>
                    </b-col>
                </b-row>
                <b-modal ref="my-modal" hide-footer :title="$t('contract_show.confirm_signature')">
                    <img :src="signature" alt="">
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

                <b-tabs content-class="mt-3" class="company-invest__detail mt-3" v-if="order.payment_status === 1">
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
                </b-tabs>
            </div>
            <div v-else>
                <h3>{{ $t('contract_pdf.please_login') }}</h3>
            </div>
        </div>
    </div>
</template>

<script>
    import pdf from 'vue-pdf'
    import {mapGetters} from "vuex";
    import CircleProgress from '../../commons/CircleProgress';
    import FlashDotProgress from '../../commons/FlashDotProgress';
    import env from '../../env';
    const domain = env.INVESTOR_DOMAIN;
    import InforBestB from './InforBestB';

    export default {
        name: "ContractPdf",
        components: {
            pdf,
            CircleProgress,
            FlashDotProgress,
            InforBestB
        },
        computed:{
            ...mapGetters([
                'signature', 'locale'
            ])
        },
        data() {
            return {
                domain: domain,
                authorize:false,
                isLoaded:false,
                src: null,
                numPages: undefined,
                order:null,
                isLoading: true,
                isLoadingRequestOrder: false,
                isShowInfoBank: false,
                form: {
                    signatureImage: null,
                },
                signatureImage: null,
                originalTemplateContract: "",
                templateContract: "",
                checkSendRequest: false,
                visibleWaiting: false,
                sendFail: false,
                checkCloseLoading: false,
            }
        },
        mounted() {
            var self = this;

            let data = {
                route: 'order/' + this.$route.params.orderId
            };

            this.$store.commit("setsignature", null);

            this.$store.dispatch('getAllModel', data)
            .then(res => {
                this.order = res.data;
                this.authorize = true;
                this.src = '/' + res.data.contract_url;
                this.originalTemplateContract = res.data.contract;
                this.templateContract = res.data.contract;

                pdf.createLoadingTask('/' + res.data.contract_url).promise.then(pdf => {
                    this.numPages = pdf.numPages;
                });
            })
            .catch(err => {
                this.authorize = false
            })
            .finally(() => {
                this.isLoaded = true;
                self.isLoading = false;
            })
        },
        methods: {
            redirectInvest() {
                window.location.href = domain;
                this.isLoading = false;
                this.isShowInfoBank = false;
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
            async archiveForm(is_later,pay_method){
                const formData = new FormData();
                var order_id = this.$route.params.orderId;
                const sign = this.getSignature();
                this.templateContract = this.originalTemplateContract;
                var sign_img = "";

                if (sign.isEmpty === false) {
                    sign_img = "<br/><img src='" + sign.data + "' style='width: 30%'>";
                    formData.append('signature', sign.data);
                } else {
                    sign_img = "<br/><img src='" + this.signatureImage + "' style='width: 30%'>";
                    formData.append('signature', this.signatureImage);
                }

                this.templateContract += sign_img
                formData.append('locale', this.locale);
                formData.append('order_id', order_id);
                formData.append('payment_status', 2);
                formData.append('payment_method', pay_method);
                formData.append('contract_value', this.templateContract);

                return formData;
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
            getSignature(){
                return this.$refs.signaturePad.saveSignature();
            },
            resetSignature(){
                this.$store.commit("setsignature", null);
                this.$refs.signaturePad.clearSignature();
            },
            async submit(pay_method) {
                var self = this;
                self.isLoadingRequestOrder = true;
                self.checkSendRequest = true;
                self.visibleWaiting = true;
                self.isLoading = true;

                let formData = await self.archiveForm(false, pay_method);
                let data = {
                    route:'payment/vnpay/create-payment',
                    form:formData
                };

                self.$store.dispatch('createModel', data)
                .then(res => {
                    if (pay_method == 2) {
                        if (res.data.code === "00") {
                            location.href = res.data.redirect;
                        } else if(res.data.code === "001") {
                            console.log(res.data.message);
                        }
                    } else {
                        self.checkSendRequest = false;
                        self.visibleWaiting = false;
                        self.isLoadingRequestOrder = false;
                        self.isShowInfoBank = true;
                    }
                })
                .catch(err => {
                    self.checkCloseLoading = true;
                    self.visibleWaiting = false;
                    self.sendFail = true;
                    self.$toast.error(self.$t('errors.error_1'));
                })
            },
            closeLoading() {
                this.isLoadingRequestOrder = false;
                this.checkCloseLoading = false;
                this.checkSendRequest = false;
                this.visibleWaiting = false;
                this.sendFail = false;
                this.isLoading = false;
            }
        },
    }
</script>

<style scoped lang="scss">
    .pagePDF {
        border: solid 1px #00BFFF;
    }

    .signature > div {
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
</style>
