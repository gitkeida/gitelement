export default {
    v_user: state => {
        let nowUser = getStorage('user');
        if(state.user == '' && nowUser != null){
            state.user = nowUser;
            state.is_login = true;
        }

        return state.user;
    },
    v_is_login: state => {
        let nowUser = getStorage('user');
        if(state.user == '' && nowUser != null ) {
            state.user = nowUser;
            state.is_login = true;
        }
        return state.is_login;
    },
}