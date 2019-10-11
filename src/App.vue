<template>
  <div id="app">
    <router-view style="min-height:100%;"/>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style lang="less">
html,body,#app{height:100%;}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center;
  color: #2c3e50;
  margin-top: 60px; */
}

.g-title {
  height:50px;
  width:100%;
  line-height:50px;
  font-size:14px;
  border-bottom:1px solid #ddd;
  margin-bottom:30px;
}
</style>
