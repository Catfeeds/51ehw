<style type="text/css">
  .container {background: #F6F6F6;}
</style>
<!-- 账户设置 -->
<div class="account_settings">
  <!-- 头像 -->
  <div class="account_settings_head">
  	<a href="<?php echo site_url("Member/info/UserInfo"); ?>">
  	  <div class="account_settings_head_left"><img src="<?php echo $avatar?$avatar:"images/member_defult.png";?>" alt=""></div>
  	  <div class="account_settings_head_right">
  	  	<p><?php echo $nick_name;?></p>
  	  	<?php if($real_name){?>
  	  	<p>真实姓名: <span><?php echo $real_name;?></span></p>
  	  	<?php };?>
  	  </div>
  	  <em class="icon-right"></em>
  	</a>
  </div>	
  
  <!-- 部落个人资料 -->
  <?php  
  //if($tribe){;
  if(false){;?>
  <div class="account_settings_list">
    <ul>
        <li><a href="<?php echo site_url("Tribe_social/Edit_Info");?>"><span class="icon-bulagerenziliao"></span><span>部落个人资料</span><em class="icon-right c9"></em></a></li>
    </ul>
  </div>
  <?php };?>

  <div class="account_settings_list">
    <ul>
        <li style="margin-bottom: 6px;"><a href="<?php echo site_url("Member/info/AuthenticationView");?>"><span class="icon-members_off"></span><span>实名认证</span><i><?php echo $is_authentication?"已认证":"未认证"; ?></i><em class="icon-right"></em></a></li>
        <li><a href="<?php echo site_url("Member/info/pwd_edit");?>"><span class="icon-xiugaimima"></span><span>修改密码</span><em class="icon-right"></em></a></li>
        <li><a href="<?php echo site_url("Member/info/paypwd_edit");?>"><span class="icon-xiugaizhifumima"></span><span>修改支付密码</span><em class="icon-right"></em></a></li>
        <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){?>
        <li><a href="<?php echo site_url('member/binding')?>"><span class="icon-zhanghaobangding"></span><span>账号绑定</span><em class="icon-right"></em></a></li>
        <?php };?>
    </ul>
  </div>



</div>