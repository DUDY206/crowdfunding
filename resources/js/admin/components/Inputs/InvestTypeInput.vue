<template>
    <div>
        <b-form  >
            <b-row>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Tên hình thức đầu tư (VI) <span class="text-danger font-italic">{{errors.name_vi}}</span></p>
                        <b-form-input
                            v-model="form.name_vi"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group  >
                        <p>Mô tả  (VI) <span class="text-danger font-italic">{{errors.short_description_vi}}</span></p>
                        <ckeditor v-model="form.short_description_vi" :config="config"></ckeditor>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group  >
                        <p>Tên hình thức đầu tư (EN) <span class="text-danger font-italic">{{errors.name_en}}</span></p>
                        <b-form-input
                            v-model="form.name_en"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group  >
                        <p>Mô tả (EN) <span class="text-danger font-italic">{{errors.short_description_en}}</span></p>
                        <ckeditor v-model="form.short_description_en" :config="config"></ckeditor>
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
    import globalCKeditorConfig from "../../globalCKeditorConfig";

    export default {
        name: "InvestTypeInput",
        props:[
            'item',
            'isAdd',
            'modalName'
        ],
        data(){
            return {
                config:globalCKeditorConfig,
                form:{
                    name_vi:'',
                    short_description_vi:'',
                    name_en:'',
                    short_description_en:'',
                },
                errors:{
                    name_vi:'',
                    short_description_vi:'',
                    name_en:'',
                    short_description_en:'',
                },
            }
        },
        methods:{
            archiveForm(){
                const formData = new FormData();
                for(var key in this.form){
                    if(this.form[key] !== null){
                        formData.append(key,this.form[key]);
                    }
                }
                return formData
            },
            createForm(){
                let formData = this.archiveForm();
                this.$store.dispatch('createInvestType',formData)
                    .then((res) => {
                        this.$toast.success('Thêm loại hợp đồng thành công');
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
                this.$store.dispatch('editInvestType',formData)
                    .then((res) => {
                        this.$toast.success('Sửa loại hợp đồng thành công');
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
        },
        mounted() {
            if(!this.$props.isAdd){
                const lang = ['name','short_description']
                for(var field of lang){
                    this.form[field+'_vi'] = this.$props.item['lang_'+field]['vi'];
                    this.form[field+'_en'] = this.$props.item['lang_'+field]['en'];
                }
            }
        }

    }
</script>

<style scoped>

</style>
