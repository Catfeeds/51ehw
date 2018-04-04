<style type="text/css">
  .clans_invite_phone {margin: 15px 18% 0 10%;}
  .clans_add_status {padding-bottom: 70px;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
  <style type="text/css">
    .circle_publish_jia {position: inherit;display: block;margin: 50px 15px 0 15px;width: auto;}
  </style>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>添加身份</span>
</div>
<?php }?>
<!-- 添加身份 -->
<a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
<div class="clans_add_status">
   <div class="clans_add_status_list">
     <ul>
         <li>
           <a href="javascript:void(0);">
             <span class="clans_add_status_active"><i class='icon-building_'></i></span>
             <span class="clans_add_status_active">单位名称</span>
          </a>
         </li>
         <li>
           <a href="javascript:void(0);">
             <span><i class='icon-building_1'></i></span>
             <span>政府社团</span>
          </a>
         </li>
         <li>
           <a href="javascript:void(0);">
             <span><i class='icon-hammer'></i></span>
             <span>非政府社团</span>
          </a>
         </li>
     </ul>
   </div>
	<span id="tables">
        <!-- 机构 -->
        <div class="clans_invite_phone"> 
        <span class="organization">单位</span><input type="text" value="" placeholder="请输入名称"  name="organization_name[]">
        </div>
        <!-- 职务 -->
        <div class="clans_invite_phone">
        <span>职务</span><input type="text" value="" placeholder="请输入职位头衔" maxlength="11" name="organizationl_duties[]">
        </div>
	</span>  

<!-- 添加按钮 -->
<a href="javascript:void(0);" onclick="add_table();" class="pictures_add_icon"><span class="icon-add_pictures"></span></a>  

 


</div>


<a href="javascript:save_sub()" class="circle_publish_jia">保存</a>


<script type="text/javascript">
var type = 1;

   $(".clans_add_status_list ul li").on("click",function(){
     $(this).children('a').find('span').addClass('clans_add_status_active');
     $(this).siblings('li').children('a').find('span').removeClass('clans_add_status_active');
     type =  $(this).index()+1;

     var organization_name = new Array();
     organization_name[1]="单位"
	 organization_name[2]="组织"
	 organization_name[3]="组织"
     $('.organization').html(organization_name[type]);

   })

   
function save_sub()
{
	   
	var organization_name = new Array();//单位
	var organizationl_duties = new Array();//职务
	$('input[name="organization_name[]"]').each(function(i){
		var unit = $(this).val();//单位
		var position = $(this).parent().next().children('input').val();//职位
		if(unit && position){
			organization_name[i] = unit;
			organizationl_duties[i] = position;
		}
	});

	
	if( !organization_name[0] )
	{
		$(".black_feds").text('请输入机构名称').show();
		setTimeout("prompt();", 2000); 
		return;
	}

	if( !organizationl_duties[0] )
	{
		$(".black_feds").text('请输入职务').show();
		setTimeout("prompt();", 2000); 
		return;
	}
	
	$.ajax({ 
		url:'<?php echo site_url('Tribe_social/Add_Identity')?>',
		type:'post',
		dataType:'json',
		data:{organization_name:organization_name,organizationl_duties:organizationl_duties,type:type},
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
			$(".black_feds").text('网络异常，请稍后再试').show();
			setTimeout("prompt();", 2000); 
			$('.circle_publish_jia').attr('href','javascript:save_sub()');
	       	return false;
		}
	})
}

//添加表单
function add_table(){
	html = '<div class="add_identity_box" >';
  	html += '<a href="javascript:void(0);" onclick=\'$(this).parent().remove();\'>删除</a>';
  	html += '<div class="clans_invite_phone" >'; 
  	html += '<span class="organization">单位</span><input type="text" value="" placeholder="请输入名称"  name="organization_name[]">';
  	html += '</div>';
  	html += '<div class="clans_invite_phone">';
  	html += '<span>职务</span><input type="text" value="" placeholder="请输入职位头衔" maxlength="11" name="organizationl_duties[]">';
  	html += '</div>';
  	html += '</div>';
	$("#tables").append(html);
}



</script>