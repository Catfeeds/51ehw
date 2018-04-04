<style type="text/css">
	.container {background: #f4f4f4!important;}
</style>
<div class="commodity_h50"></div>
<div class="order-pay">
    <!-- 有余额的时候 -->
	<div class="order-pay-yes" hidden>
		<ul>
		  <li><span>订单金额</span><span class="fn-right order-pay-money-color">10货豆</span></li>
		  <li class="order-pay-money"><span>货豆支付</span><span class="fn-right">10货豆</span></li>
		  <li class="order-pay-money">请输入支付密码<input type="text"></li>
		  <li class="order-pay-forget"><span class="order-pay-money-color" hidden>密码错误，请重新输入</span><a href="javascript:void(0);" class="fn-right">忘记支付密码？</a></li>
	   </ul>	
	</div>

	<!-- 余额不足的时候 -->
	<div class="order-pay-no">
		<ul>
		  <li><span>订单金额</span><span class="fn-right order-pay-money-color">10货豆</span></li>
		  <li><span>货豆余额</span><span class="fn-right">5货豆</span></li>
		  <li class="order-pay-money mb-10" id="order-pay-way">请选择支付金额<span class="order-pay-way-active">混合支付</span><span>微信支付</span></li>
	   </ul>	
	</div>
	<div class="order-pay-no order-pay-way">
		<ul>
		  <li class="order-pay-money"><span>货豆支付金额</span><span class="fn-right">5货豆</span></li>
		  <li class="order-pay-money"><span>微信支付金额</span><span class="fn-right">5元</span></li>
		  <li class="order-pay-money">请输入支付密码<input type="password" ></li>
		  <li class="order-pay-forget"><span class="order-pay-money-color" hidden>密码错误，请重新输入</span><a href="javascript:void(0);" class="fn-right">忘记支付密码？</a></li>
		</ul>
		<ul hidden>
		  <li class="order-pay-money"><span >微信支付金额</span><span class="fn-right">10元</span></li>
		</ul>
	</div>	






	<!-- 确认支付 -->
	<div class="order-pay-tishi" hidden>
		<span>货豆扣款成功，将在3秒内跳转微信支付，请勿关闭页面</span>
	</div>
	<a href="javascript:void(0);" class="order-pay-confirm">确认支付</a>


	
</div>	

<script type="text/javascript">
	$("#order-pay-way span").on("click",function(){
		var index = $(this).index();
		$(this).addClass("order-pay-way-active").siblings().removeClass("order-pay-way-active");
		$(".order-pay-way ul").eq(index).show().siblings().hide();
	})
	// 点击确认支付
	$(".order-pay-confirm").on("click",function(){
		$(".order-pay-tishi").css("display","block");
		$(".order-pay-confirm").css("background","#ccc");
		$(".order-pay-confirm").css("color","#aaa");
	})

</script>


