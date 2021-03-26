<template>
    <router-view></router-view>
</template>

<script>
  export default {
      methods: {
          clearState() {
              // this.$store.commit('settempFormContract', null);
              console.log("this is App.vue")
          }
      },
      mounted() {
          window.addEventListener('beforeunload', this.clearState)
      }
  }
</script>
<style >

</style>
