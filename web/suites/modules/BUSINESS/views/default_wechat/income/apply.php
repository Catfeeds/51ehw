<style>
.container{ background:#f4f4f4}

</style>
<!--申请升级开始-->
   <div class="apply_sh">
      <div class="apply_sh_top">
        <h4>您当前身份为：<span><?php echo $identity_info['identity_name']?></span></h4>
        <h4>再追加<?php echo $apply_identity_info['price'] / 10000?>万元合伙金，即可立即升级为 <a href="javascript:;"><?php echo $apply_identity_info['identity_name']?></a></h4>
      </div>
      <div class="apply_sh_zhong">
        <h5>追加合伙金</h5>
        <input type="text" name="tbxLoginNickname" class="apply_sh_zhong_in" readonly id="account_name" value="¥  <?php echo $apply_identity_info['price']?>">
     	<label class="item-checkbox">
		<label class="checkbox_hu">
			<input type="checkbox" checked="" name='choose_ok'>
		</label><span>我同意合伙人加盟协议</span>
	    </label>
      </div>
   
   </div>



  <?php if( !$is_apply ) {?>
      <div class="liji_sheng"><a href="javascript:;" id="sub_apply_dentity">立即申请</a></div>
  <?php }else{?>
      <div class="liji_sheng"><a href="javascript:;" style="background-color:#ccc">已申请</a></div>
  <?php }?>

<!--申请升级结束-->

<script type="text/javascript">

$('#sub_apply_dentity').click(function()
{ 
	if ( !$('input[name=choose_ok]').is(':checked') )
	{ 
		$(".black_feds").text('请勾选合伙人加盟协议').show();
		setTimeout("prompt();", 2000); 
       	return false;
	}
	save_sub(this);
})



function save_sub(obj)
{
	
	$.ajax({ 
		url:'<?php echo site_url('Income/Apply_Upgrade_Identity/'.$apply_identity_info['identity_id'])?>',
		type:'post',
		dataType:'json',
// 		data:{},
		beforeSend:function()
		{
			$(obj).text('申请中.....');
			$(obj).unbind('click');
			
		},
		success:function( data )
		{
			if( data.status == 1 )
			{ 
				//var url = '<?php //echo site_url('Income')?>';
// 				window.setTimeout('window.location.href="'+url+'"', 1000);
				$(obj).css('background-color','#ccc');
				$(obj).text('已申请');
				
			}else{ 
				
				$(obj).click(function(){ save_sub(obj) })
			}
			
			$(".black_feds").text(data.message).show();
			setTimeout("prompt();", 2000); 
	       	return false;
		},
		error:function()
		{
			$(obj).text('立即申请');
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
			$(obj).click(function(){ save_sub(obj) })
	       	return false;
		}
	})
}


</script>
