import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'
import getters from './getters'

Vue.use(Vuex);

const state = {
    is_login:false,
    user:'',
    token:'',
};

// 仅记录storage 列表
const storage = {
    navList:[],         // 导航栏列表
    navSide: '/home',   // 导航栏当前显示页面
};

export default new Vuex.Store({
    state,
    mutations,
    getters,
});