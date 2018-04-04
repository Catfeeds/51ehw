 


 <div class="certificatio_top">
    <div class="certificatio_con">   
        <div class="certificatio_sh">实名认证</div>
        <div class="certificatio_t"><a href="<?php echo site_url("home");?>">首页</a> > <a href="javascript:;">个人中心</a> > <a href="javascript:;">安全设置</a> >  <a href="javascript:;" class="certificatio_current">立即设置</a></div>
        <ul class="certificatio_ul">
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">真实姓名：</span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input" type="text" name="industry">
                     <span class="certificatio_yin">请输入真实姓名</span>
                     <p class="certificatio_p">为确保您的账户安全，请填写您本人的实名认证信息</p>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">身份证号： </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input1" type="text" name="industry">
                     <span class="certificatio_yin">请输入身份证号</span>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">银行卡号： </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input1" type="text" name="industry">
                     <span class="certificatio_yin">请输入银行卡号</span>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">预留手机号码： </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input1 tel" type="text" name="tel">
                     <span class="certificatio_yin error">请输入手机号码</span>
                      <p class="certificatio_p">请填写该卡在银行预留的手机号码，验证该银行卡是否真实属于您本人</p>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc">短信验证码: </span></div>
                <div class="certificatio_ul_right">
                     <input class="certificatio_input2" type="text" name="code">
                      <button class="certificatio_button btn1">获取验证码</button>
                     <span class="certificatio_yin">请输入验证码</span>
                     <p class="certificatio_p"><a class="certificatio_p1" href="#">《实名认证协议》</a></p>
                </div>
             </li>
             <li>
                <div class="certificatio_ul_left"><span class="certificatio_mingc"></span></div>
                <div class="certificatio_ul_right">                
                      <button class="certificatio_ton">同意并绑定</button>
                </div>
             </li>
        </ul>


       <ul class="certificatio_uol" style="display:none;">
           <li>
              <div class="certificatio_le"><span class="certificatio_le_span">真实姓名：</span></div> 
              <div class="certificatio_ri"><span class="certificatio_ri_span">**蓉</span></div> 
           </li>   
           <li>
              <div class="certificatio_le"><span class="certificatio_le_span">身份证号：</span></div> 
              <div class="certificatio_ri"><span class="certificatio_ri_span">4****************8</span></div> 
           </li> 
            <li>
              <div class="certificatio_le"><span class="certificatio_le_span">通过认证时间：</span></div> 
              <div class="certificatio_ri"><span class="certificatio_ri_span">2017-12-12 12:00:00</span></div> 
           </li>   
            <li>
              <div class="certificatio_le"><span class="certificatio_le_span">绑定手机：</span></div> 
              <div class="certificatio_ri"><span class="certificatio_ri_span">13570283716</span></div> 
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
    </div>
 </div>




  


<!--获取验证码-->
<script type="text/javascript">
var btn1 = document.querySelector('.btn1');
var tel = document.querySelector('.tel');
var error = document.querySelector('.error');
var time = 60;
btn1.onclick = function(){
  var name = tel.value;  
  if (name == "") {
    error.innerHTML='手机号不能为空!';
    return;
  } 
  else {
    if (!(/^1[3|4|5|7|8]\d{9}$/.test(name))) {
      error.innerHTML='手机号格式有误.';
       return;
    }
  }
  var timer = setInterval(function(){    
    time--;
    btn1.innerHTML = time + "秒";
    btn1.disabled = true;
    if (time==0) {
      time = 60;
      clearInterval(timer); 
      btn1.innerHTML = "获取验证码";
      btn1.disabled = false;
    }
  },1000);
}

</script>