<template>
    <div class="container mb-3" v-if="isLoaded">
        <b-row>
            <b-col cols="12" lg="6">
                <h1>
                    Thông tin đầu tư cá nhân
                </h1>
                <b-form >
                    <b-form-group
                        v-for="field in form"
                        :label="extractInputTitle(field.title)"
                    >
                        <b-form-input
                            v-model="field.value"
                            type="text"
                            required
                            v-if="extractInputTitle(field.title) !== 'Ngân hàng'"
                        ></b-form-input>

                        <b-form-select v-model="selected" :options="configBankList" v-else></b-form-select>
                    </b-form-group>

                    <b-form-group
                        label="Số tiền đầu tư"
                    >
                        <b-form-input
                            v-model="money"
                            type="text"
                            required
                        ></b-form-input>

                    </b-form-group>
                    <p>
                        Sau khi xác nhận thanh toán, Bestb sẽ gửi cho bạn hợp đồng, vui lòng kiểm tra thông tin thanh toán và tiến hành xác nhận thông tin hợp đồng! Mọi thông tin bạn cung cấp sẽ được bestb bảo mật ... (marketing chém nhé :)))
                    </p>

                    <b-button variant="primary" @click="submitForm">Submit</b-button>
                </b-form>
            </b-col>

            <b-col cols="12" lg="6">

            </b-col>
        </b-row>
    </div>
</template>

<script>
    import configBankList from "../configBankList";
    import {mapGetters} from "vuex";
    export default {
        name: "ContractForm",
        data(){
            return {
                selected:null,
                isLoaded:false,
                contract:null,
                form:{

                },
                configBankList:configBankList,
                money:null,
            }
        },
        computed:{
            ...mapGetters([
                'tempFormContract'
            ])
        },
        mounted() {
            let slug = this.$route.params.companyInvest;
            let locale = this.$store.state.locale;
            let id = this.$route.params.investTypeId;
            let data = {
                route:'company-invest/'+slug+'/contract/'+id+'/'+locale
            }
            this.$store.dispatch('getAllModel',data)
                .then(res=>{
                    this.contract = res.data
                    this.isLoaded = true
                    this.extractFieldInput();
                })

            this.$store.dispatch("getCompanyInvestBySlug", {
                slug: slug,
                locale: locale,
            }).then((res) => {})
        },
        methods:{
            extractFieldInput(){
                let c = new Map()
                for(var field of this.contract.input_label.split(',')){
                    let b = field.split(':');
                    this.form[b[0]] = {}
                    this.form[b[0]]['title'] = b[1]
                    this.form[b[0]]['value'] = ''
                }
            },
            extractInputTitle(title){
                return title.replaceAll("\"","");
            },
            async submitForm(){
                var form_submit = {}
                for(var key in this.form){
                    if(this.form[key].title !== "\"Ngân hàng\""){
                        form_submit[key] = this.form[key].value
                    }else{
                        form_submit[key] = this.configBankList.find(o => o.value === this.selected).text
                    }
                }
                form_submit['money'] = this.money
                console.log(form_submit)
                this.$store.commit('settempFormContract',form_submit)

                let slug = await this.$route.params.companyInvest;
                let locale = await this.$store.state.locale;
                let id = await this.$route.params.investTypeId;

                let path = '/' + locale + '/' + slug + '/contract/' + id + '/confirm-contract-form'
                this.$router.push({path:path}).then(res=>{})
            }
        }
    }
</script>

<style scoped>

</style>
