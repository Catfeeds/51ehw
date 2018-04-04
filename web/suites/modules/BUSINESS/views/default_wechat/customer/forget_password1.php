<?php $this->session->set_userdata('forget',1);?>
<script type="text/javascript">
var msg = '<?php echo isset($error_msg)? $error_msg:'' ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'code_error' : 
				$(".black_feds").text("验证码有误，请重新输入").show();
				setTimeout("prompt();", 2000);
				break;
			case 'code_null' : 
    			$(".black_feds").text("请填写短信验证码不能为空").show();
    			setTimeout("prompt();", 2000);
    			break;
			case 'mobile_null' : 
    			$(".black_feds").text("请填写手机号码不能为空").show();
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
			case 'user_unregistered' : 
    			$(".black_feds").text("该用户尚未注册").show();
    			setTimeout("prompt();", 2000);
    			break;
			case 'code_timeout' : 
    			$(".black_feds").text("验证码已失效，请重新获取").show();
    			setTimeout("prompt();", 2000);
    			break;
			default : break;
		}
	}	
});
</script>

<style type="text/css" href="css/validator.css"></style>
<div class="page clearfix">
		<div class="login-container">
			<form name="form1" action="<?php echo site_url('customer/update_password') ?>" onsubmit="javascript:return WebForm_OnSubmit();"  method="post" id="form1">	
			<!--忘记密码－步骤01 start-->
				<!-- 手机号码验证 开始 -->
				<div style="margin-top: 117.5px; display: block;" id="banding_first_verify">
					<div class="bangding_login-mima">
						<input class="mima_text" id="username" name="name" type="tel" placeholder="请输入手机号" autocomplete="off" value=''>
						<!-- value='18814148940' -->
					</div>
					<div class="register-button" style="background: #F6CA0B !important; color: #262626 !important; margin-top: 20px;">
						<a id="firstSubmit">下一步</a>
					</div>
				</div>
				<span id='mobiletest' ></span>
				<!-- 手机号码验证 结束 -->

				<!-- 输入密码和验证码 -->
				<div style="display: none;padding-top: 61px;" id="banding_second_verify">
				    <div style="position: relative;border-bottom:1px solid #EAECEA;margin:0 11.5%;overflow: hidden;" >
						<div class="register-num">
							<input id="captcha" name="yzm" type="text" placeholder="请输入验证码" autocomplete="off" required="required">
						</div>
						<a id="change_img" class="num-button" style="top: 6px;"><img src="<?php echo site_url('customer/yzm_img')?>" id="czy" style="cursor: pointer; width: 72px;height: 27px;margin:0"></a>
					</div>
				    
				
					<div style="position: relative;border-bottom:1px solid #EAECEA;margin:0 11.5%;overflow: hidden;" >
						<div class="register-num">
							<input id="mobile_vertify" name="mobile_vertify" type="tel" placeholder="请输入验证码" autocomplete="off" required="required">
						</div>
						<input type="button"  onclick="send_valitaty();" class="num-button" id="get_mobile_code" value="获取验证码">
					</div>
					<!-- 密码 -->
					<div class="bangding_login-mima">
						<input type="password" onfocus="this.type='password'" class="mima_text" id="pass" name="password" placeholder="6～16位密码，数字或字母" autocomplete="off" required="required">
						<div class="bangding_login-mima-icon">
								<em class="text-bg01 icon-chakanmima1"></em> <em class="pwd-bg01 icon-chakanmima"></em>
						</div>
						<input type="hidden" name="ConfirmPassword" id="ConfirmPassword" value="" >	
						<input type="hidden" name="name" id="namenum" value="">	
					</div>
					<!-- <div class="forget_password_tishi">
						<span style="color: #535353;"><span style="color: #FB9A36;">*</span>6-16位数字或英文字母</span>
					</div> -->
					<div class="register-button" id="secondSubmitdiv" onclick="formsubmit();" style="background: #FDCF0C !important; font-size: 18px !important;">
						<a id='register_save'>提交</a>
					</div>
				</div>
				<!-- 输入密码和验证码 结束 -->
			</form>
			<!--忘记密码－步骤01 end-->
		</div>
		<!--login-container end-->
	</div>
	<!--page end-->


	<script type="text/javascript">
	//图片验证码
    $('#change_img').click(function(){
        $('#czy').attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
    });

	
	// 手机号码可用性验证js
	$('#firstSubmit').click(function(){
		var mobile = $('#username').val();
		if(isMobileNum(mobile)){
			var test =  isUser(mobile);
			if(test){
				$("#banding_first_verify").toggle();
				$("#banding_second_verify").toggle();
				}else{
					$(".black_feds").text("该用户尚未注册").show();
		       		 setTimeout("prompt();", 2000);
		       		 return;
					}
			}else{
				$(".black_feds").text("请输入正确手机号").show();
	       		 setTimeout("prompt();", 2000);
	       		 return;
	       		 }
		})
		
		//发送验证码
	function send_valitaty(){
        var mobile = $('#username').val();
        var test = isUser(mobile);
        var type = 1;
        if(isMobileNum(mobile)){
            if(test){
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
            }else{
                $(".black_feds").text("该用户尚未注册").show();
                setTimeout("prompt();", 2000);
                return;
            }
        }else{
        	$(".black_feds").text("请输入正确手机号").show();
        	setTimeout("prompt();", 2000);
        	 return;
        }
	}

	//验证数据
	function formsubmit(){
	    var yzm = $("#captcha").val();
	    $.post("<?php echo site_url("customer/ajax_check_yzm");?>?captcha="+yzm,function(data){
	    	if(!data["Result"]){
	    		$(".black_feds").text("验证码错误！").show();return;
	    	}
		
    		var mobile = $('#username').val();
    		if($('#pass').val()==""){
    			 $(".black_feds").text("新密码不能为空！").show();
    	      	 setTimeout("prompt();", 2000);
    	      	 return;
    		}else if($('#pass').val().length<6 || $('#pass').val().length>20){
    			 $(".black_feds").text("新密码必须为6-20字符！").show();
    	      	 setTimeout("prompt();", 2000);
    	      	 return;
    		}
    		
    		$('#ConfirmPassword').val($('#pass').val());
    		$('#namenum').val($('#username').val());
    	    if ($('#mobile_vertify').val()==''){
    	        $(".black_feds").text("请填写短信验证码不能为空").show();
    	      	 setTimeout("prompt();", 2000);
    	    }else{
    		    var code = $('#mobile_vertify').val();
    		    var test = isUser(mobile);
    		    var type = 1;
    		    if(isMobileNum(mobile)){
    				if(test){
    					check_code(code,type,mobile);
					}else{
						$(".black_feds").text("该用户尚未注册").show();
			       		 setTimeout("prompt();", 2000);
			       		 return;
			       }
				}else{
					$(".black_feds").text("请输入正确手机号").show();
					setTimeout("prompt();", 2000);
		       		 return;
				}
            }
	    },"json");
	}
	function WebForm_OnSubmit() {
		if (typeof(ValidatorOnSubmit) == "function" && ValidatorOnSubmit() == false)
			{
				return false;
			}else
			{
				return true;
			}
		}
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
	</script>
	<!-- 验证码相关js -->
	<script type="text/javascript" src="js/verificationCode.js"></script>