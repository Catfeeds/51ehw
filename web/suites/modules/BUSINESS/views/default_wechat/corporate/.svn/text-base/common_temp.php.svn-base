
<!-- 商家信息 开始 -->
<div class="shop-information">
	<!-- 商家信息 头部 -->
	<div class="shop-information-header">
		<ul>
		    <li class="shop-information-tu"><img src="<?php echo isset($corporation['img_url'])&&$corporation['img_url']!=''?IMAGE_URL.$corporation['img_url']:'images/preterm_logo.png' ?>"
		     	height="70" width="70" alt="" onerror="this.src='images/default_img_s.jpg'"></li>
		    <li class="shop-information-test">
		    	<span class="shop-title"><?php echo isset($corporation['corporation_name'])?$corporation['corporation_name']:"" ?></span><br>
		    	<span class="shop-num">店铺号：<?php echo isset($corporation['id'])?$corporation['id']:"0" ?></span><br>
		    	<span class="shop-huiyuan"><?php echo $corporation["gradeshow"]?></span>
		    </li>
		</ul>
		<div class="shop-all-remove">
			<a href="<?php echo site_url("home/GetShopGoods/".$corporation['id']);?>" class="shop-all"><span class="icon-wangdianhao shop-wangdianhao"></span>全部商品</a>
			<a href="javascript:void(0);" onclick=fav_corporation(<?php echo isset($corporation['id'])?$corporation['id']:"0" ?>) class="shop-remove"><span class="icon-like shop-like"></span><span class="shop-guanzhi-text">已关注</span></a>
		</div>
	</div>

	<!-- 间隔线 -->
	<div class="shop-information-line"></div>

	<!-- 信誉信息 开始 -->
	<div class="shop-prestige">
		<div class="shop-prestige-title">
			<span class="shop-information-left">信誉信息</span>
		</div>
		<ul>
		    <li class="shop-information-left">供应等级: 
		    <!-- <span class="icon-zuanshi shop-zuanshi"></span><span class="icon-zuanshi shop-zuanshi"></span> -->
		    <?php for($i=0;$i<$corp_amount['img_amount'];$i++){ ?>
		    <img alt="" src="<?php echo THEMEURL.$corp_amount['img_url'];?>" id="vendor-grade">
		    <?php } ?>
		    </li>
		    <li class="shop-information-left">交易勋章: 
		    <!-- <span class="icon-xunzhang01 shop-xunzhang"></span> -->
		    <?php for($i=0;$i<$month_amount['img_amount'];$i++){ ?>
		    <img alt="" src="<?php echo THEMEURL.$month_amount['img_url'];?>" id="vendor-grade">
		    <?php } ?></li>
		    <li class="shop-information-left"><p>会员背书:
		    <?php if($recommend != null && count($recommend)>0){?>
		    <?php foreach ($recommend as $k=>$v):?>
		    </p> 
		    <p >
		  	<a href="<?php echo site_url('corporate/resource/detailh5/'.$v['id'].'/'.$corporation['id']);?>" ><img src="<?php echo IMAGE_URL.$v['logo'];?>" alt=""  id="recommend<?php echo $k;?>" />	</a>
		    <?php endforeach;?>
		    <?php }else{?>暂无<?php }?>
		    </p>
		    </li>
		    <li class="shop-information-left-tu">
		    	
		   	 
		    </li>
		</ul>
	</div>
	<!-- 信誉信息 结束 -->

	<!-- 联系信息 开始 -->
	<div class="shop-prestige shop-contact">
		<div class="shop-prestige-title">
			<span class="shop-information-left">联系信息</span>
		</div>
		<ul>
		    <li class="shop-information-left">联系人<span class="shop-buweizhi">补</span>: <?php echo isset($corporation['contact_name'])?$corporation['contact_name']:"" ?></li>
		    <li class="shop-information-left"><span class="shop-lianxi">联系地址: </span>
		    <span class="shop-dizhi">
		    <?php echo isset($corporation['province'])?$corporation['province']:"" ?>
		    <?php echo isset($corporation['city'])?$corporation['city']:"" ?>
		    <?php echo isset($corporation['district'])?$corporation['district']:"" ?> - 
		    <?php echo isset($corporation['address'])?$corporation['address']:"" ?>
		    </span></li>
		   
		</ul>
	</div>
	<!-- 联系信息 结束 -->

	<!-- 内容与底部有一定的距离 -->
	<div class="shop-information-height">
		
	</div>

	<!-- 即时通讯 拨打电话 -->
	<div class="shop-information-footer">
		<ul>
		    <li><a href="javascript:void(0);" class="shop-communication">即时通讯</a></li>
		    <li><a href="tel:4000029777" class="shop-dial">拨打电话</a></li><!-- <?php // echo $corporation['contact_mobile'];?> -->
		</ul>
	</div>
	<!-- 即时通讯 拨打电话 结束 -->
</div>
<!-- 商家信息 结束 -->
<script>


// 当前企业是否收藏
var is_favourites = "<?php echo isset($is_favourites)?$is_favourites:0;?>";

/**
 * 初始化
 */
$(function(){
	if(is_favourites == 1){
		$(".shop-guanzhi-text").html("已关注");
	}else{
		$(".shop-guanzhi-text").html("未关注");
    	$(".shop-remove").addClass("shop-active02-color");
	}
})

/**
 * 关注/取消关注店铺操作
 */
function fav_corporation(corporation_id){
	<?php if(!$this->session->userdata('user_in')):?>
	$(".black_feds").text("您还未登录，请先登录。").show();
	setTimeout("prompt();", 1000);
	<?php else:?>
	if(corporation_id != 0){
    	if(is_favourites==0){
            $.ajax({
                url: base_url+'/Member/fav/store_corporation',
                type: 'POST',
                data:{'pid':corporation_id},
                dataType: 'html',
                success: function(data){
                	$(".shop-remove").toggleClass("shop-active02-color");
            		$(".shop-guanzhi-text").html("已关注");
            		// 是否关注，全局可以使用判断
            		is_favourites = 1;
            		$(".black_feds").text(data).show();
                	setTimeout("prompt();", 2000);
                }
            });
    	}else{
            $.ajax({
                url: base_url+'/member/fav/unfavorite_corporation',
                type: 'POST',
                data:{'corporation_id':corporation_id},
                dataType: 'json',
                success: function(data){
                    if(data["Result"]==true){
                    	$(".shop-remove").toggleClass("shop-active02-color");
                		$(".shop-guanzhi-text").html("未关注");
                		// 是否关注，全局可以使用判断
                		is_favourites = 0;
                    }
            		$(".black_feds").text(data["message"]).show();
                	setTimeout("prompt();", 2000);
                }
            });
        	
    	}
	}
    <?php endif;?>
}

$(".shop-communication").on("click",function(){
	$(".black_feds").text("即将推出").show();
	setTimeout("prompt();", 2000);
});
</script>