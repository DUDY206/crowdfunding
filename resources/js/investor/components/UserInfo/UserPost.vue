<template>
   <div class="d-flex flex-row user-post  mt-3">
       <img src="/investor/images/tmp.jpg" alt="" class="avatar">
       <div class="pl-2">
           <h5><b>User name</b> replied on <b>Investment</b></h5>
           <p class="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos doloribus perspiciatis porro, praesentium sapiente similique ullam veniam? Delectus deserunt eum iste nostrum, quidem suscipit? Ad aut blanditiis consequuntur debitis   </p>
       </div>
       <p class="time">
           6 minutes ago
       </p>
   </div>
</template>

<script>
    export default {
        name: "UserPost"
    }
</script>

<style scoped lang="scss">
    .avatar{
        width: 30px;
        height: 30px;
        min-width: 30px;
        min-height: 30px;
        object-fit: cover;
    }
    .content{
        color:#777;
        font-size: 16px;
    }
    .time{
        font-size: 13px;
    }
    .user-post{
        border: 1px solid #e9e9e9;
        border-radius: 4px;
        box-shadow: 0 0 0 transparent;
        padding: 1rem;
    }
    .user-post:hover{
        box-shadow: 0 3px 8px rgb(0 0 0 / 5%);
        -webkit-transform: translateY(-3px);
        -ms-transform: translateY(-3px);
        transform: translateY(-3px);
    }
</style>
