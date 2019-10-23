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

export default new Vuex.Store({
    state,
    mutations,
    getters,
});