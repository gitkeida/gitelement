import axios from './axios'

// export default {
//     banner: 'banner.php',
//     updata_banner: 'updata_banner.php',
//     login:'login.php',
//     user_admin: 'user_admin.php',       // 管理员列表， post, data {user_db:''}
// }


export default {

    // 轮播列表
    banner: params => axios.get('banner.php',{params}),

    // 修改轮播信息
    updata_banner: params => axios.post('updata_banner.php',params),

    // 登录
    login: params => axios.post('login.php',params),

    // 管理员列表
    user_admin: fd => axios.post('user_admin.php',fd),
}