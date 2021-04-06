<template>
    <div class="content">
        <div class="container-fluid">
            <div class="loading-page" v-if="isLoading">
                <div class="overlay-load">
                    <dot-space-progress></dot-space-progress>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <edit-profile-form :onLoading="onLoading" :offLoading="offLoading"></edit-profile-form>
                </div>
                <div class="col-md-4">
                    <user-card :onLoading="onLoading" :offLoading="offLoading"></user-card>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import EditProfileForm from './UserProfile/EditProfileForm.vue';
    import UserCard from './UserProfile/UserCard.vue';
    import DotSpaceProgress from '../../commons/DotSpaceProgress.vue';

    export default {
        data() {
            return {
                isLoading: false,
            }
        },
        components: {
            EditProfileForm,
            UserCard,
            DotSpaceProgress,
        },
        methods: {
            onLoading() {
                var self = this;
                self.isLoading = true;
            },

            offLoading() {
                var self = this;
                self.isLoading = false;
            }
        }
    }

</script>
<style lang="scss">
    .loading-page {
        .overlay-load {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 260px;
            right: 0;
            z-index: 999999;
            background: hsla(0,0%,8%,0.25);
        }
    }
</style>
