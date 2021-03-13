<template>
    <div v-if="isLoaded">
        <b-form  >
            <b-row>
                <b-col cols="3">
                    <div v-for="field in allInvestContractField" >
                        <input type="checkbox" :id="'checkbox-'+field.id" :value="field.id" v-model="selected" >
                        <label :for="'checkbox-'+field.id">{{field.lang_field.vi}}</label>
                    </div>

                </b-col>
                <b-col cols="9">
                    <div v-for="id in selected">
                        <b-form-group  >
                            <p>{{allInvestContractField.find(o => o.id === id).lang_field.vi}} <span class="text-danger font-italic"></span></p>
                            <b-form-input
                                v-model="allInvestContractField.find(o => o.id === id).value"
                                type="text"
                                required
                            ></b-form-input>
                        </b-form-group>

                    </div>
                </b-col>
            </b-row>
        </b-form>
        <b-row align-h="between">
            <b-col cols="3">
                <b-button class="mt-3" block @click="$bvModal.hide(modalName)">Close</b-button>
            </b-col>
            <b-col cols="3">
                <b-button class="mt-3" block @click="createForm">Save</b-button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        name: "InvestCompanyFieldInput",
        props:[
            'itemId',
            'modalName'
        ],
        data(){
            return {
                isLoaded : false,
                allInvestContractField:null,
                dbInvestContractField:null,
                selected:[]
            }
        },
        mounted() {
            let data = {
                route:'invest-contract-field',
            }
            this.$store.dispatch('getAllModel',data)
                .then(res => {
                    this.allInvestContractField = res.data
                    for(var index = 0; index < this.allInvestContractField.length;index++){
                        this.allInvestContractField[index].selected = false
                        this.allInvestContractField[index].value = null
                    }
                    this.isLoaded = true;
                })
            data = {
                route:'invest-has-contract-field/'+this.$props.itemId,
            }
            this.$store.dispatch('getAllModel',data)
                .then(res => {
                    this.dbInvestContractField = res.data
                    for(var dbField of this.dbInvestContractField){
                        this.allInvestContractField.find(o => o.id === dbField.id).selected = true
                        this.allInvestContractField.find(o => o.id === dbField.id).value = dbField.pivot.value
                        this.selected.push(dbField.id)
                    }
                })
        },
        methods:{
            createForm(){
                let formData = new FormData();
                formData.append('invest_id',this.$props.itemId)

                for(var id of this.selected){
                    formData.append('contract_value['+id+']',this.allInvestContractField.find(o => o.id === id).value)
                }
                let data = {
                    route:'invest-contract-field-value',
                    form:formData
                }
                this.$store.dispatch('createModel',data)
                    .then((res) => {
                    this.$toast.success('Sửa thông tin hợp đồng dự án thành công');
                    this.$bvModal.hide(this.$props.modalName)
                })
                    .catch((err) => {
                        let errorJson = JSON.parse(JSON.stringify(err))
                        console.log(errorJson)
                        this.$toast.error('Xin thử lại');

                    });
            }
        }
    }
</script>

<style scoped lang="scss">
    input[type=checkbox]{
        -ms-transform: scale(2); /* IE */
        -moz-transform: scale(2); /* FF */
        -webkit-transform: scale(2); /* Safari and Chrome */
        -o-transform: scale(2); /* Opera */
        transform: scale(2);
        margin-right:1rem
    }
</style>
