<template>
    <div>
        <b-button  variant="success" v-b-modal="'modal-create'" class="ml-lg-3 bg-success text-white border-0">THÊM {{formName}}</b-button>
        <b-modal id="modal-create" size="xl" v-bind:title="'THÊM '+formName" hide-footer>
            <div class="my-4" v-bind:is="form" :item="null" :isAdd="true" v-bind:modalName="'modal-create'">THÊM {{formName}} </div>
        </b-modal>
        <table class="table">
            <thead>
            <slot name="columns">
                <tr>
                    <th v-for="(value,key) in columns" :key="key">{{value}}</th>
                    <th >Action</th>
                </tr>
            </slot>
            </thead>
            <tbody>
            <tr v-for="(item, index) in data" :key="index">
                <slot :row="item">
                    <td v-for="(value,key) in columns" :key="key" v-if="hasValue(item, key)">{{itemValue(item, key)}}</td>
                    <td>
                        <b-button class="bg-warning text-white border-0" variant="warning" v-b-modal="'modal-'+item.id">SỬA</b-button>
                        <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" @click="deleteItem(model,item.id)">XÓA</b-button>

                    </td>
                </slot>
            </tr>
            </tbody>
        </table>
        <b-modal hide-footer v-bind:id="'modal-'+item.id" v-for="(item, index) in data" :key="index" size="xl" v-bind:title="'SỬA '+formName" >
            <div class="my-4" v-bind:is="form" :item="item" :isAdd="false" v-bind:modalName="'modal-'+item.id">Edit {{item.id}} </div>
        </b-modal>
    </div>

</template>
<script>
    export default {
        name: 'l-table',
        props: {
            columns: Object,//{column_db:column_show} , column_db(nest column): field_A.field_B
            data: Array,
            form:String,
            formName:String,
            model:String,
        },
        methods: {
            hasValue(item, column) {
                return item[column.toLowerCase()] !== 'undefined'
            },
            itemValue(item, column) {
                // console.log("column:",column)
                let data = item;
                let nest_columns = column.split('.')
                // console.log('nest_columns:',nest_columns);
                nest_columns.forEach(column => {
                    if (data === null) {
                        return null
                    }
                    data = data[column]
                })
                return data
            },
            deleteItem(model,id){
                let uri = model + '/' + id;
                if(confirm('Xác nhận xóa'))
                    this.$store.dispatch("deleteItem",uri)
                        .then(res => {
                            this.$toast.success('Xóa công ty thành công');
                        }).catch(err => {
                            this.$toast.error('Lỗi xin thử lại');
                            console.log(err);
                    })
            }

        }
    }
</script>
<style lang="scss">
    .modal-backdrop{
        background: rgba(0,0,0,0.6) !important;
    }
    .modal-dialog{
        transform: none!important;
    }
</style>
