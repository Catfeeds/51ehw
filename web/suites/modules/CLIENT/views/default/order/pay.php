
  
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
	
   var len = document.order_save.radio.length;
	for(var i=0;i<len;i++)
	{
		
		if(document.order_save.radio[i].checked == true)
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

    <div class="gouwuche_box">
    	<div class="gouwuche_box_top">支付</div>
    	<form action="<?php  if(isset($is_app) && $is_app == "app"){echo site_url('order_app/save_pay'); }else{echo site_url('order/save_pay');}?>" id="order_save" name="order_save" method="post">
    	<div class="dingdan3_con02">
    	   <div class="dingdan4_con02">
            	<div class="dingdan4_2 chongzhi02_con02 clearfix">
                        <ul class="dingdan4_2_ul">
                            <li style="height: 25px">
                                订单：<?php echo $order_sn;?><input type="hidden" name="order_id" value="<?php echo $order_sn;?>">
                            </li>
                            <li style="height: 25px">
                                应付金额：<span class="ui-pay-money"><strong><?php echo $total_price;?>元</strong></span>
                                <input name="amount" type="hidden" value="<?php echo $total_price;?>" size="100">
                                <input name="merchant_id" type="hidden"	value="80140311172356932106" size="100">
                            	<input name="order_time" type="hidden" value="<?php echo strtotime("now");?>" size="100">
                            	<input name="merchant_url" type="hidden" value="<?php  if(isset($is_app) && $is_app == "app"){echo "http://www.wjhgw.com/index.php/order_app/afterpay/".$order_sn;}else{echo  "http://www.wjhgw.com/index.php/order/afterpay/".$order_sn;}?>" size="100">
                            	<input name="cust_param" type="hidden" value="web" size="100">
        	                    <input name="key" type="hidden" value="433a63646a514606a9d25f01971fe330" size="100">
        	                    <input name="sign_msg" type="hidden" value="" size="100">
        
                            </li>
                            <li style="height: 25px">
                            不限送货时间<span class="line">/</span><?php echo isset($invoice) &&$invoice == 1 ? '需要开发票' : '不需要开发票'; ?>
                            </li>
                            <li style="height: 25px"></li>
                            <li style="width: 800px;height: 25px"  > 配送：收货人：<?php echo $consignee;?>
                            &nbsp;手机号码：<?php echo $contact_mobile;?>
                            &nbsp;电话号码：<?php echo $contact_phone;?>
                            &nbsp;收货地址：<?php echo $address;?></li>
                           
                        </ul>

                             
                        
                </div>
            </div>
        </div>
    	   
    	   
          

            <div class="dingdan3_con02">
        
              <p class="dingdan2_p">储蓄卡</p>
              <div class="dingdan4_con02">
                  <div class="dingdan4_con03">
                          <ul>
                              <li>
                              <ul class="dingdan4_fukuan" id="select">
                                  <li><a href="javascript:void(0)" id="wchatpay">微信</a></li>
                                  <li class="dingdan4_line"></li>
                                  <li  id="wilpay"><a href="javascript:void(0)">支付宝</a></li>
                                  <li class="dingdan4_line"></li>
                                  <li class="dingdan4_current"><a href="javascript:void(0)" id="card">银行卡</a></li>
                              </ul>
                          </ul>
                  </div>
                  
                  <div class="ui-pay-system-box">
                  <div class="dingdan3_con02">
            	       <div class="dingdan4_con02" id="wilpays" style="display:none">
            	       <p class="dingdan2_p">支付平台</p>
                            <div class="dingdan4_con03">
                                <ul class="dingdan4_2_ul">
                                    <li>
                                        <label>
                                            <input type="radio" name="payment_id" value="1" >
                                            <img src="<?php echo IMAGE_URL.'uploads/payment/kuaiyin_logo.jpg'?>"/>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                
                  <div class="dingdan4_2 chongzhi02_con02 clearfix" id="cards" style="display:block">
                  	<ul class="dingdan4_2_ul">
                    	<li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_01.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_02.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_03.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_04.jpg" width="173" height="38" alt=""/></span>
                        </li>
                    	<li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_05.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_06.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_07.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_08.jpg" width="173" height="38" alt=""/></span>
                        </li>
                    	<li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_09.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_10.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_11.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li>
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_12.jpg" width="173" height="38" alt=""/></span>
                        </li>
                    	<li class="dingdan4_li">
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_13.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li class="dingdan4_li">
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_14.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li class="dingdan4_li">
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_15.jpg" width="173" height="38" alt=""/></span>
                        </li>
                        <li class="dingdan4_li">
                        	<input class="dingdan4_2_input" type="radio" value="" name="radio">
                            <span class="dingdan4_2_img"><img src="images/dingdan4_2_16.jpg" width="173" height="38" alt=""/></span>
                        </li>
                    </ul>
                  </div>
            </div>
            </div>
            </div>
            
            <div class="dingdan3_btn"><a href="javascript:void(0)"  onclick="submitPay(this);">确定支付方式</a></div>
       
           </form>
        </div>
<script type="text/javascript">
<!--
$(function(){
	$('#wilpay').on('click',function(){
	    $('#cards').hide();
	    //$('#wchatpays').hide();
	    $('#wilpays').show();
	});

	$('#card').on('click',function(){
		$('#cards').show();
	    //$('#wchatpays').hide();
	    $('#wilpays').hide();
	});
	$('#wchatpay').on('click',function(){
		$('#cards').hide();
	    //$('#wchatpays').show();
	    $('#wilpays').hide();
	});

});
//-->
</script>      


  