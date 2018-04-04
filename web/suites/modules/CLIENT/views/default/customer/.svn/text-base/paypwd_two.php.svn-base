<?php 
header("Cache-Control:no-cache,must-revalidate,no-store"); //这个no-store加了之后，Firefox下有效
header("Pragma:no-cache");
header("Expires:-1");
//$this->session->set_userdata('pay',2);

?>
<?php if(isset($status)&&$status=='updatepay'): ?>
<form action="<?php echo site_url('member/save_set/update_paypwd/1'); ?>" method="post" id="form_save">
<?php else:?>
<form action="<?php echo site_url('member/save_set/update_paypwd'); ?>" method="post" id="form_save">
<?php endif;?>
        <div class="passwd_top">
        <div class="passwd_con">
            <p class="pay_t"><a href="<?php echo site_url("home");?>">首页</a> > <a href="<?php echo site_url("Member/info");?>">个人中心</a> > <a href="<?php echo site_url("Member/save_set");?>">安全设置</a> >  <a href="javascript:void(0);" class="pay_current">立即设置</a></p>
            <?php if(isset($status)&&$status=='updatepay'): ?>
             <img src="images/revise2.png">
            <?php else: ?>
            <img src="images/pay2.png">
            <?php endif; ?>
            <ul class="pay_ul">
             <li><span class="pay_span">输入新密码：</span>
             <input type="password" class="phone_hao" placeholder="请输入支付密码" id="paypassword" name="paypassword">
             <div class="pwd-con">
				<span id="pwd_Weak" class="pwd pwd_c">&nbsp;</span> 
				<span id="pwd_Medium" class="pwd pwd_c pwd_f">无</span> 
				<span id="pwd_Strong" class="pwd pwd_c pwd_c_r">&nbsp;</span>
			</div> 
			<div id="perror" style="display:none;width:300px;float:right;margin-right:-40px;margin-top:5px;color:red;font-size:15px;"></div>
             </li>
            <li><span class="pay_span">确认新密码：</span>
            <input type="password" class="phone_hao" placeholder="请再次输入支付密码" id="surepaypassword">
            <div id="sperror" style="display:none;width:300px;float:right;margin-right:85px;margin-top:5px;color:red;font-size:15px;"></div>
            </li>
                <li><span class="pay_span" style="margin-right:5px;">图形验证码：</span><input type="text" placeholder="输入验证码" id="captcha">
                	<img src="<?php echo site_url('customer/yzm_img')?>" id="czy" style="cursor: pointer; height: 45px; width: 80px; vertical-align: middle; float: left;margin:-68px 390px 0 332px; ">
                    <span style="margin-left:90px;"><i>看不清！</i><a id="change_img" style="color:#fea33b" onclick="change_yzm()">换一张！</a></span>
                    <div id="verror" style="display:none;width:300px;float:right;margin-right:30px;margin-top:-66px;color:red;font-size:15px;"></div>
                </li>
            </ul>
            <input type="hidden" name="m_verfity" value="<?php echo isset($m_verfity)&&$m_verfity!=null?$m_verfity:"" ?>">
            <a href="javascript:submit();"><h1>确认提交</h1></a>
        </div>
    </div>
</form>
    
    <script>

    $('#czy').click(function(){
    	$(this).attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
        });

    function change_yzm(){
   	 $('#czy').attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
    }

    $('#captcha').blur(function(){
    	if ($('#captcha').val()==''){
            //alert('验证码不能为空');
        	$('#verror').html('验证码不能为空！');
            $('#verror').show();
        }else{                
        	$.ajax({
                url:base_url + "/customer/ajax_check_yzm",//captcha/"+$('#captcha').val(),
                type:"GET",
                data:{captcha:$('#captcha').val()},
                datatype:"json",
                success:function(results){
                	var data = jQuery.parseJSON(results);
                	if(data.Result==false){
                    	$('#verror').html('验证码错误！');
                        $('#verror').show();
                        }
                    },
                error:function(){
                    alert("服务器无响应，请重试");
                    }
            
            });
            }
    });
    $('#captcha').click(function(){
        	$('#verror').html('');
            $('#verror').hide();
    });

    $('#paypassword').blur(function(){
    	if ($('#paypassword').val()==''){
            $('#perror').html('支付密码不能为空！');
            $('#perror').show();
        }else if($('#paypassword').val().length<6){
        	$('#perror').html('支付密码必须大于6位！');
            $('#perror').show();
        }
    });
    $('#paypassword').click(function(){
    	$('#perror').html('');
        $('#perror').hide();
    });

    $('#surepaypassword').blur(function(){
    	if($('#surepaypassword').val()==''){
        	$('#sperror').html('确认支付密码不能为空！');
            $('#sperror').show();
        }else if($('#surepaypassword').val()!=$('#paypassword').val()){
        	$('#sperror').html('两次支付密码不一致！');
            $('#sperror').show();
        }
    });
    $('#surepaypassword').click(function(){
    	$('#sperror').html('');
        $('#sperror').hide();
    });

    function submit(){
    	if ($('#paypassword').val()==''){
            //alert('短信验证码不能为空');
            $('#perror').html('支付密码不能为空！');
            $('#perror').show();
        }else if($('#paypassword').val().length<6){
        	$('#perror').html('支付密码必须大于6位！');
            $('#perror').show();
        }else if($('#surepaypassword').val()==''){
        	$('#sperror').html('确认支付密码不能为空！');
            $('#sperror').show();
        }else if($('#surepaypassword').val()!=$('#paypassword').val()){
        	$('#sperror').html('两次支付密码不一致！');
            $('#sperror').show();
        }else if ($('#captcha').val()==''){
            //alert('验证码不能为空');
        	$('#verror').html('验证码不能为空！');
            $('#verror').show();
        }else{
            $.ajax({
                    url:base_url + "/customer/ajax_check_yzm",
                    type:"GET",
                    data:{captcha:$('#captcha').val()},
                    datatype:"json",
                    success:function(results){
                            var data = jQuery.parseJSON(results);
                            if(data.Result==true){
                            	$.ajax({
                            		url:"<?php echo site_url('Member/save_set/check_paypassword_ajax')?>",
                                    type:"POST",
                                    data:{password:$('#surepaypassword').val()},
                                    datatype:"json",
                                    success:function(data){
                                        var data = jQuery.parseJSON(data);
                                        if(data.Result==true){
                                            $('#form_save').submit();
                                        }else{
                                            alert("新旧支付密码不能一致");
                                        }
                                    }
                            	})
                            	}
                            else{
                                $('#verror').html('验证码错误！');
                                $('#verror').show();
                                }
                      },
                      error:function(){
                             alert("服务器无响应，请重试");
                      } 
             });

        
        }
    }

    $("#paypassword").keyup(function() {
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
    </script>