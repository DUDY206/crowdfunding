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

<style lang="scss" scoped>
.filter-data {
    position: absolute;
    right: 30px;
    top: 81px;
    display: flex;
    align-items: center;

    input[type=text] {
        background-color: #f3f2ee;
        border: 1px solid #e8e7e3;
        border-radius: 4px;
        color: #66615b;
        font-size: 14px;
        padding: 7px 10px;
        height: 40px;
        width: 250px;
    }

    .filter-input {
        background: #52b86a;
        line-height: 39px;
        text-align: center;
        border-radius: 5px;
        padding: 0 5px;

        a {
            display: block;
            color: white;
        }
    }

    .filter-input:hover {
        background: #0e9b30;
    }
}

.none-filter {
    color: #8feca5 !important;
}
</style>
