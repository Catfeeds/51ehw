<?php
 header("Cache-Control:no-cache,must-revalidate,no-store"); //这个no-store加了之后，Firefox下有效
header("Pragma:no-cache");
header("Expires:-1");
?>
	<div class="container" id="leftTabBox">
		


		<div class="page clearfix">
		<form action ="<?php echo site_url('customer/update_password') ?>" method="post" id="form">
		<!--忘记密码－步骤02 start-->
		<div>
			<div style="position: relative">
				<div class="register-num" style="width: 95%;">
					<input id="pass1" name="password" type="text" placeholder="输入新密码" style="width: 100%;" autocomplete="off" value="">
				</div>
			</div>
			<div class="bangding_login-mima">
				<input  type="password" class="mima_text" type="text" id="pass2" name="ConfirmPassword" placeholder="再次输入密码" autocomplete="off">
				<input type="hidden" name="name" value="<?php echo isset($name)&&$name!=''?$name:""; ?>">
			</div>
			
			<div class="register-button" onclick="formsubmit();"  style="background: #FECF0A !important; color: #262626 !important; font-size: 18px !important;">
				<a style="padding:15px 35%;" >确定</a>
			</div>
		</div>
		
       <!--忘记密码－步骤02 end-->
    	</form>
    </div>
	</div>
	<script type="text/javascript">
	function formsubmit(){
		if($('#pass1').val()==""){
			alert('新密码不能为空！');
			/*$('#perror').html('新密码不能为空！');
	        $('#perror').show();*/
			}
		else if($('#pass1').val().length<6 || $('#pass1').val().length>20){
			alert('新密码必须为6-20字符！')
			/*$('#perror').html('新密码必须为6-20字符！');
	        $('#perror').show();*/
			}
	    /*else if(check_pass($('#pass1').val())==1){
			$('#perror').html('新密码过于简单！');
	        $('#perror').show();
			}*/
		else if($('#pass2').val()==""){
			alert('确认新密码不能为空！');
			/*$('#pterror').html('确认新密码不能为空！');
	        $('#pterror').show();*/
			}
		else if($('#pass1').val()!==$('#pass2').val()){
		    alert('两次密码不一致');
			/*$('#pterror').html('两次密码不一致！');
	        $('#pterror').show();*/
		}else{
		   $('#form').submit();
	    }
	}
	    
</script>