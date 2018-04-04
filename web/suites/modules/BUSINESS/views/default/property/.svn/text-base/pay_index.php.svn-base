<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<link href="css/reset.css" rel="stylesheet" type="text/css"> 注释-->
<link href="css/theme/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/theme/style.css" rel="stylesheet" type="text/css">
<link href="css/theme/style_v2.css" rel="stylesheet" type="text/css">
<title>51易货网</title>
</head>

<body>

	<div class="Box member_Box clearfix">
        <div class="kehu_Left">
        	<ul class="kehu_Left_ul">
            	<li class="kehu_title"><a>个人中心</a></li>
                <li><a href="<?php echo site_url('member/info')?>">个人信息</a></li>
                <li class="kehu_current"><a href="<?php echo site_url('member/property/get_list')?>">我的资产</a></li>
                <!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
                <li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
                <li><a href="#">安全设置</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>订单中心 </a></li>
                <li><a href="<?php echo site_url('member/order')?>">我的订单</a></li>
                <li><a href="<?php echo site_url('member/fav')?>">我的收藏</a></li>
                <li><a href="<?php echo site_url('member/my_comment/get_list/')?>">我的评价</a></li>
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户中心</a></li>
                <li><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
                <li><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
               <!-- <li><a href="#">分红结算</a></li>-->
            </ul>
            <ul>
            	<li class="kehu_title"><a>客户服务</a></li>
            	<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
                <li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
                <!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li> -->
                <!--<li><a href="#">在线客服</a></li>
                <li><a href="#">返修退换货</a></li>-->
            </ul>
        </div>

         <!--货豆余额纪录开始-->
		<div class="huankuan_cmRight" display:block">
     
            <div class="huankuan_rTop_5" style="display: block">充值</div>
                 <!--充值账户开始-->
                <div class="recharge" style="display:block;">
                    <form  name="form" method="post" target= "_blank" action="<?php echo site_url('charge/changeSubmit');?>" onkeydown="if(event.keyCode==13) return false";>
                        <ul>
                           <li><span>充值账户：</span><span class="yan_r"><?php echo $customer['name']?></span></li>
                           <li class="yan_l"><span>充值金额：</span><span> <input type="text" onkeyup="value=value.replace(/[^\-?\d.]/g,'')" value="" placeholder="请输入金额" name="amount" class="input-text1"></span></li>
                           <li class="yan_l"><span>微信扫码支付</span><span> <input type="radio" value="2" placeholder="请输入金额" name="payment_id" class=""></span>
                           <span style='margin-left:50px;'>支付宝支付</span><span> <input type="radio" value="1" placeholder="请输入金额" name="payment_id" class=""></span>
                           <span style='margin-left:50px;'>银联支付</span><span> <input type="radio" value="3" placeholder="请输入金额" name="payment_id" class=""></span>
                           </li>
                           
                           <li class="recharge_ka">
                              <p>请注意：在线支付成功后，充值金额会在1分钟内到账；如需要提现，请致电51易货网客服</p>  
                              <p class="recharge_ka_nei">
                                <small><img src="images/zhufu.png"/></small>
                                <em>客服电话：<span>400-0029-777</span></em>
                                <em class="recharge_ka_nei1">服务时间：<span>周一 至 周日  0:00 - 24:00</span></em>
                              </p>
                             <div class="recharge_ka_nei2"><a href="javascript:void(0);" id="sub">下一步</a></div>       
                           </li>
                        </ul>
                    </form>
                    <div class="wenxin">
                       <dl>
                          <h5>温馨提示：</h5>
                          <dd>1. 充值成功后，余额可能存在延迟现象，一般1到5分钟内到账，如有问题，请咨询客服；</dd>
                          <dd>2. 充值金额不得小于0.01元且不得大于50000元；</dd>
                          <dd>3. 您只能用储蓄卡进行充值，如遇到任何支付问题可以查看在线支付帮助；</dd>
                          <dd>4. 充值完成后，您可以进入账户充值记录页面进行查看余额充值状态。</dd>
                       </dl>
                    </div>
                </div> <!--充值账户结束-->
               
            </div>
        </div>
        <!--通用操作 弹窗start-->
<div class="dingdan4_6_tanchuang" style="display:none">
  <div class="dingdan4_3_tanchuang_con">
      <div class="dingdan4_3_tanchuang_top">支付中，请勿关闭页面</div>
      <div class="dingdan4_3_tanchuang_top2">
          <p id='prompt'><img src="images/za1.png"/></p>
          <div class="prompt_1">
            <p>请您在新打开的页面进行支付，支付完成前请不要关闭该窗口。</p>
            <em>
            <div class="prompt_top"><a href="<?php echo site_url('member/property/get_list/2')?>">已完成支付</a></div>
            <div class="prompt_xia"><a href="<?php echo site_url('member/faq')?>">支付遇到问题</a></div>
            <span><a href="javascript:void(0);" id="return">返回重选</a></span>
            </em>
          </div>
      </div>
  </div>
</div>
<!--通用操作 弹窗end-->
</body>
</html>
<script>

		<!--转货豆金额：-->
		
	$("#sub").click(function(){
		
		var cash = $('input[name=amount]').val();
	    var choose_pay = $('input:radio[name="payment_id"]:checked').val();
	   
	    
		var str = "^(([1-9]\\d{0,9})|0)(\\.\\d{1,2})?$";
		if(cash == "" || !cash.match(str))
		{
			alert('请输入正确的充值金额');
		}else if(cash < 0.01){ //cash < 10
			alert('充值金额不能小于0');
		}else if( cash > 50000){ 
			alert('充值金额不能大于50000');
	    }else if(!choose_pay){ 
			alert('请选择支付方式');
		}else{
			$('.dingdan4_6_tanchuang').show();
			document.form.submit();
		}
		
	    
		});

	$("#return").click(function(){
		$('.dingdan4_6_tanchuang').hide();
	});

</script>
