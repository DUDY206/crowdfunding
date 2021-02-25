<template>
    <b-card no-body class="overflow-hidden" style="max-width: 540px;">
        <b-row no-gutters>
            <b-col cols="2">
                <b-card-img src="/investor/images/tmp.jpg" alt="Image" class="rounded-0 "></b-card-img>
            </b-col>
            <b-col cols="10">
                <b-card-body title="Humaoid user">
                    <b-card-text>
                        <b-badge variant="success">Success</b-badge>
                        <b-badge variant="danger">Danger</b-badge>
                    </b-card-text>
                </b-card-body>
            </b-col>
        </b-row>
    </b-card>
</template>

<script>
    export default {
        name: "UserInfoCard"
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
