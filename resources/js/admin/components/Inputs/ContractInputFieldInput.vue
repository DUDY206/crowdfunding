<template>
    <div>
        <b-form  >
            <b-row>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Tên trường tiếng Việt <span class="text-danger font-italic">{{errors.field_vi}}</span></p>
                        <b-form-input
                            v-model="form.field_vi"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Tên trường tiếng Anh <span class="text-danger font-italic">{{errors.field_en}}</span></p>
                        <b-form-input
                            v-model="form.field_en"
                            type="text"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-form>
        <b-row align-h="between">
            <b-col cols="3">
                <b-button class="mt-3" block @click="$bvModal.hide(modalName)">Close</b-button>
            </b-col>
            <b-col cols="3">
                <b-button class="mt-3" block @click="createForm" v-if="isAdd">Save</b-button>
                <b-button class="mt-3" block @click="editForm" v-else>Save</b-button>
            </b-col>
        </b-row>


    </div>
</template>

<script>
    export default {
        name: "ContractInputFieldInput",
        props:[
            'item',
            'isAdd',
            'modalName'
        ],
        data(){
            return {
                form:{
                    field_vi:'',
                    field_en:'',
                },
                errors:{
                    field_vi:'',
                    field_en:'',
                },
            }
        },
        mounted() {
            if(!this.$props.isAdd){
                this.form.field_vi = this.$props.item.lang_field.vi;
                this.form.field_en = this.$props.item.lang_field.en;
            }
        },
        methods:{
            archiveForm(){
                const formData = new FormData();
                for(var key in this.form){
                    formData.append(key,this.form[key]);
                }
                return formData
            },
            createForm(){
                let formData = this.archiveForm();
                this.$store.dispatch('createContractInputField',formData)
                    .then((res) => {
                        this.$toast.success('Thêm trường input hợp đồng thành công');
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
            editForm(){
                let formData = {
                    id:this.$props.item.id,
                    form:this.archiveForm()
                }
                this.$store.dispatch('editContractInputField',formData)
                    .then((res) => {
                        this.$toast.success('Sửa trường input hợp đồng thành công');
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
