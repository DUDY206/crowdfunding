<template>
    <div v-if="isLoaded">
        <h3>Danh sách các trường nhập cho hợp đồng</h3>
        <b-form-checkbox-group
            id="checkbox-group-2"
            v-model="selected"
            class="d-flex flex-column"
        >
            <b-form-checkbox :value="input_field.id" v-for="input_field in listContractInputField.data" >{{input_field.lang_field.vi}}</b-form-checkbox>
        </b-form-checkbox-group>
        <div class="mt-3">

            <b-button @click="createForm"  variant="danger" >Save</b-button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "ContractHasInputFieldInput",
        props:[
            'contractId'
        ],
        data(){
            return {
                isLoaded : false,
                selected:[],
            }
        },
        computed:{
            ...mapGetters(['listContractInputField'])
        },
        mounted() {
            this.$store.dispatch('getAllContractInputField');
            let data = {
                route:'contract-has-input-field/' + this.$props.contractId,
            }
            this.$store.dispatch('getAllModel',data)
                .then(res => {
                    for(var index in res.data){
                        this.selected.push(res.data[index].id)
                    }
                    this.isLoaded = true;
            })
        },
        methods:{
            archiveForm(){
                const formData = new FormData();
                formData.append('invest_type_id',this.$props.contractId)
                let index = 0;
                for(let id in this.selected){
                    formData.append('contract_field['+index+']',this.selected[id]);
                    index++;
                }
                return formData
            },
            createForm(){
                let formData = this.archiveForm();
                let data = {
                    route:'contract-has-input-field',
                    form:formData
                }
                this.$store.dispatch('createModel',data)
                    .then((res) => {
                        this.$toast.success('Cập nhật trường nhập thành công');
                        this.clearInput();
                        this.$bvModal.hide(this.$props.modalName)
                    })
                    .catch((err) => {
                        let errorJson = JSON.parse(JSON.stringify(err))
                        console.log(errorJson)
                        this.$toast.error('Xin thử lại');
                        for(var key in errorJson){
                            if(typeof errorJson[key] !== 'undefined'){
                                this.errors[key] = errorJson[key][0];
                            }else{
                                this.errors[key] = '';
                            }
                        }
                    });
            },
            clearInput(){
                for(var key in this.form){
                    this.form[key] = '';
                    this.errors[key] = '';
                }
                this.avatar = '';

            }
        }
    }
</script>

<style scoped>

</style>
