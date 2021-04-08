<template>
    <div>
        <b-form>
            <b-tabs content-class="mt-3" v-model="isFaq">
                <b-tab title="FAQ" active>
                    <b-button variant="success" class="my-lg-3" @click="addMoreFAQ">Thêm mới</b-button>
                    <b-card no-body >
                        <b-tabs :key="total_faq" pills card vertical active-nav-item-class="font-weight-bold text-uppercase bg-primary">
                            <b-tab v-bind:title="index" v-for="(value, index) in form_faq" v-bind:key="index">
                                <b-row>
                                    <b-col cols="6">
                                        <b-form-group >
                                            <p>Câu hỏi (VI)</p>
                                            <b-form-input
                                                v-model="form_faq[index].question_vi"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group >
                                            <p>Trả lời (VI)</p>
                                            <b-form-input
                                                v-model="form_faq[index].answer_vi"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col cols="6">
                                        <b-form-group >
                                            <p>Câu hỏi (EN)</p>
                                            <b-form-input
                                                v-model="form_faq[index].question_en"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group >
                                            <p>Trả lời (EN)</p>
                                            <b-form-input
                                                v-model="form_faq[index].answer_en"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <div class="d-flex align-content-between">
                                    <b-button class="mt-3" block @click="deleteThisFAQ(index)" >Xóa FAQ này</b-button>
                                    <b-button class="mt-3" block @click="createFormRiskFAQ" >Cập nhật</b-button>
                                </div>
                            </b-tab>
                            <div class="btn-update" v-if="checkTotalFAQ === 0">
                                <b-button class="mt-3" block @click="createFormRiskFAQ">Cập nhật</b-button>
                            </div>
                        </b-tabs>
                    </b-card>
                </b-tab>
                <b-tab title="Risks">
                    <b-button variant="success" class="my-lg-3" @click="addMoreRisk">Thêm mới</b-button>
                    <b-card no-body >
                        <b-tabs :key="total_risk" pills card vertical active-nav-item-class="font-weight-bold text-uppercase bg-primary">
                            <b-tab v-bind:title="index" v-for="(value, index) in form_risk" v-bind:key="index">
                                <b-row>
                                    <b-col cols="6">
                                        <b-form-group >
                                            <p>Rủi ro (VI)</p>
                                            <b-form-input
                                                v-model="form_risk[index].risk_vi"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group >
                                            <p>Giải pháp (VI)</p>
                                            <b-form-input
                                                v-model="form_risk[index].risk_en"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col cols="6">
                                        <b-form-group >
                                            <p>Rủi ro (EN)</p>
                                            <b-form-input
                                                v-model="form_risk[index].solution_vi"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group >
                                            <p>Giải pháp (EN)</p>
                                            <b-form-input
                                                v-model="form_risk[index].solution_en"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <div class="d-flex align-content-between">
                                    <b-button class="mt-3" block @click="deleteThisRisk(index)">Xóa Rick này</b-button>
                                    <b-button class="mt-3" block @click="createFormRiskFAQ">Cập nhật</b-button>
                                </div>
                            </b-tab>
                            <div class="btn-update" v-if="checkTotalRisk === 0">
                                <b-button class="mt-3" block @click="createFormRiskFAQ">Cập nhật</b-button>
                            </div>
                        </b-tabs>
                    </b-card>
                </b-tab>
            </b-tabs>
        </b-form>
        <p>{{isFaq}}</p>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "CompanyInvestFAQInput",
        props: [
            'item',
            'modalName',
            'onLoading',
            'offLoading'
        ],
        computed: {
            ...mapGetters(['listCompanyInvest', 'currentUrl'])
        },
        data() {
            return {
                isFaq:0,
                total_faq:1,
                total_risk:1,
                form_faq: {
                    0: {
                        question_vi:"",
                        question_en:"",
                        answer_vi:"",
                        answer_en:"",
                    }
                },
                form_risk:{
                    0: {
                        risk_vi:"",
                        risk_en:"",
                        solution_vi:"",
                        solution_en:"",
                    }
                },
                checkTotalFAQ: null,
                checkTotalRisk: null,
            }
        },
        methods: {
            archiveForm() {
                let formData = new FormData();
                formData.append('invest_id', this.$props.item.id)
                if (this.isFaq === 0) {
                    formData.append('is_faq', 1);
                    let arr = [];
                    let index = 0;
                    for (let index in this.form_faq) {
                        for (let key in this.form_faq[index]) {
                            if (this.form_faq[index] !== "") {
                                formData.append('faq['+index+']['+key+']', this.form_faq[index][key]);
                            }
                        }
                    }
                } else {
                    formData.append('is_faq', 0);
                    let arr = [];
                    let index = 0;
                    for (let index in this.form_risk) {
                        for (let key in this.form_risk[index]) {
                            if (this.form_risk[index] !== "") {
                                formData.append('risk['+index+']['+key+']', this.form_risk[index][key])
                            }
                        }
                    }
                }

                return formData;
            },
            createFormRiskFAQ() {
                var self = this;
                self.onLoading();
                // let page = self.$route.query.page;
                let formData = self.archiveForm();

                self.$store.dispatch('createFAQRisk', formData)
                .then((res) => {
                    self.$toast.success('Cập nhật thành công');
                    self.$bvModal.hide(self.$props.modalName);
                })
                .catch((err) => {
                    self.offLoading();
                    self.$toast.error('Xin thử lại');
                });

            },
            addMoreRisk() {
                this.total_risk++;
                let max_index = this.getMaxIndexArrayObject(this.form_risk);
                this.form_risk[max_index+1] = {
                    risk_vi:"",
                    risk_en:"",
                    solution_vi:"",
                    solution_en:"",
                }
            },
            addMoreFAQ() {
                this.total_faq++;
                let max_index = this.getMaxIndexArrayObject(this.form_faq);
                this.form_faq[max_index+1] = {
                    question_vi:"",
                    question_en:"",
                    answer_vi:"",
                    answer_en:"",
                }
            },
            getMaxIndexArrayObject(object) {
                let max = 0;
                for(var key in object){
                    let num_key = parseInt(key);
                    if(num_key > max) max = num_key;
                }
                return max;
            },
            deleteThisFAQ(index) {
                if (confirm('Xác nhận xóa FAQ này')) {
                    this.total_faq--;
                    this.checkTotalFAQ--;
                    delete this.form_faq[index];
                }
            },
            deleteThisRisk(index) {
                if(confirm('Xác nhận xóa Rick này')){
                    this.total_risk--;
                    this.checkTotalRisk--;
                    delete this.form_risk[index];
                }
                console.log(this.checkTotalRisk);
            },
        },
        mounted() {
            const lang_faq = ['question', 'answer'];
            for (var index in this.$props.item.faq) {
                this.form_faq[index.toString()] = {};
                for (var field of lang_faq) {
                    this.form_faq[index.toString()][field+'_vi'] = this.$props.item.faq[index]['lang_'+field]['vi'];
                    this.form_faq[index.toString()][field+'_en'] = this.$props.item.faq[index]['lang_'+field]['en'];
                }
                this.checkTotalFAQ++;
            }

            const lang_risks = ['risk', 'solution'];
            for (var index in this.$props.item.risks) {
                this.form_risk[index.toString()] = {};
                for (var field of lang_risks) {
                    this.form_risk[index.toString()][field+'_vi'] = this.$props.item.risks[index]['lang_'+field]['vi'];
                    this.form_risk[index.toString()][field+'_en'] = this.$props.item.risks[index]['lang_'+field]['en'];
                }
                this.checkTotalRisk++;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .btn-update {
        width: 110px;
        margin: 0 auto;
    }

    .general-not-found-fr {
        width: 100%;
        text-align: center;
    }
</style>
