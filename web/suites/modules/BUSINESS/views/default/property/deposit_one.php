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
                <!-- li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li> -->
                <!--<li><a href="#">在线客服</a></li>
                <li><a href="#">返修退换货</a></li>-->
            </ul>
            <ul>
			<li class="kehu_title"><a>需求管理</a></li>
			<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
			<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
			<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
		    </ul>
        </div>

         <!--货豆余额纪录开始-->
		<div class="huankuan_cmRight" display:block">
     
            <div class="huankuan_rTop_5" style="display: block">充值</div>
                 <!--充值账户开始-->
                <div class="recharge" style="display:block;">
                  <ul>
                       <li><span>充值账户：</span><span class="yan_r">张大大</span></li>
                       <li class="yan_l"><span>充值金额：</span><span> <input type="text" value="" placeholder="请输入金额" name="title" class="input-text1"></span></li>
                       <li class="yan_l"><span>微信扫码支付</span><span> <input type="radio" value="2" placeholder="请输入金额" name="title" class=""></span>
                       <span style='margin-left:50px;'>支付宝支付</span><span> <input type="radio" value="2" placeholder="请输入金额" name="title" class=""></span>
                       </li>
                       
                       <li class="recharge_ka">
                          <p>请注意：在线支付成功后，充值金额会在1分钟内到账；如需要提现，请致电51易货网客服</p>  
                          <p class="recharge_ka_nei">
                            <small><img src="images/zhufu.png"/></small>
                            <em>客服电话：<span>400-0029-777</span></em>
                            <em class="recharge_ka_nei1">服务时间：<span>周一 至 周日  0:00 - 24:00</span></em>
                          </p>
                         <div class="recharge_ka_nei2"><a href="javascript:void(0);" id="step1">下一步</a></div>       
                       </li>
                 </ul>
                    <div class="wenxin">
                       <dl>
                          <h5>温馨提示：</h5>
                          <dd>1. 充值成功后，余额可能存在延迟现象，一般1到5分钟内到账，如有问题，请咨询客服；</dd>
                          <dd>2. 充值金额输入值必须是不小于10且不大于50000的正整数；</dd>
                          <dd>3. 您只能用储蓄卡进行充值，如遇到任何支付问题可以查看在线支付帮助；</dd>
                          <dd>4. 充值完成后，您可以进入账户充值纪录页面进行查看余额充值状态。</dd>
                       </dl>
                    </div>
                </div> <!--充值账户结束-->
               
            </div>
        </div>
</body>
</html>
<script>
// $("#collect_shops").click(function(){
// 	    $(".kehuguanli_con_top_1").css("display","block");
// 	    $(".kehuguanli_con_top").css('display','none'); 
// 	    $("#collect_shop").parent().removeClass();
// 		$(".huankuan_rTop").hide()
// 		$(".huankuan_rTop_1").hide()
// 	    $(".huankuan_rTop_2").show()
// 		$(".huankuan_rTop_3").hide()
// 		$(".kehuguanli_con04").show()
// 	    $("#collect_shops").parent().addClass("huankuan_rCon01_current");
// 		});
// 	$("#collect_shop").click(function(){
// 	    $(".kehuguanli_con_top_1").css("display","none");
// 	    $(".kehuguanli_con_top").css('display','block');
// 	    $("#collect_shops").parent().removeClass();
// 		$(".huankuan_rTop").show()
// 	    $(".huankuan_rTop_2").hide()
// 		$(".huankuan_rTop_1").hide()
// 	    $("#collect_shop").parent().addClass("huankuan_rCon01_current"); 
// 		});
	
// 	$("#detailed_2").click(function(){
// 	    $(".kehuguanli_con03").css("display","block");
// 	    $(".kehuguanli_con02").css('display','none'); 
// 	    $("#detailed_1").parent().removeClass();
// 		$(".huankuan_rTop").hide()
// 	    $(".huankuan_rTop_1").show()
// 	    $("#detailed_2").parent().addClass("huankuan_rCon01_curren1");
// 		});	
// 	$("#detailed_1").click(function(){
// 	    $(".kehuguanli_con03").css("display","none");
// 		 $(".kehuguanli_con02").css('display','block'); 
// 		$(".huankuan_rTop").show()
// 	    $(".huankuan_rTop_1").hide()
// 	    $("#detailed_2").parent().removeClass();
// 	    $("#detailed_1").parent().addClass("huankuan_rCon01_curren1");
// 		});	
		
	$("#sure").click(function(){
			$(".huankuan_cmRight").hide()
			$(".huankuan_cmRight_1").show()
			$('.dingdan4_3_tanchuang').hide();
			$('.huankuan_rTop_4').show();
		});	
		
	$("#cash").click(function(){
			$('.dd').hide();
		
		});	
	$("#cash1").click(function(){
		    $(".huankuan_cmRight").hide()
			$(".huankuan_cmRight_1").hide()
		   $(".huankuan_cmRight_2").show()
			$('.dingdan4_3_tanchuang').hide();
			$('.huankuan_rTop_4').show();
		});	
		<!--转货豆金额：-->
		
	$("#determine_1").click(function(){
		var cash = '<?php echo isset($customer['cash']) ? $customer['cash'] :'0.00'?>';
		var m_credit = $('input[name=charge_m]').val();

		var str = "^(([1-9]\\d{0,9})|0)(\\.\\d{1,2})?$";
		if(m_credit == "" || !m_credit.match(str))
		{
			alert('请输入正确的充值金额','确定',"$('.purchaase_failure').hide()");
		}else if(m_credit < 10){
			alert('购买数量小于等于10','确定',"$('.purchaase_failure').hide()");
		}else if( m_credit > 50000){ 
			alert('购买数量不能大于50000','确定',"$('.purchaase_failure').hide()");
		}else if("<?php echo count($customer)?>" == 0){
			alert('未开通支付账号');
		}else if( '<?php echo $customer['pay_passwd']?>' ==  '' ){ 
			$('#dingdan4_3_tanchuang_3').show();
	    }else if( m_credit > parseFloat(cash) ){ 
	        alert('现金余额不足');
	    }else{ 
			$('#pass_message').hide();
			$('.dingdan4_5_tanchuang').show();
		}
// 		
		});

	function ajax_submit(){ 
		var m_credit = $('input[name=charge_m]').val();
		var pass = $('input[name=pay_password]').val();
		
		$.post("<?php echo site_url('charge/purchase_M')?>",{m_credit:m_credit,pass:pass},function(data){
			if(data){ 
	            switch(data){ 
	            case 1:
	                $('input[name=charge_m]').val('');
	                $('.huankuan_rTop_4').hide();
	        		$('.huankuan_rTop_6').show();
	        		$('.transformation').hide();
	        		$('.dingdan4_5_tanchuang').hide();
	        		$('.transformation_1').show();
	                break;
	            case 2:
	           	    alert('现金余额不足');
	                break;
	            case 3:
	            	alert('未开通支付账号');
	            	break;
	            case 4:
	            	$('#pass_message').show();
	            	break;
	            }
	        }else{ 
	      	  alert('充值失败请稍后再试','确定',"$('.purchaase_failure').hide()");
	        }    
		},"json");
	}
	
	$(".dingdan4_3_btn03").on("click",function(){
		$('.dingdan4_5_tanchuang').hide();
		$('.huankuan_rTop_4').show();
		$('.huankuan_rTop_6').hide();
		$('.transformation').show();
		})
		
// 	$("#sure_1").click(function(){
// 		$('.huankuan_rTop_4').hide();
// 		$('.huankuan_rTop_6').show();
// 		$('.transformation').hide();
// 		$('.dingdan4_5_tanchuang').hide();
// 		$('.transformation_1').show();
// 		});	
		
    $("#alipay").click(function(){
	    $(".kehuguanli_con_top_1").css("display","block");
	    $(".Wechat").css('display','none'); 
	    $("#payment1").parent().removeClass();
	    $("#alipay").parent().addClass("recharge_1_top1");
		$('.Wechat').hide();
		$('.Wechat_1').show();
		});
	$("#payment1").click(function(){
	    $(".kehuguanli_con_top_1").css("display","none");
	    $(".Wechat").css('display','block');
	    $("#alipay").parent().removeClass();
	    $("#payment1").parent().addClass("recharge_1_top1"); 
		$('.Wechat_1').hide();
		});
		
	$("#step1").click(function(){
		$('.recharge').hide();
		$('.recharge_1').show();
		$('.huankuan_rTop_5').hide();
		$('.huankuan_rTop_7').show();
		});
    $("#button_2").click(function(){
	    $("#button_1").parent().removeClass();
	    $("#button_2").parent().addClass("tab_button1");
		$('.Wechat_xia').hide();
		$('.Wechat_xia1').show();
		});
	$("#button_1").click(function(){
	    $("#button_2").parent().removeClass();
	    $("#button_1").parent().addClass("tab_button1"); 
		$('.Wechat_xia').show();
		$('.Wechat_xia1').hide();
		});
	$("#confirm").click(function(){
		$('.dingdan4_6_tanchuang').show();
		});
			
	$("#return").click(function(){
		$('.dingdan4_6_tanchuang').hide();
		});
		
</script>
<script>
	 function show(){ 
	$('#dingdan4_3_tanchuang').show();
     }
	$(".dingdan4_3_btn01").on("click",function(){
		$('.dingdan4_3_tanchuang').hide();
		$(".dd").show()
		$('.huankuan_rTop_3').hide();
		})
</script>