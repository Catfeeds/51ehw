<!DOCTYPE html>
<html>
<head>
    <title>信息提示</title>
	<base href="<?php echo THEMEURL; ?>" />
    <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
    <link href="css/base.css" rel="stylesheet" type="text/css"/>
    <link href="css/public.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.css" rel="stylesheet" type="text/css"/>
    <link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
</head>
<body>
<!-- head-top S -->
<?php $this->load->view('_header');?>
<!-- head-top E -->
<!-- 出错信息 s -->


	<div class="w980 ">
        <dl class="ui-error-dl fn-clear">
            <dt class="ui-error-dt"><img src="images/400_img.png"/></dt>
            <dd class="ui-error-dd">
				<?php if($type):?>
					<span><?php echo $msg; ?> </span>
				<?php else:?>
					<span><?php echo $msg; ?> </span>
				<?php endif;?>
			</dd>
			<?php if($auto): ?>
				<script>setTimeout("redirect('<?php echo $goto; ?>');", 5000);</script>
			<dd class="ui-error-dd"><span >5秒后跳转</span></dd>
            <dd class="ui-error-dd"><a href="<?php echo $goto; ?>" class="ui-main-a">点击回首页</a></dd>
			<?php else :?>
				<dd class="ui-error-dd"><span ></span></dd>
            <dd class="ui-error-dd"><a href="<?php echo $goto; ?>" class="ui-main-a">点击回首页</a></dd>
			<?php endif;?>
			
            
        </dl>
    </div>


	
<!-- 出错信息 e -->
<?php $this->load->view('_footer');?>
</body>
</html>
<script> 
function redirect($url)
{
	location = $url;	
}
</script>