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
		

		<!--提货权余额纪录开始 -->
		<div class="huankuan_cmRight" id="charge_list" style="width:100%">

			<div class="huankuan_rTop_5" style="display: block">微信扫码支付</div>
			<!--充值账户开始-->
			<div class="recharge" style="display: block;">
				<div class="Wechat" style="display: block;">
					<p>
						微信扫码支付：<span><?php echo number_format($price,2)?></span>元
					</p>
					<div align="center" id="qrcode"></div>
				</div>

			</div>
			<!--充值账户结束-->

		</div>

		<!--提货权余额纪录开始-->
		<div class="huankuan_cmRight" style="display:none; " id="message">
			<div class="huankuan_rTop_5" style="display: block">支付通知</div>
			<div class="transformation_1">
				<span><img src="images/success1.png"></span>
				<h5>保证金支付成功</h5>
				<p>
					<a href="<?php echo site_url('home/index');?>">返回首页</a>
				</p>
			</div>
		</div>
	</div>
	
</body>
</html>
<script src="js/qrcode.js"></script>
<script>
if(<?php echo $unifiedOrderResult["code_url"] != NULL; ?>)

{

var url = "<?php echo $code_url;?>";

//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'

var qr = qrcode(10, 'M');

qr.addData(url);

qr.make();

// var wording=document.createElement('p');

// wording.innerHTML = "扫我，扫我";

var code=document.createElement('DIV');

code.innerHTML = qr.createImgTag();

var element=document.getElementById("qrcode");

// element.appendChild(wording);

element.appendChild(code);

}
$(function (){ 
	is_ok();
	
})

function is_ok(){ 
	$.ajax({ 
        url:"<?php echo site_url('charge/examine_charge')?>",
        data:{order_sn:"<?php echo $order_sn?>"},
        type:'post',
        dataType:'json',
        success:function (data){
            if(data){ 
                $('#charge_list').hide();
            	$('#message').show();
            	 setTimeout(function(){
                 window.location.href="<?php echo site_url("corporate/info");?>"; 
                 },2000);;// 成功后跳转到企业中心
            }else{ 
            	setTimeout("is_ok()",3000); 
            }
        }
	})

}
	</script>
