<?php 
header("Cache-Control:no-cache,must-revalidate,no-store"); //这个no-store加了之后，Firefox下有效
header("Pragma:no-cache");
header("Expires:-1");


?>
    <div class="passwd_top" ">
        <div class="passwd_con">
        <form action ="<?php echo site_url('customer/update_password') ?>" method="post" id="form">
            <p>用户找回密码</p>
            <img src="images/zhaohui2.png">
            <ul id="ul">
                <li>输入新密码：<input type="password" id="pass1" name="password" class="phone_hao" value="">
                <div class="pwd-con">
				<span id="pwd_Weak" class="pwd pwd_c">&nbsp;</span> 
				<span id="pwd_Medium" class="pwd pwd_c pwd_f">无</span> 
				<span id="pwd_Strong" class="pwd pwd_c pwd_c_r">&nbsp;</span>
			    </div> 
                <div id="perror" style="display:none;width:300px;float:right;margin-right:0;margin-top:12px;color:red;font-size:15px;"</div>
                </li>
                <li>确认新密码：<input type="password" id="pass2" class="phone_hao" value="" name="ConfirmPassword"><div id="pterror" style="display:none;width:300px;float:right;margin-right:130px;margin-top:10px;color:red;font-size:15px;"></div></li>
                <input type="hidden" name="name" value="<?php echo isset($name)&&$name!=''?$name:""; ?>">
                <input type="hidden" name="mobile" value="<?php echo isset($mobile)&&$mobile!=''?$mobile:""; ?>">
                <input type="hidden" name="mobile_verfity" value="<?php echo $mobile_verfity;?>" >
            </ul>
            <a href="javascript:formsubmit();"><h1>确认提交</h1></a>
            </form>
        </div>
    </div>
</body>

<script>
$('#pass1').blur(function(){
	if($('#pass1').val()==""){
		$('#perror').html('新密码不能为空！');
        $('#perror').show();
		}
	else if($('#pass1').val().length<6 || $('#pass1').val().length>20){
		$('#perror').html('新密码必须为6-20字符！');
        $('#perror').show();
		}
	/*else if(check_pass($('#pass1').val())==1){
		$('#perror').html('新密码过于简单！');
        $('#perror').show();
		}*/
});
$('#pass1').click(function(){
		$('#perror').html('');
        $('#perror').hide();
});

$('#pass2').blur(function(){
	if($('#pass2').val()==""){
		$('#pterror').html('确认新密码不能为空！');
        $('#pterror').show();
		}
	else if($('#pass1').val()!==$('#pass2').val()){
	    //alert('两次密码不一致');;
		$('#pterror').html('两次密码不一致！');
        $('#pterror').show();
	}
});
$('#pass2').click(function(){
		$('#pterror').html('');
        $('#pterror').hide();
});

function formsubmit(){
	if($('#pass1').val()==""){
		$('#perror').html('新密码不能为空！');
        $('#perror').show();
		}
	else if($('#pass1').val().length<6 || $('#pass1').val().length>20){
		$('#perror').html('新密码必须为6-20字符！');
        $('#perror').show();
		}
    /*else if(check_pass($('#pass1').val())==1){
		$('#perror').html('新密码过于简单！');
        $('#perror').show();
		}*/
	else if($('#pass2').val()==""){
		$('#pterror').html('确认新密码不能为空！');
        $('#pterror').show();
		}
	else if($('#pass1').val()!==$('#pass2').val()){
	    //alert('两次密码不一致');
		$('#pterror').html('两次密码不一致！');
        $('#pterror').show();
	}else{
	   $('#form').submit();
    }
}


function check_pass(pwd){
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
	    return m;
}

    $("#pass1").keyup(function() {
		var strength = CheckIntensity($(this).val());
		if (strength) {
			$("#pwdStrengh").show();
		} else {
			$("#pwdStrengh").hide();
		}
		$("#pwdStrengh").attr("className", strength);
	});
    
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

//javascript:location.replace(this.href); event.returnValue=false;
</script>