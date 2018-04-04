<!DOCTYPE html>
<html>
<head>
    <title>滋补养身</title>
    <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
    <base href="<?php echo THEMEURL; ?>" />
    <link href="css/base.css" rel="stylesheet" type="text/css"/>
    <link href="css/public.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="css/cat.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/Jdropdown.js"></script>
    <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
</head>
<body>
<?php $this->load->view('_header');?>

<!--bd-top E--->
<div class="ui-bd m-top10">
<div class="w980 fn-clear">
<div class="ui-left-cat fn-left">
<div class="ui-cat-title"><h3>滋补养身</h3></div>
<div class="ui-cat-nav">
<?php $this->load->view('goods/filter');?>
</div>
</div>
<!--JS banner-->
<div class="ui-wines-banner fn-left">
      <div class="flexslider">
          <ul class="slides">
          <?php foreach($ad_top as $ad):?>
            	<li>
  	    	    	<img src="<?php echo IMAGE_URL.$ad["img_url"]?>" />
  	    		</li>
		<?php endforeach;?>		
          </ul>
        </div>
</div>
<ul class="ui-shop-hot fn-right">
	<?php foreach ($list_hot as $k=>$v):?>
    <li class="<?php if($k>0) echo "m-top10";?>">
        <i class="hot"></i>
        <a href="<?php echo site_url('goods/detail/'.$v['id']);?>" target="_blank" title="">
            <img src="<?php echo IMAGE_URL.'uploads/'.$v['goods_thumb'];?>">
        </a>
    </li>
    <?php endforeach;?>
</ul>
<!--JS banner-->
</div>

<?php if($cateList != null && count($cateList)>0){
	foreach($cateList as $cate)
	{
	?>
	<div class="ui-bd w980 m-top10">
    <div class="ui-main-wine ">
        <div class="ui-wine-title">
            <h3><?php echo $cate["sign_name"];?></h3>
            <div class="fn-right ui-title-right">
                <!--<a href="<?php echo site_url('goods/lists');?>">红葡萄酒</a>
                <a href="<?php echo site_url('goods/lists');?>">红葡萄酒</a>-->
                <a href="<?php echo site_url('goods/lists?cate=419&a_'.$cate["cate_id"]."=".$cate["sign_id"]);?>" title="" class="whole">全部</a>
            </div>
        </div>
        <div class="ui-pic-banner fn-left">
			<?php
				$adimg ="images/img/t1.jpg";
				foreach($adList as $v){
					if (strpos($v['po_sign'],$cate["sign_name"])>0)
					{
						$adimg  = $v["img_url"];
					}
				}
			?>
            <img src="<?php echo IMAGE_URL.$adimg;?>">
        </div>

        <div class="ui-goods-list m-top10 fn-clear">
           <!--触发事件 li添加good-hover--->
                    <ul class="fn-clear">
					<?php
						$pL = $productList[$cate["sign_id"]];
						foreach($pL as $v){
						if($v != null){
						
						?>
                        <li class="good-hover">
                            <div class="ui-goods-pic">
                                <a href="<?php echo site_url('goods/detail/'.$v['id']);?>"><img src="<?php echo IMAGE_URL.'uploads/'.$v['goods_thumb'];?>"></a>
                            </div>
                            <div class="ui-goods-info">
                                <div class="ui-goods-price">
                                     <b>¥<?php echo $v['price'];?></b><s>¥<?php echo $v['market_price'];?></s>
                                </div>
                                <div class="ui-goods-message">
                                   <a href="<?php echo site_url('cart/add/'.$v['id']);?>"><?php echo $v['name'];?></a>
                                </div>
                            </div>
                            <div class="ui-goods-but"><a href="<?php echo site_url('cart/add/'.$v['id']);?>" title="立即购买"></a> </div>
                        </li>
						<?php }}?>
                       
            </ul>
        </div>
    </div>
</div>
<?php }}?>

<div class="ui-bd w980">
    <!--浏览记录JS S-->
            <div class="ui-history m-top10">
                <div class="ui-history-title"><h3>浏览记录</h3></div>
                <div class="ui-history-bd fn-clear">
                    <div class="con"> 
							<div id="carousel_container"> 
								<div id="left_scroll"></div> 
								<div id="carousel_inner"> 
								<ul id="carousel_ul" class="list-bgline"> 
									<?php if($viewhistory){
						
										foreach($viewhistory as $h)
										{

										
										?>
									 
									 <li class="ui-history-list">
										<div class="list-pic"><a href="<?php echo site_url('goods/detail/'.$h['id']);?>"><img src="<?php echo IMAGE_URL.'uploads/'.$h['goods_thumb'];?>"></a></div>
										<div class="list-info"><?php echo $h['name'];?></div>
										<div class="list-price">¥<?php echo $h['price'];?></div>
										<div class="list-but">
											<a href="<?php echo site_url('cart/add/'.$h['id']);?>" title="加入购物车" class="history-but fn-left">加入购物车</a><a href="<?php echo site_url('cart/add/'.$h['id']);?>" title="立即购买" class="history-but fn-right">立即购买</a> 
										</div>
									</li>
									<?php }}?>
									
								</ul> 
								</div> 
								<div id="right_scroll"></div> 
							</div> 
						</div> 


                    </div>
                </div>	
            <!--浏览记录JS e-->
</div>
</div>
<!--bd-top S--->
<?php $this->load->view('_footer');?>
</body>
<script>
//产品焦点图
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide"
  });
});	
var parameterHover = function(){
	$(".ui-goods-list li").hover(function(){
		$(this).addClass("hover").siblings().removeClass("hover");
	},function(){
		$(this).removeClass("hover");
	})
} 
parameterHover();

</script>
<script type="text/javascript"> 
//浏览记录
<!-- 
var SellerScroll = function(options){ 
this.SetOptions(options); 
this.lButton = this.options.lButton; 
this.rButton = this.options.rButton; 
this.oList = this.options.oList; 
this.showSum = this.options.showSum; 

this.iList = $("#" + this.options.oList + " > li"); 
this.iListSum = this.iList.length; 
this.iListWidth = this.iList.outerWidth(true); 
this.moveWidth = this.iListWidth * this.showSum; 

this.dividers = Math.ceil(this.iListSum / this.showSum);
this.moveMaxOffset = (this.dividers - 1) * this.moveWidth; 
this.LeftScroll(); 
this.RightScroll(); 
}; 
SellerScroll.prototype = { 
SetOptions: function(options){ 
this.options = { 
lButton: "left_scroll", 
rButton: "right_scroll", 
oList: "carousel_ul", 
showSum: 4
}; 
$.extend(this.options, options || {}); 
}, 
ReturnLeft: function(){ 
return isNaN(parseInt($("#" + this.oList).css("left"))) ? 0 : parseInt($("#" + this.oList).css("left")); 
}, 
LeftScroll: function(){ 
if(this.dividers == 1) return; 
var _this = this, currentOffset; 
$("#" + this.lButton).click(function(){ 
currentOffset = _this.ReturnLeft(); 
if(currentOffset == 0){ 
for(var i = 1; i <= _this.showSum; i++){ 
$(_this.iList[_this.iListSum - i]).prependTo($("#" + _this.oList)); 
} 
$("#" + _this.oList).css({ left: -_this.moveWidth }); 
$("#" + _this.oList + ":not(:animated)").animate( { left: "+=" + _this.moveWidth }, { duration: "slow", complete: function(){ 
for(var j = _this.showSum + 1; j <= _this.iListSum; j++){ 
$(_this.iList[_this.iListSum - j]).prependTo($("#" + _this.oList)); 
} 
$("#" + _this.oList).css({ left: -_this.moveWidth * (_this.dividers - 1) }); 
} } ); 
}else{ 
$("#" + _this.oList + ":not(:animated)").animate( { left: "+=" + _this.moveWidth }, "slow" ); 
} 
}); 
}, 
RightScroll: function(){ 
if(this.dividers == 1) return; 
var _this = this, currentOffset; 
$("#" + this.rButton).click(function(){ 
currentOffset = _this.ReturnLeft(); 
if(Math.abs(currentOffset) >= _this.moveMaxOffset){ 
for(var i = 0; i < _this.showSum; i++){ 
$(_this.iList[i]).appendTo($("#" + _this.oList)); 
} 
$("#" + _this.oList).css({ left: -_this.moveWidth * (_this.dividers - 2) }); 

$("#" + _this.oList + ":not(:animated)").animate( { left: "-=" + _this.moveWidth }, { duration: "slow", complete: function(){ 
for(var j = _this.showSum; j < _this.iListSum; j++){ 
$(_this.iList[j]).appendTo($("#" + _this.oList)); 
} 
$("#" + _this.oList).css({ left: 0 }); 
} } ); 
}else{ 
$("#" + _this.oList + ":not(:animated)").animate( { left: "-=" + _this.moveWidth }, "slow" ); 
} 
}); 
} 
}; 
$(document).ready(function(){ 
var ff = new SellerScroll(); 
}); 
//--> 
</script> 
</html>