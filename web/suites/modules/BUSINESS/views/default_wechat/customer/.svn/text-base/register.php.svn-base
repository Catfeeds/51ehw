
<style type="text/css" href="css/validator.css"></style>
<style type="text/css">
	.bangding_login-mima input {width: 80%;}
</style>
<div class="container">
	<div class="page clearfix">
		<div class="login-container">
			<form name="form1" method="post" action="<?php echo site_url('customer/save')?>" onsubmit="javascript:return WebForm_OnSubmit();" id="form1">

				<!-- 手机号码验证 开始 -->
				<div style="margin-top: 117.5px; display: block;" id="banding_first_verify">
					<div class="bangding_login-mima">
						<input class="mima_text" id="mobile" name="mobile" type="tel" placeholder="请输入手机号" autocomplete="off" value=''>
						<!-- value='18814148940' -->
					</div>
					<div class="register-button" style="background: #F6CA0B !important; color: #262626 !important; margin-top: 20px;margin-bottom: 15px;">
						<a id="firstSubmit">下一步</a>
					</div>
					<a href="<?php echo site_url('customer/login')?>" class='zhuce_login_text'><span>立即登录</span></a>
				</div>
				<span id='mobiletest' style='display: none'></span>
				<!-- 手机号码验证 结束 -->

				<!-- 输入密码和验证码 -->
				<div style="display: none;padding-top: 61px;" id="banding_second_verify">
					<div style="position: relative;border-bottom:1px solid #EAECEA;margin:0 11.5%;overflow: hidden;">
						<div class="register-num">
							<input id="captcha" name="yzm" type="text" placeholder="请输入验证码" autocomplete="off" required="required">
						</div>
						<a id="change_img" class="num-button"><img src="<?php echo site_url('customer/yzm_img')?>" id="czy" style="cursor: pointer; width: 72px;height: 27px;margin:0"></a>
					</div>
					<div style="position: relative;border-bottom:1px solid #EAECEA;margin:0 11.5%;overflow: hidden;">
						<div class="register-num">
							<input id="handset-num" name="mobile_vertify" type="tel" placeholder="请输入验证码" autocomplete="off" required="required">
						</div>
						<input type="button" class="num-button" id="get_mobile_code" value="获取验证码">
					</div>
					<!-- 密码 -->
					<div class="bangding_login-mima">
						<input type="password"  class="mima_text" id="tbxRegisterPassword" name="tbxRegisterPassword" placeholder="6～16位密码，数字或字母" autocomplete="off" required="required">
						<div class="bangding_login-mima-icon">
						   <em class="text-bg01 icon-chakanmima1"></em> <em class="pwd-bg01 icon-chakanmima"></em>
						</div>
					</div>
					<!-- <div style="margin-left: 10px; margin-top: 5px; font-size: 12px;">
						<span style="color: #535353;"><span style="color: #FB9A36;">*</span>6-16位数字或英文字母</span>
					</div> -->
					<div class="register-button" id="secondSubmitdiv">
						<a id='register_save'>完成</a>
					</div>
				</div>
				<!-- 输入密码和验证码 结束 -->
			</form>
		</div>
		<!--login-container end-->
	</div>
	<!--page end-->
</div>
<!--container end-->

<style>
<!--
.errors {
	background: #FFF2E9 url(images/reg3.gif) no-repeat;
	padding-left: 25px;
	height: 20px;
	line-height: 20px;
	border: none;
	color: red;
	margin-bottom: 10px;
}

.success {
	background: #E9FFEB url(images/reg4.gif) no-repeat;
	padding-left: 25px;
	height: 20px;
	line-height: 20px;
	color: #000;
	border: none;
	margin-bottom: 10px;
}

.loading {
	background: #E9FFEB url(images/loading.gif) no-repeat;
	padding-left: 25px;
	height: 20px;
	line-height: 20px;
	color: #ccc;
	border: none;
	margin-bottom: 10px;
}

.nores {
	background: #E9F0FF url(images/reg2.gif) no-repeat;
	padding-left: 25px;
	height: 20px;
	line-height: 20px;
}
-->
</style>

<script type="text/javascript" src="js/verificationCode.js"></script>
<script>
//图片验证码
$('#change_img').click(function(){
    $('#czy').attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
});

// 密码输入框是否显示相关js
$(".text-bg01").on("touchstart",function(){
    $(".mima_text").attr('type', 'text');
    $(".text-bg01").css("display","none");
    $(".pwd-bg01").css("display","block");
    $(".checkbtn").css("background","#FC8909");
})
$(".pwd-bg01").on("touchstart",function(){
    $(".mima_text").attr('type', 'password');
    $(".text-bg01").css("display","block");
    $(".pwd-bg01").css("display","none");
    $(".checkbtn").css("background","#fff");
})

// 手机号码可用性验证js
$('#firstSubmit').click(function(){
	var name = $('#mobile').val();
	var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
	//验证手机
	if(name=='' || isNaN(name) || name.length!=11 || !partten_mobile.test(name)){
		$(".black_feds").text("请输入正确手机号").show();
		setTimeout("prompt();", 2000);
		return;
	}else{
		var check_name = $.ajax({
    	    url:'<?php echo site_url("customer/check_mobile_phone") ?>',
    	    type:'get',
    	    dataType:'json',
    	    data:{
    	    	mobile:name
		    },
		    beforeSend:function(){
				$(".black_feds").text("正在检测手机号...").show();
    		},
    		success:function(data){
    		    if(data.Result){
        		    $("#mobiletest").html(name);
    				$(".black_feds").toggle();
    				$("#banding_first_verify").toggle();
    				$("#banding_second_verify").toggle();
    		    }else{
        			$(".black_feds").text("该手机号已注册，请登录").show();
        			setTimeout("prompt();", 2000);
    		    }
    		},
    	    error:function(){
    			$(".black_feds").text("网络出错，请重试！").show();
    			setTimeout("prompt();", 2000);
    			return;
    		}
		})
	}
})

//获取验证码js
$("#get_mobile_code").click(function(){
	var type = 8;
	var mobile = $("input[name='mobile']").val();
	var get_code_id = "#get_mobile_code";
    var yzm = $("#captcha").val();
	$.post("<?php echo site_url("customer/ajax_check_yzm");?>?captcha="+yzm,function(data){
		if(data["Result"]){
			get_mobile_code(type,mobile,yzm);
    	}else{
    		$(".black_feds").text("验证码错误！").show();
            setTimeout("prompt();", 2000);
    		return;
    	}
	},"json");
	
})

//验证短信验证码
$("#register_save").click(function(){
    var yzm = $("#captcha").val();
    $.post("<?php echo site_url("customer/ajax_check_yzm");?>?captcha="+yzm,function(data){
    	if(!data["Result"]){
    		$(".black_feds").text("验证码错误！").show();
    		setTimeout("prompt();", 2000);
    		return;
    	}
	
    	var password = $("input[name='tbxRegisterPassword']").val();
    	if(password.length<6 || password.length>16){
    		$(".black_feds").text("密码应为6-16位数字或英文字母").show();
    		setTimeout("prompt();", 2000);
    		return false;
    	}
    	var code = $("#handset-num").val();
    	var type = 8;
    	var mobile = $('.mobile').html();
    	check_code(code,type,mobile);
    },"json");
})

function WebForm_OnSubmit() {
if (typeof(ValidatorOnSubmit) == "function" && ValidatorOnSubmit() == false)
	{
		return false;
	}else
	{
		return true;
	}
}

function validate(group)
{
	return $.formValidator.pageIsValid(group);
}

</script>