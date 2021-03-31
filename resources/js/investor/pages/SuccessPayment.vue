<template>
    <div class="container payreturn">
        <circle-progress v-if="isLoading"></circle-progress>
        <div class="card" v-else>
            <template v-if="success">
                <div class="check-mark-success">
                    <i class="checkmark">✓</i>
                </div>
                <h1 class="success-detail">{{detail}}</h1>
            </template>
            <template v-else>
                <div class="check-mark-error">
                    <i class="checkmark" style="color: #E54646">✖</i>
                </div>
                <h1 class="error-detail">{{detail}}</h1>
            </template>
            <br>
            <button type="button" class="btn btn-secondary btn-lg"><a class="close-payment" :href="'/'+locale">Trang chủ</a></button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import CircleProgress from '../../commons/CircleProgress';

    export default {
        name: "SuccessPayment",
        computed: {
            ...mapGetters([
                'locale'
            ])
        },
        components: {
            CircleProgress
        },
        data() {
            return {
                isLoading: false,
                secureHash: '',
                vnp_SecureHash: '',
                detail: '',
                vnp_ResponseCode: '',
                success: false,
            }
        },
        mounted() {
            var self = this;
            self.isLoading = true;

            let data = {
                route: this.$route.fullPath.replace('/' + this.locale + '/', '')
            };

            this.$store.dispatch('getAllModel', data)
            .then(res=>{
                this.secureHash = res.data.secureHash;
                this.vnp_SecureHash = res.data.vnp_SecureHash;
                this.detail = res.data.detail;
                this.vnp_ResponseCode = res.data.vnp_ResponseCode;

                if (this.secureHash === this.vnp_SecureHash) {
                    if (this.vnp_ResponseCode === '00') {
                        this.success = true;
                        this.detail = "Giao dịch thành công";
                    } else {
                        this.detail = "Giao dịch không thành công";
                    }
                } else {
                    this.detail = "Chữ ký không hợp lệ";
                }
                self.isLoading = false;
            })
            .catch(err => {
                console.log(err)
            })
        }
    }
</script>

<style lang="scss" scoped>

    body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
    }

    .success-detail, .error-detail{
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 35px;
        margin-bottom: 10px;
    }

    .success-detail {
        color: #88B04B;
    }

    .error-detail {
        color: #E54646;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    i {
        color: #9ABC66;
        font-size: 34px;
        margin-left: -8px;
    }

    .card {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: white;
        border-radius: 4px;
        display: flex;
        margin: auto;
        border: none!important;
    }

    .close-payment, .close-payment:hover {
        font-weight: 700;
        text-decoration: none;
        color: black;
        font-size: 30px;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
    }

    .check-mark-success, .check-mark-error {
        border-radius:200px;
        height:50px;
        width:50px;
        margin:0 auto;
    }

    .check-mark-success {
        background: #f0f7e6;
    }

    .check-mark-error {
        background: #FCDAD5;
    }
</style>
