<style type="text/css">
	.container {background: #F6F6F6;}
</style>

<!-- 实名认证 状态 -->
<div class="verify_bank">
    <!-- 已认证信息 -->
    <div>
      <!-- 已认证信息 -->
      <div class="verify_bank_name"><span>已认证信息</span></div>
      <!-- 姓名 -->
      <div class="verify_bank_num verify_bank_num01"><span>姓名</span><span style='padding-left: 15px;'>**<?php echo mb_substr($customer["real_name"], -1);?></span></div>
      <!-- 身份证号 -->
      <div class="verify_bank_num verify_bank_num02" style="margin-top: 6px;"><span>身份证号</span><span style='padding-left: 15px;'><?php echo substr($customer["idcard"], 0,1);?>****************<?php echo substr($customer["idcard"], -1);?></span></div>
    </div>
</div>	



