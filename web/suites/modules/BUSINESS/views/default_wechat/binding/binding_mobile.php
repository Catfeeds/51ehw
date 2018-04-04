
<div class="page clearfix">
<?php switch ($step){
	case 1:{?>
	<form action="<?php echo site_url('member/binding/update_login');?>" method='post' name="form1" id="form1">
		<!-- mobile -->
		<div id="banding_first_verify" class="envelope_two regsiter" style="margin-top:5px;font-size:12px;">
			<h2>完成绑定账号才可进行更多操作</h2>
			<div>
				<input id="tbxBindingMobile" name="tbxBindingMobile" type="text" placeholder="请输入手机号" autocomplete="off" value="">
			</div>
			<a href="javascript:void(0);" id="firstSubmit">下一步</a>
			<!-- <ul>
				<li>还没有账号? <a href="<?php echo site_url('customer/registration/0/1');?>">去注册</a></li>
			</ul> -->
		</div>
		<!-- mobile end -->
    		
		<div id="banding_second_verify" style="display:none;">
			<div style="width: 50%; margin: auto; ">
				<img src="images/bangding_logo.png"
					style="padding-top: 40px; padding-bottom: 35px;">
			</div>
			<!-- 验证码 -->
			<div style="position: relative;border-bottom:1px solid #EAECEA;margin:0 11.5%;">
				<div class="register-num">
					<input id="mobile-vertify" name="mobile-vertify" type="text" placeholder="请输入验证码" autocomplete="off" value="">
				</div>
				<input type="button" class="num-button" id='get_mobile_code' style="top: 0; line-height: 36px;" value="获取验证码">
				<input type="hidden" id='mobile_code_type' name='mobile_code_type' value="<?php echo $mobile_code_type;?>">
			</div>
			<!-- 密码 -->
			<!--  <div id="bangding_login_mima" class="bangding_login-mima">
				<input id="tbxBindingPassword" class="mima_text" type="password" name="tbxBindingPassword" placeholder="请输入登录密码" autocomplete="off">
				
				<div class="bangding_login-mima-icon">
					<div class="checkbtn">
						<em class="b-text">abc</em> <em class="b-pwd">...</em> <em class="text-bg"></em> <em class="pwd-bg"></em>
					</div>
				</div>
			</div>
			<div id="bangding_login_mima_prompt" style="margin-left: 10px; color:#9E9E9E;"> <span>*6-16位数字或英文字母</span></div>
			-->
			<!-- 完成绑定按钮 -->
			<div class="register-button" id="secondSubmitdiv" style="background:#FDCF0C!important;text-align: center;line-height: 45px;"><!-- #FED530 -->
				<a id='secondSubmit'  onclick="secondSubmit();">完成绑定</a>
			</div>
		</div>
		<!-- 未注册进行绑定 结束-->
	</form>

<script type="text/javascript" src="js/verificationCode.js"></script>
<script>

var password_show = false;

//验证手机号码可用性
$('#firstSubmit').click(function(){
	var name = $('#tbxBindingMobile').val();
	var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
	//验证手机
	if(name=='' || isNaN(name) || name.length!=11 || !partten_mobile.test(name)){
		$(".black_feds").text("请输入正确手机号").show();
		setTimeout("prompt();", 2000);
		return;
	}else{
	$.ajax({
	    url:'<?php echo site_url("customer/check_mobile_binding_info") ?>',
	    dataType:'json',
	    type:'get',
	    data:{
    	    mobile:name
		    },
		    beforeSend:function(){
				$(".black_feds").text("正在检测手机号...").show();
		},
		success:function(data){
		    if(data['Result']){
			   
		    	//password_show = true;//未注册显示密码框
		    }else{
// 		    	password_show = false;//已注册不显示密码框
// 		    	$("#bangding_login_mima").hide();
// 		    	$("#bangding_login_mima_prompt").hide();
// 		    	$("input[name='tbxBindingPassword']").val("");
		    	$(".black_feds").text("该手机号已绑定微信").show();
				setTimeout("prompt();", 2000);
				return;
		    }
		    $(".black_feds").hide();
			$("#banding_first_verify").hide();
			$("#banding_second_verify").show();
		},
	    error:function(){
			$(".black_feds").text("网络出错，请重试！").show();
			setTimeout("prompt();", 2000);
			return;
		}
		})
	}
})

// 获取验证码
$("#get_mobile_code").click(function(){
	var type = $('#mobile_code_type').val();
	var mobile = $('#tbxBindingMobile').val();
	var get_code_id = "#get_mobile_code";
	get_mobile_code(type,mobile);
})

// 验证验证码，绑定帐号
function secondSubmit(){
	var type = $('#mobile_code_type').val();
    var mobile = $('#tbxBindingMobile').val();
    var code = $('#mobile-vertify').val();
    var password = $('#tbxBindingPassword').val();
    var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
    
    if(mobile=='' || isNaN(mobile) || mobile.length!=11 || !partten_mobile.test(mobile)){
        $(".black_feds").text("请输入正确手机号").show();
        setTimeout("prompt();", 2000);
        return;
    }
    
//     if(password.length < 6 && password.length > 20 && password =='' && password_show == true){
//         $(".black_feds").text("密码应该为6-20位之间").show();
//         setTimeout("prompt();", 2000);
//         return;
//     }
    
    if(code == ''){
        $(".black_feds").text("验证码有误，请重新输入").show();
        setTimeout("prompt();", 2000);
        return;
    }
	$(".black_feds").text("正在绑定手机...").show();

	$('#secondSubmit').attr("onclick","return false;");
	$.ajax({
    	url:'<?php echo site_url("customer/check_mobile/9") ?>',
    	type:'get',
    	data:{mobile_vertify:code},
    	success:function(data){
    		var msg=eval('('+data+')');
    		if(msg.Result){
    			document.form1.submit();
    	    }else{
        		$('#secondSubmit').attr("onclick","secondSubmit();");
    			$(".black_feds").text("验证码有误，请重新输入").show();
    			setTimeout("prompt();", 2000);
    	    }
    	},
    	error:function(){
			$(".black_feds").text("网络出错，请重试！").show();
			setTimeout("prompt();", 2000);
            $('#secondSubmitdiv').css('background-color','#D5D5D5');
            $('#secondSubmit').attr("onclick","return false;");
			return;
		}
    })
	
    
}
</script>

<script>
// 密码是否显示js
// $(".text-bg").on("touchstart",function(){
// 	$(".mima_text").attr('type', 'text');
// 	$(".text-bg").css("display","none");
// 	$(".pwd-bg").css("display","block");
// 	$(".checkbtn").css("background-color","#FC8909");
// 	})
// $(".pwd-bg").on("touchstart",function(){
// 	$(".mima_text").attr('type', 'password');
// 	$(".text-bg").css("display","block");
// 	$(".pwd-bg").css("display","none");
// 	$(".checkbtn").css("background-color","#fff");
// })
</script>

<script>
//进入页面验证是否绑定失败回调
$(function(){
	var err = "<?php echo isset($err)?$err:0;?>";
	if(err=="1"){
		$(".black_feds").text("验证码有误，请重新输入").show();
		setTimeout("prompt();", 2000);
	}else if(err=="2"){
		$(".black_feds").text("验证码已失效，请重新获取").show();
		setTimeout("prompt();", 2000);
	}else if(err=="3"){
		$(".black_feds").text("此手机已被绑定").show();
		setTimeout("prompt();", 2000);
	}else if(err=="4"){
		$(".black_feds").text("账号异常，请联系客服").show();
		setTimeout("prompt();", 2000);
	}
})
</script>
<?php
        break;
           }
    case 3:{?>	
<!-- 绑定完成 start -->
	<form action="<?php echo site_url('member/info/');?>" method='post'>
		<div>
			<div style="width: 50%; margin: auto;">
				<img src="images/bangding_logo.png"
					style="padding-top: 40px; padding-bottom: 30px;">
			</div>
			<div style="text-align: center;">
				<span style="display: block; font-size: 15px; color: #383838;">绑定成功</span>
				<span
					style="display: block; font-size: 15px; color: #535353; padding-top: 10px;">您可以用微信或手机号+密码直接登录</span>
			</div>
			<div class="register-button" style="background: #F6CA0B !important; color: #262626 !important;"><a href="<?php echo !empty($back)?$back:site_url("member/info")?>">确定</a></div>
		</div>
	</form>
</div>
<!-- 绑定完成 end -->
<?php
        break;
           }
    }?>	