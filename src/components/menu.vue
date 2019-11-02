<template>
    <el-row class="g-menu_wrap">

        <el-col class="g-menu_case" :style="{width:isCollapse?'64px':''}">

            <el-menu class="g-menu"
                background-color="#304156"
                text-color="#ffffff"
                active-text-color="#409EFF"
                :collapse="isCollapse"
                :default-active="$route.fullPath"
                :router="true"
            >

                <template v-for="(item,idx) in data" >

                    <!-- if item.child.length -->
                    <el-submenu v-if="item.child.length" :index="String(idx)" :key="idx">
                        <template slot="title">
                            <i :class="item.icon"></i>
                            <span>{{item.title}}</span>
                        </template>

                        <el-menu-item v-for="(child,childIdx) in item.child" 
                            :key="childIdx" 
                            :index="child.router" 
                            @click="handleClick(child,item.title)"
                            :routesssss="child.router"
                        >{{child.title}}</el-menu-item>
                        
                    </el-submenu>

                    <!-- else  -->
                    <el-menu-item v-else 
                        :index="item.router" 
                        :key="idx" 
                        @click="handleClick(item)"
                        :routessss="item.router"                        
                        >
                        
                        <i :class="item.icon"></i>
                        
                        <span slot="title">{{item.title}}</span>

                    </el-menu-item>
                    
                    <!-- end if -->

                </template>


            </el-menu>
        </el-col>

    </el-row>
</template>

<script>
export default {
    data(){
        return {
            msg:'',
            data:[
                {title:'首页',icon:'el-icon-menu',child:'',router:'/home'},
                {title:'商品管理',icon:'el-icon-s-goods',child:[
                    {title:'商品列表',router:'/s'},
                    {title:'添加商品',router:'.d'},
                ]},
                {title:'用户管理',icon:'el-icon-s-custom',child:[
                    {title:'管理员列表',router:'/user-admin'},
                    {title:'用户列表',router:'/'},
                    {title:'用户管理',router:'/'},
                ]},
                {title:'轮播广告',icon:'el-icon-picture',child:'',router:'/banner-list'}

            ]
        }
    },
    props:['isCollapse'],
    methods: {

      handleClick(child,parent){
        //   console.log("click")
          parent && (child.parent = parent)
        //   console.log(child)

          this.$emit("breadcrumbData",child);
      }
    }
}
</script>

<style lang="less" scoped>
    .g-menu_wrap {min-height:100%;}
    .g-menu_case {
        position:fixed;
        width:300px;
        top:0;
        left:0;
        height:100%;

    }
    .g-menu {
        min-height:100%;

        &:not(.el-menu--collapse) {
            width:300px;
        }
    }
    
</style>