<!DOCTYPE html>
<html>
<head>
        <title>成功提交订单</title>
        <base href="<?php echo THEMEURL; ?>" />
        <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
        <link href="css/base.css" rel="stylesheet" type="text/css"/>
        <link href="css/public.css" rel="stylesheet" type="text/css"/>
        <link href="css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="css/cart.css" rel="stylesheet" type="text/css"/>
        <link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
        <script type="text/javascript" src="js/jquery-1.8.2.min.js" ></script>
		<script type="text/javascript" src="js/jqnav.js" ></script>
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
			//alert("1111");
			if(document.order_save.bank_code[i].value ==  "alipay")
			{//alert("<?php echo site_url('alipay/save_pay')?>");
				document.order_save.action = "<?php echo site_url('alipay/charge_pay')?>";
			}else
			{
				document.order_save.action = "<?php echo site_url('charge/save_pay');?>";
			}
		}
		
		
	}
	
	if(flag)
	{
		return true;
	}else
	{
		alert("请选择支付方式");
		return false;
	}
}
</script>
</head>
<body>
<?php $this->load->view('_header');?>         
        <!-- head-top E -->
        <div class="ui-bd w980">
        <form  action="<?php echo site_url('charge/save_pay');?>" id="order_save" name="order_save" method="post" target="_blank">
            <div class="ui-cart-info m-top10">
                <ul>
                    
                    <li>
                        充值金额：<span class="ui-pay-money"><strong><?php echo $amount;?>元</strong></span>
                        <input name="amount" type="hidden" value="<?php echo $amount;?>" size="100">

                    </li>
                    
                </ul>
            </div>
            <div class="ui-pay-system-box m-top10">
               
				<div class="ui-system-title-nav">
                   <ul>
                     <li class="active" onclick="changePay(0)" id="kuiyinbt">快银支付</li>
                     <li onclick="changePay(1)" id="alipaybt">支付宝</li>
                   </ul>
                </div>
			<!--<div class="ui-system-title"><h3>网上银行</h3></div>
				<div class="ui-system-bd">-->
                <div class="ui-system-bd ui-title-nav-bd" id="kuiyinlayout" >
                    <ul class="ui-system-payment-list fn-clear caslist" id="caslist">
					
      <li>
        <input name="bank_code" type="radio" value="UP" />
        <img src="images/bank/casbank1.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[0].checked = true;"/></li>
      <li>
        <input name="bank_code" type="radio" value="CCB" />
        <img src="images/bank/casbank2.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[1].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="ABC" />
        <img src="images/bank/casbank3.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[2].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="PSBC" />
        <img src="images/bank/casbank4.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[3].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="BOC" />
        <img src="images/bank/casbank5.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[4].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="BANKCOMM" />
        <img src="images/bank/casbank6.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[5].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="CMB" />
        <img src="images/bank/casbank7.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[6].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="CEB" />
        <img src="images/bank/casbank8.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[7].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="ICBC" />
        <img src="images/bank/casbank9.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[8].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="SPDB" />
        <img src="images/bank/casbank10.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[9].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="HXB" />
        <img src="images/bank/casbank11.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[10].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="NBCB" />
        <img src="images/bank/casbank12.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[11].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="CIB" />
        <img src="images/bank/casbank13.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[12].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="CGB" />
        <img src="images/bank/casbank14.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[13].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="BOB" />
        <img src="images/bank/casbank15.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[14].checked = true;" /></li>
      <li>
        <input name="bank_code" type="radio" value="PINGAN" />
        <img src="images/bank/casbank16.gif" width="180" height="40" onclick="javascript:document.order_save.bank_code[15].checked = true;" /></li>
                  </ul>
                     <div class="morebank"><a href="javascript:;" class="a_morebank">选择更多银行</a></div>
                </div>

				<div class="ui-system-bd ui-title-nav-bd" id="alipaylayout" style="display:none" >
                    <ul class="ui-system-payment-list fn-clear caslist" id="caslist">
                        <li>
							 <input name="bank_code" type="radio" value="alipay" />
							 <img src="images/zhifu/payOnline_zfb.gif" width="180" height="40" />
						 </li>
                    </ul>

                </div>
				

            </div>
            <div class="ui-cart-btn fn-clear m-top15">
<!--                 <a href="cart.html" class="ui-shop-to but buy-dakelight">修改订单</a> -->
                <a onclick="submitPay(this);" class="ui-shop-checkout but buy-dakelight" target="_blank">下一步</a>
            </div>
        </form>    
        </div>
		<div class="wenxi">
     <h2>温馨提示：</h2>
      <p>请确保您已经在银行柜台开通了网上支付功能，否则将无法支付成功。</p>
  </div>
<?php $this->load->view('_footer');?>
    </body>
</html>
<script>
function changePay(type)
{
	if(type == 1)
	{
		$('#alipaylayout').show();
		$('#kuiyinlayout').hide();
		$('#creditlayout').hide();
		$('#alipaybt').attr("class","active");
		$('#kuiyinbt').attr("class","");
		$('#creditbt').attr("class","");
		for(i = 0; i < document.order_save.bank_code.length; i++){
			if(document.order_save.bank_code[i].value == 'credit'){
				document.order_save.bank_code[i].checked = true;	
			}
		}
	}
	else
	{
		$('#kuiyinlayout').show();
		$('#alipaylayout').hide();
		$('#creditlayout').hide();
		$('#creditbt').attr("class","");
		$('#alipaybt').attr("class","");
		$('#kuiyinbt').attr("class","active");
		for(i = 0; i < document.order_save.bank_code.length; i++){
			if(document.order_save.bank_code[i].value == 'alipay'){
				document.order_save.bank_code[i].checked = false;	
			}
			else if(document.order_save.bank_code[i].value == 'credit'){
				document.order_save.bank_code[i].checked = false;	
			}
		}
	}
}
</script>