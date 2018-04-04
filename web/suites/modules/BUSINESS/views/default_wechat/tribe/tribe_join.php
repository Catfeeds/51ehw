<!-- 邀请加入 -->

<div class="invitation_join">
  <!-- 图片 -->
  <div><img src="images/invite_header.png"></div>

  <!-- 状态一 -->
  <div class="invitation_join_status_one" ><span>51易货账号：</span><span><?php echo $mobile?></span><span style="margin-left: 5px;"><?php echo $str_name ? "({$str_name})":'';?></span></div>
  


  <!-- 提示 -->
  <div class="invitation_join_tishi"><span>* 以便系统进一步识别您的亲朋好友</span></div>

 



  <!-- 提交 -->
  <?php if( $apply_status == 1 ){ //审核中?>
      <div class="invitation_join_tijiao"><a href="javascript:void(0);" style="background-color:#ccc">待审核</a></div>
      <div class="invitation_join_tijiao_ok"><a href="javascript:void(0);" style="color:red"><?php echo $real_name ? "{$real_name}":'';?>审核中请耐心等待……即将进入部落家园</a></div>
  <?php }else{ //可申请。?>
  	  <div class="invitation_join_tijiao"><a href="javascript:sub_apply();">提交</a></div>
      <div class="invitation_join_tijiao_ok" <?php if($apply_status != 3){echo 'hidden';}?>><a href="javascript:void(0);" style="color:red">审核不通过</a></div>
  <?php }?>
  <!-- 五一易货提醒您常回家看看 -->
  <div class="invitation_join_text">
    <p>五一易货提醒您常回家看看</p>
    <p>400-029-7777</p>
  </div>


</div>

<script type="text/javascript">
var code_invite = '<?php echo  empty($code_invite) ? 0:$code_invite;?>';
function sub_apply()
{
	var tribe_id = '<?php echo $tribe_id?>';
    $.post("<?php echo site_url("tribe/apply");?>",{id:tribe_id,'code_invite':code_invite},
        function(data)
        {
        	$(".black_feds").text(data.message).show();
    		setTimeout("prompt();", 2000);
    		
    	    if( data['status']==6 )
    	    {
    			window.location.href="<?php echo site_url("member/binding/binding_mobile");?>";//未绑定手机
    	    	return;
    	    }else if ( data['status'] == 2 || data['status'] == 8 )
    	    { 
    	    	setTimeout(function(){
    				window.location.href='<?php echo site_url('Tribe/Home');?>/'+tribe_id;
    		    }, 1000);
    		    
    	    }else if ( data['status'] == 3 )
    	    { 
        	    $('.invitation_join_tijiao a').css('background-color','#ccc');
        	    $('.invitation_join_tijiao_ok a').text('<?php echo $real_name ? "{$real_name}":'';?>审核中请耐心等待……即将进入部落家园');
        	    $('.invitation_join_tijiao_ok').show();
        	    $('.invitation_join_tijiao a').text('待审核');
        	    $('.invitation_join_tijiao a').attr('href','javascript:;');
        	    setTimeout(function(){
       	    	 window.location.href = " <?php echo site_url("Login/Join_tribe/{$tribe_id}").'?refresh='.date('YmdHis');?>";
            	    },10000);
    	    }
			
    	},"json");
    
}


<?php if(!empty($apply_status) && $apply_status == 1){ //审核状态执行刷新页面 ?>
$(function () { 
    setInterval(function(){
   	 window.location.href = " <?php echo site_url("Login/Join_tribe/{$tribe_id}").'?refresh='.date('YmdHis');?>";
        },10000);
})
<?php }?>
    
</script>