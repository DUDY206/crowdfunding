<template>
    <div class="qc-crowdfunding" v-if="listImageAdvertisement.length !== 0">
        <div class="wrapper-list-qc">
            <div class="box-item" v-for="advertisement in listImageAdvertisement" v-bind:key="advertisement.id">
                <a :href="(advertisement.url === 'null' || advertisement.url === null) ? '#' : advertisement.url">
                    <img :src="domain + url_folder + advertisement.img" />
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import env from '../../../env';
    const domain = env.INVESTOR_DOMAIN;

    export default {
        name: 'Advertisement',
        data() {
            return {
                domain: domain,
                url_folder: '/storage/advertisement/',
                listImageAdvertisement: {},
            }
        },
        mounted() {
            var self = this;

            self.$store.dispatch('getAllImageAdvertisement')
            .then((res) => {
                self.listImageAdvertisement = res.data;
            })
            .catch((err) => {

            })
        }
    }
</script>

<style lang="scss" scoped>
    .qc-crowdfunding {
        position: absolute;

        .wrapper-list-qc {
            margin-bottom: 10px;
            overflow-y: hidden;
            height: 100%;
            padding-right: 12px;

            .box-item {
                margin-bottom: 10px;

                a {
                    display: block;

                    img {
                        width: 100%;
                        border-radius: 5px;
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
            transition: .5s all ease;
        }

        .wrapper-list-qc:hover {
            overflow-y: scroll;
            padding-right: 5px;
        }
    }
</style>
