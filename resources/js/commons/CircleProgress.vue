<template>
    <div class="wrapper-progress">
        <div class="lds-dual-ring"></div>
        <div class="text-circle-load">Loading...</div>
    </div>
</template>

<script>
    export default {}
</script>

<style scoped>
    .wrapper-progress {
        display: flex;
        justify-content: center;
        width: 100%;
        position: relative;
    }

    .lds-dual-ring {
        display: inline-block;
        width: 50px;
        height: 50px;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 4px solid #bdb1b1;
        border-color: #e27c93 #b3494900 #e27c93 transparent;
        -webkit-animation: lds-dual-ring 1.2s linear infinite;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .text-circle-load {
        position: absolute;
        bottom: -20px;
    }
</style>
