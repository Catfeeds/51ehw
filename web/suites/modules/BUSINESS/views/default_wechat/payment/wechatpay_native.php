<html lang="en" class="no-js">
<head>
<meta charset="UTF-8">
<base href="<?php echo THEMEURL;?>" />
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no" />
<meta name="MobileOptimized" content="640">
<title><?php echo $title;?></title>
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/swiper3.08.min.css">
<link rel="stylesheet" type="text/css" href="css/fonts.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/swiper3.08.jquery.min.js"></script>
<script type="text/javascript" src="js/TouchSlide.1.1.js"></script>
</head>
<body>
<div class="container">
   <div class="page_fix">
    <div class="group_form_list">
                <ul>
                    <li style="margin-bottom: 30px;">
                        <label>微信支付</label>
                        <div id="qrcode"></div>
                        
                    </li>
                    <li  style="margin-bottom: 30px;border-bottom:none;">
                        <p class="text-center" style="margin-bottom: 30px;"><em></em>订单号：<?php echo $out_trade_no; ?></p>
                    </li>
                    <li style="margin-bottom: 30px;border-bottom:none;">
                        <form  action="./order_query.php" method="post">
			                <input name="out_trade_no" type='hidden' value="<?php echo $out_trade_no; ?>">
		                    <button type="submit" class="red-but" style="border:0;">查询订单状态</button>
		                </form>
                    </li>
                    <li style="margin-bottom: 30px;border-bottom:none;">
                        <form  action="./refund.php" method="post">
			                <input name="out_trade_no" type='hidden' value="<?php echo $out_trade_no; ?>">
		                	<input name="refund_fee" type='hidden' value="1">
		                    <button type="submit" class="red-but" style="border:0;" >申请退款</button>
	                	</form>
                    </li>
                    <li style="margin-bottom: 30px;border-bottom:none;">
                        <a href="<?php echo site_url("Home");?>" target="_self" class="red-but">返回首页</a>
                    </li>
                </ul>
               
            </div>    

   </div>
    </div>
	


	

</body>
	<script src="js/qrcode.js"></script>
	<script>
		if(<?php echo $unifiedOrderResult["code_url"] != NULL; ?>)
		{
			var url = "<?php echo $code_url;?>";
			//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
			var qr = qrcode(10, 'M');
			qr.addData(url);
			qr.make();
			var wording=document.createElement('p');
			wording.innerHTML = "扫我，扫我";
			var code=document.createElement('DIV');
			code.innerHTML = qr.createImgTag();
			var element=document.getElementById("qrcode");
			element.appendChild(wording);
			element.appendChild(code);
		}
	</script>
</html>