<template>
    <div v-if="isLoaded">
        <h3>Danh sách các loại hợp đồng cho dự án</h3>
        <b-form-checkbox-group
            id="checkbox-group-2"
            v-model="selected"
            class="d-flex flex-column"
        >
            <b-form-checkbox :value="investType.id" v-for="investType in listInvestType" >{{investType.lang_name.vi}}</b-form-checkbox>
        </b-form-checkbox-group>
        <div class="mt-3">
            <b-button @click="$router.push('invest-type')" variant="primary">Danh sách loại hợp đồng</b-button>
            <b-button @click="saveInvestHasType" variant="danger" >Save</b-button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "InvestTypeField",
        props:[
            'investId',
            'modalName',
            'arrayInvestType'
        ],
        computed:{
            ...mapGetters([
                'listInvestType'
            ])
        },
        data(){
            return {
                selected: this.$props.arrayInvestType,
                isLoaded:false,
            }
        },
        methods:{
            archiveForm(){
                const formData = new FormData();
                formData.append('invest_id',this.$props.investId)
                let index = 0;
                for(let id in this.selected){
                    formData.append('invest_type['+index+']',this.selected[id]);
                    index++;
                }
                return formData
            },
            saveInvestHasType(){
                let formData = this.archiveForm();
                console.log(Object.fromEntries(formData));
                this.$store.dispatch("syncInvestHasType",formData).
                then(res=>{
                    this.$bvModal.hide(this.$props.modalName)
                    this.$toast.success('Cập nhật danh sách hợp đồng thành công');
                    let index = this.$store.state.listCompanyInvest.data.findIndex(e => e.id === this.$props.investId);
                    this.$store.state.listCompanyInvest.data[index].array_invest_type = this.selected;
                }).catch((err) => {
                    let errorJson = JSON.parse(JSON.stringify(err))
                    console.log(errorJson)
                    this.$toast.error('Xin thử lại');
                });
            }
        },
        mounted() {
            this.$store.dispatch('getAllInvestType').then(res => {
                this.isLoaded = true
            })
        }
    }
</script>

<style scoped>

</style>
