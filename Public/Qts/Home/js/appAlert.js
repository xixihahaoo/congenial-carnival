/**
*  msg 分享内容
*  time 弹出时间 毫秒
*/
function alertMessage(msg,time)
{
    api.toast({
        msg : msg,
        duration : time,
        location : 'bottom'
    });
}

//开启进度框
function showProgress()
{
    api.showProgress({
        animationType:'fade',   //fade  渐隐渐现 zoom 缩放
        title: '努力加载中...',
        text: '先喝杯茶...',
        modal: true //是否模态，模态时整个页面将不可交互
    });
}

//关闭进度框
function closeProgress()
{
    api.hideProgress();
}