<template>
    <div class="filter-data pull-right">
        <div class="filter-input mg-right-10 br-red">
            <a v-if="isCheckSearch" :href="routeMain" class="pointer">
                Làm mới
            </a>
        </div>
        <input type="text" v-on:keyup="onChangeFilter(key)" v-model="key" :placeholder="placeholderName" />
        <div class="filter-input mg-left-10">
            <a v-if="isCheckFilterBtnSearch" @click="searchInSearch" class="pointer">Tìm kiếm</a>
            <a v-else class="none-filter not-allow-pointer">Tìm kiếm</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'SearchList',
        props: {
            isCheckSearch: Boolean,
            onChangeFilter: Function,
            keySearch: String,
            isCheckFilterBtnSearch: Boolean,
            search: Function,
            placeholderName: String,
            routeMain: String,
        },
        data() {
            return {
                key: '',
            }
        },
        mounted() {
            var self = this;

            self.key = self.keySearch;
        },
        methods: {
            searchInSearch(e) {
                e.preventDefault();
                var self = this;

                self.$router.push({path: self.routeMain + '/search', query: {keySearch: self.key} }).then(() => {});
                self.search(e);
            }
        }
    }
</script>
