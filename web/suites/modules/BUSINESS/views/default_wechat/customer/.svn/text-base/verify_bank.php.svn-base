<script src="js/verification.js"></script><!-- js验证类 -->
<script src="js/verificationCode.js"></script><!-- 验证码相关js -->
<style type="text/css">
	.container {background: #F6F6F6;}
	.num-button {top: -9px;}
    .tuichu_ball_box {height: 60%;width: 80%;overflow-y: scroll;}
</style>


<!-- 银行卡验证 -->
<form id="form1">
    <div class="verify_bank">
        <!-- 第一步 -->
        <div class="verify_bank_one" style="padding-top: 6px;">
            <!-- 姓名 -->
        	<div class="verify_bank_num verify_bank_num01"><span>姓名</span><input type="text" name="real_name" value=""  placeholder="必填，请输入真实姓名"><i class="icon-guanbi1" onclick="delinput(this,'#nextone')"></i></div>
            <!-- 身份证号 -->
            <div class="verify_bank_num verify_bank_num02" style="margin-top: 6px;"><span>身份证号</span><input type="tel" onkeyup="verify_bank_one()" name="idcard" value="" placeholder="必填，请输入18位身份证号" maxlength="18"><i class="icon-guanbi1" onclick="delinput(this,'#nextone')"></i></div>
            <div class="verify_bank_next"><button  disabled="disabled" id="nextone" onclick="verify_bank_next('.verify_bank_one','.verify_bank_two');return false;">下一步</button></div>
        </div>
    
        <!-- 第二步 -->
        <div class="verify_bank_two" hidden>
            <!-- 持卡人 -->
            <div class="verify_bank_name"><span id="realname">持卡人: 泰迪熊</span><em class="icon-bangzhu" onclick="tishi();"></em></div>
            <!-- 银行卡号 -->
            <div class="verify_bank_num verify_bank_num03"><span>银行卡号</span><input type="text" id="" value="" onkeyup="verify_bank_two()" name="bank" placeholder="请输入银行卡号" maxlength="19"><i class="icon-guanbi1" onclick="delinput(this,'#nexttwo')"></i><em class="icon-bangzhu" onclick="tishi('只支持储蓄卡');"></em></div>
            <!-- 预留手机 -->
            <div class="verify_bank_num verify_bank_num04" style="margin-top: 6px;"><span>预留手机</span><input type="text" value="" onkeyup="verify_bank_two()" name="bankmobile"  placeholder="请输入银行预留手机号" maxlength="11"><i class="icon-guanbi1" onclick="delinput(this,'#nexttwo')"></i><em class="icon-bangzhu" onclick="tishi('银行预留手机号是办理银行卡时所填写的手机，没有预留，手机号忘记或已停用，请联系银行客服');"></em></div>
            <!-- 实名认证协议 -->
            <div class="verify_bank_agree">
            	<label><input type="checkbox" onchange="verify_bank_two()" id="agree" class="icon-yixuan1 recommend_tishi_active" checked="checked"><span>同意</span><a href="javascript:void(0);" onclick="approve_protocol_get();">实名认证协议</a></label>
            </div>
            <div class="verify_bank_next"><button disabled="disabled" id="nexttwo" onclick="verify_bank_next('.verify_bank_two','.verify_bank_three');return false;">下一步</button></div>
        </div>
    
    
        <!-- 第三步 -->
        <div class="verify_phone_number verify_bank_three" hidden>
            <div class="verify_phone_text">
            	<p>绑定银行卡需要短信确认，验证码已发送至</p>
            	<p id="phone">手机：<?php echo substr($mobile,0,3)."****".substr($mobile,7,4);?></p>
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
          	<a href="javascript:void(0);" class="verify_bank_ball_know" id="ball_konw" onclick="ball_konw(0);">知道了</a>
        </div>
        </div> 
    </div>	
</form>

<!-- 实名认证协议 弹窗 -->
<div class="tuichu_ball" hidden>
   <a href="javascript:void(0);" class="approve_protocol_close" onclick="close();"><img src="images/51h5-lose.png" alt=""></a>
   <div class="tuichu_ball_box">
     <div class="tuichu_ball_main">
     <div class="approve_protocol">
     <div class="approve_protocol_title"><span>“51易货网”实名认证协议</span></div>   
     <div class="approve_protocol_main">
        <p>为了提高交易的安全性和陕西五一易货网络科技有限责任公司用户（以下简称“用户”）身份的可信度，<span>陕西五一易货网络科技有限责任公司</span>（以下简称51易货网）向您提供认证服务。在您申请认证前，您必须先注册成为51易货网用户。51易货网有权采取各种其认为必要手段对用户的身份进行识别。但是，作为普通的网络平台，51易货网所能采取的方法有限，而且在网络上进行用户身份识别也存在一定的困难，因此，51易货网对完成认证的用户身份的准确性和绝对真实性不做任何保证。</p>
        <p>51易货网向您提供的认证服务包括以下具体程序：</p>
        <p>1、银行账户识别</p>
        <p>2、身份信息识别</p>
        <p>51易货网有权记录并保存您完成以上程序提供给51易货网的信息和51易货网获取的结果信息，亦有权根据本协议约定向您或第三方提供您是否通过认证的结论以及您的身份信息。</p>
        <h2>一、关于认证服务的理解与认同</h2>
        <p>1、认证服务是由51易货网提供的一项身份识别服务。除非本协议另有约定，一旦您的51易货网账户完成了认证，相应的身份信息和认证结果将不因任何原因被修改或撤回；如果您的身份信息在完成认证后发生了变更，您应向51易货网提供相应有权部门出具的凭证，由51易货网协助您变更您在51易货网支付账户的对应认证信息。</p>
        <p>2、51易货网有权单方随时修改或变更本协议内容，并通过51易货网网站公告变更后的协议文本，无需单独通知您。本协议进行任何修改或变更后，您还继续使用51易货网服务和/或认证服务的，即代表您已阅读、了解并同意接受变更后的协议内容；您如果不同意变更后的协议内容，应立即停用51易货网服务和认证服务。</p>
        <h2>二、身份信息识别</h2>
        <p>1、中华人民共和国大陆（以下简称大陆）个人51易货网用户可提供以下证件用于认证：认证当时处在有效期内的身份证、护照等明确标有身份证号的证件之一（需要在线上传证件时，必须是彩色原件扫描件/彩色数码拍摄件，第二代身份证需要同时提交正反两面，户籍证明提供日起有效期在三个月以上，除临时身份证外，51易货网对有效期三个月以内的证件不予提供认证服务)</p>
        <p>2、对于法律规定不具有完全民事行为能力的自然人，51易货网不向其提供认证服务。</p>
        <p>3、通过身份信息识别的51易货网用户不能自行修改已经认证的信息，包括但不限于平台上店铺名称、姓名以及身份证件号码等。</p>
        <p>大陆个人51易货网用户认证的有效期与其提供的身份证件有效期一致，但最长自认证完成日起不超过20年，户籍证明从通过审核当日开始起计算，有效期一年。其他个人51易货网用户认证信息的有效期按证件有效期和担保期限两者中较短的有效期计算，但最长自认证完成日起不超过20年。商户类51易货网用户认证信息的有效期一般为一年，若营业期限距离认证通过日少于一年则应以营业期限为准。有效期满后，相应的51易货网账户只能使用原先认证的身份信息或经合法变更后的身份信息进行再次认证。</p>
        <p>4、如51易货网用户在认证有效期内变更任何身份信息，则应在变更发生后三个工作日内书面通知51易货网变更认证，否则51易货网有权随时单方终止提供51易货网服务，且因此造成的全部后果，由51易货网用户自行承担。</p>
        <p>5、在51易货网用户对其51易货网账户进行取回密码等操作时，需要按照51易货网的提示出示可确认其持有该账户的个人身份证件，相关证件的要求依照本条前6项约定。</p>
        <h2>三、银行账户识别</h2>
        <p>1、个人51易货网用户进行认证应提供本人在大陆银行开设的人民币账号、开户名、开户银行。</p>
        <p>2、51易货网用户填写的银行账户的开户名必须与身份信息中的真实姓名或营业执照中的名称完全一致，所有经51易货网用户填写的资料将成为认证资料。</p>
        <p>3、若51易货网用户尚不具备完全民事行为能力，而以提供不实认证资料的方式，使51易货网误认为该用户是完全民事行为能力人而受理身份信息识别申请的，则因此产生的一切后果将由该用户及(或)其监护人承担，51易货网不承担任何责任。</p>
        <h2>四、特别声明</h2>
        <p>1、身份认证信息共享：</p>
        <p>为了使您享有便捷的服务，您经由其它网站向51易货网提交认证申请即表示您同意51易货网为您核对所提交的全部身份信息和银行账户信息，并同意51易货网将是否通过认证的结果及相关身份信息（不包括您的银行账户信息）提供给该网站。</p>
        <p>2、认证资料的管理：</p>
        <p>您在认证时提交给51易货网的认证资料，即不可撤销的授权由51易货网保留。51易货网承诺除法定或约定的事由外，不公开或编辑或透露您的认证资料及保存在51易货网的非公开内容用于商业目的，但本条第1项规定以及以下情形除外：</p>
        <p>1) 您授权51易货网透露的相关信息；</p>
        <p>2) 51易货网向国家司法及行政机关提供；</p>
        <p>3) 51易货网向51易货网关联企业提供；</p>
        <p>4) 第三方和51易货网一起为用户提供服务时，该第三方向您提供服务所需的相关信息（不包括您的银行账户信息）。</p>
        <p>5) 基于解决您与第三方民事纠纷的需要，51易货网有权向该第三方提供您的身份信息。</p>
        <h2>五、第三方网站的链接</h2>
        <p>为实现身份信息审查，51易货网网站(www.51ehw.com)上可能包含了指向第三方网站（如网上银行网站）的链接（以下简称“链接网站”）。“链接网站”非由51易货网控制，对于任何“链接网站”的内容，包含但不限于“链接网站”内含的任何链接，或“链接网站”的任何改变或更新，51易货网均不予负责。自“链接网站”接收的网络传播或其它形式之传送，51易货网不予负责。</p>
        <h2>六、不得为非法或被禁止目的的使用</h2>
        <p>接受本协议全部的说明、条款、条件是您申请认证的先决条件。您声明并保证，您不得就任何非法或为本协议、条件及须知所禁止之目的进行认证申请。您不得以任何可能损害、使瘫痪、使过度负荷或损害其他网站或其他网站的服务或51易货网或干扰他人对于51易货网认证申请的使用等方式使用认证服务。您不得通过非51易货网许可提供的任何方式取得或试图取得任何资料或信息。</p>
        <h2>七、有关免责</h2>
        <p>下列情况时51易货网无需承担任何责任：</p>
        <p>1、由于您将51易货网账户密码告知他人或未保管好自己的密码或与他人共享51易货网账户或任何其他非51易货网的过错，导致您的个人资料泄露。</p>
        <p>2、任何由于黑客攻击、计算机病毒侵入或发作、电信部门技术调整导致之影响、因政府管制而造成的暂时性关闭、由于第三方原因(包括不可抗力，例如国际出口的主干线路及国际出口电信提供商一方出现故障、火灾、水灾、雷击、地震、洪水、台风、龙卷风、火山爆发、瘟疫和传染病流行、罢工、战争或暴力行为或类似事件等)及其他非因51易货网过错而造成的认证信息泄露、丢失、被盗用或被篡改等。</p>
        <p>3、由于与51易货网链接的其它网站（如网上银行等）所造成的银行账户信息泄露及由此而导致的任何法律争议和后果。</p>
        <p>4、任何51易货网用户（包括未成年人用户）向51易货网提供错误、不完整、不实信息等造成不能通过认证或遭受任何其他损失，概与51易货网无关，给他人造成损失的，该用户应予以赔偿。</p>
        <h2>八、协议关系</h2>
        <p>本协议为《陕西五一易货网络科技有限责任公司用户服务协议》的有效组成部分；本协议未约定的内容，以《陕西五一易货网络科技有限责任公司用户服务协议》的约定为准。</p>
     </div>
</div>  
      </div>
   </div>
 </div>






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
    
   	if(real_name && isCardNo(idcard)){
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

   	if(bank.length >= 16  && bank.length <= 19  && $('#agree').prop("checked") && checkMobile(bankmobile)){
//    	   	$("#phone").text(bankmobile.substr(0,3)+"***"+bankmobile.substr(7,4));
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
function ball_konw(status) {
	$('.verify_bank_ball').hide();
	if(status){
		$("#ball_konw").attr("onclick","ball_konw(0)");
		verify_bank_next('.verify_bank_three','.verify_bank_two');
	}
}

// 点击下一步 or 上一步
function verify_bank_next(current,next) {
    $(current).hide();//被隐藏的页面
    $(next).show();//要显示的页面
    now = next;//记录当前页面
}

//获取验证码
function getcode(type){
	var bankmobile = "<?php echo $mobile;?>";
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
					$("#ball_konw").removeAttr("onclick").attr("href","<?php echo site_url("Member/info/AuthenticationView");?>");
					tishi(data["msg"]);
				}
			}else if(data["status"] == 02){
				$("#ball_konw").attr("onclick","ball_konw(1)");
				tishi(data["msg"]);
			}else{
				tishi(data["msg"]);
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
				$("#ball_konw").removeAttr("onclick").attr("href","<?php echo site_url("Member/info/AuthenticationView");?>");
				tishi(data["msg"]);
			}else{
				tishi(data["msg"]);
			}
		},
		error:function(res){
			console.log(res);
		}
	});
}

function approve_protocol_get() {
  $('.tuichu_ball').show();
}
// 点击关闭弹窗
  $('.approve_protocol_close').on('click',function(){
    $('.tuichu_ball').hide();
  });



</script>