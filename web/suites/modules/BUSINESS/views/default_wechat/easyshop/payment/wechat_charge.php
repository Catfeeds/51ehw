<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>

	<script type="text/javascript">

		//调用微信JS api 支付
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters;
				error_log($jsApiParameters);
				?>,
				function(res){
					WeixinJSBridge.log(res.err_msg);
					if(res.err_msg == "get_brand_wcpay_request:ok"){
						location.href = "<?php echo site_url("easyshop/payment/Return_url/view/".$charge['charge_no']."/1");?>";
					}else if(res.err_msg == "get_brand_wcpay_request:cancel"){
						location.href = "<?php echo site_url("easyshop/payment/Return_url/view/".$charge['charge_no']."/2");?>";
					}else if(res.err_msg == "get_brand_wcpay_request:fail"){
						location.href = "<?php echo site_url("easyshop/payment/Return_url/view/".$charge['charge_no']."/3");?>";
					}
					//alert(res.err_code+res.err_desc+res.err_msg);
				}
			);
		}

		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			    }
			}else{
			    jsApiCall();
			}
		}
	</script>
</head>
<body onload="callpay()">
</body>
</html>