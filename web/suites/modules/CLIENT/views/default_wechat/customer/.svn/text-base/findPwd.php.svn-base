<!DOCTYPE html>
<html>
    <head>
        <title>找回密码</title>
		<base href="<?php echo THEMEURL; ?>" />
        <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
        <link href="css/base.css" rel="stylesheet" type="text/css"/>
        <link href="css/public.css" rel="stylesheet" type="text/css"/>
        <link href="css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="css/login.css" rel="stylesheet" type="text/css"/>
        <link href="css/form.css" rel="stylesheet" type="text/css"/>
        <link rel="Shortcut Icon" href="logo.ico" type="image/x-icon" />
<link rel="bookmark" href="logo.ico" type="image/x-icon" />
		<script type="text/javascript" src="js/jquery-1.8.2.min.js" ></script>
    </head>
    <body>
        <!-- head-top S -->
       <?php $this->load->view('_header') ?>
        <!-- head-top E -->
        <div class="ui-bd w980">
            <div class="ui-login">
                <div class="ui-login-title">
                    <h3>找回密码</h3>
                </div>
				<form name="findpw" action="<?php echo site_url('customer/getPW')?>" method="post" onsubmit="return checkForm()">
                <div class="ui-login-bd fn-clear">
                    <div class="ui-login-left fn-left">
                        <p class="ui-form-item" style="color:red;">请输入您注册时使用的电子邮箱，我们将给您发送重置密码邮件。</p>
                        <div class="ui-form-item">
                            <label class="ui-title-login">会 员 名<b>:</b></label>
                            <input type="text" name="username" class="text" placeholder="请输入帐号" onChange="javascript:$('#usernameerr').hide()">
							<div style="display: none;" id="usernameerr" class="onLoad"></div>
                        </div>
                        <div class="ui-form-item">
                            <label class="ui-title-login">电子邮箱<b>:</b></label>
                            <input type="text" class="text" name="email" placeholder="请输入..." onChange="javascript:$('#emailerr').hide()">
							<div style="display: none;" id="emailerr" class="onLoad"></div>
                        </div>


						<div id="pnlVerifier" class="ui-form-item">
						<label class="ui-title-login">验证码<b>:</b></label>
						<input name="tbxVerifier" maxlength="5" class="text5"  id="tbxLoginVerifier" autocomplete="off" type="text">
						 
						<input name="hflLoginTimes" id="hflLoginTimes" type="hidden">
					  
						<img src="<?php echo site_url('customer/yzm_img')?>" id="captcha-pic" onclick="change_yzm1(this)" style="cursor: pointer; height: 30px; width: 90px; vertical-align: middle;">

						</div>
						 <?php if($error && $error!=""){?>
						  <div class="onError" >
							<span id="cvlLoginVerifier" style="margin-right: 5px;"><?php echo $error;?></span>
							<em id="loginVerifier" style="padding-left: 0pt;display: none;"></em>
						  </div>
						  <?php }?>
                        <div class="ui-main-login-but">
                            <button type="submit" class="btn-determine">确&nbsp;&nbsp;&nbsp;定</button>
                        </div>
                    </div>
                    <div class="ui-login-note">
                        <span>还不是红酒网会员？</span><a href="<?php echo site_url('customer/registration')?>" title="立即注册" class="ui-login-registration"></a>
                    </div>
                </div>
				</form>
            </div>
        </div>
       <?php $this->load->view('_footer') ?>
    </body>
</html>
<script>
function change_yzm1(obj)
{

    $(obj).attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
}

function checkForm()
{
	if(document.findpw.username.value=="")
	{
		$("#usernameerr").show();
		$("#usernameerr").html("请填写会员名");
		return false;

	}
	else if(document.findpw.email.value=="")
	{
		$("#emailerr").show();
		$("#emailerr").html("请填写Email");
		return false;
	}
	else
	{
		return true;
	}
}
</script>