
export default {
    SET_USER(state,options){
        state.user = options;
        state.token = options.user_id;
        state.is_login = true;
        setStorage('user',options);
        setStorage('token',options.user_id);
    },
    SET_IS_LOGIN(state,bool){
        if(bool == false){
            state.user = '';
            state.token = '';
            removeStorage('user');
            removeStorage('token');
        }
        state.is_login = bool;
    },
}