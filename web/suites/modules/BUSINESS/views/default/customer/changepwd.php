<div class="Box member_Box clearfix">
	<div class="kehu_Left">
		<ul class="kehu_Left_ul">
			<li class="kehu_title"><a>个人中心</a></li>
			<li><a href="<?php echo site_url('member/info')?>">个人信息</a></li>
			<li><a href="<?php echo site_url('member/property/get_list')?>">我的资产</a></li>
			<!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
			<li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
			<li class="kehu_current"><a
				href="<?php echo site_url('member/save_set') ?>">安全设置</a></li>
		</ul>
		<ul>
			<li class="kehu_title"><a>订单中心 </a></li>
			<li><a href="<?php echo site_url('member/order')?>">我的订单</a></li>
			<li><a href="<?php echo site_url('member/fav')?>">我的收藏</a></li>
			<li><a href="<?php echo site_url('member/my_comment/get_list/')?>">我的评价</a></li>
		</ul>
		<ul>
			<li class="kehu_title"><a>客户中心</a></li>
			<li><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
			<li><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
		</ul>
		<ul>
			<li class="kehu_title"><a>客户服务</a></li>
			<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
			<li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
			<li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>
		</ul>
	    <ul>
		<li class="kehu_title"><a>需求管理</a></li>
		<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
		<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
		<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
	    </ul>
	</div>

	<div class="huankuan_cmRight">
		<div class="huankuan_rTop">个人信息</div>
		<div class="kehufuwu_04_top2">
			<h4>修改密码</h4>
		</div>
		<div class="gerenzhongxin_01_con clearfix">
			<form name="form1" method="post"
				action="<?php echo site_url('member/info/pwd_save')?>" id="form1">
				<div class="gerenzhongxin_01_con_left">
					<ul>
						<li>原密码：</li>
						<li>新密码：</li>
						<li>确认新密码：</li>
					</ul>
				</div>

				<div class="gerenzhongxin_01_con_right">
					<ul>
						<li><input type="password" name="txtOldPwd" id="txtOldPwd"
							class="gerenzhongxin_01_con_input" placeholder="请输入旧密码"><span
							class="help-block" id="rfvOldPwd" style="color: red;">* </span></li>
						<li><input type="password" name="txtNewPwd" id="txtNewPwd"
							class="gerenzhongxin_01_con_input" placeholder="密码长度只能在6-16位字符之间"><span
							class="help-block" id="rfvNewPwd" style="color: red;">* </span></li>
						<li><input type="password" name="txtConfimPwd" id="txtConfimPwd"
							class="gerenzhongxin_01_con_input" placeholder="确认新密码"><span
							class="help-block" id="cvConfimPwd" style="color: red;">* </span></li>
					</ul>
					<div class="gerenzhongxin_01_xiugai_btn">
						<a id="sub">保存</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
    $("#sub").click(
    	    function(){
    	    	$('#form1').submit();
        	    });
    
    </script>

<script type="text/javascript">
$(function(){
 $('#txtOldPwd').blur(function() {
   if ($('#txtOldPwd').val() == ''){
     $('#rfvOldPwd').show();
   }else{
	 $('#rfvOldPwd').hide();
     $('#txtNewPwd').blur(function() {
         var newpwd = $('#txtNewPwd').val().length;
         if(newpwd>5 && newpwd<17){
        	 $('#rfvNewPwd').hide();
             $('#txtConfimPwd').blur(function() {
               if ($('#txtConfimPwd').val() != $('#txtNewPwd').val()){
            	   $('#cvConfimPwd').text("*");
                 $('#cvConfimPwd').show();
    		   }else{
                 $('#cvConfimPwd').hide();
    		   }
    		 });
         }else{
        	 $('#rfvNewPwd').show();
         }
	 });
   }
 });
  
  $('#form1').submit(function() {
    var pass = true;
	$(':input').next('span').hide();

    if ($('#txtOldPwd').val() == ''){
    	$('#rfvOldPwd').text("请输入旧密码"); 
      $('#rfvOldPwd').show();
	  pass = false;
    }else{
        pass = true;
	}

	if ($('#txtNewPwd').val() == ''){
		$('#rfvNewPwd').text("请输入新密码");
		$('#rfvNewPwd').show();
		pass = false;
    }else if($('#txtNewPwd').val().length > 5 && $('#txtNewPwd').val().length < 17){
        pass = true;
	}else{
    	$('#rfvNewPwd').text("密码长度只能在6-16位字符之间");
        $('#rfvNewPwd').show();
        pass = false;
	}
    
	if ($('#txtNewPwd').val() != '' && $('#txtConfimPwd').val() != $('#txtNewPwd').val()){
		$('#cvConfimPwd').text('两次密码不一致');
		$('#cvConfimPwd').show();
		pass = false;	
    }
	return pass;
  });
});  

var msg = '<?php echo $error_msg; ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'pw_error' : $('#lblMsg').empty().text('旧密码错误').show();break;
			case 'pw_repeat' : $('#lblMsg').empty().text('新旧密码不能一致').show();break;
			default : break;
		}
	}	
});
</script>


