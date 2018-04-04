<!DOCTYPE html>
<html>
<head>
    <title>VIP</title>
    <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
    <base href="<?php echo THEMEURL; ?>" />
    <link href="css/base.css" rel="stylesheet" type="text/css"/>
    <link href="css/public.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="css/cat.css" rel="stylesheet" type="text/css"/>
    <link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
    <script type="text/javascript" src="js/jquery-1.8.2.min.js" ></script>
    <script type="text/javascript" src="js/Jdropdown.js"></script>
</head>
<body>
<?php $this->load->view('_header');?>
<!-- head-top E -->
<!--bd-top E--->
    <div class="ui-bd m-top10">
        <div class="w980 fn-clear">
            <div class="ui-left-cat fn-left">
                <div class="ui-cat-title"><h3>选酒中心</h3></div>
<div class="ui-cat-nav">
<?php $this->load->view('goods/filter');?>

</div>
                </div>
            <!--JS banner-->
            <div class="ui-vip-banner fn-right">
                <ul>
                   <?php if($ad_top && count($ad_top)>0){
                   		$ad = $ad_top[0];
                   	?>
		          	<li><a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?>><img src="<?php echo IMAGE_URL.$ad['img_url'];?>" /></a></li>
		          <?php } ?>
                </ul>
            </div>
            <!--JS banner-->
        </div>
        <div class="ui-bd w980">
            <div class="ui-goods m-top10">
                <div class="ui-goods-filter">
				<form name="vipsearch" method="post" action="<?php echo site_url('goods/vip')?>">
                    <div class="ui-filter-title fn-left">商品筛选</div>
                    <div class="ui-category fn-left">
					<input type="hidden" name="attr" value="<?php echo $catestr;?>">
					<input type="hidden" name="order" value="<?php echo $order;?>">
					<input type="hidden" name="page" value="<?php echo $page?>">
					  <label>商品</label>
                        <select name="cate" onchange="javascript:vipsearch.submit()">
							<option value="">请选择</option>
							<?php if($mainCate){
								foreach($mainCate as $mc){
								?>
								<option value="<?php echo $mc["id"];?>" <?php if($default_maincateid && $default_maincateid == $mc["id"]){echo "selected";}?>><?php echo $mc["name"];?></option>
							<?php }}?>
                        </select>
					  <?php if($cate && $cateList){
						  foreach($cate as $c)
							{

						  ?>
						<label><?php echo $c["cate_name_show"]?></label>
                        <select name="a_<?php echo $c['cate_id']?>" onchange="click_condition()">
                            <option value="">请选择</option>
							 <?php if($cateList[$c["cate_id"]]){
								foreach($cateList[$c["cate_id"]] as $v)
							  {
							  ?>
							 <option value="<?php echo $v["sign_id"]?>" <?php if($default_attr && array_key_exists($c["cate_id"],$default_attr) && $default_attr[$c["cate_id"]] == $v["sign_id"]){echo "selected";}?>><?php echo $v["sign_name"]?></option>
							 <?php }}?>
                        </select>
					  <?php }}?>
                        
                    </div>
                </div>
                <div class="ui-filter-section fn-clear">
                    <div class="fn-left ui-search-reorder">
                        <h3>排序方式：</h3>
                        <div class="ui-search-turn fn-left">
                            <a href="javascript:click_Orderby('onsale_down')" title="默认" class="active">默认</a>
                            <a href="javascript:click_Orderby('order')" title="人气" >人气</a>
                            <a href="javascript:click_Orderby('price_up')" title="价格">价格</a>
                            <a href="javascript:click_Orderby('onsale_up')" title="上架时间" >上架时间</a>
                        </div>
                    </div>
                    <div class="fn-right ui-search-page">
                        <span class="fn-left">共有<?php echo $totalcount;?>件商品<?php echo $page;?>/<?php echo $totalpage?></span>
                        <?php if($totalpage>1){?>
                        <a href="javascript:prePage()" title="上一页" class="prev none">上一页</a><a href="javascript:nextPage()" title="下一页" class="next">下一页</a>
                    	<?php }?>
                    </div>
                </div>
				</form>
                <div class="ui-goods-list fn-clear m-top10">
                    <!--触发事件 li添加good-hover--->
                    <ul class="fn-clear">
                    	<?php
                    	 if($productList){
                    		foreach($productList as $v){
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
                                     <a href="<?php echo site_url('goods/detail/'.$v['id']);?>"><?php echo $v['name'];?></a>
                                </div>
                            </div>
                             <div class="ui-goods-but"><a href="<?php echo site_url('cart/add/'.$v['id']);?>" title="立即购买"></a> </div>
                        </li>
                       <?php }}?>
                    </ul>
                    <!--触发事件 li添加good-hover E--->
                </div>
                <div class="ui-page">
                	 <?php echo $pagination;?>
                </div>
            </div>
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

										//print_r($h);
										?>
									 
									 <li class="ui-history-list">
										<div class="list-pic"><a href="<?php echo site_url('goods/detail/'.$h['id']);?>"><img src="<?php echo IMAGE_URL.'uploads/'.$h['goods_thumb']?>"></a></div>
										<div class="list-info"><?php echo $h['name'];?></div>
										<div class="list-price">¥<?php echo $h['price'];?></div>
										<div class="list-but">
											<a style="cursor: pointer;" onclick="add_cart(<?php echo $h['id'];?>,1)" title="加入购物车" class="history-but fn-left">加入购物车</a><a href="<?php echo site_url('cart/add/'.$h['id']);?>" title="立即购买" class="history-but fn-right">立即购买</a> 
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

var parameterHover = function(){
	$(".ui-goods-list li").hover(function(){
		$(this).addClass("hover").siblings().removeClass("hover");
	},function(){
		$(this).removeClass("hover");
	})
} 
parameterHover();
//我的账号、购物车触发效果
(function(a){
	a.fn.hoverClass=function(b){
		var a=this;
		a.each(function(c){
			a.eq(c).hover(function(){
				$(this).addClass(b)
			},function(){
				$(this).removeClass(b)
			})
		});
		return a
	};
})(jQuery);
$(function(){
	$(".navbox").hoverClass("current");
});
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
function click_Orderby(val)
{

	document.vipsearch.order.value=val;
	
	document.vipsearch.page.value = "1";

	document.vipsearch.submit();
}

function click_condition()
{
	document.vipsearch.page.value = 1;
	document.vipsearch.submit();
}

function prePage()
{
	<?php if($page >1){?>
		document.vipsearch.page.value = document.vipsearch.page.value-1;
		document.vipsearch.action="<?php echo site_url('goods/vip')?>";
		document.vipsearch.submit();
	<?php }?>
}

function nextPage()
{
	
	<?php if($page < $totalpage){?>
	document.vipsearch.page.value = Number(document.vipsearch.page.value)+1;
	document.vipsearch.action="<?php echo  site_url('goods/vip')?>";
    document.vipsearch.submit();
    <?php }?>
	
}
</script> 
</html>