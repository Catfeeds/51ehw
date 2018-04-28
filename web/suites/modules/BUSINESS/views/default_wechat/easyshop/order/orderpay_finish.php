
<div class="page clearfix">
	<div style="margin-bottom: 45px;">
		<img src="images/orders_ok_img.png" alt="">
	</div>


    <!-- 您的订单支付成功 -->
	<div style="position: relative;display:block;?>">
		<em class="icon-zhifuchenggong" style="position: absolute; top: 60px; left: 30px; font-size: 50px; color: #FED609;"></em>
		<div style="text-align: center;margin-bottom: 24px;font-size: 21px;"><span>您的支付已成功</span></div>

		<span class="order_span_text">您的订单号：<?php echo $charge['obj_no'];?></span>
		<span class="order_span_text">支付金额：<?php echo '￥'.$charge['amount'];?></span>
	</div>
    <!-- 您的订单支付成功 -->
	
	<div style="margin-top: 45px;">
		
			<a href="<?php echo site_url('Easyshop/order/order_list/'.$order['tribe_id'])?>" class="custom_button" style="display: block;text-align: center; width: 90%; background: #FED609; color: #27302B; font-size: 17px; line-height: 40px; margin: auto; margin-bottom: 10px; border-radius: 2px;">我的订单</a>
		
		<div
			style="text-align: center; width: 90%; color: #27302B; font-size: 17px; line-height: 40px; margin-top: 10px; margin: auto; border-radius: 2px;">
			<a href="<?php echo site_url("Home")?>">继续购物</a>
		</div>
	</div>
</div>
