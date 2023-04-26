/*
 */
/*var defined = {
	moveArea: "main_content",//移动区域
	thisEle : "user_center",
	curWidth : 200,
	curLeft : -200,
	curX : 0,
	curY : 0,
	newX : 0,
	newY : 0,
	actual : 0,
	t : false,
	r : false,
	b : false,
	l : false
}
*/
	function gestureEven (obj){
		this.moveArea = obj.moveArea;//移动区域
		this.thisEle = obj.thisEle;//移动元素
		this.curWidth = obj.curWidth;//移动元素的宽度
		this.curLeft = obj.curLeft;//移动元素的left值
		this.curX = obj.curX;//当前x的坐标
		this.curY = obj.curY;//当前y的坐标
		this.newX = obj.newX;//新的x坐标
		this.newY = obj.newY;//新的y坐标
		this.actual = obj.actual;//坐标的差值
		this.t = obj.t;//上
		this.r = obj.r;//右
		this.b = obj.b;//下
		this.l = obj.l;//左
		that = this;
		
		var moveEle = document.getElementById(this.moveArea);
		var curMove = document.getElementById(this.thisEle);
		alert(moveEle)
		moveEle.addEventListener("touchstart",function(e){
	    	var point = e.touches ? e.touches[0] : e;
	    	this.curX  = point.clientX;
	    	this.curY  = point.clientY;
	    },false)
		
		moveEle.addEventListener("touchend",function(e){
	    	var point = e.touches ? e.touches[0] : e;//是否支持 e.touches 触摸事件
	    	this.newX = point.clientX; //获取移动时的坐标
	    	this.newY  = point.clientY;
	    	this.actual = this.newX - this.curX;//移动时的坐标  一 手势按下时的坐标
	    	
	    	if(this.newX > this.curX){//向右滑动
	    		that.r = true;
	    	}else if(this.newY > this.curY){//向下滑动
	    		that.b = true;
	    	}else if(this.newX < this.curX){//向左滑动
	    		this.l = true;
	    	}else if(this.newY < this.curY){//向上滑动
	    		that.t = true;
	    	}
	    	return false;
	    	
	    },false)
		}

	var parn = new gestureEven ({
		moveArea: "main_content",//移动区域
		thisEle : "user_center",
		curWidth : 200,
		curLeft : -200,
		curX : 0,
		curY : 0,
		newX : 0,
		newY : 0,
		actual : 0,
		t : false,
		r : false,
		b : false,
		l : false
	});
	
	
	alert(parn.t)//false
















