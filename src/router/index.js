import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Index from '@/pages/index'
import BannerList from '@/pages/b_bannerList'

Vue.use(Router)

export default new Router({
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
        {path:'/banner-list',name:'轮播列表',component:BannerList}
      ]
    },

  ]
})
