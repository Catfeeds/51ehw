<?php 
//session_start(); 
header("Cache-Control:no-cache,must-revalidate,no-store"); //这个no-store加了之后，Firefox下有效
header("Pragma:no-cache");
header("Expires:-1");
$this->session->set_userdata('forget',1); 

?>
    <div class="passwd_top" >
        <div class="passwd_con">
        <form action="<?php echo site_url('customer/forget_password2') ?>?action=save" method="get" id="form">
            <p>用户找回密码</p>
            <img src="images/zhaohui1.png">
            <ul>
                <li>输入用户名：<input type="text" placeholder="请输入您的用户名或手机号" id="username" name="name" class="phone_hao"><div id="nerror" style="display:none;width:300px;float:right;margin-right:130px;margin-top:10px;color:red;font-size:15px;"></div></li>
                <!-- <li>输入手机号：<input type="text" placeholder="请输入您的手机号" id="mobile" name="mobile" class="phone_hao"><div id="merror" style="display:none;width:300px;float:right;margin-right:130px;margin-top:10px;color:red;font-size:15px;"></div></li>-->
                <li>图形验证码：<input type="text" placeholder="输入验证码" id="captcha">
                	<img src="<?php echo site_url('customer/yzm_img')?>" id="czy" style="cursor: pointer; height: 40px; width: 80px; vertical-align: middle;  margin:0px;">
                    <span><i>看不清！</i><a id="change_img" style="color:#fea33b">换一张！</a></span>
                    <div id="verror" style="display:none;width:300px;float:right;margin-right:64px;margin-top:12px;color:red;font-size:15px;"></div>
                </li>
                
                <li>短信验证码：<input type="text" placeholder="输入验证码" id="mobile_vertify" name="mobile_vertify">
                	<a id="get_mobile_code" onclick="send_valitaty();" class="regsiter_02_huoqu"  style="width:145px;">获取手机验证码</a> 
                    <a id="reget_code" class="regsiter_02_huoqu" style="display: none; width:150px; margin-left:5px;">重新获取验证码(<span id="re_second">99</span>)</a>
                    <span class="eh_msgerror icon-cha" style="display: none" id="registerMobileVertify"></span>
                    <div id="mverror" style="display:none;width:300px;float:right;margin-right:130px;margin-top:10px;color:red;font-size:15px;"></div>
                </li>

            </ul>
            <a onclick="formsubmit();"><h1>下一步</h1></a>
            </form>
        </div>
    </div>

    <script>
    function send_valitaty(){
            var mobile = 0;
            if($("#username").val() != ""){
                var yzm = $("#captcha").val();
                $.post("<?php echo site_url("customer/ajax_check_yzm");?>?captcha="+yzm,function(data){
                	if(data["Result"]){
                    	$.ajax({
                            url:"<?php echo site_url('customer/load_mobile') ?>",
                            type:"GET",
                            data:{mobile:$('#username').val()},
                            dataType:'json',
                            success:function(result){
                                $('#get_mobile_code').removeAttr('onclick');
                                $('#get_mobile_code').html('获取验证码中...');
                            	if(result!=null&&result.mobile!=null){
                                	$.ajax({
                                	    url: base_url+'/customer/ajax_send/'+1,
                                	    type: 'POST',
                                	    data:{'mobile':result.mobile,'yzm':yzm},
                                	    dataType: 'html',
                                	    success: function(data){
                                	    	$('#re_second').html(100);
                                	    	timeprocess = setTimeout(remainTime,1000);
                                			// alert(data);
                              			  }
                                	  });
                            	}else{
                                    //alert("该用户绑定手机与输入手机不一致！");
                            		$('#nerror').html('该用户未绑定手机！');
                                    $('#nerror').show();
                                }
                            },
                            error:function(){
                                alert('服务器无响应，请重试！');
                                }
                        });
                   }else{
                	  $('#verror').attr("class","onError").html("验证码错误！").show();
                   }
                },"json");
            }else{
                alert("请先填写手机号码！");
            }
    }

    function remainTime(){
    	$('#get_mobile_code').css('display', 'none');
    	$('#reget_code').css('display', 'inline-block');
    	var times = $('#re_second').html();
    	if(times < 1){
    		$('#get_mobile_code').css('display', 'inline-block');
    		$('#reget_code').css('display', 'none');
    		clearTimeout(timeprocess);
            $('#get_mobile_code').attr('onclick','send_valitaty()');
            $('#get_mobile_code').html('获取手机验证码');
    	}else{
    		times -= 1;
    		$('#re_second').html(times);
    		timeprocess = setTimeout("remainTime()",1000);
    	}
    }

    $('#change_img').click(function(){

        $('#czy').attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
    });
    $('#czy').click(function(){
    	$(this).attr('src','<?php echo site_url('customer/yzm_img')?>'+'/'+Math.random());
        });

    $('#username').blur(function(){
    	if($('#username').val()==''){
            //alert('用户名不能为空');
            $('#nerror').html('用户名不能为空！');
            $('#nerror').show();
        }else{
            $.ajax({
                url:"<?php echo site_url('customer/check_mobile_phone') ?>",
                type:"GET",
                data:{mobile:$('#username').val(),},
                dataType:"json",
                beforeSend:function(){
                	/*$('#nerror').html('检查用户名...');
                    $('#nerror').show();*/
                    },
                success:function(data){
                    if(data.Result==true){
                    	$('#nerror').html('该用户尚未注册！');
                        $('#nerror').show();
                        }
                    else{
                    	$('#nerror').html('');
                        $('#nerror').hide();
                        }
                    },
            });
        }
    });
    $('#username').click(function(){
            $('#nerror').html('');
            $('#nerror').hide();
    });

    $('#mobile').blur(function(){
    	if ($('#mobile').val()==''){
            //alert('手机号不能为空');
        	$('#merror').html('手机号不能为空！');
            $('#merror').show();
        }
    });
    $('#mobile').click(function(){
        	$('#merror').html('');
            $('#merror').hide();
    });

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

    function formsubmit(){
        if($('#username').val()==''){
            //alert('用户名不能为空');  
            $('#nerror').html('用户名不能为空！');
            $('#nerror').show();
        }/*else if ($('#mobile').val()==''){
            //alert('手机号不能为空');
        	$('#merror').html('手机号不能为空！');
            $('#merror').show();
        }*/else if ($('#mobile_vertify').val()==''){
            //alert('短信验证码不能为空');
            $('#mverror').html('短信验证码不能为空！');
            $('#mverror').show();
        }else if ($('#captcha').val()==''){
            //alert('验证码不能为空');
        	$('#verror').html('验证码不能为空！');
            $('#verror').show();
        }else{
        	$.ajax({
                url:"<?php echo site_url('customer/check_mobile_phone') ?>",
                type:"GET",
                data:{mobile:$('#username').val(),},
                dataType:"json",
                beforeSend:function(){
                	/*$('#nerror').html('检查用户名...');
                    $('#nerror').show();*/
                    },
                success:function(data){
                    if(data.Result==true){
                    	$('#nerror').html('该用户尚未注册！');
                        $('#nerror').show();
                        }
                    else{
                        //$.get(base_url+'customer/check_name_mobile',name:$('#username').val(),);
                    	$.ajax({
                            url:base_url + "/customer/ajax_check_yzm",//captcha/"+$('#captcha').val(),
                            type:"GET",
                            data:{captcha:$('#captcha').val()},
                            datatype:"json",
                            success:function(results){
                            	var data = jQuery.parseJSON(results);
                            	if(data.Result==true){                    	
                                       $.ajax({
                                               url:"<?php echo site_url('customer/check_mobile/1') ?>",
                                               type:"GET",
                                               data:{mobile_vertify:$('#mobile_vertify').val()},
                                               dataType:'json',
                                               success:function(da){
                                                    //var da = jQuery.parseJSON(results);
                                                    
                                                    if(da.Result==true){
                                                        $('#form').submit();
                                                    }
                                                    else{
                                                        //alert("手机验证码不正确！");
                                                        $('#mverror').html('短信验证码错误！');
                                                        $('#mverror').show();
                                                        $('#nerror').hide();
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
                    },
            });
            }
        
    }
    

    </script>