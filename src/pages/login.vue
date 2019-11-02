<template>
  <div class="" style="height:100%;">
      <div class="g-content">

          <div class="g-login_case">
              <h3>欢迎您</h3>
              <el-form :model="ruleForm" :rules="rules" ref="ruleForm" >
                  <el-form-item prop="name" >
                    <el-input
                            placeholder="请输入账户"
                            prefix-icon="el-icon-user"
                            class="g-input"
                            v-model="ruleForm.name"
                             @keyup.enter.native="login"
                            >
                    </el-input>
                  </el-form-item>

                  <el-form-item prop="pwd" >
                    <el-input
                            placeholder="请输入密码"
                            prefix-icon="el-icon-lock"
                            class="g-input"
                            v-model="ruleForm.pwd"
                            @keyup.enter.native="login()"
                            show-password>
                    </el-input>
                  </el-form-item>



                <el-button type="primary" round style="width:330px;" @click="login()">登录</el-button>

              </el-form>

          </div>

      </div>
  </div>
</template>

<script>
import {mapMutations,mapGetters} from 'vuex'

export default {
  name: '',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      ruleForm: {
          name:'',
          pwd:'',
          pwdError:'sdf',
          nameError:'sd',
          errorMsg:'',
      },
      rules: {
          name:[
              {required:true,message:'请输入用户名',trigger: 'blur'},
              { min: 3, max: 12, message: '长度在 3 - 12 个字符', trigger: 'blur' }
          ],
          pwd: [
              {required:true,message:'请输入密码',trigger: 'blur'},
              {min:3,max:16,message:'长度在 3 - 12 个字符',trigger:'blur'}
          ]
      }
    }
  },
  computed:{
      ...mapGetters([
          'v_user',
          'v_is_login'
      ])
  },
  methods:{
      ...mapMutations([
          'SET_USER',
          'SET_IS_LOGIN'
      ]),
      login:function(){
          
          this.$refs.ruleForm.validate((valid)=>{
              if(valid){
                  this.$api.login(this.ruleForm).then(res=>{
                        console.log("登录");
                        console.log(res)
                        if(res.data.code == 1){
                            console.log("登录成功")

                            this.$message.success(res.data.msg);
                            this.SET_USER(res.data.data);

                            this.$router.push('/home');

                        } else {
                            // this.$refs.ruleForm.fields[0].error="错误提示";
                            this.$message.error(res.data.msg);
                        }
                  })

              } else {
                  
                  console.log('验证失败');
                  return false;

              }
          })
      }
  },
  mounted:function(){
      
      // 清除登录信息
      this.SET_IS_LOGIN(false);
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="less" scoped>
    .g-content {
        width:100%;
        height:100%;
        background:url(../assets/images/login_bg.jpg);
        background-position:center center;

        &>.g-login_case {
            width:400px;
            // padding:35px;
            position:fixed;
            top:40%;
            left:50%;
            transform:translate(-50%,-50%);
            text-align:center;

            &>h3 {
                text-align:center;
                margin-bottom:30px;
                font-size:28px;
                font-weight:normal;
                color:#fff;
            }

            & .g-input {
                width:330px;
                height:46px;
                margin-bottom:30px;
                background:transparent!important;
                // border:1px solid rgba(255,255,255,0.2)!important;
                border-radius:46px;
                // overflow:hidden;
            }
        }
    }
</style>
<style lang="less">
    .g-login_case .el-input__inner {
        background:transparent!important;
        border:2px solid rgba(255,255,255,0.2);
        border-radius:46px;
        height:46px;
        color:#fff;
    }
    .g-login_case .el-input--prefix .el-input__inner {
        padding-left:45px;
    }
    .g-login_case .el-input__icon {
        font-size:20px;
        line-height:46px;
        width:35px;
    }

    .g-login_case .el-form-item__error {
        top:70%;
        left:50px;
    }
</style>
