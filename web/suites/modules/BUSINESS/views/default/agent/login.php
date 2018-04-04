<?php 
header("Cache-Control:no-cache,must-revalidate,no-store"); //这个no-store加了之后，Firefox下有效
header("Pragma:no-cache");
header("Expires:-1");
?>
  <!--登录帐号开始-->
  <div class="account">
    <div class="account1">
      <div class="account_rigth">
        <h5>登录</h5>
        <form action="<?php echo site_url("Agent/home/check_agent")?>" method="post" id="form_login">
        <div class="suo">
          <div class="form-group"> <span class="loginname">会员名：</span>
            <input id="agentname" type="text" class="form-control" name="agentname" tabindex="1"  placeholder="请输入会员名">
            <span id="error_name" style="line-height: 30px;width: 100px;padding-left: 10px;color: red;"></span>
          </div>
          <div class="form-group"> <span class="entry">登录密码：</span>
            <input type="password" id="password" name="password" class="form-control" tabindex="2"  placeholder="请输入登录密码">
            <span id="error_pass" style="line-height: 30px;width: 100px;padding-left: 10px;color: red;"></span>
          </div>
          <div class="login-btn">
           <a onclick="form_login()">登录</a> 
           <span id="error_tip" style="line-height: 30px;width: 100px;padding-left: 230px;color: red;margin-top:-30px;"><?php echo $err_msg;?></span>
          </div>
          
        </div>
        </form>
      </div>
    </div>
  </div>
  <!--登录帐号结束-->
</div>
<!--全局结束-->
</body>
</html>
<script>
$("#agentname").blur(function(){
	if($("#agentname").val()==""){
	    $("#error_name").html("请输入用户名");
	}
});
$("#agentname").click(function(){
	$("#error_name").html("");
});
$("#password").blur(function(){
	if($("#password").val()==""){
		$("#error_pass").html("请输入密码");
	}
});
$("#password").click(function(){
	$("#error_pass").html("");
});
function form_login(){
    var sub = true;
	if($("#agentname").val()==""){
		$("#error_name").html("请输入用户名");
	    sub = false;
	}else{
	    sub = true;
    }
	
	if($("#password").val()==""){
		$("#error_pass").html("请输入密码");
		sub = false;
	}else{
	    sub = true;
	}

	if(sub){
	    $("#form_login").submit();
	}
	
}
</script>