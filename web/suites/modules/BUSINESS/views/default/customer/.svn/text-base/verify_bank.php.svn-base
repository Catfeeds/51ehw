 <style type="text/css">
 .follow_bottom p{text-align: left; font-size: 14px;text-indent: 2em;}
 .follow_nei{ width: 50%;}
 .follow_nei_li{width: auto;padding:0 20px;}
 .follow_nei_li h2{ text-align: left;font-size: 14px;color: #333333;font-weight: bold; margin-top: 20px;}
 .follow_bottom_span{color: #333333;font-size: 14px;font-weight: bold;}
 .follow_bottom { overflow-y: scroll;max-height: 450px;}
 </style>

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
                <div class="certificatio_ul_left"><span class="certificatio_mingc">手机号码： </span></div>
                <div class="certificatio_ul_right">
                     <input disabled="true" style="border: none;" class="certificatio_input1 tel" type="text" name="ownmobile" onkeyup=""  value="<?php echo substr_replace($this->session->userdata("mobile"),'****',3,4);?>" maxlength="11">
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">短信验证码: </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input2" type="text" name="VerificationCode">
                     <input type="button" class="certificatio_button btn1"  id ="get_mobile_code" onclick="getcode(10);" value="获取验证码">
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

  <div class="follow_bg">
    <div class="follow_top">
        <div class="follow_nei">
            <h5>“51易货网”实名认证协议</h5>   
            <div class="follow_nei_li">          
               <div class="follow_bottom">
                   <p>为了提高交易的安全性和陕西五一易货网络科技有限责任公司用户（以下简称“用户”）身份的可信度，<span class="follow_bottom_span">陕西五一易货网络科技有限责任公司</span>（以下简称51易货网）向您提供认证服务。在您申请认证前，您必须先注册成为51易货网用户。51易货网有权采取各种其认为必要手段对用户的身份进行识别。但是，作为普通的网络平台，51易货网所能采取的方法有限，而且在网络上进行用户身份识别也存在一定的困难，因此，51易货网对完成认证的用户身份的准确性和绝对真实性不做任何保证。 </p>
                   <p>51易货网向您提供的认证服务包括以下具体程序：</p>
                   <p>1、银行账户识别 </p>
                   <p>2、身份信息识别 </p>
                   <p>51易货网有权记录并保存您完成以上程序提供给51易货网的信息和51易货网获取的结果信息，亦有权根据本协议约定向您或第三方提供您是否通过认证的结论以及您的身份信息。 </p>
                   <h2>一、关于认证服务的理解与认同</h2>
                   <p>1、认证服务是由51易货网提供的一项身份识别服务。除非本协议另有约定，一旦您的51易货网账户完成了认证，相应的身份信息和认证结果将不因任何原因被修改或撤回；如果您的身份信息在完成认证后发生了变更，您应向51易货网提供相应有权部门出具的凭证，由51易货网协助您变更您在51易货网支付账户的对应认证信息。</p>
                   <p>2、51易货网有权单方随时修改或变更本协议内容，并通过51易货网网站公告变更后的协议文本，无需单独通知您。本协议进行任何修改或变更后，您还继续使用51易货网服务和/或认证服务的，即代表您已阅读、了解并同意接受变更后的协议内容；您如果不同意变更后的协议内容，应立即停用51易货网服务和认证服务。 </p>
                   <h2>二、身份信息识别</h2>
                   <p>1、中华人民共和国大陆（以下简称大陆）个人51易货网用户可提供以下证件用于认证：认证当时处在有效期内的身份证、护照等明确标有身份证号的证件之一（需要在线上传证件时，必须是彩色原件扫描件/彩色数码拍摄件，第二代身份证需要同时提交正反两面，户籍证明提供日起有效期在三个月以上，除临时身份证外，51易货网对有效期三个月以内的证件不予提供认证服务)</p>
                   <p>2、对于法律规定不具有完全民事行为能力的自然人，51易货网不向其提供认证服务。</p>
                   <p>3、通过身份信息识别的51易货网用户不能自行修改已经认证的信息，包括但不限于平台上店铺名称、姓名以及身份证件号码等。</p>
                   <p>大陆个人51易货网用户认证的有效期与其提供的身份证件有效期一致，但最长自认证完成日起不超过20年，户籍证明从通过审核当日开始起计算，有效期一年。其他个人51易货网用户认证信息的有效期按证件有效期和担保期限两者中较短的有效期计算，但最长自认证完成日起不超过20年。商户类51易货网用户认证信息的有效期一般为一年，若营业期限距离认证通过日少于一年则应以营业期限为准。有效期满后，相应的51易货网账户只能使用原先认证的身份信息或经合法变更后的身份信息进行再次认证。</p>
                   <p>4、如51易货网用户在认证有效期内变更任何身份信息，则应在变更发生后三个工作日内书面通知51易货网变更认证，否则51易货网有权随时单方终止提供51易货网服务，且因此造成的全部后果，由51易货网用户自行承担。</p>
                   <p>5、在51易货网用户对其51易货网账户进行取回密码等操作时，需要按照51易货网的提示出示可确认其持有该账户的个人身份证件，相关证件的要求依照本条前6项约定。 </p>
                   <h2>三、银行账户识别</h2>
                   <p>1、个人51易货网用户进行认证应提供本人在大陆银行开设的人民币账号、开户名、开户银行。</p>
                   <p>2、51易货网用户填写的银行账户的开户名必须与身份信息中的真实姓名或营业执照中的名称完全一致，所有经51易货网用户填写的资料将成为认证资料。</p>
                   <p>3、若51易货网用户尚不具备完全民事行为能力，而以提供不实认证资料的方式，使51易货网误认为该用户是完全民事行为能力人而受理身份信息识别申请的，则因此产生的一切后果将由该用户及(或)其监护人承担，51易货网不承担任何责任。 </p>
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
                   <p>为实现身份信息审查，51易货网网站(www.51ehw.com)上可能包含了指向第三方网站（如网上银行网站）的链接（以下简称“链接网站”）。“链接网站”非由51易货网控制，对于任何“链接网站”的内容，包含但不限于“链接网站”内含的任何链接，或“链接网站”的任何改变或更新，51易货网均不予负责。自“链接网站”接收的网络传播或其它形式之传送，51易货网不予负责。 </p>
                   <h2>六、不得为非法或被禁止目的的使用</h2>
                   <p>接受本协议全部的说明、条款、条件是您申请认证的先决条件。您声明并保证，您不得就任何非法或为本协议、条件及须知所禁止之目的进行认证申请。您不得以任何可能损害、使瘫痪、使过度负荷或损害其他网站或其他网站的服务或51易货网或干扰他人对于51易货网认证申请的使用等方式使用认证服务。您不得通过非51易货网许可提供的任何方式取得或试图取得任何资料或信息。</p>
                   <h2>七、有关免责</h2>
                   <p>下列情况时51易货网无需承担任何责任：</p>
                   <p>1、由于您将51易货网账户密码告知他人或未保管好自己的密码或与他人共享51易货网账户或任何其他非51易货网的过错，导致您的个人资料泄露。</p>
                   <p>2、任何由于黑客攻击、计算机病毒侵入或发作、电信部门技术调整导致之影响、因政府管制而造成的暂时性关闭、由于第三方原因(包括不可抗力，例如国际出口的主干线路及国际出口电信提供商一方出现故障、火灾、水灾、雷击、地震、洪水、台风、龙卷风、火山爆发、瘟疫和传染病流行、罢工、战争或暴力行为或类似事件等)及其他非因51易货网过错而造成的认证信息泄露、丢失、被盗用或被篡改等。</p>
                   <p>3、由于与51易货网链接的其它网站（如网上银行等）所造成的银行账户信息泄露及由此而导致的任何法律争议和后果。</p>
                   <p>4、任何51易货网用户（包括未成年人用户）向51易货网提供错误、不完整、不实信息等造成不能通过认证或遭受任何其他损失，概与51易货网无关，给他人造成损失的，该用户应予以赔偿。 </p>
                   <h2>八、协议关系</h2>
                   <p>本协议为《陕西五一易货网络科技有限责任公司用户服务协议》的有效组成部分；本协议未约定的内容，以《陕西五一易货网络科技有限责任公司用户服务协议》的约定为准。</p>
                </div> 
                <div class="follow_bottom_di">
                        <a class="follow_bottom_di_left" type="button" onclick="ehw_submita()">确认</a>
                        <a class="follow_bottom_di_figth" href="javascript:" onclick="ehw_reset()">取消</a>

                    </div>
            </div>
        </div>
    </div>
</div>





<script type="text/javascript">
//第一步实名
function verify_realName(){
    var real_name = $('input[name="real_name"]').val();
   // var reg=/^[\u2E80-\u9FFF]+$/;
    if(!real_name || real_name == ''){
      //$("#yz_name").show();
        }else{
          if(reg.test(real_name) ){
           // var real_name = $('input[name="real_name"]').val();
             // $("#yz_name").hide();
            }else{
           //   $("#yz_name").show();
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
  $.ajax({
    url: '<?php echo  site_url("Customer/ajax_send");?>'+'/'+type,
    type: 'POST',
    data:{'mobile':<?php echo $this->session->userdata("mobile");?>},
    dataType: 'html',
    success: function(data){
      $('#get_mobile_code').attr("disabled",true);
      $('#get_mobile_code').val('90s');
      setTimeout(remainTime1,1000);
    },
    error:function(){
        alert("网络出错，请重试！");
    return;
  }
  });
}

function remainTime1(){
  var times =  $('#get_mobile_code').val().replace(/[^0-9]/ig,"");
  if(times < 1){
    $('#get_mobile_code').val('获取验证码');
    $('#get_mobile_code').attr("disabled",false); 
  }else{
    times -= 1;
    $('#get_mobile_code').val(''+ times +'s');
    setTimeout(remainTime1,1000);
  }
}

//提交绑定
function submitform(){
   //var real_name = $('input[name="real_name"]').val();
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
  /* if(!real_name || real_name == ''){
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
   }*/
   if(!idcard || idcard == ''){
        $("#yz_idcrad").show();
         return false;
          }else{
            if(isCardNo(idcard) ){
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
          window.location.reload();
        }else{
          alert(data["msg"]);
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
      $('body,html').removeAttr("style")
  document.documentElement.style.overflow='scroll';
    document.documentElement.style.position='';
    }
    //添加成功
    function ehw_submita(){
       $(".follow_bg").hide();
       $('body,html').removeAttr("style")
  document.documentElement.style.overflow='scroll';
    document.documentElement.style.position='';
    }

  $(".follow_bg").hide();//初始化隐藏
   //打开标签。
    $(".certificatio_p1").on("click",function(){
        $(".follow_bg").show();
        $(".follow_bg").css("opacity","1");
        document.documentElement.style.position='fixed';
  //增加
  $('body,html').css({'height':'100%','overflow':'hidden'});
   document.documentElement.style.overflow='hidden';
    })
</script>

