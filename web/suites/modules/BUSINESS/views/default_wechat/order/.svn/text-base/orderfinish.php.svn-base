
<div class="page clearfix">
	<div style="margin-bottom: 45px;">
		<img src="images/orders_ok_img.png" alt="">
	</div>
	
    <!-- 您的订单提交成功 -->
	<div style="position: relative;display:<?php echo !empty($order_finish)&&$order_finish==1?"block":"none";?>;">
		<em class="icon-dingdanyiwancheng"
			style="position: absolute; top: 7px; left: 30px; font-size: 80px; color: #FED609;"></em>
		<span class="order_span_text">您的订单已提交成功</span>
		<?php if(isset($status) && $status == 1):?>
		<span class="order_span_text">请等待商家确认</span>
		<?php else:?>
		<span class="order_span_text">可进行付款</span>
		<?php endif;?>
		<?php if(isset($order_sn)&& $order_sn!=''):?>
		<span class="order_span_text">您的订单号：<?php echo $order_sn;?></span>
		<?php endif;?>
	</div>
    <!-- 您的订单提交成功 -->

    <!-- 您的订单支付成功 -->
	<div style="position: relative;display:<?php echo !empty($order_finish)&&$order_finish==1?"none":"block";?>">
		<em class="icon-zhifuchenggong" style="position: absolute; top: 60px; left: 30px; font-size: 50px; color: #FED609;"></em>
		<div style="text-align: center;margin-bottom: 24px;font-size: 21px;"><span>您的支付已成功</span></div>
<!-- 		<span class="order_span_text">请及时完善订单以便发货</span> -->
		<span class="order_span_text">使用提货权：<?php echo isset($pay_account)?$pay_account:"0.00"?></span>
		<?php if(isset($order_sn)&& $order_sn!=''):?>
		<span class="order_span_text">您的订单号：<?php echo $order_sn;?></span>
		<?php endif;?>
	</div>
    <!-- 您的订单支付成功 -->
	
	<div style="margin-top: 45px;">
		
			<a href="<?php echo site_url('member/order/detail/'.$order_id)?>" class="custom_button" style="display: block;text-align: center; width: 90%; background: #FED609; color: #27302B; font-size: 17px; line-height: 40px; margin: auto; margin-bottom: 10px; border-radius: 2px;">我的订单</a>
		
		<div
			style="text-align: center; width: 90%; color: #27302B; font-size: 17px; line-height: 40px; margin-top: 10px; margin: auto; border-radius: 2px;">
			<a href="<?php echo site_url("Home")?>">继续购物</a>
		</div>
	</div>
</div>
