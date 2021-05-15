<template>
    <div>
        <b-form v-if="checkFormAdd">
            Bạn không có quyền với chức năng này
        </b-form>
        <b-form v-if="!checkFormAdd && isLoaded">
            <b-tabs content-class="mt-3">
                <b-row>
                    <b-col cols="12">
                        <p class="text-bold">Cập nhật ngày</p>
                        <b-form-group>
                            <b-form-input
                                required
                                disabled
                                :value="order.updated_at"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="6">
                        <p class="text-bold">Thông tin thanh toán</p>
                        <b-form-group>
                            <p>Ngày đăng ký đầu tư</p>
                            <b-form-input
                                required
                                disabled
                                :value="order.created_at"
                            />
                        </b-form-group>
                        <b-form-group>
                            <p>Số tiền đầu tư</p>
                            <b-form-input
                                required
                                disabled
                                :value="amountFilter"
                            />
                        </b-form-group>
                        <b-form-group>
                            <p>Hình thức thanh toán</p>
                            <b-form-input
                                required
                                disabled
                                :value="order.pay_method"
                            />
                        </b-form-group>
                        <b-form-group>
                            <p>Trạng thái thanh toán</p>
                            <b-form-select v-model="form.payment_status" :options="status_option"></b-form-select>
                        </b-form-group>
                    </b-col>
                    <b-col cols="6">
                        <a :href="domain + order.contract_url" class="text-bold" target="_blank">Hợp đồng người đầu tư</a>
                        <br>
                    </b-col>
                    <b-col cols="6">
                        <p class="text-bold">Thông tin nhà đầu tư</p>
                        <b-form-group>
                            <p>Họ tên</p>
                            <b-form-input
                                required
                                disabled
                                :value="order.user.full_name"
                            />
                        </b-form-group>
                        <b-form-group>
                            <p>Email</p>
                            <b-form-input
                                required
                                disabled
                                :value="order.user.email"
                            />
                        </b-form-group>
                        <b-form-group>
                            <p>Số điện thoại</p>
                            <b-form-input
                                required
                                disabled
                                :value="order.user.phone_number"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col cols="6">
                        <p class="text-bold">Thông tin dự án</p>
                        <b-form-group>
                            <p>Tên dự án muốn đầu tư</p>
                            <b-form-input
                                required
                                disabled
                                :value="order.company_invest.lang_name['vi']"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-tabs>
        </b-form>
        <b-row align-h="between">
            <b-col cols="3">
                <b-button class="mt-3" block @click="$bvModal.hide(modalName)">Đóng</b-button>
            </b-col>
            <b-col cols="3" v-if="!checkFormAdd">
                <b-button class="mt-3" block @click="editForm">Cập nhật</b-button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from "../../../env";
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "OrderInput",
        props: [
            'item',
            'isAdd',
            'modalName',
            'onLoading',
            'offLoading',
            'updatePaginate',
        ],
        data() {
            return {
                domain: domain,
                checkFormAdd: false,
                amountFilter: '',
                form: {
                    payment_status: null
                },
                status_option: [
                    { value: 1, text: 'Đang xác nhận thông tin' },
                    { value: 2, text: 'Đang chờ thanh toán' },
                    { value: 3, text: 'Đã thanh toán' },
                ],
                order: {},
                isLoaded: false,
            }
        },
        computed: {
            ...mapGetters(['currentUrl'])
        },
        mounted() {
            var self = this;
            self.onLoading();

            if (!self.$props.isAdd) {
                self.$store.dispatch('showOrder', self.item.id)
                .then((res) => {
                    self.order = res.data;
                    self.amountFilter = self.order.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    self.form.payment_status = self.order.payment_status;

                    self.offLoading();
                    self.isLoaded = true;
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                    self.isLoaded = true;
                })
            } else {
                self.checkFormAdd = true;
                self.offLoading();
            }
        },
        methods: {
            getAllOrder() {
                this.$store.dispatch('getAllOrder')
                .then((res) => {
                    this.offLoading();
                })
                .catch((err) => {
                    this.offLoading();
                })
            },
            getAllOrderByPage(self, page) {
                self.$store.dispatch('getAllOrderByPage', page)
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    self.offLoading();
                })
            },
            archiveForm() {
                const formData = new FormData();

                for (var key in this.form) {
                    formData.append(key, this.form[key]);
                }

                return formData;
            },
            editForm() {
                var self = this;
                self.onLoading();

                let formData = {
                    id: self.$props.item.id,
                    form: self.archiveForm()
                };

                self.$store.dispatch('updateOrder', formData)
                .then((res) => {
                    self.$toast.success('Cập nhật thành công');
                    self.$bvModal.hide(self.$props.modalName);

                    self.getAllOrderByPage(self, self.currentUrl.current_page);
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            }
        }
    }
</script>

<style scoped lang="scss">
    img {
        width: 400px;
    }

    .mul {
        color: white;
    }

    .pl-icon {
        margin-left: 5px;
    }

    .pl-icon:hover {
        color: #0a98b5;
    }

    .modal-dialog {
        z-index: 999999;
    }

    .wrapper-multiple {
        background-color: #FFFFFF;
        border: 1px solid #E3E3E3;
        border-radius: 4px;
        color: #565656;
        box-shadow: none;
        position: relative;
        align-items: center;
        overflow: auto;

        .box {
            display: flex;
            background: #007bffa6;
            border-radius: 5px;
            padding: 0 10px;
            margin: 5px;
            width: fit-content;
            float: left;

            .w-action {
                a {
                    background: #f0fff4;
                    margin-left: 10px;
                    padding: 0px 3px;
                    border-radius: 50%;
                    color: red;
                    font-weight: bold;
                }

                a:hover {
                    background: red !important;
                    color: white !important;
                }
            }
        }
    }
</style>
