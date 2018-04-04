$(function() {
	/*
	 * $.formValidator.initConfig({ autotip : true, validatorgroup : "1" });
	 * $("#tbxLoginNickname").formValidator({ validatorgroup : "1", tipid :
	 * "loginNickname", onshow : "", onfocus : "", oncorrect : ""
	 * }).inputValidator({ min : 1, onerror : "请填写用户名" });
	 * $("#tbxLoginPassword").formValidator({ validatorgroup : "1", tipid :
	 * "loginPassword", onshow : "", onfocus : "", oncorrect : ""
	 * }).inputValidator({ min : 1, onerror : "请填写密码" });
	 * $("#tbxLoginVerifier").formValidator({ validatorgroup : "1", tipid :
	 * "loginVerifier", onshow : "", onfocus : "", oncorrect : ""
	 * }).inputValidator({ min : 1, onerror : "请填写验证码" });
	 */
	$.formValidator.initConfig({
		autotip : true,
		formid : "register-form"
	});
	/*$("#tbxRegisterNickname").formValidator({
		tipid : "registerNickname",
		onshow : "",
		onfocus : "",
		oncorrect : function() {
			var tips = $(this).parent().find(".onSuccess");
			tips.addClass('icon-gou');
			tips.html("");
		}
	}).inputValidator({
		min : 4,
		max : 20,
		onerror : "用户名长度只能在4-20位字符之间"
	}).regexValidator({
		regexp : "^[^\u4e00-\u9fa5]{0,}$",
		datatype : "string",
		onerror : "用户名只能由英文、数字及“_”组成"
	}).ajaxValidator({
		type : "GET",
		async : true,
		url : base_url + "/customer/check_name",
		datatype : "json",
		success : function(result) {
			return result.Result;
		},
		buttons : null,
		onwait : "正在检测用户名是否重复...",
		onerror : "该用户名已被使用"
	});
	;*/
	// if ($("#hflRegisterNickname").val() != "true")
	// {
	/*
	 * $("#tbxRegisterNickname") .ajaxValidator( { type: "GET", url: "<?php
	 * echo site_url('customer/check_name')?>", datatype: "json", success:
	 * function(result) { return result.Result; }, buttons: $("#ibtRegister"),
	 * onwait: "正在检测用户名是否重复...", onerror: "该用户名已被使用" }); //}
	 */
	$("#tbxRegisterPassword").formValidator({
		tipid : "registerPassword",
		onshow : "",
		onfocus : "",
		oncorrect : function() {
			var tips = $(this).parent().find(".onSuccess");
			tips.addClass('icon-gou');
			tips.html("");
		}
	}).inputValidator({
		min : 6,
		max : 16,
		onerror : "密码长度只能在6-16位字符之间"
	}).regexValidator({
		regexp : "password",
		datatype : "enum",
		onerror : "密码只能由英文、数字及“_”、“-”组成"
	});
	/*
	 * if ($("#hflRegisterPassword").val() != "true") {
	 * $("#tbxRegisterPassword") .ajaxValidator( { type: "GET", url: "<?php
	 * echo site_url('login/check_pw')?>", datatype: "json", success:
	 * function(result) { return result.Result; }, buttons: $("#ibtRegister"),
	 * onwait: "正在检测密码强度...", onerror: "该密码不安全，为保证您的账户安全，请更换其它密码" }); }
	 */
	$("#tbxRegisterPassword").keyup(function() {
		var strength = CheckIntensity($(this).val());
		if (strength) {
			$("#pwdStrengh").show();
		} else {
			$("#pwdStrengh").hide();
		}
		$("#pwdStrengh").attr("className", strength);
	});
	/*
	 * $("#tbxRegisterPassword").change( function() { $("#tbxRegisterPassword")
	 * .ajaxValidator( { type: "GET", url: "<?php echo
	 * site_url('login/check_pw')?>", datatype: "json", success:
	 * function(result) { return true; //return result.Result; }, buttons:
	 * $("#ibtRegister"), onwait: "正在检测密码强度...", onerror:
	 * "该密码不安全，为保证您的账户安全，请更换其它密码" }); });
	 */
	$("#tbxRegisterRepeatPassword").formValidator({
		tipid : "registerRepeatPassword",
		onshow : "",
		onfocus : "",
		oncorrect : function() {
			var tips = $(this).parent().find(".onSuccess");
			tips.addClass('icon-gou');
			tips.html("");
		}
	}).compareValidator({
		desid : "tbxRegisterPassword",
		operateor : "=",
		onerror : "两次输入的密码不一致"
	});

	$("#mobile").formValidator({
		tipid : "registerMobile",
		onshow : "",
		onfocus : "",
		oncorrect : function() {
			var tips = $(this).parent().find(".onSuccess");
			tips.addClass('icon-gou');
			tips.html("");
		}
	}).regexValidator({
		regexp : "mobile",
		datatype : "enum",
		onerror : "请填写正确的手机号码"
	}).ajaxValidator({
		type : "GET",
		async : true,
		url : base_url + "/customer/check_mobile_phone",
		datatype : "json",
		success : function(result) {
			return result.Result;
		},
		buttons : null,
		onwait : "正在检测手机号码是否重复...",
		onerror : "该手机号码已被使用"
	});

	$("#mobile_vertify").formValidator({
		tipid : "registerMobileVertify",
		onshow : "",
		onfocus : "",
		oncorrect : function() {
			var tips = $(this).parent().find(".onSuccess");
			tips.addClass('icon-gou');
			tips.html("");
		}
	}).inputValidator({
		min : 6,
		max : 6,
		onerror : "手机验证码填写错误"
	}).ajaxValidator({
		type : "GET",
		async : true,
		url : base_url + "/customer/check_mobile",
		datatype : "json",
		success : function(result) {
			return result.Result;
		},
		buttons : null,
		onwait : "正在检测手机验证码是否正确...",
		onerror : "手机验证码填写错误"
	});

	$("#captcha").formValidator({
		tipid : "registerCaptcha",
		onshow : "",
		onfocus : "",
		oncorrect : function() {
			var tips = $(this).parent().find(".onSuccess");
			tips.addClass('icon-gou');
			tips.html("");
		}
	}).inputValidator({
		min : 4,
		max : 5,
		onerror : "请填写正确的验证码"
	}).ajaxValidator({
		type : "GET",
		async : true,
		url : base_url + "/customer/ajax_check_yzm",
		datatype : "json",
		success : function(result) {
			return result.Result;
		},
		buttons : null,
		onwait : "正在检测验证码是否正确...",
		onerror : "验证码填写错误"
	});

	// if ($("#hflRegisterEmail").val() != "true")
	// {
	// }
	/*
	 * $("#tbxRegisterEmail").change( function() { $("#tbxRegisterEmail")
	 * .ajaxValidator( { type: "GET", url: "loginservice.aspx", datatype:
	 * "json", success: function(result) { return result.Result; }, buttons:
	 * $("#ibtRegister"), onwait: "正在检测邮箱是否重复...", onerror: "该邮箱已被使用，请您更换其它邮箱"
	 * }); });
	 */
	/*
	 * $("#tbxReferee") .formValidator( { validatorgroup: "2", tipid: "referee",
	 * onshow: "非必填，如您注册并完成订单，推荐人有机会获得积分", onfocus: "", oncorrect: "" });
	 */

	$("#choose").formValidator({
		tipid : "agreement",
		onshow : "",
		onfocus : "",
		empty : false,
		oncorrect : function() {
			var tips = $(this).parent().find(".onSuccess");
			tips.addClass('icon-gou');
			tips.html("");
		}
	}).functionValidator({
		fun : function(a, b) {
			if ($("#choose").prop("checked")) {
				return true;
			}
			else{
				return false;
			}
		},
		onerror: "请确认已满18周岁并接受服务条款"
	});

	$("input").focus(function() {
		var error = $(this).parent().find(".onError");
		error.hide();
	});
});

function WebForm_OnSubmit() {
	alert(typeof (ValidatorOnSubmit));
	if (typeof (ValidatorOnSubmit) == "function"
			&& ValidatorOnSubmit() == false) {
		return false;
	} else {

		return true;
	}
}

function validate(group) {
	return $.formValidator.pageIsValid(group);
}
function isChn(str){
    var reg = /^[u4E00-u9FA5]+$/;
    if(!reg.test(str)){
     return false;
    }
    return true;
}