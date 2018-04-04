<?php $this->load->view('_header') ?>
        <!-- head-top E -->
		<form name="form1" method="post" action="<?php echo site_url('customer/save')?>" onsubmit="javascript:return WebForm_OnSubmit();" id="form1">
        <div class="ui-bd w980">
            <div class="ui-login">
                <div class="ui-registration-title">
                    <h3><img src="images/login.gif"/> </h3>
                </div>
                <div class="ui-login-bd fn-clear">
                    <div class="ui-login-left fn-left">
                        <div class="ui-form-item">
                            <label class="ui-title-login">账&nbsp;&nbsp;&nbsp;&nbsp;户<b>:</b></label>
                            <input type="text" name="tbxRegisterNickname" id="tbxRegisterNickname" class="text" placeholder="请输入帐号">
							<div  style="display: none;" id="registerNickname"></div>
                        </div>
                        <div class="ui-form-item">
                            <label class="ui-title-login">密&nbsp;&nbsp;&nbsp;&nbsp;码<b>:</b></label>
                            <input  type="password" name="tbxRegisterPassword" maxlength="16" id="tbxRegisterPassword" class="text" placeholder="请输入密码">
						<div style="display: none;" id="registerPassword"></div>
                        </div>
                        <div class="ui-form-item">
                            <label class="ui-title-login">密码确认<b>:</b></label>
                            <input  type="password" class="text" name="tbxRegisterRepeatPassword" maxlength="16" id="tbxRegisterRepeatPassword" placeholder="请输入密码">
							<div style="display: none;" id="registerRepeatPassword"></div>
                        </div>
						<div class="ui-form-item">
                            <label class="ui-title-login">电邮地址<b>:</b></label>
                            <input  type="text" class="text"  name="tbxRegisterEmail" maxlength="50" id="tbxRegisterEmail"  placeholder="请输入电邮">
							<div style="display: none;" id="registerEmail"></font></div>
                        </div>
                        <div class="ui-form-item fn-clear">
                                <span class="ui-loginframe-label fn-left">
                                    <span class="ui-prettyform-checkbox">
                                        <input type="checkbox"　id="choose" class="ui-prettyform-hidden"/></span>
                                    <label class="years">我已满18周岁并接受易货网服务条款</label>

                                </span>
                        </div>
                        <div class="ui-main-login-but">

                            <input name="ibtRegister" id="ibtRegister" type="image" name="ibtRegister" id="ibtRegister" class="btn-register" onclick="return validate('2');WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;ibtRegister&quot;, &quot;&quot;, true, &quot;2&quot;, &quot;&quot;, false, false))" src="<?php echo base_url()?>images/bottom_login.gif"/>


                        </div>
                    </div>
                    <div class="ui-login-note">
                        <span>已经是易货网的会员了？</span><a href="<?php echo  site_url('login/index')?>" title="立即登录" class="ui-registration-login"></a>
                    </div>
                </div>
            </div>
        </div>
		</form>
<?php $this->load->view('_footer') ?>
<script type="text/javascript" src="js/jquery_002.js"></script>
<script type="text/javascript" src="js/jquery-validate.js"></script>
<script>
$(
	function()
	{
		$.formValidator.initConfig(
			{
				autotip: true,
				validatorgroup: "1"
			});
		$("#tbxLoginNickname")
			.formValidator(
				{
					validatorgroup: "1",
					tipid: "loginNickname",
					onshow: "",
					onfocus: "",
					oncorrect: ""
				})
			.inputValidator(
				{
					min: 1,
					onerror: "请填写用户名"
				});
		$("#tbxLoginPassword")
			.formValidator(
				{
					validatorgroup: "1",
					tipid: "loginPassword",
					onshow: "",
					onfocus: "",
					oncorrect: ""
				})
			.inputValidator(
				{
					min: 1,
					onerror: "请填写密码"
				});
		$("#tbxLoginVerifier")
			.formValidator(
				{
					validatorgroup: "1",
					tipid: "loginVerifier",
					onshow: "",
					onfocus: "",
					oncorrect: ""
				})
			.inputValidator(
				{
					min: 1,
					onerror: "请填写验证码"
				});
		$.formValidator.initConfig(
			{
				autotip: true,
				validatorgroup: "2"
			});
		$("#tbxRegisterNickname")
			.formValidator(
				{
					validatorgroup: "2",
					tipid: "registerNickname",
					onshow: "",
					onfocus: "",
					oncorrect: ""
				})
			.inputValidator(
				{
					min: 4,
					max: 20,
					onerror: "用户名长度只能在4-20位字符之间"
				})
			.regexValidator(
				{
					regexp: "username",
					datatype: "enum",
					onerror: "用户名只能由中英文、数字及“_”、“-”组成"
				});
		//if ($("#hflRegisterNickname").val() != "true")
		//{
			$("#tbxRegisterNickname")
				.ajaxValidator(
					{
						type: "GET",
						url: '<?php echo site_url('login/check_name')?>',
						datatype: "json",
						success:
							function(result)
							{
								return result.Result;
							},
						buttons: $("#ibtRegister"),
						onwait: "正在检测用户名是否重复...",
						onerror: "该用户名已被使用"
					});
		//}
		/*$("#tbxRegisterNickname").change(
			function()
			{
				$("#tbxRegisterNickname")
					.ajaxValidator(
						{
							type: "GET",
							url: "loginservice.aspx",
							datatype: "json",
							success:
								function(result)
								{
									return result.Result;
								},
							buttons: $("#ibtRegister"),
							onwait: "正在检测用户名是否重复...",
							onerror: "该用户名已被使用"
						});
			});*/
		$("#tbxRegisterPassword")
			.formValidator(
				{
					validatorgroup: "2",
					tipid: "registerPassword",
					onshow: "",
					onfocus: "",
					oncorrect: ""
				})
			.inputValidator(
				{
					min: 6,
					max: 16,
					onerror: "密码长度只能在6-16位字符之间"
				})
			.regexValidator(
				{
					regexp: "password",
					datatype: "enum",
					onerror: "密码只能由英文、数字及“_”、“-”组成"
				});
		/*if ($("#hflRegisterPassword").val() != "true")
		{
			$("#tbxRegisterPassword")
				.ajaxValidator(
					{
						type: "GET",
						url: "<?php echo site_url('login/check_pw')?>",
						datatype: "json",
						success:
							function(result)
							{
								return result.Result;
							},
						buttons: $("#ibtRegister"),
						onwait: "正在检测密码强度...",
						onerror: "该密码不安全，为保证您的账户安全，请更换其它密码"
					});
		}*/
		$("#tbxRegisterPassword").keyup(
			function()
			{
				var strength = checkPasswordStrength($(this).val());
				if (strength)
				{
					$("#pwdStrengh").show();
				}
				else
				{
					$("#pwdStrengh").hide();
				}
				$("#pwdStrengh").attr("className", strength);
			});
		/*$("#tbxRegisterPassword").change(
			function()
			{
				$("#tbxRegisterPassword")
					.ajaxValidator(
						{
							type: "GET",
							url: "<?php echo site_url('login/check_pw')?>",
							datatype: "json",
							success:
								function(result)
								{
								    return true;
									//return result.Result;
								},
							buttons: $("#ibtRegister"),
							onwait: "正在检测密码强度...",
							onerror: "该密码不安全，为保证您的账户安全，请更换其它密码"
						});
			});*/
		$("#tbxRegisterRepeatPassword")
			.formValidator(
				{
					validatorgroup: "2",
					tipid: "registerRepeatPassword",
					onshow: "",
					onfocus: "",
					oncorrect: ""
				})
			.compareValidator(
				{
					desid: "tbxRegisterPassword",
					operateor: "=",
					onerror: "两次输入的密码不一致"
				});
		$("#tbxRegisterEmail")
			.formValidator(
				{
					validatorgroup: "2",
					tipid: "registerEmail",
					onshow: "",
					onfocus: "",
					oncorrect: ""
				})
			.inputValidator(
				{
					min: 1,
					onerror: "请填写邮箱"
				})
			.regexValidator(
				{
					regexp: "email",
					datatype: "enum",
					onerror: "邮箱地址格式不正确"
				});
		$("#tbxRegisterEmail").blur(
			function()
			{
				var email = $("#tbxRegisterEmail").val();
				if (email.indexOf("@hotmail") > 0)
				{
					$("#registerEmail").css({color: "Red", display: "inline"});
					$("#registerEmail").text("@hotmail.com无法收到购物提醒邮件，建议更换");
				}
				else if (email.indexOf("@live") > 0)
				{
					$("#registerEmail").css({color: "Red", display: "inline"});
					$("#registerEmail").text("@live.com无法收到购物提醒邮件，建议更换");
				}
				else if (email.indexOf("@gmail") > 0)
				{
					$("#registerEmail").css({color: "Red", display: "inline"});
					$("#registerEmail").text("@gmail.com无法收到购物提醒邮件，建议更换");
				}
			});
		//if ($("#hflRegisterEmail").val() != "true")
		//{
			$("#tbxRegisterEmail")
				.ajaxValidator(
					{
						type: "GET",
						url: "<?php echo site_url('login/check_email')?>",
						datatype: "json",
						success:
							function(result)
							{
							  //alert(result);
								return result.Result;
							},
						buttons: $("#ibtRegister"),
						onwait: "正在检测邮箱是否重复...",
						onerror: "该邮箱已被使用，请您更换其它邮箱"
					});
		//}
		/*$("#tbxRegisterEmail").change(
			function()
			{
				$("#tbxRegisterEmail")
					.ajaxValidator(
						{
							type: "GET",
							url: "loginservice.aspx",
							datatype: "json",
							success:
								function(result)
								{
									return result.Result;
								},
							buttons: $("#ibtRegister"),
							onwait: "正在检测邮箱是否重复...",
							onerror: "该邮箱已被使用，请您更换其它邮箱"
						});
			});*/
		/*$("#tbxReferee")
			.formValidator(
				{
					validatorgroup: "2",
					tipid: "referee",
					onshow: "非必填，如您注册并完成订单，推荐人有机会获得积分",
					onfocus: "",
					oncorrect: ""
				});*/

		$("#choose")
			.formValidator(
				{
					validatorgroup: "2",
					tipid: "agreement",
					onshow: "",
					onfocus: "",
					oncorrect: ""
				})
			.inputValidator(
				{
					min: 1,
					onerror: "请确认已满18周岁并接受买酒服务条款"
				});

		$(":input").focus(
			function()
			{
				var settings = $(this).attr("settings");
				if (settings != null && settings.length > 0)
				{
					var group = settings[0].validatorgroup;
					if (group == "1")
					{
						$.formValidator.resetTipState("2");
					}
					else if (group == "2")
					{
						$.formValidator.resetTipState("1");
					}
				}
			});
	});

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