<template>
    <a v-bind:href="'/' + $i18n.locale + '/user/' + user.slug" class="text-dark text-decoration-none">
        <b-card no-body class="overflow-hidden" style="max-width: 540px;">
            <b-row no-gutters>
                <b-col cols="2">
                    <b-card-img v-bind:src="user.avatar_path" alt="Image" class="rounded-0 "></b-card-img>
                </b-col>
                <b-col cols="10">
                    <b-card-body v-bind:title="user.full_name">
                        <b-card-text>
                            <b-badge variant="success">Following</b-badge>
                        </b-card-text>
                    </b-card-body>
                </b-col>
            </b-row>
        </b-card>
    </a>
</template>

<script>
    export default {
        name: "UserInfoCard",
        props:[
            'user'
        ]
    }
</script>

<style scoped lang="scss">
    .card-body{
        padding:0 0.5rem
    }
    .card-img{
        height: 50px;
        width: 50px;
        min-width: 50px;
        min-height: 50px;
        object-fit: cover;
        border-radius: 3px!important;
    }
    .card{
        border: none!important;
        padding: 0.5rem 0;
    }
    .card + .card{
        border-top: 1px solid #eee!important;
    }
    .card-title{
        margin:0!important;
        font-size: 16px;
        font-weight: 600;
    }
</style>
