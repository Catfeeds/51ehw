$(function() {
	var _length = $(".integral_title li").length;  //导航栏长度(个数)
	$(".integral_title li").css("width", (100 / _length) + "%"); //每一个li的宽度％

	var deviceWidth = document.documentElement.clientWidth; //获取浏览器窗口文档显示区域的宽度，不包括滚动条
	if(deviceWidth > 750) {
		deviceWidth = 750;
	}
	document.documentElement.style.fontSize = deviceWidth / 7.5 + 'px'; //rem响应式布局

	//设置父节点的高度
	var child_height = $("dl.viewport dd").eq(0).css("height");
	$(".viewport").css("height",child_height);  //ul的高度等于li的高度
	
	//手势滑动 数组
	var touches = {
        startX: 0,
        startY: 0,
        endX: 0,
        endY: 0,
        moveLength: 0,//从 startX 到 endX 的长度
        lastMoveLength: 0, // 上一次的移动长度
        baseLength: document.documentElement.clientWidth
    };


	var sliderBody = $(".viewport")[0];
	var baseSlide = sliderBody.getElementsByTagName('dd');
	sliderBody.style.width = baseSlide.length * touches.baseLength + "px";  //ul总宽度

	for(var i = 0; i < baseSlide.length; i++) {
		baseSlide[i].style.width = touches.baseLength + 'px'; //每个li的宽度等于浏览器窗口文档显示区域的宽度
		baseSlide[i].style.left = i * touches.baseLength + 'px';  
	}
	sliderBody.addEventListener('touchstart', onTouchStart, false); //增加触摸监听事件

    //触摸监听事件
    function onTouchStart(e) {
        if (e.touches.length == 1) {  //一点触控
            touches.startX = e.touches[0].pageX;  //按下鼠标指针当前坐标的x轴位置
            touches.startY = e.touches[0].pageY;  //按下鼠标指针当前坐标的y轴位置
            sliderBody.addEventListener('touchmove', onTouchMove, false);  //增加移动监听事件
        }
    }
     
    //移动监听事件 
    function onTouchMove(e) {
        touches.endX = e.touches[0].pageX;
        touches.endY = e.touches[0].pageY;
        sliderBody.addEventListener('touchend', onTouchEnd, false);  //增加结束监听事件
        touches.moveLength = touches.startX - touches.endX;  //返回的可能是负数也可能是整数(左右滑动结果不一样)
        sliderBody.style.transform = "translate3d(" + (touches.moveLength * -0.1 + touches.lastMoveLength) + "px,0,0)"; //定义3D转换
    }
    
    //结束监听事件
    function onTouchEnd(e) {
        sliderBody.removeEventListener('touchmove', onTouchMove);   //删除移动事件 
        sliderBody.removeEventListener('touchend', onTouchEnd);   //删除结束事件

        if (Math.abs(touches.moveLength) > touches.baseLength / 10) {   //Math.abs()返回数的绝对值 
            //向右边滑动
            if (touches.moveLength < 0) {  
                if (touches.lastMoveLength == 0) {
                    sliderBody.style.transform = "translate3d(0,0,0)";
                } else {
                    touches.lastMoveLength += touches.baseLength;
                    sliderBody.style.transform = "translate3d(" + touches.lastMoveLength + "px,0,0)";
                    reset(touches.lastMoveLength); 
                }
            } else {//向左边滑动
                if (Math.abs(touches.lastMoveLength) == (baseSlide.length - 1) * touches.baseLength) {
                    sliderBody.style.transform = "translate3d(" + touches.lastMoveLength + "px,0,0)";
                } else {
                    touches.lastMoveLength += touches.baseLength * -1;
                    sliderBody.style.transform = "translate3d(" + touches.lastMoveLength + "px,0,0)";
                    reset(touches.lastMoveLength);
                }
            }
        } else {
            sliderBody.style.transform = "translate3d(" + touches.lastMoveLength + "px,0,0)";
        }
    }
    
  
    //改变导航栏li的active属性和高度
    function reset(len){
		var index = Math.abs(len) / touches.baseLength;
		if(index === 3){
			$(".integral_title li").find("em:last-child").css("bottom", "0.27rem");
		}else{
			$(".integral_title li").find("em:last-child").css("bottom", "0.31rem");
		}
		var _height = $("dl.viewport").find("dd").eq(index).height();
		$(".viewport").find("dd").eq(index).addClass("active").siblings("dd").removeClass("active");
		$("dl.viewport").css("height", _height + "px");
		$(".shijia").css("height",_height + "px");
	}
    
	//点击切换tab
	var rank_num = 0;
	$(".integral_title").on("click", "li", function() {
		$(this).addClass("active").siblings("dd").removeClass("active");
		console.log(rank_num);
		if($(this).index() === 3) {
			if(rank_num % 2 === 0) {  //偶数取余为0
				$(this).find("em:last-child").addClass("add_color").siblings("em").removeClass("add_color");
				//降序方法  
				$("div.shop:last-child").jSort({
					sort_by: "span.shop-goods-monery font",  //指向item内需要排序的元素，默认为p
					is_num: "true",  //是否按按数字大小排序，默认是false
					item: "a",  //指向需要排序的html内容元素，默认为div
					order: "desc"  //排序方式，asc-顺序，desc-倒序，默认为asc
				});
			} else {
				$(this).find("em:first-child").addClass("add_color").siblings("em").removeClass("add_color");
				//升序方法  
				$("div.shop:last-child").jSort({
					sort_by: "span.shop-goods-monery font",
					is_num: "true",
					item: "a",
					order: "asc"
				});
			}
			$(this).find("em:last-child").css("bottom", "0.27rem");
			rank_num++;
		} else {
			rank_num = 0;
			$(this).siblings("dd").find("em:last-child").css("bottom", "0.31rem");
		}

		touches.lastMoveLength = (-1) * ($(this).index()) * touches.baseLength; //左偏移距离
		var _height = $("dl.viewport").find("dd").eq($(this).index()).height(); //根据当前显示的子节点高度改变夫节点高度
		$("dl.viewport;").css({
			"transform": "translate3d(" + touches.lastMoveLength + "px,0,0)",
			"height": _height + "px"
		});
		$(".shijia").css("height",_height + "px");
	});
});




(function($){
   $.fn.jSort = function(options){
	   
	var options = $.extend({
		sort_by: 'p',
		item: 'div',
		order: 'asc', //desc
		is_num: false,
		sort_by_attr: false,
		attr_name: ''
	},options);

	return this.each(function() {            
		var hndl = this;
		var titles = [];
		var i = 0;
		
		//init titles
		$(this).find(options.item).each(function(){
		
			var txt;
			var sort_by = $(this).find(options.sort_by);
			
			if(options.sort_by_attr){
				txt = sort_by.attr(options.attr_name).toLowerCase();	
			}
			else{
				txt = sort_by.text().toLowerCase();	
			}
						
			titles.push([txt, i]);
			
			$(this).attr("rel", "sort" + i);			
			i++;
		});
		
		this.sortNum = function(a, b){			
			return eval(a[0] -  b[0]);
		};
		
		this.sortABC = function(a, b){			
			return a[0] > b[0] ? 1 : -1;
		};
		
		if(options.is_num){
			titles.sort(hndl.sortNum);
		}
		else{
			titles.sort(hndl.sortABC);
		}	
		
		if(options.order == "desc"){
			if(options.is_num){
				titles.reverse(hndl.sortNum);
			}
			else{				
				titles.reverse(hndl.sortABC);
			}				
		}
		
		for (var t=0; t < titles.length; t++){
			var el = $(hndl).find(options.item + "[rel='sort" + titles[t][1] + "']");
			$(hndl).append(el);
		}
		
	});    
   };
})(jQuery);