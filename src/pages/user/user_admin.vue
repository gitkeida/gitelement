<template>
  <div class="">
        <div class="g-title">
            <h2>管理员列表</h2>
        </div>

        <el-table class="g-user_table"
            :data="tabData"
            :row-class-name="tableRowClassName"
            border
        >
            <el-table-column prop="user_id" label="编号"></el-table-column>
            <el-table-column prop="reg_time" label="日期"></el-table-column>
            <el-table-column prop="user_name" label="用户名"></el-table-column>
            <el-table-column prop="user_email" label="email"></el-table-column>
            <el-table-column prop="expire" label="账号状态"></el-table-column>
        </el-table>
  </div>
</template>

<script>
import {mapGetters,mapMutations} from 'vuex'
import api from '@/service/api'
export default {
  name: '',
  data () {
    return {
      msg: '',
      tabData:[],
      
    }
  },
  components:{},
  computed:{
      ...mapGetters([
          'v_user'
      ])
  },
  methods:{
      tableRowClassName({row,rowIndex}){
          if(rowIndex == 1){
              return 'warning-row';
          } else if (rowIndex == 3){
              return 'success-row';
          }

          return '';
      },
      getData:function(){
          this.axios.post(api.user_admin,{
              user_db: this.v_user.user_db
          }).then(res=>{
              console.log(res);
              if(res.status == 200) {
                  let data = res.data;

                  if(data.code == 1){
                      this.tabData = data.data;
                  }
              }

          })
      }
  },
  mounted:function(){
      this.getData();
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="less" scoped>

</style>
<style>
  .el-table .warning-row {
    background: oldlace;
  }

  .el-table .success-row {
    background: #f0f9eb;
  }
</style>