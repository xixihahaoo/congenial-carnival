$(function(){
    //	主页面
    var $main_page = $("#main_right");
    //  移动页面
    var move_page = $("#user_content");
    $("#forName").click(function(){
        if( $("#main_right").position().left == 250 ){
            $("#main_right").animate({left : "0px"}, 500)
            $("#user_content").animate( {left : "-100px"}, 500 )


        }else{
            $("#main_right").animate({left : "250px"}, 500)
            $("#user_content").animate( {left : "0px"}, 500 )
        }
    })

    $("#main_right").click(function(){
        if( $(this).position().left == 250 ){
            $(this).animate({left : "0px"}, 500)
            $("#user_content").animate( {left : "-100px"}, 500 )


        }
    })

})