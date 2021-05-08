<template>
    <div>
        <b-row>
            <b-col cols="12">
                <b-form-group>
                    <p>
                        ID dự án
                        <a class="pl-icon pointer" @click="openModalCompanyInvest">
                            <i class="fas fa-plus"></i>
                        </a>
                        <span class="text-danger font-italic text-bold">{{errors.invest_id}}</span>
                    </p>
                    <!-- <b-form-input
                        v-model="form.invest_id"
                        type="text"
                        required
                    ></b-form-input> -->

                    <div class="wrapper-multiple" v-if="listInvestId.length > 0">
                        <div class="box" v-for="item of listInvestId" v-bind:key="item">
                            <div class="mul w-content">{{ item }}</div>
                            <div class="mul w-action">
                                <a class="pointer" @click="removeInvestId(item)">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row align-h="between">
            <b-col cols="3">
                <b-button class="mt-3" block @click="$bvModal.hide(modalName)">Đóng</b-button>
            </b-col>
            <b-col cols="3">
                <b-button class="mt-3" block @click="updateInvestOfCategory">Cập nhật</b-button>
            </b-col>
        </b-row>

        <modal-company-invest
            v-if="isModalCompanyInvest"
            :closeModalCompanyInvest="closeModalCompanyInvest"
            :listInvestId="listInvestId"
            :removeInvestId="removeInvestId"
            :onLoading="onLoading"
            :offLoading="offLoading"
        />
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import ModalCompanyInvest from "../Modal-Dialog/ModalCompanyInvest";

    export default {
        name: "CategoryInvestInput",
        components: {
            ModalCompanyInvest,
        },
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
                isModalCompanyInvest: false,
                form: {
                    invest_id: [],
                },
                errors: {
                    invest_id: null,
                },
                listInvestId: [],
            }
        },
        computed: {
            ...mapGetters(['currentUrl', 'listCompanyInvest'])
        },
        mounted() {
            var self = this;

            if (self.item.company_invest.length > 0) {
                for (var invest of self.item.company_invest) {
                    self.listInvestId.push(invest.id);
                }
            }
        },
        methods: {
            getAllCategory() {
                var self = this;

                self.$store.dispatch('getAllCategory')
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            },
            getAllCategoryByPage(page) {
                var self = this;

                self.$store.dispatch('getAllCategoryByPage', page)
                .then((res) => {
                    self.offLoading();
                })
                .catch((err) => {
                    console.log(err);
                    self.offLoading();
                })
            },
            openModalCompanyInvest() {
                var self = this;

                self.isModalCompanyInvest = true;
            },
            closeModalCompanyInvest() {
                var self = this;

                self.isModalCompanyInvest = false;
            },
            removeInvestId(investId) {
                var self = this;

                const index = self.listInvestId.indexOf(investId);

                if (index > -1) {
                    self.listInvestId.splice(index, 1);
                }
            },
            archiveForm() {
                const formData = new FormData();

                this.form.invest_id = this.listInvestId;

                for (var key in this.form) {
                    if (key === 'invest_id') {
                        formData.append(key, '[' + this.form.invest_id + ']');
                    }
                }

                return formData;
            },
            updateInvestOfCategory() {
                var self = this;
                self.onLoading();

                const formData = {
                    id: self.item.id,
                    form: self.archiveForm()
                };

                self.$store.dispatch('addCategoryToInvest', formData)
                .then((res) => {
                    if (self.currentUrl.current_page === 1) {
                        self.getAllCategory();
                    } else {
                        self.getAllCategoryByPage(self.currentUrl.current_page);
                    }

                    self.isModalCompanyInvest = false;
                    self.$toast.success('Cập nhật thành công');
                })
                .catch((err) => {
                    self.offLoading();
                    self.$toast.error('Xin thử lại');
                    console.log(err);
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
