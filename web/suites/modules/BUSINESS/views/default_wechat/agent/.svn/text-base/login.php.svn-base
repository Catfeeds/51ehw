<?php
header("Cache-Control:no-cache,must-revalidate,no-store"); // 这个no-store加了之后，Firefox下有效
header("Pragma:no-cache");
header("Expires:-1");
?>
<?php

$_err_msg = $this->input->get_post("err_msg");
if ($_err_msg != 0) {
    echo "<script>alert('用户名密码错误!');</script>";
}
?>
<div class="container" style="background-color: #e8e8e8">
	<div class="header_fix" name="top">
		<a href="<?php echo isset($back)?site_url($back):"javascript:history.back()";?>"
			style="position: fixed; top: 15px; left: 15px;"><img
			src="<?php echo THEMEURL.'/images/icon-back.png';?>" height="16"
			width="9" alt=""></a>
		<p class="title">51易货合伙人</p>
	</div>
	<!--header end-->

	<form action="<?php echo site_url("Agent/home/check_agent")?>"
		method="post" id="form_login">
		<!-- <div style="margin-top: 10px;">
			<span id="error_tip"
				style="line-height: 15px; width: 100%; color: red; font-size: 12px; margin-left: 13px;"><?php //echo $err_msg;?>
			</span>
		</div> -->
		<div class="logo_content" style="margin-top: 12px;">
			<p>
				<input type="text" value="" name="agentname" id="agentname"
					placeholder="请输入您的账号" style="width: 93.33%">
			</p>
			<p>
				<input type="password" value="" name="password" id="password"
					placeholder="请输入您密码" style="width: 93.33%">
			</p>
		</div>
		<!-- logo_content end -->


		<div class="login_button">
			<span onclick="form_login();">登录</span>
		</div>
		<!-- login_button end -->
	</form>
</div>
<!--container end-->
</body>
</html>
<script>
$("#agentname").blur(function(){
	if($("#agentname").val()==""){
	    $("#error_tip").html("请输入您的账号");
	}
});
$("#agentname").click(function(){
	$("#error_tip").html("");
});
$("#password").blur(function(){
	if($("#password").val()==""){
		$("#error_tip").html("请输入您的密码");
	}
});
$("#password").click(function(){
	$("#error_tip").html("");
});
function form_login(){
    var sub = true;
	if($("#agentname").val()==""){
		$("#error_tip").html("请输入您的账号");
	    sub = false;
	}else if($("#password").val()==""){
		$("#error_tip").html("请输入您的密码");
		sub = false;
	}else{
	    sub = true;
	}

	if(sub){
	    $("#form_login").submit();
	}
	
}
</script>