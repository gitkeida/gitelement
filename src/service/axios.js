import Vue from 'vue';
import axios from 'axios';
import qs from 'qs';

axios.defaults.baseURL = 'http://119.29.67.165/mineData/admin/data/';

axios.interceptors.request.use(
    config =>{
        // console.log("请求消息头：");
        // console.log(config)
        if(config.method == 'post'){

            config.headers = {'Content-Type':'application/x-www-form-urlencoded'};
            // config.data = qs.stringify(config.data);
        }
        return config;
    },
);
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';



Vue.prototype.axios = axios;

export default axios;