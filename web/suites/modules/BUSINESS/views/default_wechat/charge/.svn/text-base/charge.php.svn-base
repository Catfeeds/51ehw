<style type="text/css">
	.container {background: #f6f6f6;}
	.charge_pay_title {color: #333333;font-size: 15px;height: 50px;line-height: 50px;padding: 0 15px;}
	.charge_pay ul li {position: relative;height: 50px;line-height: 50px;background: #fff;display: block;text-align: left;padding: 0 15px;border-bottom: 1px solid #ddd;}
	.charge_pay_weixin {width: 115px;float: left;margin-top: 10px;}
	.charge_pay_zhifubao {width: 86px;height: 30px;float: left;margin-top: 10px;}
	.charge_pay_yinlian {width: 127px;float: left;margin-top: 10px;}
	.charge_pay ul li em {position: absolute;right: 15px;top: 18px;width: 18px;height: 18px;border: 1px solid #999999;background-color: #fff;border-radius: 100%;}
	.icon-choose {color: #fed602;font-size: 18px;border: 0!important;}
	.charge_pay_monery {background: #fff;margin-top: 20px;height: 50px;line-height: 50px;padding: 0 15px;color: #333333;font-size: 15px;}
</style>
<form name="charge" method="post" action="<?php echo site_url("charge/Web_Change_Submit")?>">
	<div class="charge_pay"> 
	      <div class="charge_pay_title"><span>充值方式</span></div>
	      <input type="hidden" id="payment_id" name="payment_id" value="1">
		  <ul>
		   <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false):?>
		    <li><img src="images/zhifubao.png" alt="" class="charge_pay_zhifubao"><em data-value="1" class="icon-choose"></em></li>
		    <li><img src="images/yinlian_pay.jpg" alt="" class="charge_pay_yinlian"><em data-value="3"></em></li>
		   <?php else:?>
		    <li><img src="images/weixin_pay.png" alt="" class="charge_pay_weixin"><em data-value="2" class="icon-choose"></em></li>
		    <li><img src="images/yinlian_pay.jpg" alt="" class="charge_pay_yinlian"><em data-value="3"></em></li>
		   <?php endif;?>
		  
		  </ul>
		  <div class="charge_pay_monery">充值金额： <input type="text" name="amount" id="" class="cash_recharge_input" onkeyup="value=value.replace(/[^\-?\d.]/g,'')" value="" placeholder="请输入充值金额"></div>
		</div>

	<div class="cash_recharge_button">
		<button type="button" onclick="checkSubmit()" class="custom_border">确定</button>
	</div>
	<!-- 充值未成功的时候显示 -->
	<div class="cash_recharge_failure" style="display: none;">
		<!-- 弹窗 -->
		<div class="failure_ball">
			<p>您的充值未成功</p>
			<p>
				<button>取消</button><button>重试</button>
			</p>
		</div>
	</div>
</form>
<script>
<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false):?>
<?php else:?>
$("#payment_id").val(2);
<?php endif;?>


 // 点击选择支付方式
 $(".charge_pay ul li").on("click",function(){
 	$(this).children('em').addClass("icon-choose");
 	$(this).siblings('li').children('em').removeClass('icon-choose');
 	$("#payment_id").val($(this).children('em').attr("data-value"));
 })




// 页面回调提示信息监控
$(function(){
	var message = <?php echo $message;?>;
	if(message == 1){
        $(".black_feds").text("支付取消").show();
        setTimeout("prompt();", 3000);
	}else if(message == 2){
        $(".black_feds").text("网络错误，支付失败").show();
        setTimeout("prompt();", 3000);
	}
})

function checkSubmit()
{
	var ok = true;
	var payment_id = $('input[name=payment_id]').val();
	
	var amount = $('input[name=amount]').val();
	
	var str = "^(([1-9]\\d{0,9})|0)(\\.\\d{1,2})?$";
	if(amount == "" || !amount.match(str))
	{
        $(".black_feds").text("请输入正确的充值金额").show();
        setTimeout("prompt();", 3000);
	}else if(amount <= 0){
        $(".black_feds").text("充值金额不能小于0").show();
        setTimeout("prompt();", 3000);
	}else{ 
		document.charge.submit();
    }
}
</script>