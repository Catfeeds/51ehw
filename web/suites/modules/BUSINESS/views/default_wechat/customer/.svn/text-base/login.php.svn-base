<style type="text/css">
body {
	overflow: hidden;
}
.new_container {background: #EEEEEE!important;}
.quick-login {border-top: 1px solid #E5E5E5;margin-top: 45px;position: relative;}
.quick-login h4 {position: absolute;top: -8px;left: 50%;color: #616161;width: 140px;margin-left: -70px;padding: 0 20px;font-size: 13px;text-align: center;}
.quick-login-choice {margin-top:30px;text-align: center;}
.quick-login-choice a {padding: 0 0px;font-size: 13px;color: #595D62;}
.icon-weixin {display: block;color: #149F16;font-size: 30px;}
.new_container {margin-bottom: 0px;}
</style>
	<form action="<?php echo site_url('customer/check_customer')?>"
		id="login-form" method="post">
		<div class="logo_main" style="text-align: center; padding-top: 15px;">
			<!-- <img src="images/reg_logo.jpg" alt=""><br> -->
			<input id="account_name" type="tel" value="" placeholder="请输入手机号码"
				name="tbxLoginNickname" required="required"
				style="height: 40px; width: 93.33%; margin-bottom: 15px; border: 1px solid #FCFCFC; border-radius: 2px; font-size: 15px; text-indent: 10px;" ><br>
			<input id="password" type="password" value="" placeholder="请输入登录密码"
				name="tbxLoginPassword" required="required"
				style="height: 40px; width: 93.33%; margin-bottom: 20px; border: 1px solid #FCFCFC; border-radius: 2px; font-size: 15px; text-indent: 10px;"><br>
			<button id="login_sub"
				style="text-align: center; height: 45px; width: 94.66%; background-color: #FDCF0C; border: 1px solid #FDCF0C; border-radius: 2px; color: #fff; font-size: 16px; outline: none;">登录</button>
			<br>
			<a href="<?php echo site_url("customer/forget_password");?>"> <span
				style="float: right; padding-right: 1.8%; padding-top: 15px; font-size: 15px; color: #535353;">忘记密码？</span></a>
		</div>
	</form>
	
	<!-- 其他登陆方式 -->
		<div style="position: relative;width:90%;left:5%;margin-top: 200px;">
			<div class="quick-login">
    			<h4>其他登录方式</h4>	
    			<div class="quick-login-choice">
    			    <a href="javascript:wechat_login();">
    			    <!-- <a href="http://weixin.qq.com/r/OEzUzGjEzTWyrSyv9xkq"> -->
    				<span class="icon-weixin"></span>
    			    <span class="">微信</span>
    			    </a>
    			</div>
		    </div>
		</div>



</div>

<script>

$(function(){
	var err = "<?php echo $err_msg?>";
	if(err!=""){
		$(".black_feds").text(err).show();
		setTimeout("prompt();", 2000);
		return;
	}
})

function wechat_login(){
	$(".black_feds").text("请关注51易货网微信公众号，或者在微信端打开当前网页").show();
	setTimeout("prompt();", 2000);
}
</script>