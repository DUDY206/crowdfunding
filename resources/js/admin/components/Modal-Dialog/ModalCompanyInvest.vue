<template>
    <div class="nt-follow-modal">
        <div class="content">
            <div class="wrapper-container">
                <div class="title">
                    Danh sách dự án
                    <a @click="closeModalCompanyInvest">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="option-filter">
                    <div class="filter">
                        <div class="search">
                            <input type="text" v-model="keySearch" placeholder="Tìm kiếm" />
                            <a @click="searchData" class="pointer">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                        <div class="paginate" v-if="!checkSearch">
                            <a v-if="!isCheckLeftPaginate" @click="leftPaginate">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a v-else class="unlink">
                                <i class="fas fa-chevron-left"></i>
                            </a>

                            <a v-if="!isCheckRightPaginate" @click="rightPaginate">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a v-else class="unlink">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="check-all" v-if="!checkSearch">
                        <div class="actions">
                            <a class="text-decoration-none" @click="checkAll(1)" v-if="!isCheckAll">Chọn tất</a>
                            <a class="text-decoration-none active" @click="checkAll(0)" v-if="isCheckAll">Hủy tất cả</a>
                        </div>
                    </div>
                </div>
                <div class="wp-container scroll">
                    <div class="item" v-for="invest, index in listCompanyInvest.data" v-bind:key="index">
                        <div class="name short-text">{{ invest.lang_name.vi }}</div>

                        <div class="actions" v-if="!listInvestId.includes(invest.id)">
                            <a @click="pushInvestId(invest.id)" class="text-decoration-none">Thêm</a>
                        </div>

                        <div class="actions active" v-else>
                            <a @click="removeInvestId(invest.id)" class="text-decoration-none active">Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: "ModalCompanyInvest",
        props: [
            'closeModalCompanyInvest',
            'listInvestId',
            'removeInvestId',
            'onLoading',
            'offLoading',
        ],
        computed:{
            ...mapGetters([
                'listCompanyInvest', 'auth', 'currentUrl'
            ])
        },
        data() {
            return {
                domain: domain,
                isCheckLeftPaginate: false,
                isCheckRightPaginate: false,
                keySearch: '',
                checkSearch: false,
                isCheckAll: false,
            }
        },
        mounted() {
            var self = this;
            self.onLoading();

            self.$store.dispatch('getAllCompanyInvest')
            .then((res) => {
                self.isCheckLeftPaginate = true;
                self.offLoading();
            })
            .catch((err) => {
                self.offLoading();
                console.log(err);
            })
        },
        methods: {
            checkPaginateInvest() {
                var self = this;

                if (self.listCompanyInvest.current_page === 1) {
                    self.isCheckLeftPaginate = true;
                    self.offLoading();
                } else {
                    self.isCheckRightPaginate = false;
                    self.$store.dispatch('getAllCompanyInvestByPage', parseInt(self.listCompanyInvest.current_page) - 1)
                    .then((res) => {
                        self.offLoading();
                    })
                    .catch((err) => {
                        self.offLoading();
                        console.log(err);
                    })
                }
            },
            checkActiveCheckAll() {
                var self = this;

                for (var invest of self.listCompanyInvest.data) {
                    if (self.listInvestId.indexOf(invest.id) === -1) {
                        self.isCheckAll = false;
                    } else {
                        self.isCheckAll = true;
                    }
                }
            },
            leftPaginate() {
                var self = this;
                self.onLoading();
                self.$store.dispatch('getAllCompanyInvestByPage', parseInt(self.currentUrl.current_page) - 1)
                .then((res) => {
                    self.isCheckRightPaginate = false;

                    if (self.currentUrl.links[0].url === null) {
                        self.isCheckLeftPaginate = true;
                    }

                    self.checkActiveCheckAll();
                    self.offLoading();
                })
                .catch((err) => {
                    self.offLoading();
                    console.log(err);
                })
            },
            rightPaginate() {
                var self = this;
                self.onLoading();

                self.$store.dispatch('getAllCompanyInvestByPage', parseInt(self.currentUrl.current_page) + 1)
                .then((res) => {
                    self.isCheckLeftPaginate = false;

                    if (self.currentUrl.links[self.currentUrl.links.length-1].url === null) {
                        self.isCheckRightPaginate = true;
                    }


                    self.checkActiveCheckAll();
                    self.offLoading();
                })
                .catch((err) => {
                    self.offLoading();
                    console.log(err);
                })
            },
            searchData() {
                var self = this;
                self.onLoading();

                if (self.keySearch === '') {
                    self.$store.dispatch('getAllCompanyInvest')
                    .then((res) => {
                        self.isCheckLeftPaginate = true;
                        self.checkSearch = false;
                        self.offLoading();
                    })
                    .catch((err) => {
                        self.offLoading();
                        console.log(err);
                    })
                } else {
                    self.$store.dispatch('searchCompanyInvest', self.keySearch)
                    .then((res) => {
                        self.checkSearch = true;
                        self.offLoading();
                    })
                    .catch((err) => {
                        self.offLoading();
                        console.log(err);
                    })
                }
            },
            pushInvestId(investId) {
                var self = this;

                self.listInvestId.push(investId);
            },
            checkAll(status) {
                var self = this;

                if (status === 1) {
                    self.isCheckAll = true;

                    for (var invest of self.listCompanyInvest.data) {
                        if (self.listInvestId.indexOf(invest.id) !== -1) {
                            const index = self.listInvestId.indexOf(invest.id);

                            if (index > -1) {
                                self.listInvestId.splice(index, 1);
                            }
                        }

                        self.listInvestId.push(invest.id);
                    }
                }

                if (status === 0) {
                    self.isCheckAll = false;

                    for (var invest of self.listCompanyInvest.data) {
                        if (self.listInvestId.indexOf(invest.id) !== -1) {
                            const index = self.listInvestId.indexOf(invest.id);

                            if (index > -1) {
                                self.listInvestId.splice(index, 1);
                            }
                        }
                    }
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .nt-follow-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: hsla(0,0%,8%,.85);

        .content {
            z-index: 100;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;

            .wrapper-container {
                background: white;
                height: 600px;
                width: 450px;
                border-radius: 5px;
                padding: 10px;

                .title {
                    font-size: 17px;
                    font-weight: 600;
                    color: var(--main-grey);
                    text-align: center;
                    margin-bottom: 10px;
                    position: relative;

                    a {
                        position: absolute;
                        left: 20px;
                        cursor: pointer;
                        background: #fde4e4;
                        border-radius: 50%;
                        padding: 0 10px;

                        i:hover {
                            color: blue;
                        }
                    }
                }

                .option-filter {
                    .filter {
                        display: flex;
                        justify-content: space-between;
                        padding: 0 20px;

                        .search {
                            input {
                                outline: none;
                                background: none;
                                border: 1px solid #debcbc;
                                border-radius: 6px;
                                padding: 0 10px;
                                font-size: 15px;
                            }
                        }

                        .paginate {
                            a {
                                cursor: pointer;
                                background: #1f1818;
                                padding: 5px 10px;
                                color: white;
                            }

                            .unlink {
                                background: #f9f1f1;
                                cursor: not-allowed !important;
                            }
                        }
                    }

                    .check-all {
                        margin: 10px 0;
                        padding: 0 27px;
                        display: flex;
                        justify-content: flex-end;

                        .actions {
                            border: 1px solid #c1dbf6;
                            border-radius: 5px;
                            line-height: 25px;
                            text-align: center;
                            width: 90px;
                            cursor: pointer;

                            a.active {
                                color: #007bff;
                            }
                        }

                        .actions:hover {
                            border: 1px solid #0000ff61;
                        }
                    }
                }

                .wp-container {
                    padding: 0 20px;
                    height: 471px;

                    .item {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        border-bottom: 1px solid #f6f0f0;
                        padding: 10px 0;

                        img {
                            width: 10%;
                            height: 40px;
                            object-fit: cover;
                            border-radius: 50%;
                        }

                        .name {
                            width: 240px;
                            font-size: 17px;
                            font-weight: 600;
                        }

                        .actions {
                            border: 1px solid #c1dbf6;
                            border-radius: 5px;
                            line-height: 25px;
                            text-align: center;
                            width: 90px;
                            cursor: pointer;

                            a {
                                font-size: 15px;
                                display: block;
                            }

                            a.active {
                                color: #007bff;
                            }
                        }

                        .actions:hover {
                            border: 1px solid #0000ff61;
                        }

                        .actions.active {
                            border: 1px solid #0000ff61
                        }
                    }

                    .item:first-child {
                        border-top: 1px solid #f6f0f0;
                    }
                }
            }
        }
    }

    ::-webkit-scrollbar {
        width: 7px;
    }

        /* Track */
    ::-webkit-scrollbar-track {
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgb(92, 79, 79);
        border-radius: 10px;
    }

    @media (max-height: 600px) {
        .nt-follow-modal .content .wrapper-container {
            height: 400px !important;

            .wp-container {
                height: 271px !important;
            }
        }
    }
</style>
