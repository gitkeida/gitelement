<template>
    <div>
        <div class="g-title">
            <h2>轮播列表</h2>
        </div>


        <el-table
            :data="tableData"
            stripe
            style="width:100%;"
        >   

            <el-table-column prop="bannerid" label="ID">  </el-table-column>

            <el-table-column label="图片" > 
                <template slot-scope="scope">
                    <el-image style="width:100px;height:50px;" :src="scope.row.imgurl" fit="contain" :lazy='true' :preview-src-list="[scope.row.imgurl]">
                        <div slot="error" class="image-slot">
                            <!-- <i class="el-icon-picture-outline"></i> -->
                            <img :src="scope.row.imgurl" alt="" width="100px">
                        </div>
                    </el-image>
                </template>

            </el-table-column>
            
            <el-table-column prop="link" label="链接">  </el-table-column>
            <el-table-column prop="title" label="title">  </el-table-column>
            <el-table-column prop="bannerText" label="text">  </el-table-column>
            <el-table-column
                label="操作"
                width="100">
                <template slot-scope="scope">
                    <el-button @click="altOpen(scope.row)" type="primary" size="small">编辑</el-button>
                </template>
            </el-table-column>
        </el-table>


        <el-drawer
            title="修改商品"
            direction="rtl"
            :visible.sync="drawer"
            >

            <el-form ref="form" :model="form" label-width="80px" style="padding-right:20px;height:100%;">
                <el-form-item label="标题">
                    <el-input v-model="form.title"></el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <el-input v-model="form.bannerText"></el-input>
                </el-form-item>
                <el-form-item label="链接">
                    <el-input v-model="form.link"></el-input>
                </el-form-item>
                <el-form-item label="图片:">
                    <br>
                    <el-upload
                        class="avatar-uploader"
                        action="http://119.29.67.165/mineData/admin/data/update_load.php"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                        <img v-if="form.imgurl" :src="form.imgurl" class="avatar" width="280px">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>

                <el-form-item style="position:absolute;bottom:5%;">
                    <el-button type="primary" @click="drawerSubmit">提交</el-button>
                </el-form-item>

            </el-form>
        
        </el-drawer>
    </div>
</template>

<script>
import api from '@/service/api';
export default {
    data(){
        return {
            tableData: [
                {
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, 
                {
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 弄'
                }, 
                {
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                },
                {
                    date: '2016-05-03',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1516 弄'
                }
            ],

            drawer:false,       // 抽屉状态

            form:{},            // form对象
            newImage:null       // 保存新上传的图片
        }
    },

    methods:{
        handleClick(msg){
            console.log(msg)
        },

        altOpen(msg){
            this.form = deepClone(msg);
            this.drawer = true;
        },

        getData:function(){
            this.axios.get(api.banner).then(res=>{
                console.log("res")
                console.log(res)
                if(res.status == 200){
                    this.tableData = res.data;
                }
            })
        },

        handleAvatarSuccess(res, file) {
            console.log("上传成功")
            console.log(JSON.parse(res));
            console.log(file);

            res = JSON.parse(res);
            if(res.code == 200){
                this.form.imgurl = URL.createObjectURL(file.raw);
                this.newImage = res.msg;
            } else {
                this.$message.error(res.msg);

            }
        },
        beforeAvatarUpload(file) {
            console.log("开始上传")
            console.log(file)

            // let This = this,
            //     reader = new FileReader();

            // reader.readAsDataURL(file);
            
            // reader.onload = function(e){
            //     console.log("文件加载完成");
            //     This.form.imgurl = e.target.result;
            // }


            // return false;

            const isJPG = file.type != 'image/jpeg' && file.type != 'image/gif';
            // const isJPG = file.type === 'image/jpeg';


            const isLt2M = file.size / 1024 / 1024 < 2;

            if (isJPG) {
                this.$message.error('上传图片只能是 JPG 格式!');
            }
            if (!isLt2M) {
                this.$message.error('上传图片大小不能超过 2MB!');
            }
            return !isJPG && isLt2M;
        },

        // 提交
        drawerSubmit(){
            let postData = deepClone(this.form);
            this.newImage && (postData.imgurl = this.newImage);
            console.log(postData)
            this.axios.post(api.updata_banner,postData).then(res=>{
                console.log(res)
            }).catch(res=>{
                console.log("err")
                console.log(res)
            })

        },
    },
    mounted:function(){
        console.log("数据开始获取")
        console.log(this.tableData)
        this.getData();
    }


}
</script>

<style lang="less" >
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 280px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 280px;
        height: 178px;
        display: block;
    }
</style>