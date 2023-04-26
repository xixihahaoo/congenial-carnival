/*
 *time:2016-6-15
 * */

window.onload = window.onresize = function(){
		var winH = document.documentElement.clientHeight || document.body.clientHeight;
		var main_left = document.getElementById("main_left");
		var mainRight = document.getElementById("main_right");
		main_left.style.height = winH + "px";
		var bodyh = document.body.offsetHeight;
		window.onscroll = function(){
			var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
			main_left.style.top = scrollTop + "px";	
		}
		mainRight.style.minHeight = winH + "px";
		

	
		var mainRight = document.getElementById("main_right");
		var mainLeft = document.getElementById("main_left")
		var a = document.getElementById("a");
		var leftCon = document.getElementById("user_content");
		var lodx = 0;
		var lody = 0;
		var newX = 0;
		var newY = 0;
//		var curx= 0 ;
//  	var cury = 0 ;
    	var curl = 0;
    	var curmr = 0;
		var curR = 0;
		
		 document.addEventListener("touchstart",function(e){
	    	var point = e.touches ? e.touches[0] : e;
	    	x = point.clientX;
	    	y = point.clientY;
	    	
			curmr = getCSS(mainRight,"left");
			curR = getCSS(mainRight,"left");
			curl = getCSS(leftCon,"left");
	    },false)
		
		document.addEventListener("touchmove",function(e){
	    	var point = e.touches ? e.touches[0] : e;//是否支持 e.touches 触摸事件
	    	newX = point.clientX; //获取移动时x的坐标
	    	newY = point.clientY;//获取移动时y的坐标

	    	if(newX > x && Math.abs(parseInt(newY - y)) < 50){
	    		return false;
	    		e.preventDefault(); 
	    	}
			
	    },false)
		
		document.addEventListener("touchend",function(e){
	    	
	    	var diffX = parseInt(newX - x);
	    	var diffY = parseInt(newY - y);
	    	
	    	if(diffX > 0 && Math.abs(diffY) < 50){
	    		if(diffX > 120){
	    			diffX = 250;
	    			startMove(mainRight,{left:diffX})
	    			startMove(leftCon,{left:0})
	    			a.innerHTML = diffX;
	    		}else{
	    			startMove(mainRight,{left:diffX},function(){
	    				a.innerHTML = diffX;
	    				if(diffX <= 130){
	    					diffX = 0;
	    					startMove(mainRight,{left:diffX})
	    				}
	    			})
	    			a.innerHTML = diffX;
	    		}
	    	}else if(diffX < 0 && Math.abs(diffY) < 50){
	    		if(parseInt(mainRight.style.left) >0){
	    			if(diffX < -100){
		    			diffX = 0;
		    			startMove(mainRight,{left:diffX})
		    			startMove(leftCon,{left:-100})
		    			a.innerHTML = diffX;
		    		}else{
			    			startMove(mainRight,{left:curmr + diffX},function(){
			    				if(curmr - diffX > 120){
			    					diffX = 250;
			    					startMove(mainRight,{left:diffX})
			    				}
			    			})
		    			a.innerHTML = diffX;
		    		}
	    		}
	    	}
	    	
	    },false)
	function getCSS(obj,attr){
		return obj.currentStyle ? parseInt(obj[attr]) : parseInt(window.getComputedStyle(obj,false)[attr]);
	}



	var forName = document.getElementById("forName");
	var mright = document.getElementById("main_right");
	var aa = document.getElementById("user_content");

}

