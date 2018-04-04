<script src="js/verification.js"></script><!-- js验证类 -->
<script src="js/verificationCode.js"></script><!-- 验证码相关js -->
<style type="text/css">
	.container {background: #F6F6F6;}
	.num-button {top: -9px;}
</style>


<!-- 银行卡验证 -->
<form id="form1">
    <div class="verify_bank">
        <!-- 第一步 -->
        <div class="verify_bank_one" style="padding-top: 6px;">
            <!-- 姓名 -->
        	<div class="verify_bank_num verify_bank_num01"><span>姓名</span><input type="text" name="real_name" value="" onkeyup="verify_bank_one()" maxlength="5" placeholder="必填，请输入真实姓名"><i class="icon-guanbi1" onclick="delinput(this,'#nextone')"></i></div>
            <!-- 身份证号 -->
            <div class="verify_bank_num verify_bank_num02" style="margin-top: 6px;"><span>身份证号</span><input type="tel" onkeyup="verify_bank_one()" name="idcard" value="" placeholder="必填，请输入18位身份证号" maxlength="18"><i class="icon-guanbi1" onclick="delinput(this,'#nextone')"></i></div>
            <div class="verify_bank_next"><button  disabled="disabled" id="nextone" onclick="verify_bank_next('.verify_bank_one','.verify_bank_two');return false;">下一步</button></div>
        </div>
    
        <!-- 第二步 -->
        <div class="verify_bank_two" hidden>
            <!-- 持卡人 -->
            <div class="verify_bank_name"><span id="realname">持卡人: 泰迪熊</span><em class="icon-bangzhu" onclick="tishi();"></em></div>
            <!-- 银行卡号 -->
            <div class="verify_bank_num verify_bank_num03"><span>银行卡号</span><input type="text" value="" onkeyup="verify_bank_two()" name="bank" placeholder="请输入银行卡号"><i class="icon-guanbi1" onclick="delinput(this,'#nexttwo')"></i><em class="icon-bangzhu" onclick="tishi('只支持储蓄卡');"></em></div>
            <!-- 预留手机 -->
            <div class="verify_bank_num verify_bank_num04" style="margin-top: 6px;"><span>预留手机</span><input type="text" value="" onkeyup="verify_bank_two()" name="bankmobile"  placeholder="请输入银行预留手机号" maxlength="11"><i class="icon-guanbi1" onclick="delinput(this,'#nexttwo')"></i><em class="icon-bangzhu" onclick="tishi('银行预留手机号是办理银行卡时所填写的手机，没有预留，手机号忘记或已停用，请联系银行客服');"></em></div>
            <!-- 实名认证协议 -->
            <div class="verify_bank_agree">
            	<label><input type="checkbox" checked="checked" onchange="verify_bank_two()" id="agree" class="icon-yixuan1 recommend_tishi_active" ><span>同意</span><a href="javascript:void(0);">实名认证协议</a></label>
            </div>
            <div class="verify_bank_next"><button disabled="disabled" id="nexttwo" onclick="verify_bank_next('.verify_bank_two','.verify_bank_three');return false;">下一步</button></div>
        </div>
    
    
        <!-- 第三步 -->
        <div class="verify_phone_number verify_bank_three" hidden>
            <div class="verify_phone_text">
            	<p>绑定银行卡需要短信确认，验证码已发送至</p>
            	<p id="phone">手机：<?php //echo substr($mobile,0,3)."****".substr($mobile,7,4);?></p>
            </div>
            <!-- 输入手机验证码 -->
            <div class="verify_phone_input">
            	<input type="text" name="VerificationCode"  onkeyup="verify_bank_three()" placeholder="请输入验证码">
            	<input type="button" class="num-button" id ="get_mobile_code"  onclick="getcode(10);return false;" value="获取验证码">
            </div>
            <div class="verify_bank_next"><button disabled="disabled" id="complete" onclick="ajaxform1();return false;">完成</button></div>
        </div>


        <!-- 第四步，支付密码 -->
        <div class="alternate_password verify_bank_four" hidden>
      		<div class="alternate_password_input"><input type="password" value="" name="pay_passwd" onkeyup="verify_bank_four()" placeholder="请输入支付密码"></div>
        	<div class="verify_bank_next"><button disabled="disabled" id="paycomplete" onclick="SetPayPassword();return false;">完成</button></div>
        </div>	
    
        <!-- 提示弹窗 -->
        <div class="verify_bank_ball">
        <div class="verify_bank_ball_box">
          	<div class="verify_bank_ball_title"><span>提示</span></div>
        	<div class="verify_bank_ball_text"><span>持卡人为您的认证身份，必须使用该认证身份下的银行卡</span></div>
          	<a href="javascript:void(0);" class="verify_bank_ball_know" onclick="ball_konw();">知道了</a>
        </div>
        </div> 
    </div>	
</form>


<script type="text/javascript">
$(function(){ 
	now = ".verify_bank_one";
    pushHistory();  
    window.addEventListener("popstate", function(e) {  
//         alert("我监听到了浏览器的返回按钮事件啦");//根据自己的需求实现自己的功能 
		if(now == ".verify_bank_one"){
			history.back(-1);
		}else if(now == ".verify_bank_two"){
			verify_bank_next(now,".verify_bank_one");
		}else if(now == ".verify_bank_three"){
			verify_bank_next(now,".verify_bank_two");
		}else if(now == '.verify_bank_four'){
			verify_bank_next(now,".verify_bank_three");
		}
    }, false);  
    
    function pushHistory() {  
        var state = {  
            title: "title",  
            url: "#"  
        };  
        window.history.pushState(state, "title", "<?php echo current_url();?>");  
    } 

    verify_bank_one();   
});  


// 点击同意
$('.verify_bank_agree label input').on('click',function(){
    if(this.checked){    
    	$(this).removeClass('icon-weixuan1');   
    	$(this).addClass('recommend_tishi_active');   
    }else{     
    	$(this).addClass('icon-weixuan1');   
    	$(this).removeClass('recommend_tishi_active');    
    }  
});

//第一步
function verify_bank_one(){
    var real_name = $('input[name="real_name"]').val();
    var idcard = $('input[name="idcard"]').val();
    if(real_name){
    	$('input[name="real_name"]').siblings('i').show();
    }else{
    	$('input[name="real_name"]').siblings('i').hide();
    }

    if(idcard){
    	$('input[name="idcard"]').siblings('i').show();
    }else{
    	$('input[name="idcard"]').siblings('i').hide();
    }
    
   	if(isChinaName(real_name) && isCardNo(idcard)){
   		var real_name = $('input[name="real_name"]').val();
   		$("#realname").text("持卡人："+real_name);
   		$('.verify_bank_one button').addClass('verify_bank_next_active').removeAttr('disabled');
   	}else{
   		$('.verify_bank_one button').removeClass('verify_bank_next_active').attr('disabled', 'disabled');
   	}
   
   	
}

///第二步
function verify_bank_two(){
    var bank = $('input[name="bank"]').val();
    var bankmobile = $('input[name="bankmobile"]').val();
    if(bank){
    	$('input[name="bank"]').siblings('i').show();
    }else{
    	$('input[name="bank"]').siblings('i').hide();
    }

    if(bankmobile){
    	$('input[name="bankmobile"]').siblings('i').show();
    }else{
    	$('input[name="bankmobile"]').siblings('i').hide();
    }

   	if(luhnCheck(bank) && $('#agree').prop("checked") && checkMobile(bankmobile)){
   	   	$("#phone").text(bankmobile);
   		$('.verify_bank_two button').addClass('verify_bank_next_active').removeAttr('disabled');
   	}else{
   		$('.verify_bank_two button').removeClass('verify_bank_next_active').attr('disabled', 'disabled');
   	}
   	
}

//第三步
function verify_bank_three(){
	var VerificationCode = $('input[name="VerificationCode"]').val();
	if(VerificationCode){
		$('.verify_bank_three #complete').addClass('verify_bank_next_active').removeAttr('disabled');
	}else{
		$('.verify_bank_three #complete').removeClass('verify_bank_next_active').attr('disabled', 'disabled');
	}
}

///第四步
function verify_bank_four(){
	var pay_passwd = $('input[name="pay_passwd"]').val();
	if(pay_passwd.length >= 6){
		$('.verify_bank_four #paycomplete').addClass('verify_bank_next_active').removeAttr('disabled');
	}else{
		$('.verify_bank_four #paycomplete').removeClass('verify_bank_next_active').attr('disabled', 'disabled');
	}
}

// 点击删除输入内容
function delinput(obj,next){
    $(obj).hide().siblings('input').val('');
    $(next).removeClass('verify_bank_next_active').attr('disabled', 'disabled');
}

//弹窗提示
function tishi(content) {
    $('.verify_bank_ball').show();
    $('.verify_bank_ball_text span').html(content);
}

//关闭弹窗提示
function ball_konw() {
	$('.verify_bank_ball').hide();
}

// 点击下一步 or 上一步
function verify_bank_next(current,next) {
    $(current).hide();//被隐藏的页面
    $(next).show();//要显示的页面
    now = next;//记录当前页面
}

//获取验证码
function getcode(type){
	var bankmobile = $('input[name="bankmobile"]').val();
	get_mobile_code(type,bankmobile);
}

//ajax实名认证
function ajaxform1(){
	var is_passwd = "<?php echo $is_passwd;?>";
	$.ajax({
		type:'post',
		dataType:'json',
		url:"<?php echo site_url("Member/info/AjaxAuthentication");?>",
		data:$("#form1").serialize(),
		success:function(data){
			if(data["status"] == 00){
				if(!is_passwd){
					verify_bank_next('.verify_bank_three','.verify_bank_four');
				}else{
					location.href="<?php echo site_url("Member/info/AuthenticationView");?>";
				}
			}else{
				tishi("您提交实名认证有误，请重新提交");
			}
		},
		error:function(res){
			console.log(res);
		}
	});
}


//ajax设置支付密码
function SetPayPassword(){
	$.ajax({
		type:'post',
		dataType:'json',
		url:"<?php echo site_url("Member/info/SetPayPassword");?>",
		data:$("#form1").serialize(),
		success:function(data){
			if(data["status"] == "00"){
				location.href="<?php echo site_url("Member/info/AuthenticationView");?>";
			}else{
				tishi("支付密码设置失败");
			}
		},
		error:function(res){
			console.log(res);
		}
	});
}



</script>