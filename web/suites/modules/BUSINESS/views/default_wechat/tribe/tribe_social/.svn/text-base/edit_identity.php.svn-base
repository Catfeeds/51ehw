<style type="text/css">
  .clans_invite_phone {margin: 15px 10% 0 10%;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>完善资料</span>
</div>
<?php }?>
<!-- 添加身份 -->
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<div class="clans_add_status">
   <div class="clans_add_status_list">
     <ul>
     	 
         <li>
           <a href="javascriupt:void(0);">
           <?php if( $identity_info['type']== 1 ){?>
               <span class="clans_add_status_active"><i class='icon-building_'></i></span>
               <span class="clans_add_status_active">单位名称</span>
           <?php }else if( $identity_info['type']== 2 ){?>
               <span class="clans_add_status_active"><i class='icon-building_1'></i></span>
               <span  class="clans_add_status_active">政府社团</span>
           <?php }else{?>
               <span class="clans_add_status_active"><i class='icon-hammer'></i></span>
               <span class="clans_add_status_active">非政府社团</span>
           <?php }?>
          </a>
         </li>
        
     </ul>
   </div>
   <!-- 组织 -->
  
  <!-- 机构 -->
  <div class="clans_invite_phone"> 
    <span><?php echo $identity_info['type']== 1 ? '单位' : ($identity_info['type']== 2 ? '组织': '组织');?></span><input type="text" value="<?php echo $identity_info['organization_name']?>" placeholder="请输入名称"  name="organization_name">
  </div>
  <!-- 职务 -->
  <div class="clans_invite_phone">
    <span>职务</span><input type="text" value="<?php echo $identity_info['organizationl_duties']?>" placeholder="请输入职位头衔" maxlength="11" name="organizationl_duties">
  </div>
 


</div>


<a href="javascript:save_sub()" class="circle_publish_jia">保存</a>


<script type="text/javascript">
var type = 1;

   $(".clans_add_status_list ul li").on("click",function(){
       $(this).children('a').find('span').addClass('clans_add_status_active');
       $(this).siblings('li').children('a').find('span').removeClass('clans_add_status_active');
       type =  $(this).index()+1;

      

   })

   
function save_sub()
{
	var organization_name = $('input[name=organization_name]').val();
	var organizationl_duties = $('input[name=organizationl_duties]').val();
	
	
	if( !organization_name )
	{
		$(".black_feds").text('请输入机构名称').show();
		setTimeout("prompt();", 2000); 
		return;
	}
	
	$.ajax({ 
		url:'<?php echo site_url('Tribe_social/Upadte_Identity')?>',
		type:'post',
		dataType:'json',
		data:{organization_name:organization_name,organizationl_duties:organizationl_duties,id:<?php echo $identity_info['id']?>},
		beforeSend:function()
		{
			$('.circle_publish_jia').attr('href','javascript:;');
		},
		success:function( data )
		{
			if( data.status == 1 )
			{ 
				window.setTimeout("window.history.go(-1)", 1000);
			}else{ 
				$('.circle_publish_jia').attr('href','javascript:save_sub()');
			}
			$(".black_feds").text(data.message).show();
			setTimeout("prompt();", 2000); 
	       	return false;
		},
		error:function()
		{
			$('.circle_publish_jia').attr('href','javascript:save_sub()');
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
	       	return false;
		}
	})
}

</script>