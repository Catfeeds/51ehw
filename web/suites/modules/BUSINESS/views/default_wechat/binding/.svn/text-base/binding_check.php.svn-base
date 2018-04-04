
<style type="text/css">
#check_binding_button {
	display: block;
	width: 98%;
	line-height: 35px;
	margin: auto;
	background: #FECE0D;
	color: #2C2C25;
	border: 1px solid #FECE0D;
	border-radius: 3px;
	font-size: 16px;
	outline: none;
}
</style>

<div class="page clearfix">
<?php switch ($state){
case 1:{?>
	<!-- 确定绑定 -->
	<div style="margin-top: 50px;">
		<div style="text-align: center; margin-top: 10px;">
			<img src="images/bangding_logo.png" alt="" width="150px;">
		</div>
		<div style="margin-top: 20px; text-align: center;">
			<span style="font-size: 14px; display: inline-block; padding: 20px 0 5px 0;">
				当前未绑定<?php echo $type_show;?>号，可绑定微信快捷登录
			</span>
		</div>
	<!-- 确定绑定 结束 -->
<?php
        break;
           }
case 2:{?>
	<!-- 确定解绑 -->
	<div style="margin-top: 50px;">
		<div style="text-align: center; margin-top: 10px;">
			<img src="images/bangding_logo.png" alt="" width="150px;">
		</div>
		<div style="margin-top: 20px; text-align: center;">
			<span
				style="font-size: 14px; display: inline-block; padding: 20px 0 5px 0;">
				当前<?php echo isset($customer['mobile'])?$customer['mobile']:$customer['name'];?>已绑定<?php echo $type;?>号<?php echo $account;?>
			</span><br> <span style="font-size: 14px;">
				解绑后须重新绑定才能使用<?php echo $type_show;?>快捷登录
			</span>
		</div>
	<!-- 确定解绑 结束 -->
<?php
    break;
       }
    }?>	
		<div style="margin-top: 55px;">
			<input type="button" value="去<?php echo $state == 1?"绑定":"解绑"?>" id="check_binding_button" onclick="window.location.href='<?php echo site_url('member/binding/binding_save/'.$type);?>'">
		</div>
	</div>
</div>
