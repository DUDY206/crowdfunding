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
            'removeInvestId'
        ],
        computed:{
            ...mapGetters([
                'listCompanyInvest', 'auth'
            ])
        },
        data() {
            return {
                domain: domain,
            }
        },
        mounted() {
            var self = this;
        },
        methods: {
            pushInvestId(investId) {
                var self = this;

                self.listInvestId.push(investId);
            },
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

                .wp-container {
                    padding: 0 20px;
                    height: 545px;

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
                height: 340px !important;
            }
        }
    }
</style>
