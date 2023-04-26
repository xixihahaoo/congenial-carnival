/**
 * Created by Administrator on 2016/5/12.
 */
function startMove(obj,json,fn){
    clearInterval(obj.timer);//每次移动，先清除定时器
    obj.timer = setInterval(function(){
        var bStop=true;
        for(var attr in json){//循环传递进来的json数据
            var iCur = 0;
            if(attr=='opacity')
            {
                iCur=parseInt(parseFloat(getCss(obj, attr))*100);
            }else{

                iCur = getCss(obj,attr);//获取当前元素的属性值
            }
            var ispend = (json[attr]-iCur)/8;//缓冲运动(速度)
            ispend = ispend > 0 ? Math.ceil(ispend):Math.floor(ispend);//速度取整

            if(iCur!=json[attr])//当前属性值到达指定位置
            {
                bStop=false;
            }

            if(attr=='opacity')
            {
                obj.style.filter='alpha(opacity:'+(iCur+ispend)+')';
                obj.style.opacity=(iCur+ispend)/100;
            }
            else
            {
                obj.style[attr]=iCur+ispend+'px';
            }

        }
        if(bStop)//如果bStop为true，动画执行到制定位置
        {
            clearInterval(obj.timer);//清除定时器
            if(fn)//回调函数，回调函数是否传人值
            {
                fn();//执行回调函数
            }
        }
    },30)
}
function getCss(ele,arr){
    return ele.currentStyle ? parseInt(ele[arr]):parseInt(window.getComputedStyle(ele,false)[arr]);
}