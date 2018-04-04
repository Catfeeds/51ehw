<form name="form1" method="post"
	action="<?php echo site_url('customer/save')?>" id="register-form">
	<!--内容 开始-->
	<div class="regsiter_02_con">
		<div class="regsiter_02_con_top">注册账户</div>
		<div class="regsiter_02_con_con clearfix">
			<!--注册输入框 开始-->
			<div class="regsiter_02_left">
				<ul>
				    <li><span class="regsiter_02_span">*</span>手机号码：</li>
					<li><span class="regsiter_02_span">*</span>登录密码：</li><br>
					<li><span class="regsiter_02_span">*</span>确认密码：</li>
                    <li><span class="regsiter_02_span"> </span>昵称：</li>

					<!-- <li><span class="regsiter_02_span">*</span>真实姓名：</li>-->
					<li><span class="regsiter_02_span">*</span>验证码：</li>
                    <li><span class="regsiter_02_span">*</span>短信验证码：</li>
				</ul>
			</div>
			<div class="regsiter_02_right">
				<ul>
				    <li><input type="text" name="mobile" class="regsiter_02_input"
						id="mobile" required placeholder="请输入手机号码"><span
						class="eh_msgerror icon-cha" style="display: none"
						id="registerMobile"></span></li>
					<!-- icon-gou icon-cha icon-gantanhao -->
					<li><input type="password" name="tbxRegisterPassword"
						id="tbxRegisterPassword" required placeholder="请输入密码"
						class="regsiter_02_input">
						<div class="pwd-con">
							<span id="pwd_Weak" class="pwd pwd_c">&nbsp;</span> <span
								id="pwd_Medium" class="pwd pwd_c pwd_f">无</span> <span
								id="pwd_Strong" class="pwd pwd_c pwd_c_r">&nbsp;</span>
						</div> <span class="eh_msgerror icon-cha" style="display: none"
						id="registerPassword"></span>
						<p>建议密码设置为包含数字及大小写英文字母</p></li>
					<li><input class="regsiter_02_input" type="password"
						name="tbxRegisterRepeatPassword" id="tbxRegisterRepeatPassword"
						required placeholder="请再次输入密码"> <span class="eh_msgerror icon-cha"
						style="display: none" id="registerRepeatPassword"></span></li>
					<li><input type="text" class="regsiter_02_input"
						name="Nickname" id="Nick_name"
						placeholder="请输入昵称" > <span class="eh_msgerror icon-cha"
						style="display: none" id="registerNickname">用户名已存在</span></li>
					<!-- <li><input type="text" class="regsiter_02_input" name="realname"
						id="realname" required placeholder="请输入真实姓名"> <span
						class="eh_msgerror icon-cha" style="display: none" id=err_realname>真实姓名超长</span></li>-->
					<li><input type="text" class="regsiter_02_input02" value=""
						name="captcha" id="captcha" required> <img
						src="<?php echo site_url('customer/yzm_img')?>" id="captcha-pic"
						onclick="change_yzm1(this)"
						style="cursor: pointer; height: 40px; width: 80px; vertical-align: middle; float: left; margin-left: 10px;">
						<div class="mQing2" style="float: left; margin-left: 10px;">
						<p>看不清？</p>
						<span class="mBox"><a id="change_img">换一张</a></span>
						</div> <span style="line-height:40px;" class="eh_msgerror icon-cha" style="display: none"
						id="registerCaptcha"></span>
					</li>
    				<li>
        				<input type="text" class="regsiter_02_input02" value="" name="mobile_vertify" id="mobile_vertify" required>
        				<a id="get_mobile_code" class="regsiter_02_huoqu">获取手机验证码</a>
        				<a id="reget_code" class="regsiter_02_huoqu" style="display: none">重新获取验证码(<span id="re_second">99</span>) </a>
    					<span class="eh_msgerror icon-cha" style="display: none" id="registerMobileVertify"></span>
    				</li>
				</ul>
			</div>
			<div class="regsiter_02_agree">
				<label><input type="checkbox" class="regsiter_02_checkbox" value="1"
					id="choose" name="choose" checked>我已阅读并同意《 <a href="javascript:void(0);"
					class="regsiter_02_agree_a" target="_blank">51易货网注册协议</a> 》</label>
				<span class="eh_msgerror icon-cha" style="display: none"
					id="agreement"></span>
			</div>
			<div align="center">
				<input type="submit" value="注册" class="regsiter_02_btn" style="width:274px; margin-left:110px;" />
			</div>
			<!--注册输入框 结束-->
		</div>
	</div>
	<!--内容 结束-->

</form>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script language="javascript" src="js/jquery-validate.js"></script>
<script type="text/javascript" src="js/jquery_002.js"></script>
<script language="javascript" src="js/flow_register.js"></script>
<script>
var timeprocess;
var err = <?php echo $this->input->get_post("err")?$this->input->get_post("err"):0;?>;
function change_yzm1(obj)
{

    $(obj).attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
}

$(document).ready(function() {
    $('#get_mobile_code').click(function(){
        if($("#mobile").val() != ""){
            $.get( base_url+'/customer/check_mobile_phone',{name:$("#mobile").val(),mobile:$("#mobile").val()},function(data){
            	var data = jQuery.parseJSON(data);
                if(data.Result==true){
                    var yzm = $("#captcha").val();
                    $.post("<?php echo site_url("customer/ajax_check_yzm");?>?captcha="+yzm,function(data){
                        if(data["Result"]){
                            $.ajax({
                        	    url: base_url+'/customer/ajax_send/8',
                        	    type: 'POST',
                        	    data:{'mobile':$("#mobile").val(),"yzm":yzm},
                        	    dataType: 'html',
                        	    success: function(data){
                            	    	$('#re_second').html(100);
                            	    	timeprocess = setTimeout(remainTime,1000);
//                            			alert(data);
                        	    	}
                        	});
                        }else{
                        	$('#registerCaptcha').attr("class","onError").html("验证码填写错误").show();
                        }
                    },"json");
                }else{
                    $('#registerMobile').attr("class","onError");
                    $('#registerMobile').html("该手机号码已被使用");
                    $('#registerMobile').show();
                }
            });
        }else{
			$('#registerMobile').attr("class","onError");
            $('#registerMobile').html("请先填写手机号码");
            $('#registerMobile').show();
       }
    });

    $('#change_img').click(function(){
    	$('#captcha-pic').attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
    });

    $('#mobile').click(function(){
    	$('#registerMobile').html("");
        $('#registerMobile').hide();
    });
});

function remainTime(){
	$('#get_mobile_code').css('display', 'none');
	$('#reget_code').css('display', 'inline-block');
	var times = $('#re_second').html();
	if(times < 1){
		$('#get_mobile_code').css('display', 'inline-block');
		$('#reget_code').css('display', 'none');
		clearTimeout(timeprocess);
	}else{
		times -= 1;
		$('#re_second').html(times);
		timeprocess = setTimeout("remainTime()",1000);
	}
}
/**
 * 密码强弱
 */
function CheckIntensity(pwd){
	  var Mcolor,Wcolor,Scolor,Color_Html;
	  var m=0;
	  var Modes=0;
	  for(i=0; i<pwd.length; i++){
	    var charType=0;
	    var t=pwd.charCodeAt(i);
	    if(t>=48 && t <=57){charType=1;}
	    else if(t>=65 && t <=90){charType=2;}
	    else if(t>=97 && t <=122){charType=4;}
	    else{charType=4;}
	    Modes |= charType;
	  }
	  for(i=0;i<4;i++){
	  if(Modes & 1){m++;}
	      Modes>>>=1;
	  }
	  if(pwd.length<=4){m=1;}
	  if(pwd.length<=0){m=0;}
	  switch(m){
	    case 1 :
	      Wcolor="pwd pwd_Weak_c";
	      Mcolor="pwd pwd_c";
	      Scolor="pwd pwd_c pwd_c_r";
	      Color_Html="弱";
	    break;
	    case 2 :
	      Wcolor="pwd pwd_Medium_c";
	      Mcolor="pwd pwd_Medium_c";
	      Scolor="pwd pwd_c pwd_c_r";
	      Color_Html="中";
	    break;
	    case 3 :
	      Wcolor="pwd pwd_Strong_c";
	      Mcolor="pwd pwd_Strong_c";
	      Scolor="pwd pwd_Strong_c pwd_Strong_c_r";
	      Color_Html="强";
	    break;
	    default :
	      Wcolor="pwd pwd_c";
	      Mcolor="pwd pwd_c pwd_f";
	      Scolor="pwd pwd_c pwd_c_r";
	      Color_Html="无";
	    break;
	  }
	  document.getElementById('pwd_Weak').className=Wcolor;
	  document.getElementById('pwd_Medium').className=Mcolor;
	  document.getElementById('pwd_Strong').className=Scolor;
	  document.getElementById('pwd_Medium').innerHTML=Color_Html;
	}
</script>