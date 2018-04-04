
<style>
	.container {background:#fff;}
    .input_red{outline:none !important;border:1px solid red !important};
</style>

<?php $this->load->view('message_ok');?><!-- 提示页面 -->
<!-- 填写加入部落资料 -->
<div id='index'>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(!$mac_type ){ ?>
<div>
  <a href="<?php echo site_url('Tribe/tribe_detail').'/'.$id;?>" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
  <a href="javascript:history.back(-1);" class="tribe_index_nav_home"><span class="icon-icon_hone_off" style="font-size: 20px;color:#fff;"></span></a>
</div>
<?php }?>

<!-- 广告图 -->
<div>
    <img src="images/tribe_information_banner.png" alt="">
</div>
<!-- 填写资料 -->
    <div class="tribe_information_fill">
<!--         <form action="" method="post" name=""> -->
            <ul hidden>
                <!--  <li>真实姓名 <span style='color:red;'>*</span><div class="tribe_information_input"><input type="text" name="customer_name" value="" ></div></li>
                <li>企业名称 <span style='color:red;'>*</span><div class="tribe_information_input"><input type="text" name="corporation_name" value=""></div></li>
                <li>职<i style="opacity: 0;">职位</i>务 <span style='color:red;'>*</span><div class="tribe_information_input"><input type="text" name="duties" value=""></div></li>
                <li>所属行业 <div class="tribe_information_input" style="margin-left:10px;"><input type="text" name="industry" value=""></div></li>
                <li>自有商品 <div class="tribe_information_input" style="margin-top:5px;margin-left:10px;">
                    <textarea name="own_goods"  placeholder="例：酒水、食品、企业服务、全品类等"></textarea>
                    </div>
                </li>
                <li style="padding-top: 3px;">置换意向<div class="tribe_information_input" style="margin-left:10px;">
                    <textarea name="replacement_intention"  placeholder="例：酒水、食品、企业服务、全品类等"></textarea>
                    </div>
                </li>-->
            </ul>



            <!-- 真实姓名 -->
            <div class="tribe_true_name">
                <span>姓名</span>
                <div class="tribe_true_name_box"><input type="text" value="<?php echo !empty($customer_info['real_name']) ? $customer_info['real_name'] : ''?>" placeholder="请输入真实姓名" name="customer_name"></div>
            </div>
            <div class="tribe_fill_tishi"><span>为了在部落内可以辨识您的身份，请填写您的真实姓名。</span></div>





            <div class="tribe_join_tijiao">
              <a onclick="apply(<?php echo $id?>)">提交申请</a>
           </div>
<!--         </form> -->
    </div>
</div>

<script>

function apply(id)
{
	var customer_name = $('input[name=customer_name]').val();
	// var corporation_name = $('input[name=corporation_name]').val();;
	// var duties = $('input[name=duties]').val();
	// var industry = $('input[name=industry]').val();
	// var own_goods = $('textarea[name=own_goods]').val();
	// var replacement_intention = $('textarea[name=replacement_intention]').val();
	var is_ok = true;
 	var pattern = /[\u4e00-\u9fa5]{2,5}$/; 
	
	if( !pattern.test(customer_name) )
	{ 
// 		Add_Message('customer_name','请输入2-5个中文字符');
		$(".black_feds").text('请输入2-5个中文字符').show();
        setTimeout("prompt();", 2000);   
		is_ok = false;
		
	}
	
// 	if( !corporation_name )
// 	{ 
// 		Add_Message('corporation_name','请输入企业名称');
// 		is_ok = false;
		
// 	}else{ 
		
// 		Delete_Message('corporation_name');
// 	}
	
// 	if( !duties )
// 	{ 
// 		Add_Message('duties','请输入职位信息');
		
// 		is_ok = false;
		
// 	}else{ 
		
// 		Delete_Message('duties');
// 	}

	if( !is_ok )
	{  
	  return;
	}
		
	
	$.post("<?php echo site_url("tribe/apply");?>",
        {id:id,customer_name:customer_name,<?php if(!empty($is_pre_record)){ echo "is_pre_record:'$is_pre_record'";}?>},
        function(data)
        {
    	    if(data['status']==6)
    	    {
    			window.location.href="<?php echo site_url("member/binding/binding_mobile");?>";//未绑定手机
    	    	return;
    	    }
        	
        	//设置成功提示页面
        	var message_view = document.getElementById('message_view');
            document.getElementById('index').style.display="none";
            message_view.style.display="block";
            
    	    switch(data['status']){
        	    case 1:
        	    	message_view.children[1].innerHTML='您已经申请过了！工作人员正在审核...';
        		    break;
        	    case 2:
        	    case 8:
        	    	message_view.children[1].innerHTML='您已经加入此部落了！';
        	    	break;
        	    case 3:
    	            message_view.children[1].innerHTML='申请成功';
            	    break;
        	    case 4:
        	    	message_view.children[1].innerHTML='申请失败';
            	    break;
        	    case 5:
        	    	message_view.children[1].innerHTML='部落不存在';
            	    break;
        	    case 7:
        	    	message_view.children[1].innerHTML='缺少必填参数';
            	    break;
        	    default:
        	        document.getElementById('index').style.display="block";
        	        message_view.style.display="none";
            	    window.location.reload();return;
            	    break;
    	    }
	    
	    //跳转提示页面
    	message_view.children[3].children[0].setAttribute('onclick','jump();');return;
	},"json");
}
function jump()
{
	
	<?php
	if(!empty($label_id)){ 
	   if($mac_type){?>
	   window.location.href="<#APP_HOME#>";
	   <?php  }else{ ?>
	   window.location.href="<?php echo site_url("Commerce/index").'/'.$label_id;?>";
	   <?php  } ?>
	<?php }else{
	    if($mac_type){?>
	    window.location.href="<#APP_HOME#>";
	    <?php  }else{ ?>
	    window.location.href="<?php echo site_url('Tribe/tribe_detail').'/'.$id;?>";
	    <?php  } ?>
	
	<?php }?>
	
}
// function Delete_Message(name)
// { 
// 	$('input[name='+name+']').removeClass('input_red');
// 	$('input[name='+name+']').parent().find('span').remove();
// }

// function Add_Message(name,message)
// { 
// 	$('input[name='+name+']').addClass('input_red');
	
// 	if( !$('input[name='+name+']').parent().find('span').html() )
// 	{
// 		$('input[name='+name+']').parent().append('<span style="font-size:10px; color:red">'+message+'</span>');
// 	}
	
// }
</script>