function qingcangbao()
{
	var commonbao = $("#commonbao");
	$.ajax({
		type:'post',
		url:"/Admin/bao/olist",   
		success:function(data){
			if(commonbao.attr('status') == 1)
			{
				commonbao.attr('status','2');
				commonbao.attr('style',"color:red;float:right;width:1em;height:2em;line-height:1em");
			}else{
				commonbao.attr('status','1');
				commonbao.attr('style',"color:green;float:right;width:1em;height:2em;line-height:1em");
			}
			commonbao.html('★<br>★<br>★');
		}
	});
}
setInterval('qingcangbao()', 1000);