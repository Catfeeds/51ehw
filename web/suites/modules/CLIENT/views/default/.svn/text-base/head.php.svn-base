<?php include_once 'template_common.php';?>
<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html> 
<!--<![endif]-->
<head>
<meta charset="utf-8">
<title><?php echo $this->session->userdata('app_info')['company_name'];?> - <?php echo isset( $title ) ? $title :$this->session->userdata('app_info')['seo_title'];?></title>
<base href="<?php echo THEMEURL; ?>" />
<meta name="keywords"
	content="<?php echo isset($KeyWords) ? $KeyWords : $this->session->userdata('app_info')['seo_keyword'];?>">
<meta name="description"
	content="<?php echo isset($Description) ? $Description :$this->session->userdata('app_info')['seo_description'];?>">

<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" type="text/css" href="css/theme/style.css">
<link rel="stylesheet" type="text/css" href="css/theme/iconfont.css">
<link rel="stylesheet" type="text/css" href="css/theme/style_v2.css">
<!-- Favicon and Apple Icons -->
<link rel="icon" type="image/png" href="images/icons/icon.png">
<link rel="apple-touch-icon" sizes="57x57"
	href="images/icons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="72x72"
	href="images/icons/apple-icon-72x72.png">
<script type="text/javascript" src="js/jquery.min.js"></script>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<?php if($this->session->userdata('app_info')['wechat_appid'] == NULL){?>
		<script type="text/javascript">
		wx.config({
		    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		    appId: '<?php echo $this->session->userdata('app_info')['wechat_appid'];?>', // 必填，公众号的唯一标识
		    timestamp: <?php echo strtotime(date('Y-m-d H:i:s'));?>, // 必填，生成签名的时间戳
		    nonceStr: '', // 必填，生成签名的随机串
		    signature: '',// 必填，签名，见附录1
		    jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
		});
		</script>
		    <?php }?>
		<script type="text/javascript">
	      	base_url="<?php echo site_url();?>";
		</script>
<script type="text/javascript" src="js/global.js"></script>
</head>
<body>