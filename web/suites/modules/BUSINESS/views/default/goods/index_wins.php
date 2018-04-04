<!DOCTYPE html>
<html>
<head>
<title>名酒品鉴</title>
<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
<base href="<?php echo THEMEURL; ?>" />
<link href="css/base.css" rel="stylesheet" type="text/css"/>
<link href="css/public.css" rel="stylesheet" type="text/css"/>
<link href="css/layout.css" rel="stylesheet" type="text/css"/>
<link href="css/cat.css" rel="stylesheet" type="text/css"/>
<link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/Jdropdown.js"></script>
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="js/ranking.js"></script>
<script type="text/javascript">
//广告效果
$(function(){
	$(".floor-maskItem").mouseover(function(){
		$(this).addClass("maskItem").parent().addClass("hover");
	}).mouseout(function(){
		$(this).removeClass("maskItem").parent().removeClass("hover");
	});
})
</script>
</head>
<body>
<?php $this->load->view('_header');?>
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
<div class="ui-wines-banner fn-left">
      <div class="flexslider">
          <ul class="slides">
          <?php foreach($ad_top as $ad):?>
          	<li><a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?>><img src="<?php echo IMAGE_URL.$ad['img_url'];?>" /></a></li>
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
<div class="ui-bd w980 m-top10">
<div class="ui-main-wine ">
<div class="ui-wine-title">
    <h3>葡萄酒</h3>

    <div class="fn-right ui-title-right">
          <?php foreach($list_type_wine as $key=>$val){
				if($key>8)
				{
					break;
				}
				?>
        <a href="<?php echo site_url('goods/lists?cate='.$wineid.'&a_'.$val["cate_id"]."=".$val["sign_id"]);?>"><?php echo $val["sign_name"]?></a>
		<?php  }?>
        <a href="<?php echo site_url('goods/lists?cate='.$wineid);?>" title="" class="whole">全部</a>
    </div>
</div>
<div class="ui-section-box fn-clear">
    <div class="ui-section-left fn-left">
        <ul>
        <?php foreach($ad_ptj_left as $ad):?>
          <li><a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?>><img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/> </a> </li>
          <?php endforeach;?>
        </ul>
    </div>
    <div class="boxpic">
    	<?php foreach($ad_ptj_midle as $ad):?>
          	<a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?> target="_blank" title="#" class="floor-maskItem" style="left:0;top:0;">
         		<img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/>
         		<div class="mask" style="width:540px; height:250px"></div>
         	</a>
        <?php endforeach;?>
        <?php foreach($ad_ptj_right as $k=>$ad):?>
          	<a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?> target="_blank"  class="floor-maskItem" style="left:540px;<?php echo $k?'top:125px':'top:0';?>;">
            	<img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/>
            	<div class="mask"></div>
        	</a>
          <?php endforeach;?> 
    </div>
</div>
<div class="ui-goods-list m-top10 fn-clear">
    <ul>
    <?php foreach ($list_goods_wine as $k=>$v):?>
        <li>
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
	<?php endforeach;?>        
    </ul>
</div>
</div>
<div class="ui-main-wine ">
<div class="ui-wine-title">
    <h3>洋酒</h3>

    <div class="fn-right ui-title-right">
	    <?php foreach($list_type_spirit as $key=>$val){
			if($key>8)
				{
					break;
				}
			?>
        <a href="<?php echo site_url('goods/lists?cate='.$spiritid.'&a_'.$val["cate_id"]."=".$val["sign_id"]);?>"><?php echo $val["sign_name"]?></a>
		<?php  }?>
        <a href="<?php echo site_url('goods/lists?cate='.$spiritid);?>" title="" class="whole">全部</a>
    </div>
</div>
<div class="ui-section-box fn-clear">
    <div class="ui-section-left fn-left">
        <ul>
        <?php foreach($ad_yj_left as $ad):?>
          	<li>
                <a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?>><img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/> </a>
            </li>
          <?php endforeach;?>
        </ul>
    </div>
    <div class="boxpic">
    	<?php foreach($ad_yj_midle as $ad):?>
          <a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?> target="_blank" title="#" class="floor-maskItem" style="left:0;top:0;">
         <img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/>
         <div class="mask" style="width:540px; height:250px"></div>
         </a>
          <?php endforeach;?>
        
         <?php foreach($ad_yj_right as $k=>$ad):?>
          <a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?> target="_blank" title="#" class="floor-maskItem" style="left:540px;<?php echo $k?'top:125px':'top:0';?>;">
            <img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/>
            <div class="mask"></div>
        	</a>
          <?php endforeach;?>
    </div>
</div>
<div class="ui-goods-list m-top10 fn-clear">
<?//php print_r($list_goods_spirit)?>
    <ul>
    <?php foreach ($list_goods_spirit as $k=>$v):?>
        <li>
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
	<?php endforeach;?>
    </ul>
</div>
</div>
<div class="ui-main-wine ">
    <div class="ui-wine-title">
        <h3>白酒</h3>
        <div class="fn-right ui-title-right">
            <?php foreach($list_type_chinesexo as $key=>$val){
				if($key>8)
				{
					break;
				}
				?>
        <a href="<?php echo site_url('goods/lists?cate='.$chinesexoid.'&a_'.$val["cate_id"]."=".$val["sign_id"]);?>"><?php echo $val["sign_name"]?></a>
		<?php  }?>
            <a href="<?php echo site_url('goods/lists?cate='.$chinesexoid);?>" title="" class="whole">全部</a>
        </div>
    </div>
    <div class="ui-section-box fn-clear">
        <div class="ui-section-left fn-left">
            <ul>
          <?php foreach($ad_bj_left as $ad):?>
          	<li>
            	<a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?>><img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/> </a>
          	</li>
          <?php endforeach;?>
            </ul>
        </div>
        <div class="boxpic">
	    	<?php foreach($ad_bj_midle as $ad):?>
	          	<a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?> target="_blank" title="#" class="floor-maskItem" style="left:0;top:0;">
	         		<img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/>
	         		<div class="mask" style="width:540px; height:250px"></div>
	         	</a>
	        <?php endforeach;?>
	        <?php foreach($ad_bj_right as $k=>$ad):?>
	          	<a <?php echo $ad['url']?'href="'.$ad['url'].'"':'';?> target="_blank"  class="floor-maskItem" style="left:540px;<?php echo $k?'top:125px':'top:0';?>;">
	            	<img src="<?php echo IMAGE_URL.$ad['img_url'];?>"/>
	            	<div class="mask"></div>
	        	</a>
	         <?php endforeach;?> 
    	</div>
    </div>
	
	<div class="ui-goods-list m-top10 fn-clear">
    <ul>
    <?php foreach ($list_goods_chinesexo as $k=>$v):?>
        <li>
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
	<?php endforeach;?>
    </ul>
</div>
</div>
</div>
</div>
</div>
<!--bd-top S--->
<?php $this->load->view('_footer');?>
</body>
<script>
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

</html>