<template>
    <div>
        <el-container class="g-section">
            <el-aside class="g-aside" :style="{width:isCollapse?'64px':'300px'}">

                <Menu :isCollapse="isCollapse" @breadcrumbData="getBreadcrumb"></Menu>

            </el-aside>

            <el-container>
                <el-header class="g-header">
                    
                    <el-row class="g-header_row1">
                        <el-col :span="1" class="g-menu_icon">
                            <i :class="isCollapse ? 'el-icon-s-unfold' : 'el-icon-s-fold'" @click="isCollapse = !isCollapse"></i>
                        </el-col>

                        <el-col :span="15" class="g-header_breadcrumb">
                            <el-breadcrumb separator-class="el-icon-arrow-right">
                                <el-breadcrumb-item v-for="(item,idx) in breadcrumbData" :key="idx">{{item}}</el-breadcrumb-item>
                            </el-breadcrumb>
                        </el-col>

                        <el-col :span="7" class="g-user_handle">
                            <ul >
                                <li>管理员：<span>{{v_user.user_name}}</span></li>
                                <li><el-button @click="$router.push('/login')">退出</el-button></li>
                            </ul>
                        </el-col>
                    </el-row>

                </el-header>

                <nav class="g-nav">
                    <ul>
                        <li v-for="(item,idx) in navData" :key="idx" @click="navTo(item)" :class="{active: $route.fullPath == item.router}">
                            <span>{{item.title}} <span v-if="item.title != '首页'" class="el-icon-close"></span></span>
                        </li>
                    </ul>
                </nav>

                <el-main>

                    <keep-alive>
                        <router-view></router-view>
                    </keep-alive>
 
                </el-main>
            </el-container>
        </el-container>
    </div>
</template>

<script>
import Menu from '@/components/menu'
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            msg:'',
            isCollapse:false,
            breadcrumbData:['首页'],
            navData:[
                {title:'首页',router:'/home',parent:''}
            ],

        }
    },
    components:{Menu},
    computed:{
        ...mapGetters([
            'v_user'
        ])
    },
    methods:{
        getBreadcrumb:function(msg){
            // 获取导航栏点击加载nav
            console.log("breadcrumb")
            console.log(msg)

            let isHave = false,
                arr = [];
                
            msg.parent && arr.push(msg.parent);
            
            arr.push(msg.title)
            
            // header 面包屑
            this.breadcrumbData = arr;


            // nav
            isHave = this.navData.some(function(item){
                return item.title == msg.title;
            });

            !isHave && this.navData.push(msg);

        },

        navTo:function(item){
            let arr = [];
            
            item.parent && arr.push(item.parent);
            
            arr.push(item.title)

            this.breadcrumbData = arr;


            this.$router.push(item.router);
        }
    }
}
</script>

<style lang='less' scoped>
    .g-section {
        height:100%;
        overflow:hidden;

    }

    .g-aside {border:1px solid pink;min-height:100%;transition:all .4s;}

    .g-header {
        background:#fff;
        box-shadow: 0 1px 4px rgba(0,21,41,.08);

        &>.g-header_row1 {height:100%;line-height:2;}

        & .g-menu_icon {
            display:flex;
            align-items:center;
            height:100%;
            min-width:40px;

            & i{font-size:30px;cursor:pointer;}
        }

        & .g-header_breadcrumb {
            height:100%;


            &>div {
                display:flex;
                align-items:center;
                height:100%;
                line-height:30px;
            }
        }

        & .g-user_handle {
            height:100%;

            &>ul {
                display:flex;
                align-items:center;
                justify-content:flex-end;
                height:100%;

                &>li {
                    margin-right:50px;

                    &:last-child {
                        margin:0;
                    }
                }
            }


        }


    }

    // nav
    .g-nav {
        background:#fff;
        padding:10px 20px;
        box-shadow: 0 1px 3px 0 rgba(0,0,0,.12), 0 0 3px 0 rgba(0,0,0,.04);

        &>ul li{
            display:inline-block;
            padding:5px 10px;
            border:1px solid #ccc;
            font-size:14px;
            border-radius:3px;
            margin-right:5px;
            cursor:pointer;

            &.active {background:#409EFF;color:#fff;border:1px solid #fff;}

            & .el-icon-close {
                border-radius:50%;
                transition:all .3s;
                transform: scale(.8);
                // vertical-align: -3px;

                &:hover {
                    background:#b4bccc;
                    color:#fff;
                    transform: scale(1);

                }
            }
        }
    }
</style>