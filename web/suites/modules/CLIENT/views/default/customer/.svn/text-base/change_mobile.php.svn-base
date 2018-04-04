
		<!--修更换手机页面-->
        <div class="passwd_top">
        <div class="passwd_con">
        <form action="<?php echo site_url('member/save_set/update_mobile') ?>" method="post" id="form">
            <p class="pay_t"><a href="<?php echo site_url("home");?>">首页</a> > <a href="<?php echo site_url("Member/info");?>">个人中心</a> > <a href="<?php echo site_url("Member/save_set");?>">安全设置</a> >  <a href="" class="pay_current">更换手机</a></p>
            <img src="images/mobile2.png">
            <ul class="pay_ul">
                <li>
                <span class="pay_span">输入新号码：</span><input type="text" class="phone_hao" placeholder="请输入新手机号码" name="mobile" id="mobile">
                <div id="merror" style="display:none;width:300px;float:right;margin-right:85px;margin-top:2px;color:red;font-size:15px;"></div>
                </li>
				<li><span class="pay_span">短信验证码：</span><input type="text" placeholder="输入手机验证码" id="mobile_vertify" name="mobile_vertify">
                	<a id="get_mobile_code" onclick="send_valitaty();" class="regsiter_02_huoqu"  style="width:145px;">获取手机验证码</a> 
                    <a id="reget_code" class="regsiter_02_huoqu" style="display: none; width:150px; margin-left:5px;">重新获取验证码(<span id="re_second">99</span>)</a>
                    <span class="eh_msgerror icon-cha" style="display: none" id="registerMobileVertify"></span>
                    <div id="mverror" style="display:none;width:300px;float:right;margin-right:80px;margin-top:5px;color:red;font-size:15px;"></div>
                </li>
                <li><span class="pay_span">图形验证码：</span><input type="text" placeholder="输入验证码" id="captcha">
                	<img src="<?php echo site_url('customer/yzm_img')?>" id="czy" style="cursor: pointer; height: 40px; width: 80px; vertical-align: middle; float: left;margin:-65px 390px 0 327px; position:relative; z-index:20; ">
                    <span style="margin-left:90px;"><i>看不清！</i><a id="change_img" style="color:#fe4101" onclick="change_yzm()">换一张！</a></span>
                    <div id="verror" style="display:none;width:300px;float:right;margin-right:25px;margin-top:-65px;color:red;font-size:15px;"></div>
                </li>
            </ul>
            <a href="javascript:;" onclick="submit();"><h1>确认提交</h1></a>
        </form>
        </div>
    </div>

    
    <script>
    
       function send_valitaty(){
           
            if($("#mobile").val() != "" && /^0{0,1}(13[0-9]|15[0-9]|18[0-9]|14[0-9])[0-9]{8}$/.test($('#mobile').val())){
           	 $.get( base_url+'/customer/check_mobile_phone',{name:$("#mobile").val(),mobile:$("#mobile").val()},function(data){
            		var data = jQuery.parseJSON(data);
            		if(data.Result){
            			$.ajax({
                            url: base_url+'/customer/ajax_send/'+4,
                            type: 'POST',
                            data:{'mobile':$("#mobile").val()},
                            dataType: 'html',
                            success: function(data){
                            	    $('#re_second').html(100);
                            	    timeprocess = setTimeout(remainTime,1000);
                            		alert(data);
                          	}
                        });
                	}else{
                		$('#merror').html('该手机已注册！');
                        $('#merror').show();
                    }
             });
                

            }else{
            	$('#merror').html('请填写正确的手机号码！');
                $('#merror').show();
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

       $('#mobile').blur(function(){
   	       if($('#mobile').val()==''){
      	    	$('#merror').html('手机号码不能为空！');
                $('#merror').show();
   	   	   }else if(!/^0{0,1}(13[0-9]|15[0-9]|18[0-9]|14[0-9])[0-9]{8}$/.test($('#mobile').val())){
      	   		$('#merror').html('请填写正确的手机号码！');
                $('#merror').show();
   	   	   }
       });
       $('#mobile').click(function(){
        	$('#merror').html('');
            $('#merror').hide();
       });

       $('#mobile_vertify').blur(function(){
           if($('#mobile_vertify').val()==''){
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
                      url:base_url + "/customer/ajax_check_yzm/",//captcha/"+$('#captcha').val(),
                      type:"GET",
                      data:{captcha:$('#captcha').val()},
                      datatype:"json",
                      success:function(results){
                      	//var data = jQuery.parseJSON(results);
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

    	  var jugde_mobile = false;
    	  var jugde_mobile_verify = false;
    	  var jugde_captcha = false;
    	  if($('#mobile').val()==''){
  	    	$('#merror').html('手机号码不能为空！');
            $('#merror').show();
	   	   }else if(!/^0{0,1}(13[0-9]|15[0-9]|18[0-9]|14[0-9])[0-9]{8}$/.test($('#mobile').val())){
  	   		$('#merror').html('请填写正确的手机号码！');
            $('#merror').show();
	   	   }else{
		   	    jugde_mobile = true;
		   }

    	  if ($('#captcha').val()==''){
              //alert('验证码不能为空');
          	$('#verror').html('验证码不能为空！');
            $('#verror').show();
          }else{                
          	$.ajax({
                  url:base_url + "/customer/ajax_check_yzm/",//captcha/"+$('#captcha').val(),
                  type:"GET",
                  data:{captcha:$('#captcha').val()},
                  datatype:"json",
                  success:function(results){
                  	var data = jQuery.parseJSON(results);
                  	if(data.Result==false){
                      	$('#verror').html('验证码错误！');
                          $('#verror').show();
                          }
                  	else{
                  	    jugde_captcha = true;
                      	}
                      },
                  error:function(){
                      alert("服务器无响应，请重试");
                      }
              
              });
              }

          if($('#mobile_vertify').val()==''){
        	  $('#mverror').html('短信验证码不能为空！');
              $('#mverror').show();
          }else{
        	  $.ajax({
                  url:base_url+'/customer/check_mobile/4',
                  type:"GET",
                  data:{mobile_vertify:$('#mobile_vertify').val()},
                  dataType:'json',
                  success:function(da){
                          if(da.Result==true){
                        	  jugde_mobile_verify = true; 
                        	  if(jugde_mobile && jugde_mobile_verify && jugde_captcha){
                      	        $('#form').submit();
                          }
                          }
                          else{
                               //alert("手机验证码不正确！");
                               $('#mverror').html('短信验证码错误！');
                               $('#mverror').show();
                               chage_yzm();
                          }
                  },
                  error:function(){
                         alert("服务器无响应，请重试");
                  }
                          
             });
          }
          
		   
  	      
      }
          
    </script>