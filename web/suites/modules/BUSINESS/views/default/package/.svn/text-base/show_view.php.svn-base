<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<base href="<?php echo THEMEURL;?>" />
<link rel="stylesheet" type="text/css" href="css/hongbao/reset.css">
<link rel="stylesheet" type="text/css" href="css/hongbao/style.css">
<link rel="stylesheet" type="text/css" href="css/hongbao/iconfont.css">
<title>51易货网 - 红包列表</title>
</head>
<body>
	<!-- <div class="red_envelope_top">
		<ul>
			<a href=""><li class="icon-fanhui"></li></a>
			<li>51易货网</li>
		</ul>
	</div> -->
	<div class="red_envelope_content">
		<div class="background_yellow">
			<h1>
				<img src="images/huangsebeijing6.png"> <img class="touxiang9"
					src="<?php echo IMAGE_URL.$sender['img_avatar'];?>">
			</h1>
		</div>
		<div class="red_envelope_font">
			<h2><?php echo $sender['nick_name'];?>的易货红包</h2>
			<h3>
			<?php if(!$is_full):?>
				<span class="shuzi_big"><?php echo $package['amount'];?></span>M
				<?php else:?>
				<span class="shuzi_big">红包已经被抢完了！</span>
				<?php endif;?>
			</h3>

			<h2 class="hongbao3"><?php if(!$is_full):?>已存入红包<?php endif;?></h2>

			<a href="<?php echo site_url('member/info');?>"><span class="center_button">进入个人中心</span></a>

			<div class="red_envelope_otgher">
			<?php if(!$is_full):?>
				<h4>系统已经将提货权绑定到您的手机号 , 请登录51易货网</h4>
				<h4>使用 , 登录账号和密码均为手机号 , 登录后请修改密码并补充资料</h4>
				<?php endif;?>
			</div>

		</div>
		<div class="con_name_time">
			<ul>
        <?php foreach ($getter as $man):?>
            <li><img src="<?php echo IMAGE_URL.$man['img_avatar'];?>">
				<h1><?php echo $man['nick_name'];?><p><?php echo $man['receive_at'];?></p></h1>
				<span><?php echo $man['amount'];?>M</span></li>
        <?php endforeach;?>
			</ul>
		</div>
	</div>
</body>
</html>
