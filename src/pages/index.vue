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
                                <el-breadcrumb-item v-for="(item,idx) in breadcrumbText" :key="idx">{{item}}</el-breadcrumb-item>
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
                            <span>{{item.title}} <span v-if="item.title != '首页'" class="el-icon-close" @click.stop="navClose(item,idx)"></span></span>
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
            breadcrumbData:{},      // 面包屑对象
            navData:[],             // 导航栏列表

        }
    },
    components:{Menu},
    computed:{
        ...mapGetters([
            'v_user'
        ]),
        // 面包屑
        breadcrumbText(){
            let arr = [];
            this.breadcrumbData.parent && arr.push(this.breadcrumbData.parent);
            arr.push(this.breadcrumbData.title);
            return arr;
        }
    },
    methods:{

        // menu子组件触发事件
        getBreadcrumb:function(msg){
            // 获取导航栏点击加载nav

            let isHave = false;
                
            
            // header 面包屑
            this.breadcrumbData = msg;


            // nav
            isHave = this.navData.some(function(item){
                return item.title == msg.title;
            });

            !isHave && this.navData.push(msg);

            !isHave && setStorage('navList',this.navData);

        },

        navTo:function(item){

            // 现已由 $route 监听 改变
            // this.breadcrumbData = item;

            // setStorage('navSide',item.router);

            this.$router.push(item.router);

        },

        // 关闭该导航栏选项
        navClose: function(item,idx) {
            console.log(item,idx)

            // 判断是否是当前页面
            let isSelf = this.navData[idx].router == this.$route.fullPath;

 

            this.navData.splice(idx,1);

            setStorage('navList',this.navData);

            isSelf && this.$router.replace(this.navData[idx-1].router);
            
        },

        navInit:function(){
            /**
             * 导航栏及面包屑初始化
             */
            let navInit = [{title:'首页',router:'/home',parent:''},],
                navSide = getStorage('navSide') || '/home';

            if(getStorage('navList') == null) {
                setStorage('navList',navInit);
            }

            this.navData = getStorage('navList') || navInit;

            // 面包屑
            this.breadcrumbData = this.navData.find(i => {
                return i.router == navSide;
            })

            console.log(this.navData)
            console.log(navSide)
        },

    },
    mounted:function(){

        this.navInit();


    },
    watch: {
        '$route': function(to,from) {
            // 面包屑
            this.breadcrumbData = this.navData.find(i => {
                return i.router == to.fullPath;
            })

            setStorage('navSide',to.fullPath);
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