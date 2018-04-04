
<style type="text/css">
	.container {background-color: #f4f4f4!important;}
</style>


<div class="header">
            <a href="javascript:history.back();" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;"></a>
            <a href="<?php echo site_url("corporate/card_package/send_record");?>" class="detailed" id="widget_submit" style="color: #fff; position: fixed; right:0;">发放纪录</a>
            <p class="title">货包</p>
</div>
<div class="commodity_h50"></div>
<div class="commodity_record">
	<ul>
	<?php if($package){?>
	<?php foreach ($package as $v){?>
    <li class="commodity_detail-list">
        <a href="<?php echo site_url("corporate/card_package/details/".$v['id']);?>">
            <div>
                <img src="<?php echo IMAGE_URL.$v["coupon_image"];?>" alt="" onerror="this.src='images/discount_error.png'">
            </div>
            <div class="commodity_record_list">
              <span class="commodity_record_cishu"><?php echo $v["number"]?"剩余：".$v["number"]:"发放完毕";?></span>
              <?php if($v["number"]){?>
              <a href="<?php echo site_url("corporate/card_package/send_view/".$v["id"]);?>" class="commodity_record_send">发放货包</a>
              <?php };?>
            </div>
        </a>
    </li>
    <?php };?>
    <?php };?>
	</ul>
</div>	


