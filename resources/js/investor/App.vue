<template>
    <router-view></router-view>
</template>

<script>
  export default {
      methods: {
          clearState() {
              // this.$store.commit('settempFormContract', null);
              console.log("load this")
          }
      },
      mounted() {
          window.addEventListener('beforeunload', this.clearState)
      }
  }
</script>
<style >

</style>
