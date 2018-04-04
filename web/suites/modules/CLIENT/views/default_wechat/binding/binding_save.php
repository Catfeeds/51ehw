
<div class="page clearfix">
	<form action="<?php echo site_url('member/binding/unbundling_update');?>" method='post' name="form1" id="form1">
		<div id="banding_second_verify">
			<div style="width: 50%; margin: auto;">
				<img src="images/bangding_logo.png"
					style="padding-top: 40px; padding-bottom: 35px;">
			</div>

			<div>
				<div style="padding-left: 10px;">
					手机号：<span class="mobile"><?php echo isset($customer['mobile'])? $customer['mobile']:" "; ?></span>
				</div>
			</div>

			<!-- 验证码 开始 -->
			<div style="position: relative">
				<div class="register-num">
					<input id="handset-num" name="handset-num" type="text" placeholder="请输入验证码" autocomplete="off" value="">
				</div>
				<input type="button" class="num-button" id="get_mobile_code" value="获取验证码">
				<input type="hidden" id='mobile_code_type' name='mobile_code_type' value="<?php echo $mobile_code_type;?>">
			</div>
			<!-- 验证码 结束 -->

			<!-- 完成绑定按钮 开始 -->
			<div class="register-button" id="secondSubmitdiv" style="background: #FDCF0C !important; text-align: center; line-height: 45px;">
				<a style="padding:15px 35%;" id="binding_save"><?php echo isset($customer[$type.'_account'])?"确认解绑":"确认绑定";?></a>
			</div>
			<!-- 完成绑定按钮 结束 -->
		</div>
	</form>
</div>

<script type="text/javascript" src="js/verificationCode.js"></script>
<script type="text/javascript">
//进入页面验证是否绑定失败回调
$(function(){
	var err = "<?php echo $err;?>";
	if(err=="1"){
		$(".black_feds").text("验证码有误，请重新输入").show();
		setTimeout("prompt();", 2000);
	}else if(err=="2"){
		$(".black_feds").text("操作失败，请联系客服").show();
		setTimeout("prompt();", 2000);
	}else if(err=="3"){
		$(".black_feds").text("操作失败，请重新操作").show();
		setTimeout("prompt();", 2000);
	}else if(err=="4"){
		$(".black_feds").text("微信授权失败，请重新操作").show();
		setTimeout("prompt();", 2000);
	}else if(err=="5"){
		$(".black_feds").text("验证码已失效，请重新获取").show();
		setTimeout("prompt();", 2000);
	}
})

// 获取验证码
$("#get_mobile_code").click(function(){
	var type = $('#mobile_code_type').val();
	var mobile = $('.mobile').html();
	var get_code_id = "#get_mobile_code";
	get_mobile_code(type,mobile,get_code_id);
})

// 验证短信验证码
$("#binding_save").click(function(){
	var code = $("#handset-num").val();
	var type = $('#mobile_code_type').val();
	var mobile = $('.mobile').html();
	check_code(code,type,mobile);
})

</script>