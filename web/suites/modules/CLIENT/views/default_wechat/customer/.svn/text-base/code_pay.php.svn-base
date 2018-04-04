
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
	<div class="wrap_tanchuang" hidden id='dingdan4_3_tanchuang_3' >
      <div class="wrap_tanchuang_con" style="margin-top: 100px;" id="wrap_tanchuang_con" onclick="$('#dingdan4_3_tanchuang_3').hide()">
          <div class="wrap_tanchuang_top" id="pay_message"></div>
        </div>
	</div>
    <!--弹窗 结束-->

<script>
function show_pay(){ 
  	var price = $('input[name=input_money]').val();
  	$('#pass_message').hide();
    if(price == ''){ 
       $('#error_price').show();
        return;
    }else{ 
    	$('#error_price').hide();
    }
	$('#wrap_tanchuang_zhifu').show();

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
				    $('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			    case 4:
				    $('#pass_message').show();
				    break;
			    case 5:
			    	$('#pay_message').html("余额不足,无法支付");
				    $('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			    case 6:
			    	$('#pay_message').html("交易失败,请稍后再试");
				    $('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			    case 7:
				    $('#wrap_tanchuang_con').attr('onclick',"window.location.href = '<?php echo site_url('member/order')?>'");
			    	$('#pay_message').html("支付成功! <a href='<?php echo site_url("home")?>' style='color:#fea33b'>点击查看订单,首页</a>");
					$('#dingdan4_3_tanchuang_3').show();
				    $('#wrap_tanchuang_zhifu').hide();
				    break;
			}
		}
    })
}
</script>