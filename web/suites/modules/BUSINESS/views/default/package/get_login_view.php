<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<base href="<?php echo THEMEURL;?>" />
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="css/hongbao/reset.css">
<link rel="stylesheet" type="text/css" href="css/hongbao/style.css">
<link rel="stylesheet" type="text/css" href="css/hongbao/iconfont.css">
<title></title>
</head>
<body>
	<form action="<?php
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false):
	   echo site_url('package/update_get_login');
	else:
	   echo site_url('customer/check_customer');
	endif;
	?>"
	id="loginform" method="post" name="loginform">
		<div class="send_box">
			<div class="red_envelope_top">
				<ul>
					<a href="javacript:history.back();"><li class="icon-fanhui"></li></a>
					<li>51易货网</li>
				</ul>
			</div>
			<div class="envelope_login">
				<div class="envelope_logins">
					<input type="text" placeholder="输入51易货网账号" name="tbxLoginNickname">
					<input type="password" placeholder="输入密码" name="tbxLoginPassword">
					<input type="hidden" name="mobile" value="<?php echo $mobile;?>">
					<input type="hidden" name="package_id" value="<?php echo $package_id;?>"> <a
						href="javascript:document.loginform.submit();"><h5>验证用户名密码</h5></a>
				</div>
			</div>
		</div>
	</form>
</body>
</html>
