
<style type="text/css">
	.container {background-color: #f4f4f4!important;}
</style>

<!-- <div class="commodity_h50"></div> -->
<div class="client_commodity_block_nav">
	<ul>
	    <li class="client_commodity_block_active">未使用(<?php echo count($not_used);?>)</li>
	    <li>已使用(<?php echo count($used);?>)</li>
	    <li>已过期(<?php echo count($overdue);?>)</li>
	</ul>
</div>


<div class="commodity_record">
	<ul>
	    <?php if($not_used){?>
	    <?php foreach ($not_used as $v){?>
	    <li class="commodity_detail-list">
	       <a href="<?php echo site_url("corporate/card_package/details/".$v["id"]."/1");?>">
	       	<div>
		      <img src="<?php echo IMAGE_URL.$v["coupon_image"]?>" alt="" onerror="this.src='images/discount_error.png'">
	       </div>
	       <div class="clicent_commodity_record_list">
	          <?php if($v["coupon_start_at"] <= date("Y-m-d") && $v["coupon_end_at"] >= date("Y-m-d")){;?>
	          <?php if($v["discount_type"] == 3){;?>
              <a href="<?php echo site_url("corporate/card_package/obtain_package_detail/{$v['id']}/{$v['sender_id']}")."/".strtotime($v["created_at"]);?>" class="client_commodity_record_send">立即使用</a>
              <?php }else{;?>
<!--               redirect("corporate/card_package/obtain_package_detail/{$id}/{$sender_id}/{$unix}");//已经领取完成直接跳转 -->
              <a href="<?php echo site_url("search/discount_goods/".$v["id"]);?>" class="client_commodity_record_send">立即使用</a>
              <?php };?>
              <?php }else{;?>
              <a href="javascript:void(0);" class="client_commodity_record_send"><?php echo $v["coupon_start_at"]."~".$v["coupon_end_at"];?></a>
              <?php };?>
<!--               <span class="icon-shanchu1 client_commodity_block_shanchu"></span> -->
	       </div>
	       </a>
	    </li>
	    <?php };?>
	    <?php }else{;?>
	    <!-- 暂无可用优惠劵 的时候显示 -->
    	    <div class="client_commodity_block_not">
            	<span class="icon-kong client_block_icon"></span>
            	<span class="client_block_not_text">暂无可用优惠劵</span>
            </div>
	    <?php };?>
	</ul>

	<ul style="display: none;">
	   <?php if($used){?>
	   <?php foreach ($used as $v){?>
	    <li class="commodity_detail-list">
	       <a href="<?php echo site_url("corporate/card_package/details/".$v["id"]);?>">
	       	<div>
		      <img src="<?php echo IMAGE_URL.$v["coupon_image"]?>" alt="" onerror="this.src='images/discount_error.png'">
	       </div>
	       <div class="clicent_commodity_record_list">
              <a href="javascript:void(0);" class="client_commodity_record_send2">已使用</a>
<!--               <span class="icon-shanchu1 client_commodity_block_shanchu"></span> -->
	       </div>
	       </a>
	    </li>
	    <?php };?>
	    <?php }else{;?>
	       <!-- 暂无可用优惠劵 的时候显示 -->
    	    <div class="client_commodity_block_not">
            	<span class="icon-kong client_block_icon"></span>
            	<span class="client_block_not_text">暂无已使用优惠劵</span>
            </div>
	    <?php };?>
	</ul>

		<ul style="display: none;">
		<?php if($overdue){?>
	    <?php foreach ($overdue as $v){?>
	    <li class="commodity_detail-list">
	       <a href="<?php echo site_url("corporate/card_package/details/".$v["id"]);?>">
	       	<div>
		      <img src="<?php echo IMAGE_URL.$v["coupon_image"]?>" alt="" onerror="this.src='images/discount_error.png'">
	       </div>
	       <div class="clicent_commodity_record_list">
              <a href="javascript:void(0);" class="client_commodity_record_send2">已过期</a>
<!--               <span class="icon-shanchu1 client_commodity_block_shanchu"></span> -->
	       </div>
	       
	       </a>
	    </li>
	    <?php };?>
	    <?php }else{;?>
	       <!-- 暂无可用优惠劵 的时候显示 -->
    	    <div class="client_commodity_block_not">
            	<span class="icon-kong client_block_icon"></span>
            	<span class="client_block_not_text">暂无已过期优惠劵</span>
            </div>
	    <?php };?>
	</ul>


	
</div>	

<script type="text/javascript">
	$(".client_commodity_block_nav ul li").on("click",function(){
		var index = $(this).index();
		$(this).addClass("client_commodity_block_active").siblings().removeClass("client_commodity_block_active");
		$(".commodity_record ul").eq(index).show().siblings().hide();
	})

</script>


