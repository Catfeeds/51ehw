<div class="Box member_Box clearfix">
	<?php //个人中心左侧菜单  
            $data['left_menu'] = 5;
            $this->load->view('customer/leftmenu',$data);
         ?>

	<div class="huankuan_cmRight">
		<div class="huankuan_rTop">个人信息</div>
		<div class="kehufuwu_04_top2">
			<h4>修改密码</h4>
		</div>
		<div class="gerenzhongxin_01_con clearfix">
			<form name="form1" method="post"
				action="<?php echo site_url('member/info/pwd_save')?>" id="form1">
				<div class="gerenzhongxin_01_con_left">
					<ul>
						<li>原密码：</li>
						<li>新密码：</li>
						<li>确认新密码：</li>
					</ul>
				</div>

				<div class="gerenzhongxin_01_con_right">
					<ul>
						<li><input type="password" name="txtOldPwd" id="txtOldPwd"
							class="gerenzhongxin_01_con_input" placeholder="请输入旧密码"><span
							class="help-block" id="rfvOldPwd" style="color: red;">* </span></li>
						<li><input type="password" name="txtNewPwd" id="txtNewPwd"
							class="gerenzhongxin_01_con_input" placeholder="密码长度只能在6-16位字符之间"><span
							class="help-block" id="rfvNewPwd" style="color: red;">* </span></li>
						<li><input type="password" name="txtConfimPwd" id="txtConfimPwd"
							class="gerenzhongxin_01_con_input" placeholder="确认新密码"><span
							class="help-block" id="cvConfimPwd" style="color: red;">* </span></li>
					</ul>
					<div class="gerenzhongxin_01_xiugai_btn">
						<a id="sub">保存</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
    $("#sub").click(
    	    function(){
    	    	$('#form1').submit();
        	    });
    
    </script>

<script type="text/javascript">
$(function(){
 $('#txtOldPwd').blur(function() {
   if ($('#txtOldPwd').val() == ''){
     $('#rfvOldPwd').show();
   }else{
	 $('#rfvOldPwd').hide();
     $('#txtNewPwd').blur(function() {
         var newpwd = $('#txtNewPwd').val().length;
         if(newpwd>5 && newpwd<17){
        	 $('#rfvNewPwd').hide();
             $('#txtConfimPwd').blur(function() {
               if ($('#txtConfimPwd').val() != $('#txtNewPwd').val()){
            	   $('#cvConfimPwd').text("*");
                 $('#cvConfimPwd').show();
    		   }else{
                 $('#cvConfimPwd').hide();
    		   }
    		 });
         }else{
        	 $('#rfvNewPwd').show();
         }
	 });
   }
 });
  
  $('#form1').submit(function() {
    var pass = true;
	$(':input').next('span').hide();

    if ($('#txtOldPwd').val() == ''){
    	$('#rfvOldPwd').text("请输入旧密码"); 
      $('#rfvOldPwd').show();
	  pass = false;
    }else{
        pass = true;
	}

	if ($('#txtNewPwd').val() == ''){
		$('#rfvNewPwd').text("请输入新密码");
		$('#rfvNewPwd').show();
		pass = false;
    }else if($('#txtNewPwd').val().length > 5 && $('#txtNewPwd').val().length < 17){
        pass = true;
	}else{
    	$('#rfvNewPwd').text("密码长度只能在6-16位字符之间");
        $('#rfvNewPwd').show();
        pass = false;
	}
    
	if ($('#txtNewPwd').val() != '' && $('#txtConfimPwd').val() != $('#txtNewPwd').val()){
		$('#cvConfimPwd').text('两次密码不一致');
		$('#cvConfimPwd').show();
		pass = false;	
    }
	return pass;
  });
});  

var msg = '<?php echo $error_msg; ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'pw_error' : $('#lblMsg').empty().text('旧密码错误').show();break;
			case 'pw_repeat' : $('#lblMsg').empty().text('新旧密码不能一致').show();break;
			default : break;
		}
	}	
});
</script>


