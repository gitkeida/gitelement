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

window.deepClone = deepClone;