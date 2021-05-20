<template>
    <b-button-group>
        <b-button v-bind:href="currentUrl.links[0].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) - 1)">‹</b-button>

        <!-- Phân trang cho danh sách ở chế độ bình thường -->
        <b-button
            v-for="(item, index) in currentUrl.links.length - 1"
            v-if="index !== 0 && !isCheckSearch"
            v-bind:key="index"
            v-bind:class="{ 'active-paginate': currentUrl.links[index].active }"
            v-bind:href="'?page=' + ((currentUrl.links[index].label !== '...') ? currentUrl.links[index].label : currentUrl.links[index-1].label + 1)"
        >
            {{currentUrl.links[index].label}}
        </b-button>

        <!-- Phân trang cho danh sách ở chế độ tim kiếm -->
        <b-button
            v-for="(item, index) in currentUrl.links.length - 1"
            v-if="index !== 0 && isCheckSearch"
            v-bind:key="index"
            v-bind:class="{ 'active-paginate': currentUrl.links[index].active }"
            v-bind:href="routeMain + '/search?keySearch=' + currentUrl.links[index].url.split('=')[1] + '=' + ((currentUrl.links[index].label !== '...') ? currentUrl.links[index].label : currentUrl.links[index-1].label + 1)"
        >
            {{currentUrl.links[index].label}}
        </b-button>

        <b-button v-bind:href="currentUrl.links[currentUrl.links.length-1].url === null ?  '#' : '?page='+ (parseInt(currentUrl.current_page) + 1)">›</b-button>
    </b-button-group>
</template>

<script>
    import {mapGetters} from "vuex";
    import env from "../../../env";
    const domain = env.ADMIN_DOMAIN;

    export default {
        name: 'PaginateList',
        props: {
            onLoading: Function,
            offLoading: Function,
            dataList: String,
            routeMain: String,
            routeMainNotSlash: String,
            isCheckSearch: Boolean
        },
        data() {
            return {
                domain: domain
            }
        },
        computed: {
            ...mapGetters(['listCompany', 'auth', 'currentUrl'])
        },
        beforeMount() {
            var self = this;

            if (self.$route.path.search("search") !== -1) {
                if (self.$route.query.keySearch === undefined) {
                    self.$toast.info('Không có trang này');
                    window.location.href = self.domain + self.routeMainNotSlash;
                }
            }
        },
    }
</script>
