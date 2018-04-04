<style type="text/css">
    a {text-decoration: none;}
    .color-bg { z-index: 998;position: fixed;top:0;left:0;height: 100%;width: 100%;background:rgba(0,0,0,0.5); opacity:0.5;}
	.h5-forget { z-index: 999;position: fixed;width: 295px;height: 180px;background-color: #fff;border: 1px solid #fff;border-radius: 5px;top: 50%;margin-top: -90px;left: 50%;margin-left: -150px;}
	.h5-lose { z-index: 999;float: right;margin-top: -15px;margin-right: -15px;}
	.forget-password {width: 265px;margin: 48px auto;text-align: center;}
	.password-text span {line-height: 30px;font-size: 16px;color: #333;}
	.password-button {height: 40px;width: 100%;background-color: #FECF0A;text-align: center;margin-top: 20px;line-height: 40px;font-size: 20px;color: #373422;display: inline-block;}

	.h5-forget2 { z-index: 999;position: fixed;width: 295px;height: 248px;background-color: #fff;border: 1px solid #fff;border-radius: 5px;top: 50%;margin-top: -124px;left: 50%;margin-left: -150px;}
	.forget2-password {width: 265px;margin: 30px auto;text-align: center;}
	.mima-forget {border: 1px solid #E8E8E8;height: 25px;width: 150px;margin-left: 20px;outline: none;}
	.float-left {float: left;margin-left: 10px;}
	.dingdan-num {display: inline-block;margin-left: -15px;}
	.diagndan-monery {display: inline-block;margin-left: -70px;}
	.no-monery {float: left;margin-top: 25px;color: #000000;}
	.no-mima {float: right;margin-top: 25px;color: #000000;}
    @media screen and (max-width:320px) {
      .mima-forget{margin-left: -15px!important;width: 145px!important;}
      .h5-forget2 {width: 270px!important;margin-left: -135px!important;}
      .password-button {width: 90%!important;}
      .no-mima {margin-right: 16px;}
    
    }
    .color_bg {background: rgba(0,0,0,0.5);width: 100%;height: 100%;position: fixed;left: 0;top: 0;z-index: 999;}
</style>
		<!--page start-->
		<div class="page">
			<!-- 输入金额 start-->
            <div class="in_money">
                <span>消费金额：</span>
                <input class="input_money" name= "input_money" type="text" placeholder="0.00" maxlength="14" onkeyup="value=value.replace(/[^\-?\d.]/g,'')"  onkeyup="value=value.replace(/[^\d.]/g,'')" value="">
                <span class="input_M">货豆</span>
                <!-- 没有输入金额时候，显示以下提示语 -->
                <p class="payNum_tips" id="error_price" hidden>*请输入正确的金额</p>
            </div>
            
             <div class="in_money_btn">
                <a href="javascript:;" onclick="show_pay()" class="pay-style pay-weixin">确定</a>
<!--                 <a href="" class="pay-style pay-cancel">取消</a> -->
            </div>
		</div>
		<!--page end-->
    <!--wrap 新增支付流程－输入支付密码－弹窗 开始--><!--默认隐藏-->
<div class="wrap_tanchuang"  hidden id="wrap_tanchuang_zhifu">
  <div class="wrap_tanchuang_con">
      <div class="wrap_tanchuang_top">支付确认</div>
      <div class="wrap_tanchuang_top2">
          <ul class="payNum_ul clearfix">
            <li><span class="pay_left">支付密码：</span><span><input type="password" placeholder="请输入支付密码" name="pay_password" class="payNum_input"></span> <!-- <a href="<?php echo site_url('customer/forget_password')?>" class="payNum_forget">忘记密码？</a>--></li>
            <li hidden id='pass_message'><span class="payNum_tips">*密码错误，请重新输入</span></li>
          </ul>
      </div>
      <div class="wrap_tanchuang_btn clearfix">
          <ul>
              <li class="wrap_tanchuang_btn01"><a href="javascript:;" id='pay_' onclick="pay()">确认支付</a></li>
              <li class="wrap_tanchuang_btn01" style="background:#ccc; "><a href="javascript:;" onclick="$('#wrap_tanchuang_zhifu').hide(); $('#pass_message').hide()">取消支付</a></li>
          </ul>
      </div>
      
  </div>
</div>
<!--wrap 新增支付流程－输入支付密码－弹窗 结束-->

 <!--验证支付密码是否存在－-><!--默认隐藏-->
	<div class="wrap_tanchuang" hidden id='no-paswd' >
         <div class="h5-forget" >
         	<div class="h5-lose" onclick="$('#no-paswd').hide();">
				<img src="images/51h5-lose.png" height="34" width="34">
			</div>
        	 <div class="forget-password" >
        		<div class="password-text">
        		  <span>亲，您还没有设置支付密码，您要先设置支付密码才能支付哦</span>
        		</div>
        		<a href="<?php echo site_url("member/info/paypwd_edit");?>" class="password-button">设置</a>
        	</div>
   		 </div>
	</div>
	
	
     <!--通用弹窗 -->
    <div class="wrap_tanchuang" hidden id='dingdan4_3_tanchuang_3' >
      <div class="wrap_tanchuang_con" style="margin-top: 100px;" id="wrap_tanchuang_con" onclick="$('#dingdan4_3_tanchuang_3').hide()">
          <div class="wrap_tanchuang_top" id="pay_message"></div>
        </div>
	</div>
    <!--弹窗 结束-->
    
    
<!--   余额不足隐藏窗口 -->
	<div id="color_bg"  class="color_bg" hidden>
        <div class="h5-forget"  >
        <div class="h5-lose" onclick="$('#color_bg').hide();">
			<img src="images/51h5-lose.png" height="34" width="34">
		</div>
    	<div class="forget-password">
    		<div class="password-text">
    		  <span>余额不足,无法支付</span>
    		</div>
    		<a href="<?php echo site_url("customer/fortune");?>" class="password-button">充值货豆</a>
    	</div>
    	</div>
    </div>	
    <!--弹窗 结束-->
<script>
function show_pay(){ 
  	var price = $('input[name=input_money]').val();
    
  	if(price >= 0.01){
  	    window.location.href="<?php echo site_url('member/order/code_pay/'.$product_id.'/'.$corp_id.'/?price=')?>"+price;
  	}else{ 
  		$(".black_feds").text("请输入正确的金额").show();
    	setTimeout("prompt();", 3000);
    }
//   	$('#pass_message').hide();
//     if(price == ''){ 
//        $('#error_price').show();
//         return;
//     }else{ 
//     	$('#error_price').hide();
//     }
// 	$('#wrap_tanchuang_zhifu').show();

}

function pay(){ 
	var corp_id = "<?php echo $corp_id?>"
    var product_id = "<?php echo $product_id?>"
    var price = $('input[name=input_money]').val();   
    var passwd = $('input[name=pay_password]').val();
	$.ajax({ 
		url:"<?php echo site_url('corporate/sale/code_pay')?>",
		data:{corp_id:corp_id, product_id:product_id, price:price,passwd:passwd},
		type:'post',
		dataType:'json',
		success:function (data){ 
			
			switch(data.status){ 
			    case 1:
			    	$('#pay_message').html("店铺不存在,无法交易");
				    $('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
    			case 2:
			    	$('#pay_message').html("该店铺未绑定二维码商品,请联系店主");
				    $('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
				case 3:
			    	$('#pay_message').html('您还没设置支付密码,无法支付');
				    $('#no-paswd').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			    case 4:
				    $('#pass_message').show();
				    break;
			    case 5:
				    $('#color_bg').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			    case 6:
			    	$('#pay_message').html("交易失败,请稍后再试");
				    $('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			    case 7:
				    $('#wrap_tanchuang_con').attr('onclick',"window.location.href = '<?php echo site_url('member/order')?>'");
			    	$('#pay_message').html("支付成功! <a href='<?php echo site_url('member/order')?>' style='color:#fea33b'>点击查看订单</a>");
					$('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			    case 8:
			    	$('#pay_message').html("无法购买自家店铺的商品");
				    $('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			}
		}
    })
}
</script>