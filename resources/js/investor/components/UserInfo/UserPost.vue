<template>
    <div class="">
        <h3>{{ $t('my_profile.my_notifications') }}</h3>
        <div class="d-flex flex-row user-post mt-3">
            <img src="/storage/investor/avatar/2021-03-25-04-09-32605c0cfc5123c.png" alt="" class="avatar">
            <div class="pl-2 wrapper-content">
                <h5 class="short-text">
                    <b>Client 1</b> {{ $t('my_profile.replied_on') }} <b>Investment</b>
                </h5>
                <p class="content short-text">
                    So good, so perfect!
                </p>
            </div>
            <p class="time">
                12 {{ $t('my_profile.minutes_ago') }}
            </p>
        </div>
        <div class="d-flex flex-row user-post mt-3">
            <img src="/storage/investor/avatar/2021-03-25-04-09-32605c0cfc5123c.png" alt="" class="avatar">
            <div class="pl-2 wrapper-content">
                <h5 class="short-text">
                    <b>Client 2</b> {{ $t('my_profile.replied_on') }} <b>Investment</b>
                </h5>
                <p class="content short-text">
                    Wow!
                </p>
            </div>
            <p class="time">
                1 {{ $t('my_profile.hour_ago') }}
            </p>
        </div>
        <div class="d-flex flex-row user-post mt-3">
            <img src="/storage/investor/avatar/2021-03-25-04-09-32605c0cfc5123c.png" alt="" class="avatar">
            <div class="pl-2 wrapper-content">
                <h5 class="short-text">
                    <b>Client 5</b> {{ $t('my_profile.replied_on') }} <b>Investment</b>
                </h5>
                <p class="content short-text">
                    This is perfect
                </p>
            </div>
            <p class="time">
                2 {{ $t('my_profile.days_ago') }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserPost"
    }
</script>

<style scoped lang="scss">
    .avatar {
        width: 30px;
        height: 30px;
        min-width: 30px;
        min-height: 30px;
        object-fit: cover;
    }

    .content {
        color:#777;
        font-size: 16px;
    }

    .time {
        position: absolute;
        right: 10px;
        font-size: 12px;
        font-weight: 500;
        color: #5a9ffa;
    }

    .user-post {
        border: 1px solid #e9e9e9;
        border-radius: 4px;
        box-shadow: 0 0 0 transparent;
        padding: 1rem;
        position: relative;
    }

    .user-post:hover {
        box-shadow: 0 3px 8px rgb(0 0 0 / 5%);
        -webkit-transform: translateY(-3px);
        -ms-transform: translateY(-3px);
        transform: translateY(-3px);
    }

    .wrapper-content {
        width: 580px;
    }

    .short-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    h3 {
        font-weight: bold;
        color: var(--main-grey);
    }
</style>
