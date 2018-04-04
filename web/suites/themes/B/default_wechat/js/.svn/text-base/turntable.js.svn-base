 
		
		
/*幸运大转盘*/		
var turnplate={
		restaraunts:[],				//大转盘奖品名称
		colors:[],					//大转盘奖品区块对应背景颜色
		img:[],                     //大转盘奖品区块对应图片
		outsideRadius:192,			//大转盘外圆的半径
		textRadius:155,				//大转盘奖品位置距离圆心的距离
		insideRadius:50,			//大转盘内圆的半径
		startAngle:0,				//开始角度
		
		bRotate:false				//false:停止;ture:旋转
};


// 图片信息
var img01 = new Image(); //小米电视
img01.src = "images/lottery/pizze_img02.png";
var img02 = new Image(); //iPhone
img02.src = "images/lottery/pizze_img01.png";
var img03 = new Image(); //酒
img03.src = "images/lottery/pizze_img03.png";

$(document).ready(function(){
	//动态添加大转盘的奖品与奖品区域背景颜色
	turnplate.restaraunts = ["谢谢参与  GOODLUCK", "80元 长安客西凤酒专属优惠券", "小米电视机", "50元 长安客西凤酒专属优惠券 ", "iPhone X ", "100元 长安客西凤酒专属优惠券 ",];
	turnplate.colors = ["#FFFFFF", "#0b0806", "#FFFFFF", "#0b0806","#FFFFFF", "#0b0806"];
	
	var rotateTimeOut = function (){
		$('#wheelcanvas').rotate({
			angle:0,
			animateTo:2160,
			duration:8000,
			callback:function (){
				alert('网络超时，请检查您的网络设置！');
			}
		});
	};

	//旋转转盘 item:奖品位置; txt：提示语;
	var rotateFn = function (item, txt){
		var angles = item * (360 / turnplate.restaraunts.length) - (360 / (turnplate.restaraunts.length*2));
		if(angles<270){
			angles = 270 - angles; 
		}else{
			angles = 360 - angles + 270;
		}
		$('#wheelcanvas').stopRotate();
		$('#wheelcanvas').rotate({
			angle:0,
			animateTo:angles+1800,
			duration:8000,
			callback:function (){
				// alert(txt);
				turnplate.bRotate = !turnplate.bRotate;
			}
		});
	};

	$('.pointer').click(function (){
		if(turnplate.bRotate)return;
		turnplate.bRotate = !turnplate.bRotate;
		
		// 次数减一
		var lottery_num = $('#lottery_num').text();
        if (lottery_num == 0) {
        	alert('您的抽奖次数已经用完，快去投票赢取更多抽奖次数吧！');
        	turnplate.bRotate = !turnplate.bRotate;
        } else{
        	lottery_num--;
		    $('#lottery_num').text(lottery_num);

		//获取随机数(奖品个数范围内)
		// var num = rnd(1,turnplate.restaraunts.length);
        // 获取随机数(1-10)
		var num = rnd(1,10);
		var item = 0;
        // 机率：谢谢参与(40%),50元(30%),80元(20%),100元(10%),小米电视机(0%),iPhone X (0%)
        if (num<5){
          item = 1;
        }else if (num>=4 && num<7){
          item = 4;
        }else if (num>=7 && num<9){
          item = 2;
        }else {
          item = 6;
        };
		//奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
		rotateFn(item, turnplate.restaraunts[item-1]);
		console.log(item);
		    switch (item) {
			case 1:
				// rotateFn(252, turnplate.restaraunts[0]);
				setTimeout(function(){
					$('.lottery_ball').show();
					$('.lottery_pizee_no').show();
					$('.lottery_pizz_yes').hide();
				},8000);
				break;
			case 2:
				// rotateFn(216, turnplate.restaraunts[1]);
				setTimeout(function(){
					$('.lottery_ball').show();
					$('.lottery_pizz_yes').show();
					$('.lottery_pizee_no').hide();
					$('.lottery_ball_pizze_img').attr('src','images/lottery/pizze_80.png');
				},8000)
				break;
			case 3:
				// rotateFn(180, turnplate.restaraunts[2]);
				
				break;
			case 4:
			    // rotateFn(180, turnplate.restaraunts[3]);
				 setTimeout(function(){
					$('.lottery_ball').show();
					$('.lottery_pizz_yes').show();
					$('.lottery_pizee_no').hide();
					$('.lottery_ball_pizze_img').attr('src','images/lottery/pizze_50.png');
				},8000)
				break;
			case 5:
				// rotateFn(108, turnplate.restaraunts[4]);
				
				break;
			case 6:
				// rotateFn(72, turnplate.restaraunts[5]);
				setTimeout(function(){
					$('.lottery_ball').show();
					$('.lottery_pizz_yes').show();
					$('.lottery_pizee_no').hide();
					$('.lottery_ball_pizze_img').attr('src','images/lottery/pizze_100.png');
				},8000)
				break;
		} 
        };

	});
});

function rnd(n, m){
	var random = Math.floor(Math.random()*(m-n+1)+n);
	return random;
	
}


//页面所有元素加载完毕后执行drawRouletteWheel()方法对转盘进行渲染
window.onload=function(){
	drawRouletteWheel();
};

function drawRouletteWheel() {    
  var canvas = document.getElementById("wheelcanvas");    
  if (canvas.getContext) {
	  //根据奖品个数计算圆周角度
	  var arc = Math.PI / (turnplate.restaraunts.length/2);
	  var ctx = canvas.getContext("2d");
	  //在给定矩形内清空一个矩形
	  ctx.clearRect(0,0,422,422);
	  //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式  
	  ctx.strokeStyle = "#FFBE04";
	  //font 属性设置或返回画布上文本内容的当前字体属性
	  ctx.font = '20px  Microsoft YaHei';    
	  for(var i = 0; i < turnplate.restaraunts.length; i++) {       
		  var angle = turnplate.startAngle + i * arc;
		  ctx.fillStyle = turnplate.colors[i];
		  // ctx.drawImage = turnplate.img[i];
		  ctx.beginPath();
		  //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）    
		  ctx.arc(211, 211, turnplate.outsideRadius, angle, angle + arc, false);    
		  ctx.arc(211, 211, turnplate.insideRadius, angle + arc, angle, true);
		  ctx.stroke();  
		  ctx.fill();
		  //锁画布(为了保存之前的画布状态)
		  ctx.save();   
		  
		  //----绘制奖品开始----
		  ctx.fillStyle = "#ca9d42"; //文字颜色
		  //字体大小必须和字体类型一起设置
          // ctx.font = '15px 宋体';
		  var text = turnplate.restaraunts[i]; //获取数组的文字
		  var line_height = 21;
		  //translate方法重新映射画布上的 (0,0) 位置
		  ctx.translate(211 + Math.cos(angle + arc / 2) * turnplate.textRadius, 211 + Math.sin(angle + arc / 2) * turnplate.textRadius);
		  
		  //rotate方法旋转当前的绘图
		  ctx.rotate(angle + arc / 2 + Math.PI / 2);
		  
		  /** 下面代码根据奖品类型、奖品名称长度渲染不同效果，如字体、颜色、图片效果。(具体根据实际情况改变) **/
		  if(text.indexOf("元")>0){//元
			  var texts = text.split("元");
			  for(var j = 0; j<texts.length; j++){
				  ctx.font = j == 0?'bold 20px Microsoft YaHei':'13px Microsoft YaHei';
				  ctx.fillStyle = '#fff';
				  if(j == 0){
					  ctx.fillText(texts[j]+"元", -ctx.measureText(texts[j]+"元").width / 2, j * line_height);
				  }else{
					  ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
				  }
			  }
		  }else if(text.indexOf("元") == -1 && text.length>6){//奖品名称长度超过一定范围 
			  text = text.substring(0,6)+"||"+text.substring(6);
			  var texts = text.split("||");
			  for(var j = 0; j<texts.length; j++){
				  ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
			  }
		  }else{
			  //在画布上绘制填色的文本。文本的默认颜色是黑色
			  //measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度
			  ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
			  ctx.fillStyle = "#ccc"; //文字颜色
		  }





		  //添加对应图标
		  if(text.indexOf("小米电视机") == 0){
		  	    ctx.fillStyle = "#ca9d42!important"; 
		  	   // 注意，这里要等到img加载完成才能绘制
			  img01.onload=function(){  
				  ctx.drawImage(img01,-45,15);      
			  }; 
			  ctx.drawImage(img01,-45,15);  
		  }else if(text.indexOf("iPhone") == 0){
			  img02.onload=function(){  
				  ctx.drawImage(img02,-25,25);      
			  }; 
			  ctx.drawImage(img02,-25,25);  
		  }if(text.indexOf("元") >= 0){
			  img03.onload=function(){  
				  ctx.drawImage(img03,-25,25);      
			  }; 
			  ctx.drawImage(img03,-25,25);  
		  }
		  //把当前画布返回（调整）到上一个save()状态之前 
		  ctx.restore();
		  //----绘制奖品结束----
	  }     
  } 
}
