<style type="text/css">
.container {
	background: #f6f6f6;
}

.tribal_avatar_top_sh .stored_chong_xia_z {
	border-radius: 50%;
	overflow: hidden;
	border: 2px solid #fff;
}

.tribal_avatar_top {
	padding-top: 20px;
	padding-bottom: 20px;
}

.zhaopian_icon {
	position: absolute;
	right: 2px;
	bottom: 2px;
	background: #fff !important;
	padding: 5px;
	font-size: 20px;
	border-radius: 50%;
	color: #aaa !important;
}

.tribal_avatar_top_sh .upload_pictures_top {
	position: relative;
	border: none;
}

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
<!-- 完善基本资料 -->
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<div class="tribal_avatar_top">
	<div class="tribal_avatar_top_sh">
		<!--上传图片-->
		<div class="upload_pictures">
			<div class="upload_pictures_top">
				<div class="stored_chong_xia_z">
					<div class="stored_chong_top">
						<div>
							<form action="<?php echo site_url('Tribe_social/Upload_Avatar');?> " method="post" enctype="multipart/form-data" id="form1">
								<input type="file" onchange="background_img()" name='file' accept="image/*">
							</form>
						</div>
					</div>
					<h2 class="stored_chong_h2">
						<img src="<?php echo $customer_info['brief_avatar'] ? IMAGE_URL.$customer_info['brief_avatar'] :$customer_info['wechat_avatar']?>" onerror="this.src='images/member_defult.png'"  id="img0">
					</h2>

				</div>
				<span class="icon-zhaopianshangchuan zhaopian_icon"></span>
			</div>
		</div>
		<p class="clans_data_perfect_sculpture">编辑头像</p>
	</div>
</div>

<!-- 资料列表 -->
<div class="clans_data_perfect_list">
	<ul>
		<li><a href="javascript:void(0);"><span class="clans_data_name">姓名</span>
			<div>
					<input type="text" value="<?php echo $customer_info['real_name'];?>" name='real_name' placeholder="请填写您的姓名">
				</div></a></li>
		<li><a href="<?php echo site_url('Tribe_social/Edit_Info/2')?>"><span class="clans_data_name">亮点</span>
			<div>
					<span><?php echo trim( $customer_info['merit'], '/');?></span>
				</div>
				<i class="icon-get_into"></i></a></li>
		<li style="margin-top: 6px;"><a href="<?php echo site_url('Tribe_social/Edit_Info/1')?>"><span
				class="clans_data_name">简介</span>
			<div>
					<span><?php echo $customer_info['brief'];?></span>
				</div>
				<i class="icon-get_into"></i></a></li>

		<?php if(!empty($customer_info_Ts)){;?>
		<li style="margin-top: 6px;"><a href="javascript:;"><span
				class="clans_data_name">手机号码</span>
			<div><span class="liandong"><?php echo $customer_info['mobile'];?></span></div>
		<!-- <i class="icon-get_into"></i> --></a></li>
		<?php };?>
		<li style="margin-top:6px;">
			<div class="tribe_edit_industry">
			   <!-- <textarea placeholder="请填写个人简介" id="msg" maxlength="200"><?php echo $customer_info['brief']?></textarea> -->
			   <!-- <span class="clans_description_num" id="wordNumber">200</span> -->
			   <div style="width:100%;height:40px; line-height:50px;">
			   	<span class="clans_data_name">手机号码是否隐藏</span>
			   	<?php if($customer_info_Ts['show_mobile'] == 1):?>
			   	<input type="checkbox" id="see_status"  class="aui-switch"  style="float: right;margin-right: 15px;margin-top:10px;" >
			   <?php else:?>
			   	<input type="checkbox" id="see_status"  class="aui-switch"  checked="checked" style="float: right;margin-right: 15px;margin-top:10px;" >
			   <?php endif;?>
			   </div>
			</div>
		</li>
	</ul>
</div>

<a href="javascript:save_sub()" class="circle_publish_jia">保存</a>
<script>
	$(document).ready(function(){
		<?php if($customer_info_Ts['show_mobile'] == 1):?>

			// 显示手机号
			$(".liandong").html(" ");
			$(".liandong").html("<?php echo $customer_info['mobile'];?> ");
			
		<?php else:?>

			// 隐藏手机号
			$(".liandong").html(" ");
			$(".liandong").html("<?php echo substr_replace($customer_info['mobile'],'****',3,4);?> ");
			
		<?php endif;?>
	});
</script>



<script type="text/javascript">

	var show_mobile = '';
	var staff_id = "<?php echo $customer_info_Ts['staff_id']?>";
	var customer_id = "<?php echo $this->session->userdata('user_id');?>";
	var url = '<?php echo site_url('Tribe/update_show_mobile');?>';
	// data_info = [staff_id,customer_id,url];
	// console.table(data_info);

	$("input[type='checkbox']").click(function(){
		if($(".aui-switch:checked").length > 0){
				show_mobile = 2;
				$.post(url,{show_mobile:show_mobile,staff_id:staff_id,customer_id:customer_id},function(res){
					
					// 隐藏手机号
					$(".liandong").html(" ");
					$(".liandong").html("<?php echo substr_replace($customer_info['mobile'],'****',3,4);?> ");
					
				});
		}else{
				show_mobile = 1;
				$.post(url,{show_mobile:show_mobile,staff_id:staff_id,customer_id:customer_id},function(res){
					console.log(res);
					
					// 显示手机号
					$(".liandong").html(" ");
					$(".liandong").html("<?php echo $customer_info['mobile'];?> ");
					
				});
		}
		// $("#show_phone").toggleClass("bgcolor");
	});


function background_img()
{ 

    $.ajax({
        url: '<?php echo site_url('Tribe_social/Upload_Avatar');?>',
        type: 'POST',
        cache: false,
        dataType:'json',
        data: new FormData( $('#form1')[0] ),
        processData: false,
        contentType: false,
        
    }).done(function(data) 
    {
    	if( data.status )
    	{
        	$('#img0').attr('src',data.data);
    		$(".black_feds").text('更换成功').show();
    		setTimeout("prompt();", 2000); 
    		return;
    	}

    	$(".black_feds").text('更换失败').show();
		setTimeout("prompt();", 2000); 
       	return false;
       	
    	
    }).fail(function(res) 
    {
    	$(".black_feds").text('网络异常，请稍后再试').show();
		setTimeout("prompt();", 2000); 
       	return false;
    	
    });
    
}

function save_sub()
{
	var real_name = $('input[name=real_name]').val();
	var pattern = /[\u4e00-\u9fa5]{2,5}$/;
	
	if( !pattern.test( real_name ) )
	{
		$(".black_feds").text('请输入2~5个中文姓名').show();
		setTimeout("prompt();", 2000); 
		return;
	}
	
	$.ajax({ 
		url:'<?php echo site_url('Tribe_social/Update_Customer_Info')?>',
		type:'post',
		dataType:'json',
		data:{real_name:real_name},
		success:function(data)
		{
			$(".black_feds").text(data.message).show();
			setTimeout("prompt();", 2000); 
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



$(function () { 
	  var isPageHide = false; 
	  window.addEventListener('pageshow', function () { 
	    if (isPageHide) { 
	      window.location.reload(); 
	    } 
	  }); 
	  window.addEventListener('pagehide', function () { 
	    isPageHide = true; 
	  }); 
})


</script>





