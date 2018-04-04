<div class="page_fix clearfix">
	<div class="group_form_list">
		<ul>
			<li><label> 真实姓名 <input type="text" class="text" name="realname" value="<?php echo isset($realname)?$realname:"" ?>" readonly>
			</label></li>
			<li><label> 手机号码 <input type="text" name="mobile" id="mobile" value="<?php echo isset($mobile)?$mobile:"" ?>" readonly>
			</label></li>
			<li><label> 身份证号码 <input type="text" name="id_num" id="id_num" value="<?php echo isset($id_num)?$id_num:"" ?>" readonly>
			</label></li>
			<li><label> 银行账号 <input type="text" class="text" name="bankname" value="<?php echo isset($bankname)?$bankname:"" ?>" readonly>
			</label></li>
			<li><label> 开户银行  <input type="text" class="text" name="bankname" value="<?php echo isset($bankname)?$bankname:"" ?>" readonly>
			</label></li>
			<li><label> 开户支行  <input type="text" class="text" name="banksubname" value="<?php echo isset($banksubname)?$banksubname:"" ?>" readonly>
			</label></li>
		</ul>
	</div>
	<!--group_form_list end-->

</div>
<!--page end-->
<script>
<?php if(isset($result)){?>
	alert("<?php echo $message?>");
<?php }?>
function checkSubmit()
{
	if(document.balance.total.value == "")
	{
		alert('请输入结算金额');
	}else if(document.balance.bankname.value == "")
	{
		alert('请输入开户银行');
	}else if(document.balance.banksubname.value == "")
	{
		alert('请输入开户支行');
	}else if(document.balance.bankaccount.value == "")
	{
		alert('请输入银行帐户');
	}else if(document.balance.realname.value == "")
	{
		alert('请输入真实姓名');
	}else
	{
		document.balance.submit();
	}

}
</script>