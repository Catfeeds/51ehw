<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=640, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="MobileOptimized" content="640">
    <base href="<?php echo base_url();?>/templates/default/game/rotate/">
    <title>MissKing-幸运轮盘抽奖</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
</head>
	<body>
	     
		<div class="game">
               <!--轮盘 开始-->
                <div class="ly-plate">
                <div class="rotate-bg"></div>
                <div class="lottery-star"><img src="images/rotate-static.png" id="lotteryBtn"></div>
                </div> <!--轮盘 结束-->   
                
        
		</div>
		<div class="game_info">
		    <div class="clearfix">
		        <h1 class="fn-left"><?php echo $money;?>元区</h1><span class="fn-right fn-18">满50人后公布结果</span>
		    </div>
		    <!--未够50人显示-->
		    <div class="game-title">第001期&nbsp;&nbsp;&nbsp;&nbsp;<span>当前参与人数 <span>1/50</span></span></div>
		    <!--未够50人显示-->
		    <!--满50人显示-->
		    <div class="game-title" style="display: none;">第001期&nbsp;&nbsp;&nbsp;&nbsp;<span>已满50人，公布结果</span></div>
		    <!--满50人显示-->
		    <div class="table">
		        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <th scope="col">序号</th>
                      <th scope="col">参与者</th>
                      <th scope="col">结果</th>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td><?php echo $this->session->userdata('user_name');?></td>
                      <td>未公布</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
             </div>
		</div>                 
	</body>
<script type="text/javascript" src="js/jQueryRotate.2.2.js"></script>
<script type="text/javascript" src="js/jquery.easing.min.js"></script>

<script>
$(function(){
	var timeOut = function(){  //超时函数
		$("#lotteryBtn").rotate({
			angle:0, 
			duration: 10000, 
			animateTo: 2160, //这里是设置请求超时后返回的角度，所以应该还是回到最原始的位置，2160是因为我要让它转6圈，就是360*6得来的
			callback:function(){
				alert('网络超时')
			}
		}); 
	}; 
	var rotateFunc = function(awards,angle,text){  //awards:奖项，angle:奖项对应的角度
		$('#lotteryBtn').stopRotate();
		$("#lotteryBtn").rotate({
			angle:0, 
			duration: 5000, 
			animateTo: angle+1440, //angle是图片上各奖项对应的角度，1440是我要让指针旋转4圈。所以最后的结束的角度就是这样子^^
			callback:function(){
				alert(text)
			}
		}); 
	};
	
	$("#lotteryBtn").rotate({ 
	   bind: 
		 { 
			click: function(){
				var time = [0,1];
					time = time[Math.floor(Math.random()*time.length)];
				if(time==0){
					timeOut(); //网络超时
				}
				if(time==1){
					var data = [1,2,3,0]; //返回的数组
						data = data[Math.floor(Math.random()*data.length)];
					if(data==1){
						rotateFunc(1,157,'恭喜您抽中的一等奖')
					}
					if(data==2){
						rotateFunc(2,247,'恭喜您抽中的二等奖')
					}
					if(data==3){
						rotateFunc(3,22,'恭喜您抽中的三等奖')
					}
					if(data==0){
						var angle = [67,112,202,292,337];
							angle = angle[Math.floor(Math.random()*angle.length)]
						rotateFunc(0,angle,'很遗憾，这次您未抽中奖')
					}
				}
			}
		 } 
	   
	});
	
})
</script>
</html>