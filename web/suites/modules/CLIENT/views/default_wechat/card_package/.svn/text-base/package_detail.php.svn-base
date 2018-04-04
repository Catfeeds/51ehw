<style type="text/css">
	.container {background-color: #f4f4f4!important;}
</style>


<!-- <div class="commodity_h50"></div> -->
<div class="commodity_detail">
	<div>
		<img src="<?php echo IMAGE_URL.$package["ad_image"]?>" alt="">
	</div>	
	<div class="commodity_detail_main">
		<div class="commodity_detail_main_title">
			<h3>货包类型：</h3>
			<?php if($package["discount_type"]==1){;?>
			<span><?php echo $package["discount"];?> 折优惠券</span>
			<?php }else{;?>
			<span><?php echo $package["deduction_price"];?> 货豆抵用券</span>
			<?php };?>
		</div>
	</div>	

	<div class="commodity_detail_explain">
		<div class="commodity_detail_explain_title">
			<h3>使用说明：</h3>
			<div class="commodity_detail_explain_text">
			<span><?php echo $package["describe"]?></span>
			</div>
		</div>
	</div>	

	
</div>	
<?php if(!empty($package["donation"]) && $package["donation"]==1 && $status==1){?>
<div class="commodity_detail_send">
	<a href="<?php echo site_url("corporate/card_package/share/1/".$package["p_id"]);?>">转赠优惠券</a>
</div>
<?php };?>