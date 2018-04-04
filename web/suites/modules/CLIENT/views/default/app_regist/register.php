<!DOCTYPE html>
<html>
    <head>
        <title>注册</title>
		<base href="<?php echo THEMEURL.'app_regist/'; ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="assets/css/default/register.css">

    </head>
    <body>
        <div data-role="page" id="pageone">
            <div data-role="header">
                <div class="ui-head-logo"><img src="assets/images/default/logo.png"/></div>
            </div>
            <div class="content">
			<form name="app_regist" action="<?php echo site_url('customer/appregist_do')?>" method="post">
                <div class="ui-title"> <h3>会员帐号申请</h3></div>
                <div class="ui-login-box">
                    <ul>
                        <li><label>登录账号</label><input type="text" name="username" class="text" placeholder="手机号/QQ号码/邮箱" value="<?php if(isset($username)) echo $username?>"></li>
                        <li><label>登录密码</label><input type="password" name="password" class="text" placeholder="6--16位之间，由字母、数字或特殊符号组成"></li>
                        <li><label>确定密码</label><input type="password" name="compassword" class="text" placeholder="请重复输入您的密码"></li>
                        <li><label>您的姓名</label><input type="text" name="name" class="text" placeholder="请填写您的真实姓名" value="<?php if(isset($name)) echo $name?>"></li>
                        <li><label>手机号码</label><input type="text" name="mobile" class="text" placeholder="请填写您的真实手机号码" value="<?php if(isset($mobile)) echo $mobile?>"></li>
                        <li class="none"><label>联系邮箱</label><input type="text" name="email" class="text" placeholder="请填写您的联系邮箱" value="<?php if(isset($email)) echo $email?>"></li>
                    </ul>
					<input type="hidden" name="parentid" value="<?php echo  $id?>">
                </div>
                <div class="accept">
                    <input data-name="用户协议" type="checkbox" name="protocol" autocomplete="off" class="ui-prettyform-hidden">
                    <span>我已认真阅读并同意《会员管理章程》</span>
                </div>
                <div class="push-button">
                    <input  type="button" value="取   消" class="ui-button"  />
                    <input  type="button" value="提交申请"  class="ui-button" onclick="submitCheck()"/>
                </div>
			</form>
            </div>
        </div>
    </body>
</html>

<script>
function submitCheck()
{
	reg_mobile = /^[1][3,4,5,8][0-9]{9}$/;
	reg_email = /^([a-zA-Z0-9_\\-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([a-zA-Z0-9\\-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)$/;

	if(document.app_regist.username.value =="")
	{
		alert("请填写用户名");
	}else if(document.app_regist.username.value.length<4 ||document.app_regist.username.value.length>12)
	{
		alert("请填写正确用户名");
	}
	else if(document.app_regist.password.value == "")
	{
		alert("请填写密码");
	}
	else if(document.app_regist.password.value.length<6 ||document.app_regist.password.value.length>16)
	{
		alert("密码长度不正确");
	}
	else if(document.app_regist.compassword.value == "")
	{
		alert("请填写确认密码");
	}else if(document.app_regist.password.value !=document.app_regist.compassword.value)
	{
		alert("确认密码与原密码不符");
	}else if(document.app_regist.mobile.value == "")
	{
		alert("请填写手机号码");
	}else if(document.app_regist.email.value == "")
	{
		alert("请填写联系邮箱");
	}else if(!reg_mobile.exec(document.app_regist.mobile.value))
	{
		alert("请填写正确手机号码");
	//}
	//else if(!reg_email.exec(document.app_regist.email.value))
	//{
	//	alert("请填写正确联系邮箱");
	}else if(document.app_regist.protocol.checked == false)
	{
		alert("请确认会员管理章程");
	}
	else
	{
		document.app_regist.submit();
	}

}

<?php if(isset($message) && $message != ""){?>
	alert("<?php echo $message?>");
<?php }?>
</script>