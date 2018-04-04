
<script type="text/javascript">    
function submitPay(obj)
{
  if(check_submit_pay())
   {
	  $('form').submit();
   }
}
function check_submit_pay()
{
	var flag = false;
	
   var len = document.order_save.bank_code.length;
	for(var i=0;i<len;i++)
	{
		
		if(document.order_save.bank_code[i].checked == true)
		{
			flag = true;
		}
		
	}
	
	if(flag)
	{
		return true;
	}else
	{
		alert("请选择银行");
		return false;
	}
}
</script>

        <!-- head-top E -->
        <div class="ui-bd w980">
        <form action="<?php  if(isset($is_app) && $is_app == "app"){echo site_url('order_app/save_pay'); }else{echo site_url('order/save_pay');}?>" id="order_save" name="order_save" method="post">
            <div class="ui-cart-info m-top10">
                <ul>
                    <li>
                        订单：<?php echo $order_sn;?><input type="hidden" name="order_id" value="<?php echo $order_sn;?>">
                    </li>
                    <li>
                        金额：<span class="ui-pay-money"><strong><?php echo $total_price;?>元</strong></span>
                        <input name="amount" type="hidden" value="<?php echo $total_price;?>" size="100">
                        <input name="merchant_id" type="hidden"	value="80140311172356932106" size="100">
                    	<input name="order_time" type="hidden" value="<?php echo strtotime("now");?>" size="100">
                    	<input name="merchant_url" type="hidden" value="<?php  if(isset($is_app) && $is_app == "app"){echo "http://www.wjhgw.com/index.php/order_app/afterpay/".$order_sn;}else{echo  "http://www.wjhgw.com/index.php/order/afterpay/".$order_sn;}?>" size="100">
                    	<input name="cust_param" type="hidden" value="web" size="100">
	                    <input name="key" type="hidden" value="433a63646a514606a9d25f01971fe330" size="100">
	                    <input name="sign_msg" type="hidden" value="" size="100">

                    </li>
                    <li>配送：<p><?php echo $consignee;?><span class="line">/</span><?php echo $contact_mobile;?> <?php echo $contact_phone;?><span class="line">/</span>
                        <?php echo $address;?><br/>不限送货时间<span class="line">/</span>不开发票</p>
                    </li>
                </ul>
            </div>
            <div class="ui-pay-system-box">
                <div class="ui-system-title"><h3>支付平台</h3></div>
                <div class="ui-system-bd">
                    <ul class="ui-system-payment-list fn-clear">
                        <li>
                            <label>
                                <input type="radio" name="payment_id" value="1" checked>
                                <img src="<?php echo base_url('uploads/payment/kuaiyin_logo.jpg')?>"/>
                            </label>
                        </li>
                    </ul>
                </div>

			<div class="ui-system-title"><h3>网上银行</h3></div>
                <div class="ui-system-bd">
                    <ul class="ui-system-payment-list fn-clear caslist" id="caslist">
                        <li>
        <input name="bank_code" type="radio" value="UP" />
        <img src="images/bank/casbank1.gif" width="180" height="40" /></li>

                    </ul>
                </div>

            </div>
            <div class="ui-cart-btn fn-clear m-top15">
<!--                 <a href="cart.html" class="ui-shop-to but buy-dakelight">修改订单</a> -->
                <a onclick="submitPay(this);" class="ui-shop-checkout but buy-dakelight">下一步</a>
            </div>
        </form>    
        </div>
		<div class="wenxi">
     <h2>温馨提示：</h2>
      <p>请确保您已经在银行柜台开通了网上支付功能，否则将无法支付成功。</p>
  </div>