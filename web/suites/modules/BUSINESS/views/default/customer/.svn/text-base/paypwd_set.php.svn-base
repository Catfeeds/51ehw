<?php 

header("Cache-Control:no-cache,must-revalidate,no-store"); //这个no-store加了之后，Firefox下有效
header("Pragma:no-cache");
header("Expires:-1");
//防止页面后退
if(isset($status)&&$status=='paypassword'){
    $this->session->set_userdata('pay',1); 
}else if(isset($status)&&$status=='updatepaypassword'){
    $this->session->set_userdata('paypassword',1);
}else if(isset($status)&&$status=='mobile'){
    $this->session->set_userdata('mobile',1);
}

?>      
<?php if(isset($status)&&$status=='paypassword'||isset($status)&&$status=='mobile'): //设置支付密码和绑定手机更换手机?>
		<!--设置支付密码页面-->
		<?php if(isset($status)&&$status=='paypassword'){ ?>
		<form action="<?php echo site_url('member/save_set/set_paypwd') ?>" method="get" id="form_paypwd">
		<?php }else if(isset($status)&&$status=='mobile'){ ?>
		<form action="<?php echo site_url('member/save_set/set_mobile') ?>" method="get" id="form_paypwd">
		<?php }?>
        <div class="passwd_top">
        <div class="passwd_con">
            <p class="pay_t"><a href="<?php echo site_url("home");?>">首页</a> > <a href="javascript:;">个人中心</a> > <a href="javascript:;">安全设置</a> >  <a href="javascript:;" class="pay_current">立即设置</a></p>
            <?php if(isset($status)&&$status=='paypassword'){?>
                <?php if(isset($forget)&&$forget=='forgetpaypassword'): ?>
                <img src="images/resetpay1.png">
                <?php else: ?>
                <img src="images/pay1.png">
                <?php endif; ?>
            <?php }else if(isset($status)&&$status=='mobile'){?>
            <img src="images/mobile1.png" >
            <?php }?>
            <ul class="pay_ul">
                <li><span class="pay_span">验证方式：</span>手机验证</li>
                <li><span class="pay_span">您的手机号：</span><?php echo isset($customer['mobile'])&&$customer['mobile']!=null?substr_replace($customer['mobile'],'* * * *',3,4):"" ?></li>
                <li>短信验证码：<input type="text" placeholder="输入验证码" id="mobile_vertify" name="m_verfity">
                	<a id="get_mobile_code" onclick="send_valitaty();" class="regsiter_02_huoqu"  style="width:145px;">获取手机验证码</a> 
                    <a id="reget_code" class="regsiter_02_huoqu" style="display: none; width:150px; margin-left:5px;">重新获取验证码(<span id="re_second">99</span>)</a>
                    <span class="eh_msgerror icon-cha" style="display: none" id="registerMobileVertify"></span>
                    <div id="mverror" style="display:none;width:300px;float:right;margin-right:130px;margin-top:0;color:red;font-size:15px;"></div>
                </li>

                <li>图形验证码：<input type="text" placeholder="输入验证码" id="captcha">
                	<img src="<?php echo site_url('customer/yzm_img')?>" id="czy" style="cursor: pointer; height: 40px; width: 80px; vertical-align: middle; float: left;margin-top:-65px; margin-right: 390px; position:relative; z-index:20;">
                    <span style="margin-left:90px;"><i>看不清！</i><a id="change_img" style="color:#fea33b" onclick="change_yzm()">换一张！</a></span>
                    <div id="verror" style="display:none;width:300px;float:right;margin-right:64px;margin-top:-102px;color:red;font-size:15px;"></div>
                </li>
            </ul>
            <a href="javascript:submit();" ><h1>下一步</h1></a>
        </div>
    </div>
    </form>
    
    <script>
    //发送验证码
    function send_valitaty(){
        var mobile = <?php echo $customer['mobile'];?>;
        $.ajax({
               url:"<?php echo site_url("customer/ajax_send")."/".($status=='paypassword'?"2":"3");?>",
               type: 'POST',
               data:{'mobile':mobile},
               dataType: 'html',
               success: function(data){
                	   $('#re_second').html(100);
                	   timeprocess = setTimeout(remainTime,1000);
                	   alert(data);
                }
        });

    }

    
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


    $('#czy').click(function(){
    	$(this).attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
    });

    function change_yzm(){
 	    $('#czy').attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
    }
    
    $('#mobile_vertify').blur(function(){
    	if ($('#mobile_vertify').val()==''){
            //alert('短信验证码不能为空');
            $('#mverror').html('短信验证码不能为空！');
            $('#mverror').show();
        }
    });
    $('#mobile_vertify').click(function(){
            $('#mverror').html('');
            $('#mverror').hide();
    });

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

    function submit(){
    	if ($('#mobile_vertify').val()==''){
            //alert('短信验证码不能为空');
            $('#mverror').html('短信验证码不能为空！');
            $('#mverror').show();
        }else if($('#mverror').val==''){
        	$('#mverror').html('短信验证码不能为空！');
            $('#mverror').show();
        }else if ($('#captcha').val()==''){
            //alert('验证码不能为空');
        	$('#verror').html('验证码不能为空！');
            $('#verror').show();
        }else{
            $.ajax({
                    url:"<?php echo site_url("customer/ajax_check_yzm");?>",//captcha/"+$('#captcha').val(),
                    type:"GET",
                    data:{captcha:$('#captcha').val()},
                    datatype:"json",
                    success:function(results){
                            var data = jQuery.parseJSON(results);
                            if(data.Result==true){                   	
                                  $.ajax({
                                	    url:"<?php echo site_url("customer/check_mobile")."/".($status=='paypassword'?"2":"3");?>",
                                        type:"GET",
                                        data:{mobile_vertify:$('#mobile_vertify').val()},
                                        dataType:'json',
                                        success:function(da){
                                        	
                                                if(da.Result==true){
                                                    $('#form_paypwd').submit();
                                                }
                                                else{
                                                     //alert("手机验证码不正确！");
                                                     $('#mverror').html('短信验证码错误！');
                                                     $('#mverror').show();
                                                     change_yzm();
                                                }
                                        },
                                        error:function(){
                                               alert("服务器无响应，请重试");
                                        }
                                                
                                   });
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
    
    </script>
    <?php elseif(isset($status)&&$status=='updatepaypassword'): //修改支付密码?>
    <!--修改支付密码页面-->
    <form action="<?php echo site_url('member/save_set/check_old_paypassword') ?>" method="post" id="form">
        <div class="passwd_top">
        <div class="passwd_con">
            <p class="pay_t"><a href="javascript:;">首页</a> > <a href="javascript:;">个人中心</a> > <a href="javascript:;">安全设置</a> >  <a href="javascript:;" class="pay_current">修改支付密码</a></p>
            <img src="images/revise1.png">
            <ul class="pay_ul">
                <li style="margin-left:295px;">
                	<span class="pay_span">输入旧密码：</span>
                    <input type="password" class="phone_hao" placeholder="请输入原支付密码" name="password" id="password">
                    <a href="<?php echo site_url('member/save_set/paypwd_set/forgetpay') ?>" class="forget_pay">忘记支付密码？</a>
                     <div id="error" style="display:block;width:300px;float:right;margin-right:130px;margin-top:45px;color:red;font-size:15px;"><?php echo isset($msg)&&$msg!=null?$msg:"" ?></div>
                </li>
            </ul>
            <a href="javascript:submit();"><h1>下一步</h1></a>
        </div>
    </div>
    </form>
    
    <script>
    function submit(){
        if($('#password').val()==null){
            $('$error').html('旧密码不能为空');
            }
        else{
            $('#form').submit();
            }
        }
    
    </script>
    
    <?php endif;?>