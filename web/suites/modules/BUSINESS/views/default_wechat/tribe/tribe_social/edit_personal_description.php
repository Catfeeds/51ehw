<style type="text/css">
  .container {background:#f6f6f6;}
  .tribe_edit_industry {position: relative;padding-top: 0;}
  .tribe_edit_industry textarea {height: 250px;border: none;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>完善资料</span>
</div>
<?php }?>
<!-- 个人简介 -->

<div class="clans_personal_description">
   <div class="tribe_edit_industry">
      <textarea placeholder="请填写个人简介" id="msg" maxlength="200"><?php echo $customer_info['brief']?></textarea>
      <span class="clans_description_num" id="wordNumber">200</span>
   </div>


</div>


<a href='javascript:save_sub()' class="circle_publish_jia">保存</a>


<script type="text/javascript">
  var num = $('#msg').val().length;
  $('#wordNumber').text((200 - num));
  //检测输入内容字数的变化
  $("#msg").on("input propertychange",function() {
    var t = 200 - $(this).val().length;
    $("#wordNumber").text(t);

    if (t<0) {
      $("#wordNumber").text(0);
    };
  })
  
  
function save_sub()
{
	var brief = $('textarea').val();
	
	if( ! brief )
	{
		$(".black_feds").text('请输入简介内容').show();
		setTimeout("prompt();", 2000); 
	}
	
	$.ajax({ 
		url:'<?php echo site_url('Tribe_social/Update_Customer_Info')?>',
		type:'post',
		dataType:'json',
		data:{brief:brief},
		success:function(data)
		{
			$(".black_feds").text(data.message).show();
			setTimeout("prompt();", 2000); 
			window.setTimeout("window.history.go(-1)", 1000);   
			 
	       	return false;
		},
		error:function()
		{
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
	       	return false;
		}
	})
}
  
</script>