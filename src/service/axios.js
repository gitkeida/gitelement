import Vue from 'vue';
import axios from 'axios';

axios.defaults.baseURL = 'http://119.29.67.165/mineData/admin/data/';

// axios.interceptors.request.use(
//     config =>{
//         config.headers = {'Content-Type':'application/x-www-form-urlencoded'};
//         return config;
//     },
// )
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';



Vue.prototype.axios = axios;

export default axios;