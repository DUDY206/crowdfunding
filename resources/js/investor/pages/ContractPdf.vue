<template>
    <div class="container" v-if="isLoaded">
        <div  v-if="authorize">
            <div v-for="i in numPages"
                 :key="i"
                 class="pagePDF"
            >
                <pdf
                    :src="src"
                    :page="i"
                    style="display: inline-block; width: 100%"
                ></pdf>
                <p class="text-center">Trang {{i}}/{{numPages}}</p>
            </div>

            <b-row class="mb-3" v-if="order.payment_status === 1">
                <b-col cols="12" lg="6">
                    <div style="" class="signature">
                        <VueSignaturePad width="500px" height="25vh" ref="signaturePad" />
                        <b-button variant="success" @click="resetSignature" class="mb-3">Xóa chữ kĩ</b-button> <br>
                    </div>
                </b-col>
                <b-col cols="12" lg="6">
                    <span class="text-danger"><i>Xin kiểm tra kĩ thông tin và chữ kí trước khi thanh toán</i></span>
                    <b-button variant="success" @click="confirm" class="mb-3">Xác nhận chữ kí và thanh toán ngay</b-button> <br>
                </b-col>
            </b-row>


            <b-modal ref="my-modal" hide-footer title="Xác nhận chữ kí">
                <img :src="signature" alt="">
                <b-button variant="success" @click="submit('2')" class="mb-3">Thanh toán VNPay</b-button> <br>

                <b-button variant="success" @click="submit('1')" class="mb-3">Chuyển khoản sau</b-button> <br>
            </b-modal>

            <b-modal ref="not-sign-my-modal" hide-footer title="Thông báo">
                Vui lòng đăng kí chữ kí trước khi thanh toán
            </b-modal>
            <a href="/storage/contract/1-73-2021-03-11-04-58-30.pdf" download>Tải xuống hơp đồng</a>
        </div>

        <div v-else>
            Không có quyền truy cập tài liệu này
        </div>
    </div>

</template>

<script>
    import pdf from 'vue-pdf'
    import {mapGetters} from "vuex";
    export default {
        name: "ContractPdf",
        components: {
            pdf
        },
        computed:{
            ...mapGetters([
                'signature','locale'
            ])
        },
        data() {
            return {
                authorize:false,
                isLoaded:false,
                src: null,
                numPages: undefined,
                order:null
            }
        },
        methods:{
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
                console.log(sign.isEmpty);
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
            async submit(pay_method){
                let formData = await this.archiveForm(false,pay_method);
                let data = {
                    route:'payment/vnpay/create-payment',
                    form:formData
                }
                this.$store.dispatch('createModel',data)
                    .then(res=>{
                        if(res.data.code === "00" ){
                            location.href = res.data.redirect;
                        }else if(res.data.code === "001"){
                            console.log(res.data.message)
                        }
                    })
            },
            resetSignature(){
                this.$refs.signaturePad.clearSignature();
            },
        },
        mounted() {
            let data = {
                route:'order/'+this.$route.params.orderId
            }
            this.$store.dispatch('getAllModel',data)
                .then(res=>{
                    this.order = res.data
                    this.authorize=true
                    this.src = '/'+res.data.contract_url
                    pdf.createLoadingTask('/'+res.data.contract_url).promise.then(pdf => {
                        this.numPages = pdf.numPages;
                    });
                }).catch(err => {
                    this.authorize=false
            }).finally(()=>{
                    this.isLoaded = true
            })


        }
    }
</script>

<style scoped lang="scss">
    .pagePDF{
        border: solid 1px #00BFFF;
    }
    .signature > div{
        border: solid 1px black;
    }
</style>
