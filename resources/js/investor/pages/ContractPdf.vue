<template>
    <div>
        <div class="overlay-nt" v-if="isLoadingRequestOrder">
            <flash-dot-progress></flash-dot-progress>
        </div>
        <circle-progress v-if="isLoading"></circle-progress>

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
                <b-row class="mb-3" v-if="order.payment_status === 1">
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
                    <b-button variant="success" class="mb-3">{{ $t('contract_show.payment_vnpay') }}</b-button>
                    ({{ $t('maintenance.main_1') }})
                    <br>

                    <b-button variant="success" @click="submit('1')" class="mb-3">{{ $t('contract_show.transfer_laster') }}</b-button>
                    <br>
                </b-modal>
                <b-modal ref="not-sign-my-modal" hide-footer :title="$t('contract_show.title_message')">
                    {{ $t('contract_show.message') }}
                </b-modal>
                <a :href="domain + order.contract_url" download>{{ $t('contract_pdf.download') }}</a>
            </div>
            <div v-else>
                {{ $t('contract_pdf.unauth') }}
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
            }
        },
        mounted() {
            var self = this;

            let data = {
                route: 'order/' + this.$route.params.orderId
            };

            this.$store.dispatch('getAllModel', data)
            .then(res => {
                this.order = res.data;
                this.authorize = true;
                this.src = '/' + res.data.contract_url;
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
            async archiveForm(is_later,pay_method){
                const formData = new FormData();
                var order_id = this.$route.params.orderId

                const sign = this.getSignature();
                formData.append('locale',this.locale);
                formData.append('order_id',order_id);
                formData.append('signature',sign.data);
                formData.append('payment_status',2);
                formData.append('payment_method',pay_method);
                return formData
            },
            confirm(){
                const sign = this.getSignature();
                if(sign.isEmpty === false){
                    this.$store.commit('setsignature',sign.data)
                    this.$refs['my-modal'].show()
                }else{
                    this.$refs['not-sign-my-modal'].show()
                }
            },
            getSignature(){
                return this.$refs.signaturePad.saveSignature();
            },
            async submit(pay_method) {
                var self = this;
                self.isLoadingRequestOrder = true;

                let formData = await this.archiveForm(false, pay_method);
                let data = {
                    route:'payment/vnpay/create-payment',
                    form:formData
                }
                this.$store.dispatch('createModel', data)
                .then(res => {
                    self.isLoadingRequestOrder = false;

                    if (pay_method == 2) {
                        if (res.data.code === "00") {
                            location.href = res.data.redirect;
                        } else if(res.data.code === "001") {
                            console.log(res.data.message);
                        }
                    } else {
                        self.isShowInfoBank = true;
                    }
                })
            },
            resetSignature(){
                this.$refs.signaturePad.clearSignature();
            },
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
