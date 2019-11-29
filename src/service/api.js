import axios from './axios'



export default {

    // 轮播列表
    banner: params => axios.get('banner.php',{params}),

    /**
     * 修改轮播信息
     * @params {object}
     * bannerid
     * imgurl
     * link
     * title
     * bannerText
     */
    updata_banner: params => axios.post('updata_banner.php',params),

    /**
     * 登录
     * @params {object}
     * user_name: 用户名
     * user_password: 密码
     */
    login: params => axios.post('user/login.php',params),

    // 管理员列表
    user_admin: fd => axios.post('user/user_admin.php',fd),

    // 修改用户权限
    user_expire: fd => axios.post('user/updata_expire.php',fd),

}