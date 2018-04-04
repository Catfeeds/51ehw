<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<link href="css/reset.css" rel="stylesheet" type="text/css"> 注释-->
<link href="css/theme/swiper3.08.min.css" rel="stylesheet"
	type="text/css">
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
			<ul>
			<li class="kehu_title"><a>需求管理</a></li>
			<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
			<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
			<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
		    </ul>
		</div>

		<!--货豆余额纪录开始-->
		<div class="huankuan_cmRight" id="charge_list">

			<div class="huankuan_rTop_5" style="display: block">微信扫码支付</div>
			<!--充值账户开始-->
			<div class="recharge" style="display: block;">
				<div class="Wechat" style="display: block;">
					<p>
						<?php echo $title ?>：<span id='wx_price'></span> 元
					</p>
					<div align="center" id="qrcode"></div>
				</div>

			</div>
			<!--充值账户结束-->

		</div>

		<!--货豆余额纪录开始-->
		<div class="huankuan_cmRight" style="display:none; " id="message">
			<div class="huankuan_rTop_5" style="display: block">充值通知</div>
			<div class="transformation_1">
				<span><img src="images/success1.png"></span>
				<h5>充值成功</h5>
				<p>
					<a href="<?php echo site_url('member/property/get_list/2');?>">点击查看我的资产</a>
				</p>
			</div>
		</div>
	</div>
	
</body>
</html>
<script src="js/qrcode.js"></script>
<script>

//获取支付二维码
function wechat_code(id,status)
{
    $.ajax({
        url:'<?php echo site_url('Wechatpay/Native_dynamic_qrcode/charge')?>'+'/'+id+'/'+status, //微信
        dataType:'json',
        type:'get',
        beforeSend:function(){     
        	
	    },
        success:function(data){

        	if( data.code_url )
    		{
        		var price = data.price+'';
        		
				if( price.indexOf(".") == -1 )
				{ 
    				
        			price = price+'.00';
				}

        		
        		$('#wx_price').text(price);
        		var url = data.code_url;
        		//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
        		var qr = qrcode(10, 'M');
        		qr.addData(url);
        		qr.make();
        		var code=document.createElement('DIV');
        		code.innerHTML = qr.createImgTag();
        		var element=document.getElementById("qrcode");
        		element.appendChild(code);
        		is_ok( id, status );
        		
    		}else{ 
        		
				alert('支付失败，请联系客服');
    		}

        },
        error:function(){
        	alert("微信扫码获取失败,请选择支付宝支付");
        }
    })
}



$(function (){ 

	wechat_code('<?php echo $charge_id?>','<?php echo $status?>');
	
})

function is_ok( id, type ){ 
	
	$.ajax({ 
        url:"<?php echo site_url('charge/examine_charge')?>",
        data:{charge_id:id},
        type:'post',
        dataType:'json',
        success:function (data){
           
            if ( data.status == 1 )
            {
				$('#charge_list').hide();
            	
            	switch (type)
                { 
                	case 1:
                		$('#message').show();
                    	break;  
                	case 3:
                		$('#message').find('a').hide();
                     	$('#message').show().find('h5').text('开通成功，重新登录后生效');
                    	break;  
                }
               
            }else{ 
            	setTimeout("is_ok("+id+","+type+")",3000); 
            }
        }
	})

}
	</script>
