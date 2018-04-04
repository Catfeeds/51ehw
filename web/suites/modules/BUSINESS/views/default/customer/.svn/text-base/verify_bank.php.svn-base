 

<script src="js/verification.js"></script><!-- js验证类 -->
<script src="js/verificationCode.js"></script><!-- 验证码相关js -->
 <div class="certificatio_top">
    <div class="certificatio_con">   
        <div class="certificatio_sh">实名认证</div>
        <div class="certificatio_t"><a href="<?php echo site_url("home");?>">首页</a> > <a href="javascript:;">个人中心</a> > <a href="javascript:;">安全设置</a> >  <a href="javascript:;" class="certificatio_current">立即设置</a></div>
       
       <?php if(empty($customer['idcard'])){ ?>
       <form id="form1">
        <ul class="certificatio_ul" style="width: 670px;">
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">真实姓名：</span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input" type="text" name="real_name" onkeyup="verify_realName()" placeholder="必填，请输入真实姓名">
                     <span class="certificatio_yin" style="display:none;" id="yz_name">请输入正确的真实姓名</span>
                     <p class="certificatio_p">为确保您的账户安全，请填写您本人的实名认证信息</p>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">身份证号： </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input1" type="text" name="idcard" onkeyup="verify_idCard()" placeholder="必填，请输入18位身份证号" maxlength="18">
                     <span class="certificatio_yin" style="display:none;" id="yz_idcrad">请输入正确的身份证号</span>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">银行卡号： </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input1" type="text" name="bank"  onkeyup="verify_bankCard()" placeholder="请输入银行卡号" maxlength="19">
                     <span class="certificatio_yin" style="display:none;" id="yz_bankcrad">请输入正确的银行卡号</span>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">预留手机号码： </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input1 tel" type="text" name="bankmobile" onkeyup="verify_bankMobile()" placeholder="请输入银行预留手机号" maxlength="11">
                     <span class="certificatio_yin error" style="display:none;" id="yz_bankmobile">请输入手机号码</span>
                      <p class="certificatio_p">请填写该卡在银行预留的手机号码，验证该银行卡是否真实属于您本人</p>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">短信验证码: </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input2" type="text" name="VerificationCode">
                     <input type="button" class="certificatio_button btn1"  id ="get_mobile_code" onclick="getcode(10);return false;" value="获取验证码">
                     <span class="certificatio_yin" style="display:none;" id="yz_code">请输入验证码</span>
                     <p class="certificatio_p"><input type="checkbox"  class="zizhi_wei_input" value="0" id="choose1" name="choose"><a class="certificatio_p1" href="javascript:;">《实名认证协议》</a><span class="certificatio_yin" style="display:none;" id="dag_bankcrad">请勾选实名认证协议</span></p>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc"></span></div>
                <div class="certificatio_ul_right">                
                      <input type ="button" class="certificatio_ton" onclick="submitform();"  value="同意并绑定">
                </div>
             </li>
        </ul>
	</form>
     <!--获取验证码-->

<!--弹窗-->
  <div class="follow_bg">
    <div class="follow_top">
        <div class="follow_nei">
            <h5>实名认证协议</h5>   
            <div class="follow_nei_li">          
               <div class="follow_bottom">
                              
                   <p>内容区域</p>

                    <div class="follow_bottom_di">
                        <a class="follow_bottom_di_left" type="button" onclick="ehw_submita()">确认</a>
                        <a class="follow_bottom_di_figth" href="javascript:" onclick="ehw_reset()">取消</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
//第一步实名
function verify_realName(){
    var real_name = $('input[name="real_name"]').val();
   // var regName =/^[\u4e00-\u9fa5]{2,4}$/; 
    if(!real_name || real_name == ''){
    	//$("#yz_name").show();
        }else{
        	if(regName.test(real_name) ){
           	//	var real_name = $('input[name="real_name"]').val();
             // var regName =/^[\u4e00-\u9fa5]{2,4}$/; 
           		//$("#yz_name").hide();
           	}else{
           	   //	$("#yz_name").show();
           	}
        }
}
//第二步身份证
function verify_idCard(){
    var idcard = $('input[name="idcard"]').val();
    var regIdNo = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
    if(!idcard || idcard == ''){
    	$("#yz_idcrad").show();
        }else{
        	if(regIdNo.test(idcard) ){
           		var idcard = $('input[name="idcard"]').val();
           		$("#yz_idcrad").hide();
           	}else{
           	   	$("#yz_idcrad").show();
           	}
        }
}

//第三步银行卡号
function verify_bankCard(){
	  var bank = $('input[name="bank"]').val();
    var reg = /^(\d{16}|\d{19})$/;
	  if(!bank || bank == ''){
		  $("#yz_bankcrad").show();
		  }else{
			  if(reg.test(bank)){
		  		$("#yz_bankcrad").hide();
			  	}else{
			  		$("#yz_bankcrad").show();
				}
			  }
}

//第四步银卡预留手机
function verify_bankMobile(){
	var bankmobile = $('input[name="bankmobile"]').val();
	if(!bankmobile || bankmobile == ''){
		  $("#yz_bankmobile").show();
		  }else{
			  if(checkMobile(bankmobile)){
		  		$("#yz_bankmobile").hide();
			  	}else{
			  		$("#yz_bankmobile").show();
				}
			  }
}


//获取验证码
function getcode(type){
	var bankmobile = $('input[name="bankmobile"]').val();
	if(!bankmobile || bankmobile == ''){
		  $("#yz_bankmobile").show();
		  return false;
		}else{
			 if(checkMobile(bankmobile)){
			  		$("#yz_bankmobile").hide();
				  	}else{
				  		$("#yz_bankmobile").show();
					  	  return false;
					}
			}
	get_mobile_code(type,bankmobile);
}

//提交绑定
function submitform(){
	 var real_name = $('input[name="real_name"]').val();
	 var idcard = $('input[name="idcard"]').val();
	 var bank = $('input[name="bank"]').val();
	 var bankmobile = $('input[name="bankmobile"]').val();
	 var code = $('input[name="VerificationCode"]').val();

	 if( !$("input[type='checkbox']").is(':checked'))
	  { 
		  $("#dag_bankcrad").show();
		  return false;
		}else{  
		  		$("#dag_bankcrad").hide();  	
	  }
	 if(!real_name || real_name == ''){
	    	$("#yz_name").show();
	    	return false;
	        }else{
	        	if(isChinaName(real_name) ){
	           		var real_name = $('input[name="real_name"]').val();
	           		$("#yz_name").hide();
	           	}else{
	           	   	$("#yz_name").show();
		           	 return false;
	           	}
	 }
	 if(!idcard || idcard == ''){
	    	$("#yz_idcrad").show();
	    	 return false;
	        }else{
	        	if(regIdNo.test(idcard) ){
	           		var idcard = $('input[name="idcard"]').val();
	           		$("#yz_idcrad").hide();
	           	}else{
	           	   	$("#yz_idcrad").show();
		           	 return false;
	           	}
	    }
	 if(!bank || bank == ''){
		  $("#yz_bankcrad").show();
		  return false;
		  }else{
			  if(luhnCheck(bank)){
		  		$("#yz_bankcrad").hide();
			  	}else{
			  		$("#yz_bankcrad").show();
			  		 return false;
				}
		 }
     
	 if(!bankmobile || bankmobile == ''){
		  $("#yz_bankmobile").show();
		  return false;
		}else{
			 if(checkMobile(bankmobile)){
			  		$("#yz_bankmobile").hide();
				  	}else{
				  		$("#yz_bankmobile").show();
					  	  return false;
					}
			}
	 if(!code || code == ''){
		 $("#yz_code").show();
		 return false;
		 }else{
			 $("#yz_bankmobile").hide();
			 }



	  


	 $.ajax({
			type:'post',
			dataType:'json',
			url:"<?php echo site_url("Member/info/AjaxAuthentication");?>",
			data:$("#form1").serialize(),
			success:function(data){
				if(data["status"] == 00){
					alert("更新成功");
				}else{
					if(data["status"] == '02'){
						alert("绑定信息错误");
						setTimeout(function(){
							window.location.reload();
							},1000);
						}else{
							alert(data["msg"]);
							}
				}
			},
			error:function(res){
				console.log(res);
			}
		});
}


  $("#bankCard").on("keyup",function(){
        //获取当前光标的位置
        var caret = this.selectionStart;
        //获取当前的value
        var value = this.value;
        //从左边沿到坐标之间的空格数
        var sp =  (value.slice(0, caret).match(/\s/g) || []).length;
        //去掉所有空格
        var nospace = value.replace(/\s/g, '');
        //重新插入空格
        var curVal = this.value = nospace.replace(/\D+/g,"").replace(/(\d{4})/g, "$1 ").trim();
        //从左边沿到原坐标之间的空格数
        var curSp = (curVal.slice(0, caret).match(/\s/g) || []).length;
        //修正光标位置
        this.selectionEnd = this.selectionStart = caret + curSp - sp;
    });

</script>      
    <?php }else{ ?>
         <ul class="certificatio_uol" >
           <li>
              <div class="certificatio_le"><span class="certificatio_le_span">真实姓名：</span></div> 
              <div class="certificatio_ri"><span class="certificatio_ri_span"><?php echo $customer['real_name'];?></span></div> 
           </li>   
           <li>
              <div class="certificatio_le"><span class="certificatio_le_span">身份证号：</span></div> 
              <div class="certificatio_ri"><span class="certificatio_ri_span"><?php echo $customer['idcard'];?></span></div> 
           </li> 
            <li>
              <div class="certificatio_le"><span class="certificatio_le_span">通过认证时间：</span></div> 
              <div class="certificatio_ri"><span class="certificatio_ri_span"><?php echo $customer['authenticationat'] ?></span></div> 
           </li>   
            <li>
              <div class="certificatio_le"><span class="certificatio_le_span">绑定预留手机：</span></div> 
              <div class="certificatio_ri"><span class="certificatio_ri_span"><?php echo $customer['bankmobile'] ?></span></div> 
           </li>          
       </ul>


          <!--已通过认证-->
          <div class="certificatio_xia" style="display:none;">
             <div class="icon-chenggong1"></div> 
             <p class="certificatio_xia_p">已通过实名认证，快去设置支付密码</p>
             <a class="certificatio_xia_a" href="#">快去设置支付密码</a>
          </div>

           <!--未通过认证-->
          <div class="certificatio_xia" style="display:none;">
             <div class="icon-shibai"></div> 
             <p class="certificatio_xia_p">未通过实名认证</p>
             <a class="certificatio_xia_a" href="#">重新认证</a>
             <p class="certificatio_xia_p1">若无法完成实名认证，请联系客服xxxxxxxx咨询</p>
          </div>   
    <?php }?>
    </div>
 </div>


<script type="text/javascript">
  //添加取消
    function ehw_reset(){
      $(".follow_bg").hide();
    }
    //添加成功
    function ehw_submita(){
       $(".follow_bg").hide();
    }

  $(".follow_bg").hide();//初始化隐藏
   //打开标签。
    $(".certificatio_p1").on("click",function(){
        $(".follow_bg").show();
        $(".follow_bg").css("opacity","1");
    })
</script>

  


