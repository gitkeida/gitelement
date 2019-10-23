/**
 * 
 * @param {存放公共方法的js文件}} obj 
 */

// 数组深拷贝
function deepClone(obj){
    let _obj = JSON.stringify(obj),
        objClone = JSON.parse(_obj);
    
    return objClone;
}

// 精确浮点数
function strip(num, precision = 12) {
    return +parseFloat(num.toPrecision(precision));
}


// 获取storage
function getStorage(name,type="local"){
    let msg = type=='session' ? sessionStorage.getItem(name) : localStorage.getItem(name);
    try {
        return JSON.parse(msg);
    } catch(e) {
        return msg;
    }
}

// 设置storage
function setStorage(name,msg,type="local"){
    if(typeof msg == 'object'){
        msg = JSON.stringify(msg);
    }

    type == 'session' ? sessionStorage.setItem(name,msg) : localStorage.setItem(name,msg);
    
}

// 删除storage
function removeStorage(name,type="local"){
    type == 'session' ?
        sessionStorage.removeItem(name)
        : localStorage.removeItem(name);
}


window.deepClone = deepClone;

window.winStrip = strip;

window.getStorage = getStorage;
window.setStorage = setStorage;
window.removeStorage = removeStorage;