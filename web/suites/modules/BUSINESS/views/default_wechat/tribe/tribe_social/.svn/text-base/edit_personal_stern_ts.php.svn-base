<style type="text/css">
  .container {background:#f6f6f6;}
  .tribe_edit_industry {position: relative;padding-top: 0;}
  .tribe_edit_industry textarea {height: 250px;border: none;}
  .bgcolor{
  	background: #72c312
  }
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
 <?php //var_dump($customer_info_Ts);?> 
<div class="clans_personal_description">
   <div class="tribe_edit_industry">
      <!-- <textarea placeholder="请填写个人简介" id="msg" maxlength="200"><?php echo $customer_info['brief']?></textarea> -->
      <!-- <span class="clans_description_num" id="wordNumber">200</span> -->
      <div style="width:100%;height:40px; line-height:40px;border:1px solid grey">
      	<span style="font-size: 14px;margin-left:15px;">显示</span>
      	<?php if($customer_info_Ts['show_mobile'] == 1):?>
      	<input type="checkbox" id="see_status"  class="aui-switch" checked="checked" style="float: right;margin-right: 15px;" >
      <?php else:?>
      	<input type="checkbox" id="see_status"  class="aui-switch" style="float: right;margin-right: 15px;" >
      <?php endif;?>
      </div>
   </div>
   <script type="text/javascript">
   	var show_mobile = '';
   	var staff_id = "<?php echo $customer_info_Ts['staff_id']?>";
   	var customer_id = "<?php echo $this->session->userdata('user_id');?>";
   	var url = '<?php echo site_url('Tribe/update_show_mobile');?>';
   		$("input[type='checkbox']").click(function(){
   			if($(".aui-switch:checked").length > 0){
   				show_mobile = 1;
   				$.post(url,{show_mobile:show_mobile,staff_id:staff_id,customer_id:customer_id},function(res){
   					console.log(res);
   				});
   			}else{
   				show_mobile = 2;
   				$.post(url,{show_mobile:show_mobile,staff_id:staff_id,customer_id:customer_id},function(res){
   					console.log(res);
   				});
   			}
   		// $("#show_phone").toggleClass("bgcolor");
   		});
   		
  
   	// var show_mobile = 2;
   	
   
   </script>

</div>


<!-- <a href='javascript:save_sub()' class="circle_publish_jia">保存</a> -->


<script type="text/javascript">
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