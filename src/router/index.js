import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Index from '@/pages/index'
import BannerList from '@/pages/b_bannerList'
import store from '@/store'

const Login = () => import('@/pages/login');

const User_Admin = () => import ('@/pages/user/user_admin');

Vue.use(Router)




const route = new Router({
  mode:'history',
  base: '/element-admin',
  routes: [
    {
      path: '/',
      name: '',
      component: Index
    },
    {
      path: '/home',
      name: '',
      component: Index,
      children:[
        {path:'/banner-list',name:'轮播列表',component:BannerList},
        {path:'/user-admin',name:'后台管理员',component:User_Admin},
      ]
    },
    {
      path: '/login',
      component:Login,
      meta:{
          is_login:true,    // 由于不需要登录的页面比较少，所以用不需要登录的来判断
      }
    }

  ]
});


route.beforeEach((to,from,next)=>{

    if(!to.meta.is_login){
      
        if(!store.getters.v_is_login){
            console.log("跳转登录")
            next({replace:true,path:'/login'});
        } else {
            next();
        }
    } else {
        next();
    }
})


export default route;
