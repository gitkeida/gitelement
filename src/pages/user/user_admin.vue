<template>
  <div class="">
        <div class="g-title">
            <h2>管理员列表</h2>
            <el-button type="primary" class="g-title_btn" @click="showDrawer = true">添加管理员</el-button>
        </div>

        <el-table class="g-user_table"
            :data="tabData"
            :row-class-name="tableRowClassName"
            border
        >
            <el-table-column label="编号" type="index" width="80"></el-table-column>
            <el-table-column prop="user_id" label="ID"></el-table-column>
            <el-table-column prop="user_name" label="用户名"></el-table-column>
            <el-table-column prop="reg_time" label="注册时间"></el-table-column>
            <el-table-column prop="user_email" label="email"></el-table-column>
            <el-table-column label="账号状态">
                <template slot-scope="scope">
                    <span>{{scope.row.expire == 0 ? '正常' : '禁用'}}</span>
                </template>
            </el-table-column>
            <el-table-column label="操作" width="100" >
                <template slot-scope="scope">
                    <div align="center">
                        <el-button 
                            @click="banned(scope.row)" 
                            :type=" scope.row.expire == 1 ? 'success' :'danger'" 
                            size="mini" 
                            :disabled="v_user.user_id == scope.row.user_id || v_user.user_db <= scope.row.user_db ? 'disabled' : false">
                            {{scope.row.expire == 1 ? '解封' : '封禁'}}
                        </el-button>
                    </div>
                </template>
            </el-table-column>
        </el-table>

        <!-- add 添加管理员输入框 -->
        <el-drawer 
            title="添加管理员"
            :visible.sync="showDrawer"
            :before-close="handleClose"
            ref="drawer"
            custom-class="demo-drawer"
            >

            <div class="g-form_content demo-drawer__content">

                <el-form :model="ruleForm" :rules="rules" ref="form" label-width="100px" style="padding-right:20px;height:100%;">
                    <el-form-item label="用户名" prop="user_name">
                        <el-input v-model="ruleForm.user_name"></el-input>
                    </el-form-item>
                    <el-form-item label="密码" prop="user_password">
                        <el-input v-model="ruleForm.user_password"></el-input>
                    </el-form-item>
                    <el-form-item label="确认密码" prop="check_password">
                        <el-input v-model="ruleForm.check_password"></el-input>
                    </el-form-item>
                    <el-form-item label="邮箱" prop="user_email">
                        <el-input v-model="ruleForm.user_email"></el-input>
                    </el-form-item>
                    <el-form-item label="角色">
                        <el-select v-model="ruleForm.user_db" placeholder="普通管理员" >
                            <el-option label="普通管理员" value="10"></el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item label="权限">
                        <el-input v-model="ruleForm.user_db"></el-input>
                    </el-form-item>
                </el-form>

                <div class="g-form_footer demo-drawer__footer">
                    <el-button @click="showDrawer = false">取 消</el-button>
                    <el-button type="primary" @click="$refs.drawer.closeDrawer()" :loading="btnLoading">{{ btnLoading ? '提交中 ...' : '确 定' }}</el-button>
                </div>

            </div>

        </el-drawer>

  </div>
</template>

<script>
import {mapGetters,mapMutations} from 'vuex'
export default {
  name: '',
  data () {
    
    /**
     * 邮箱验证
     */
    let emailReg = (rule,value,callback) => {
        let reg = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
        if(value.trim() !== '' && !reg.test(value)) {
             callback(new Error('邮箱格式不正确'));
        } else {
            callback();
        }
    };

    /**
     * 确认密码验证
     */
    let cpwdReg = (rule,value,callback) => {
        if(value.trim() === '') {
            callback(new Error('请再次输入密码'));
        } else if(value !== this.ruleForm.user_password) {
            callback(new Error('两次输入密码不一致'));
        } else {
            callback();
        }
    };




    return {
      msg: '',
      tabData:[],
      showDrawer: false,
      btnLoading: false,

      ruleForm: {
          user_name: '',
          user_password: '',
          check_password: '',
          user_email: '',
          user_db: '',
          reg_time: new Date()
      },
      rules: {
          user_name:[
              {required:true,message:'请输入用户名',trigger: 'blur'},
              { min: 4, max: 12, message: '长度在 4 - 12 个字符', trigger: 'blur' }
          ],
          user_password: [
              {required:true,message:'请输入密码',trigger: 'blur'},
              {min:4,max:16,message:'长度在 4 - 12 个字符',trigger:'blur'}
          ],
          check_password: [
              {required:true,message:'请再次输入密码',trigger: 'blur'},
              {validator: cpwdReg,trigger: 'blur'}
          ],
          user_email:[
              {validator: emailReg,trigger:'blur'}
          ]

      }
      
    }
  },
  components:{},
  computed:{
      ...mapGetters([
          'v_user'
      ])
  },
  methods:{
      // 表格类样式
      tableRowClassName({row,rowIndex}){
          if(rowIndex == 1){
              return 'warning-row';
          } else if (rowIndex == 3){
              return 'success-row';
          }

          return '';
      },
      getData:function(){
          this.$api.user_admin({
              user_db: this.v_user.user_db
          }).then(res=>{
              console.log(res);

              if(res.code == 1){
                  this.tabData = res.data;
              }

          })
      },
      // 封禁
      banned:function(row){
          console.log(row)
          this.$confirm(`确定要封禁用户 "${row.user_name}" 吗?`,'提示',{
              confirmButtonText: '确定',
              cancelButtonText: '取消'
          }).then(()=>{

              this.$api.user_expire({
                  user_id: this.v_user.user_id,
                  int_user_id: row.user_id
              }).then(res=> {
                  console.log('修改用户权限')
                  console.log(res)

                  if ( res.code == 1) {
                      this.$message.success('已封禁');
                      this.getData();
                  } else {
                      this.$message.error('修改失败');
                  }

              })

          }).catch(_=>{});
      },

      /**
       * 抽屉 
       */
      // 关闭
      handleClose(done) { 
          console.log('关闭关闭关闭')
          done();
      },
      
  },
  mounted:function(){
      this.getData();
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="less" scoped>


    /**
        抽屉
    */
    .g-drawer {

    }
</style>
<style lang="less">
  .el-table .warning-row {
    background: #FAFAFA;
  }

  .el-table .success-row {
    background: #f0f9eb;
  }

  .g-form_content {
    display:flex;
    flex-direction: column;
    height: 100%;
    padding:20px 0;

    &> form {flex:1;}
  }

  .g-form_footer {
    display:flex;
    padding:0 20px;


    &>button {flex:1;}
  }
</style>