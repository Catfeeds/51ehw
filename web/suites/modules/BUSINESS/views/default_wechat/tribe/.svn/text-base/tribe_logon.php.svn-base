<!-- 邀请加入 -->
<form name="form" method="post" action="<?php echo site_url('Login/customer_login')?>" id="form">
<div class="invitation_join">
  <!-- 图片 -->
  <div><img src="images/invite_header.png"></div>

  <!-- 状态一 -->
  <div class="invitation_join_status_one" hidden><span>51易货账号：</span><span>15698756324</span></div>
  
  <!-- 状态二 -->
  <div class="invitation_join_status_two">
     <p><input type="tel" name="mobile"  maxlength="11" placeholder="请输入您的手机号" style="width: 100%;"></p>
  </div>


  <!-- 提示 -->
  <div class="invitation_join_tishi"><span>* 以便系统进一步识别您的亲朋好友</span></div>

  <div class="invitation_join_status_two" style="padding-top: 0;">
     <p>
       <input type="tel" maxlength="" name="code" placeholder="请输入验证码">
       <input type="button" class="invite_send_but"  id="get_mobile_code" value="发送验证码" onclick="settime(this)"/> 
        <input type="hidden" name="tribe_id" value="<?php echo $tribe_id ?>">
     </p>
  </div>


  <div class="invitation_join_status_two" style="padding-top: 20px;">
     <p><input type="text" name="real_name"  maxlength="11" placeholder="请输入您的真实姓名" style="width: 100%;"></p>
  </div>
   <div class="invitation_join_tijiao" style="margin-top: 30px;"><a id="sub" href="javascript:void(0);"><?php if($staff_status){echo '提交';}else{ echo '提交并进入部落';  }?></a></div>
  
  
  <!-- 五一易货提醒您常回家看看 -->
  <div class="invitation_join_text">
    <p>五一易货提醒您常回家看看</p>
    <p>400-029-7777</p>
  </div>


</div>
</form>




<style type="text/css" href="css/validator.css"></style>
<script type="text/javascript" src="js/verificationCode.js"></script>
<script type="text/javascript">

var err_msg = <?php echo $err_msg?>;

if( err_msg == 1)
{
    $(".black_feds").text("验证码错误").show();
    setTimeout("prompt();", 2000);
    
}else if ( err_msg == 2)
{ 
	$(".black_feds").text("登录失败").show();
    setTimeout("prompt();", 2000);
}else if( err_msg == 3)
{ 
	$(".black_feds").text("您不是该部落录入用户，请点击右下角注册账户").show();
    setTimeout("prompt();", 2000);
}

//获取验证码js
$("#get_mobile_code").click(function(){
	var type = '255';
	var mobile = $("input[name='mobile']").val();
	var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
	if(mobile=='' || isNaN(mobile) || mobile.length!=11 || !partten_mobile.test(mobile)){
		$(".black_feds").text("请输入正确手机号").show();
		setTimeout("prompt();", 2000);
		return;
	}
	var get_code_id = "#get_mobile_code";
	get_mobile_code(type,mobile);
})

$('#sub').click(function(){ 
    var code = $('input[name=code]').val();
	var name = $('input[name=mobile]').val();
	var partten_mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|17[0-9]|14[0-9])[0-9]{8}$/;
	//验证手机
	if(name=='' || isNaN(name) || name.length!=11 || !partten_mobile.test(name)){
		$(".black_feds").text("请输入正确手机号").show();
		setTimeout("prompt();", 2000);
		return;
	}else if( code == '')
	{ 
		$(".black_feds").text("请输入验证码").show();
		setTimeout("prompt();", 2000);
		return;
	}
	var real_name = $('input[name=real_name]').val();
	var pattern = /[\u4e00-\u9fa5]{2,5}$/;
	
	if( !pattern.test( real_name ) )
	{
		$(".black_feds").text('请输入2~5个中文姓名').show();
		setTimeout("prompt();", 2000); 
		return;
	}
	
	document.getElementById("form").submit();
})

function change_yzm1(obj)
{

    $(obj).attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
}
</script>