<template>
    <b-col cols="12" lg="6" class="container-main" v-if="!isLoading">
        <h4>{{ $t('transaction.direct_payment') }}</h4>
        <b-form>
            <b-form-group>
                <b-form-input
                    v-model="form.full_name"
                    disabled
                    class="pointer-none"
                    :placeholder="$t('authenticator.full_name')"
                />
                <br>
                <b-form-input
                    v-model="form.email"
                    disabled
                    class="pointer-none"
                    :placeholder="$t('authenticator.email')"
                />
                <br>
                <b-form-input
                    type="number"
                    v-model="form.phone_number"
                    :placeholder="$t('authenticator.phone_number')"
                />
            </b-form-group>
            <b-button variant="primary" v-if="!btnCheck" @click="sendMail">{{ $t('contract_form.submit') }}</b-button>
            <b-button variant="info pointer-none" v-if="btnCheck">{{ $t('contract_form.submit') }}</b-button>
        </b-form>
    </b-col>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from "../../../env";
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: 'PaymentContact',
        computed: {
            ...mapGetters([
                'locale', 'auth'
            ])
        },
        props: {
            isLoading: Boolean
        },
        data() {
            return {
                form: {
                    full_name: '',
                    email: '',
                    phone_number: '',
                },
                btnCheck: false,
            }
        },
        mounted() {
            var self = this;

            self.form.full_name = self.auth.user.full_name;
            self.form.email = self.auth.user.email;
            self.form.phone_number = self.auth.user.phone_number;
        },
        methods: {
            sendMail() {
                var self = this;
                self.btnCheck = true;

                self.$store.dispatch('sendMailContact', self.form)
                .then((res) => {
                    self.btnCheck = false;
                    self.$toast.success(self.$t('transaction.sent_email'));
                })
                .catch((err) => {
                    self.btnCheck = false;
                    self.$toast.error(self.$t('errors.error_1'));
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
</style>
