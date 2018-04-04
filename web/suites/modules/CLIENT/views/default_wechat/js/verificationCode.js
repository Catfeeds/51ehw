/**
 * Alert date:2016/10/14
 * author:啊林
 * content:手机验证码验证程序
 */

/**
 * 定义验证码状态code_status
 */
var code_status = true;

/**
 * 获取验证码js
 * h5统一提示框class：black_feds
 * 发送对象：name,id:tbxCodeMobile
 * 发送类型：type,id:mobile_code_type
 * 发送后台程序：url
 */
function get_mobile_code(type ,mobile){
	$(".black_feds").text("正在发送验证码...").show();
    if(mobile != ""){
		$.ajax({
			url: base_url+'/customer/ajax_send/'+type,
			type: 'POST',
			data:{'mobile':mobile},
			dataType: 'html',
			success: function(data){
				$('#get_mobile_code').attr("disabled",true);
				$(".black_feds").hide();
				$('#get_mobile_code').css('color','#262626');
				$('#get_mobile_code').val('重新发送(90s)');
				$(".black_feds").text("发送验证码成功").show();
				setTimeout("prompt();", 2000);
				setTimeout(remainTime,1000);
			},
    	    error:function(){
    			$(".black_feds").text("网络出错，请重试！").show();
    			setTimeout("prompt();", 2000);
    			return;
    		}
        });
    }else{
		$(".black_feds").text("请输入正确手机号").show();
		setTimeout("prompt();", 2000);
		return;
   }
}

/**
 * 验证码按钮倒计时js
 * 验证码按钮id：get_mobile_code
 */
function remainTime(){
	var times =  $('#get_mobile_code').val().replace(/[^0-9]/ig,"");
	if(times < 1){
		$('#get_mobile_code').val('获取验证码');
		$('#get_mobile_code').attr("disabled",false); 
		$('#get_mobile_code').css('color','#FCB045');
		$(".black_feds").text("验证码失效，请重新获取").show();
		setTimeout("prompt();", 2000);
		code_status = false;
	}else{
		times -= 1;
		$('#get_mobile_code').val('重新发送('+ times +'s)');
		setTimeout("remainTime()",1000);
		code_status = true;
	}
}

/**
 * 验证验证码
 */
function check_code(code,type,mobile){
	if(code==''){
		$(".black_feds").text("验证码不能为空").toggle();
		setTimeout("prompt();", 2000);
		return false;
	}
	else{
		$.get(base_url+'/Customer/check_mobile/'+type,{mobile_vertify:code},function(data){
			var data = jQuery.parseJSON(data);
			if(data.Result){
				if(code_status){
					document.form1.submit();
				}else{
					$(".black_feds").text("验证码失效，请重新获取").show();
					setTimeout("prompt();", 2000);
				}
			}else{
				$(".black_feds").text("验证码有误，请重新输入").show();
				setTimeout("prompt();", 2000);
			}
		})
	}
}

/**
 *判断是否是手机号码
 *
 */
function isMobileNum(mobile){
	var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
	if(isNaN(mobile) || mobile.length!=11 || !partten_mobile.test(mobile)){
		
		return false;
	 }	
	 return true;
	}	
/**
 * 判断是否是用户isUser
 * mobile 手机号码 
 */
function isUser(mobile){
	var result = 'false';
	if(mobile == ''){
		$(".black_feds").text("手机号码不能为空").show();
		setTimeout("prompt();", 2000);
		return;
	}
	 $.ajax({
		    url: base_url+'/customer/check_mobile_phone',
		    type:'get',
		    async: false, 
		    dataType:'json',
		    data:{
		    	mobile:mobile
		    },
		    success:function(data){
		    	 if(!data.Result){
			    	    result = true;
			    	    return result;
			    	 }else{
			    		 result = false;
			    		 return result;
			    	 }
			    },
		    error:function(){
				$(".black_feds").text("网络出错，请重试！").show();
				setTimeout("prompt();", 2000);
				return;
			}
		})
	    return result;
	}