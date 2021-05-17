<template>
    <div class="bestb-crowdfunding">
        <router-view></router-view>
        <div class="tst-top-page" v-if="btnOnTop">
            <a @click="scrollTop">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    export default {
        data() {
            return {
                btnOnTop: false,
            }
        },
        computed:{
            ...mapGetters(['auth', 'locale'])
        },
        methods: {
            clearState() {
                // this.$store.commit('settempFormContract', null);
                var self = this;
                console.log("BestB");
            },
            scrollTop() {
                self.btnOnTop = false;

                this.intervalId = setInterval(() => {
                    if (window.pageYOffset === 0) {
                        clearInterval(this.intervalId)
                    }

                    window.scroll(0, window.pageYOffset - 50);
                }, 0.5)
            },
            scrollListener: function (e) {
                this.btnOnTop = window.scrollY > 150
            }
        },
        mounted() {
            var self = this;
            window.addEventListener('beforeunload', this.clearState);
            window.addEventListener('scroll', this.scrollListener);
        },
        beforeDestroy() {
            window.removeEventListener('scroll', this.scrollListener)
        }
    }
</script>
<style lang="scss">
    .bestb-crowdfunding {
        transition: all 1s ease-in-out;
    }

    .tst-top-page {
        position: fixed;
        bottom: 90px;
        right: 26px;
        width: 60px;
        height: 60px;
        box-shadow: 0 2px 6px 0 rgb(0 0 0 / 10%);
        border-radius: 50%;
        transition: all .2s ease-in-out;
        z-index: 0;
        background: #ffffff;

        a {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            cursor: pointer;
            text-decoration: none !important;
        }
    }
</style>
