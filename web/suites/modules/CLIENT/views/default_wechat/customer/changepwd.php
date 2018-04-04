
<script type="text/javascript">
var msg = '<?php echo $error_msg; ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'code_error' : 
				$(".black_feds").text("验证码有误，请重新输入").show();
				setTimeout("prompt();", 2000);
				break;
			case 'pw_repeat' : 
    			$(".black_feds").text("新旧密码不能一致").show();
    			setTimeout("prompt();", 2000);
    			break;
			case 'error' : 
    			$(".black_feds").text("网络错误").show();
    			setTimeout("prompt();", 2000);
    			break;
			case 'code_timeout' : 
    			$(".black_feds").text("验证码已失效，请重新获取").show();
    			setTimeout("prompt();", 2000);
    			break;
			case 'update_success' : 
    			$(".black_feds").text("密码修改成功").show();
    			setTimeout("prompt();", 2000);
    			break;
			default : break;
		}
	}	
});
</script>

<div class="page clearfix">
	<form name="form1" method="post" action="<?php echo site_url('member/info').($mobile_code_type==1?"/pwd_save":"/paypwd_save");?>" id="form1">
		
		<!-- 修改密码 -->
		
		<!-- 输入密码和验证码 -->
		<div>
			<div style="position: relative">
				<div class="register-num">
					<input id="handset-num" name="handset-num" type="text" placeholder="请输入验证码" autocomplete="off" value="">
				</div>
				<input type="button" class="num-button" id="get_mobile_code" value="获取验证码">
				<input type="hidden" id='mobile_code_type' name='mobile_code_type' value="<?php echo $mobile_code_type;?>">
			</div>

			<!-- 密码 -->
			<div class="bangding_login-mima">
				<input class="mima_text" type="text" onfocus="this.type='password'" name="txtNewPwd" placeholder="<?php echo $mobile_code_type==1?"请输入登录密码":"请输入支付密码";?>" autocomplete="off">
				<span style="display: none;"></span>
				<div class="bangding_login-mima-icon">
					<div class="checkbtn">
						<em class="b-text">abc</em> <em class="b-pwd">...</em> <em class="text-bg"></em> <em class="pwd-bg"></em>
					</div>
				</div>
			</div>
			<div style="margin-left: 10px; margin-top: 5px; font-size: 12px;">
				<span style="color: #535353;"><span style="color: #FB9A36;">*</span>6-16位数字或英文字母</span>
			</div>
			<div class="register-button" id="update_password_save">
				<a style="padding:15px 35%;color:#fff;" id="update_password_save">提交</a>
			</div>
		</div>
		<!-- 输入密码和验证码 结束 -->

	</form>
</div>
<!--page end-->

<!-- 验证码相关js -->
<script type="text/javascript" src="js/verificationCode.js"></script>
<script>

// 获取验证码
$("#get_mobile_code").click(function(){
	var type = $('#mobile_code_type').val();
	var mobile = "<?php echo $mobile;?>";
	var get_code_id = "#get_mobile_code";
	get_mobile_code(type,mobile,get_code_id);
})

// 输入框验证
$("#update_password_save").click(function(){
	var txtNewPwd = $("input[name='txtNewPwd']").val();
	if(!txtNewPwd){
		$(".black_feds").text("密码不能为空，请重新输入").show();
		setTimeout("prompt();", 2000);
		return;
	}else if(txtNewPwd.length<6 || txtNewPwd.length>16){
		$(".black_feds").text("密码应为6-16位数字或英文字母").show();
		setTimeout("prompt();", 2000);
		return;
	}
	
	$(".black_feds").text("正在修改密码，请稍候...").show();

	//验证短信验证码
	var code = $("#handset-num").val();
	var type = $('#mobile_code_type').val();
	var mobile = "<?php echo $mobile;?>"
	check_code(code,type,mobile);
})

</script>

<!-- 密码框是否显示相关js -->
<script type="text/javascript">

$(".text-bg").on("touchstart",function(){
    $(".mima_text").attr('type', 'text');
    $(".text-bg").css("display","none");
    $(".pwd-bg").css("display","block");
    $(".checkbtn").css("background","#D5D5D5");
})
$(".pwd-bg").on("touchstart",function(){
    $(".mima_text").attr('type', 'password');
    $(".text-bg").css("display","block");
    $(".pwd-bg").css("display","none");
    $(".checkbtn").css("background","#fff");
})

</script>