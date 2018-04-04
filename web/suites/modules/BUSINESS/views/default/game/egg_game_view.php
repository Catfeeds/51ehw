<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<base href="<?php echo base_url(); ?>" />
<meta name="keywords" content="砸金蛋" />
<meta name="description" content="砸金蛋" />
<title>砸金蛋</title>
<style type="text/css">
/* reset for html5 css3*/        body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,button,textarea,p,blockquote,th,td,section,article,aside,header,footer,nav,dialog,figure,hgroup{margin:0;padding:0;}
        table {border-collapse:collapse;border-spacing:0}
        h1,h2,h3,h4,h5,h6{font-size:100%;}
        ul,ol,li{list-style:none}
        em,i{font-style:normal}
        img{border:0;}
        input,img{vertical-align:middle;}
        input:focus{outline:none;}
        a{color:#444;text-decoration:none;}
        *{-webkit-tap-highlight-color: rgba(0,0,0,0);}       
    
.body{max-width: 640px;
  margin: auto;
  min-height: 100%;}    
.egg {
  width: 100%;
  -webkit-perspective: 800;
  -webkit-perspective-origin: 50% 200px;
  position: relative;
}}
.egg ul li{z-index:999;}
.u-egg{margin: auto;
  position: absolute;
  left: 32%;
  bottom: 20%;
  z-index: 100;}
.eggList li{float:left;background:url('images/egg_1.png') no-repeat bottom;width:158px;height:187px;cursor:pointer;position:relative;-webkit-background-size: 70% auto;}
.eggList li span{position:absolute; width:30px; height:60px; left:68px; top:64px; color:#ff0; font-size:42px; font-weight:bold;display:none;}
.eggList li.curr{background:url('images/egg_2.png') no-repeat bottom;cursor:default;z-index:300;-webkit-background-size: 70% auto;}
.eggList li.curr sup{position:absolute;background:url(images/img-4.png) no-repeat;width:232px; height:181px;top:-36px;left:-34px;z-index:800;}
.hammer{background:url(images/img-6.png) no-repeat;width:74px;height:87px;position:absolute; text-indent:-9999px;z-index:150;left:168px;top:100px;}
.resultTip{position:absolute; background:#ffc ;width:148px;padding:6px;z-index:500;top:200px; left:10px; color:#f60; text-align:center;overflow:hidden;display:none;z-index:500; }
.resultTip b{font-size:14px;line-height:24px;}
.egg>img {
  width: 100%;
  max-height: 700px;
  pointer-events: none;}
</style>
</head>

<body>
<div id="main" class="body">
	<div class="egg">
	<img src="images/stage.jpg">
	    <div class="u-egg">
		    <ul class="eggList">
			<p class="hammer" id="hammer">锤子</p>
			<p class="resultTip" id="resultTip"><b id="result"></b></p>
			<li><span>1</span><sup></sup></li>
			<!--<li><span>2</span><sup></sup></li>
			<li><span>3</span><sup></sup></li>-->
		</ul>
    </div>
		
	</div>
</div>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
function eggClick(obj) {
	var _this = obj;
	$.getJSON("<?php echo site_url('game/game/egg_data');?>",function(res){
		if(_this.hasClass("curr")){
			alert("蛋都碎了，别砸了！");
			return false;
		}
		//_this.unbind('click');
		$(".hammer").css({"top":_this.position().top-55,"left":_this.position().left+185});
		$(".hammer").animate({
			"top":_this.position().top-25,
			"left":_this.position().left+125
			},30,function(){
				_this.addClass("curr"); //蛋碎效果
				_this.find("sup").show(); //金花四溅
				$(".hammer").hide();
				$('.resultTip').css({display:'block',top:'100px',left:_this.position().left,opacity:0}).animate({top: '0',opacity:1},300,function(){
					if(res.msg==1){
						$("#result").html("恭喜，您中得"+res.prize+"!");
					}else{
						$("#result").html("很遗憾,您没能中奖!");
					}
				});	
			}
		);
	});
}


$(".eggList li").click(function() {
	$(this).children("span").hide();
	eggClick($(this));
});

$(".eggList li").hover(function() {
	var posL = $(this).position().left + $(this).width();
	$("#hammer").show().css('left', posL);
})
</script>
</body>
</html>
