
<style type="text/css">
	.container {background-color: #f4f4f4!important;}
</style>

<!-- <div class="commodity_h50"></div> -->
<div class="commodity_record">
	<ul>
	    <?php if($package){?>
	    <?php foreach($package as $v){?>
	    <li class="commodity_detail-list">
	    	<a href="<?php echo site_url("corporate/card_package/obtain_package_detail/".$v["p_id"]."/".$v["sender_id"]."/".strtotime($v["created_at"]));?>">
	       	<div>
		      <img src="<?php echo IMAGE_URL.$v["coupon_image"]?>" alt="">
	       </div>
	       <div class="commodity_record_text">
              <span class="commodity_record_cishu">发放：<?php echo $v["total"]?></span><span  class="commodity_record_num">已领取：<?php echo $v["obtain"]?></span><span class="commodity_record_time"><?php echo $v["created_at"]?></span>
	       </div>
	       </a>
	    </li>
	    <?php };?>
	    <?php }else{;?>
	    这里提示没有数据
	    <?php };?>
	    <li></li>
	    <li></li>
	</ul>


	
</div>	
