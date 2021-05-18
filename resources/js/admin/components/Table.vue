<template>
    <div>
        <b-button  variant="success" v-b-modal="'modal-create'+model" class="ml-lg-3 bg-success text-white border-0">THÊM {{formName}}</b-button>
        <b-modal :id="'modal-create'+model" size="xl" v-bind:title="'THÊM '+formName" hide-footer>
            <div class="my-4"
                v-bind:is="form"
                :item="null"
                :isAdd="true"
                v-bind:modalName="'modal-create'+model"
                :onLoading="onLoading"
                :offLoading="offLoading"
            >
                THÊM {{formName}}
            </div>
        </b-modal>
        <table class="table">
            <thead>
            <slot name="columns">
                <tr>
                    <th v-for="(value, key) in columns" :key="'th-'+key">{{value}}</th>
                    <th>Hành động</th>
                </tr>
            </slot>
            </thead>
            <tbody>
            <tr v-for="(item, index) in data" :key="'tr-'+index">
                <td v-for="(value, key) in columns" :key="'td-'+key" v-if="hasValue(item, key)">
                    <img :src="itemValue(item, key)" v-if="value === 'Hình ảnh'">
                    <div class="short-text-1" v-else>
                        {{itemValue(item, key)}}
                    </div>
                </td>
                <td>
                    <b-button class="bg-warning text-white border-0" variant="warning" v-b-modal="'modal-'+model+item.id">SỬA</b-button>
                    <b-button class="ml-lg-3 bg-danger text-white border-0" variant="danger" @click="deleteItem(model,item.id)">XÓA</b-button>
                    <slot v-bind:itemid="item.id"></slot>
                </td>
            </tr>
            </tbody>
        </table>
        <b-modal hide-footer v-bind:id="'modal-'+model+item.id" v-for="(item, index) in data" :key="model+'-'+index" size="xl" v-bind:title="'SỬA '+formName" >
            <div class="my-4"
                v-bind:is="form"
                :item="item"
                :isAdd="false"
                v-bind:modalName="'modal-'+model+item.id"
                :onLoading="onLoading"
                :offLoading="offLoading"
            >
                Edit {{item.id}}
            </div>
        </b-modal>
    </div>

</template>
<script>
    import {mapGetters} from "vuex";

    export default {
        name: 'l-table',
        props: {
            columns: Object, //{column_db:column_show} , column_db(nest column): field_A.field_B
            data: Array,
            form: String,
            formName: String,
            model: String,
            onLoading: Function,
            offLoading: Function,
        },
        computed: {
            ...mapGetters(['currentUrl'])
        },
        methods: {
            hasValue(item, column) {
                return item[column.toLowerCase()] !== 'undefined'
            },
            itemValue(item, column) {
                let data = item;
                let nest_columns = column.split('.');
                nest_columns.forEach(column => {
                    if (data === null) {
                        return null;
                    }

                    data = data[column];
                });

                return data;
            },
            deleteItem(model, id) {
                var self = this;
                self.onLoading();

                let uri = model + '/' + id;
                let parameters = {
                    route: model,
                    id: id,
                    uri: uri,
                };

                if (confirm('Xác nhận xóa')) {
                    this.$store.dispatch("deleteItem", parameters)
                    .then(res => {
                        var param = '';

                        switch (model) {
                            case 'all-company':
                                param = 'công ty';
                                break;
                            case 'company-invest':
                                param = 'dự án';
                                break;
                            case 'manage-admin':
                                param = 'admin';
                                break;
                            case 'invest-type':
                                param = 'hình thức đầu tư';
                                break;
                            case 'contract-input-field':
                                param = 'trường nhập';
                                break;
                            default:
                                console.log("Not understand in switch");
                        }

                        this.$toast.success('Xóa thông tin '+ param +' thành công');
                    })
                    .catch(err => {
                        self.offLoading();
                        if (err.statusAdminLogging) {
                            this.$toast.error(err.content);
                        }

                        this.$toast.error('Lỗi xin thử lại');
                    })
                } else {
                    self.offLoading();
                }
            }
        }
    }
</script>

<style lang="scss">
    .modal-backdrop {
        background: rgba(0,0,0,0.6) !important;
    }

    .modal-dialog {
        transform: none!important;
    }

    .wpx-165 {
        width: 200px;
    }

    img {
        width: 300px;
        height: 200px;
        object-fit: cover;
    }

    .padding-for-img {
        padding: 92px 0;
    }
</style>
