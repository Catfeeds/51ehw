
/**
 * 判断是否是用户isUser
 * mobile 手机号码 
 * code 验证码
 * status  1 验证获取   2  提交功能
 */
function checkUser(mobile,status,code){
	var type = 1;
	if(mobile==''){
	}
	alert('成功进入isUser');
}
//function checkUser(mobile = '',status = '',code = ''){
//	var type = 1;
//	if(mobile == ''){
//		$(".black_feds").text("手机号码不能为空").show();
//		setTimeout("prompt();", 2000);
//		return;
//	}
//	alert('成功进入isUser');
//	$.ajax({
//		url: base_url+'/customer/check_mobile_phone',
//		type:'get',
//		dataType:'json',
//		data:{
//			mobile:mobile
//		},
//		success:function(data){
//			if(!data.Result){
//				if(status == 1){
//					get_mobile_code(type,mobile);
//				}
//				if(status == 2){
//					check_code(code,type,mobile);
//				}
//			}else{
//				$(".black_feds").text("该用户尚未注册").show();
//				setTimeout("prompt();", 2000);
//				return;
//			}
//		},
//		error:function(){
//			$(".black_feds").text("网络出错，请重试！").show();
//			setTimeout("prompt();", 2000);
//			return;
//		}
//	})
//}


