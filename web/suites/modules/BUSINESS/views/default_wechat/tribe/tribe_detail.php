<?php $this->load->view('message_ok');?><!-- 提示页面 -->
<!-- 部落顶部按钮 -->
<span id="index">
<?php 
//app访问
$mac_type = $this->session->userdata("mac_type");
if(!$mac_type){?>
    <div>
      		<a href="javascript:history.back()<?php //echo site_url('Tribe/recommended_tribe');?>" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
      		<a href="<?php echo $label_id ?  site_url("Commerce/index").'/'.$label_id:site_url("Tribe");?>" class="tribe_index_nav_home"><span class="icon-icon_hone_off" style="font-size: 20px;color:#fff;"></span></a>
    </div>
<?php   } ?>


<!-- 部落图片 -->
<div class="tribe_index_img">
   <?php  //echo  preg_replace('/src="\/uploads\/B\//','src="'.IMAGE_URL,$tribe['content_img']);?>
   <img src="<?php echo IMAGE_URL.$tribe['content_img']?>" alt="">
   
</div>

<div class="tribe_join">
<!-- 加入部落 -->
 	<?php if($status==1){?>
    <a href="javascript:void(0);">待审核</a>
    <?php }else if($status==3){;?>
    <?php if(isset($label_id) && $label_id):?>
    <a href="javascript:update_MyApply(<?php echo $id;?>);">加入该商会部落</a>
<?php else:?>
<a href="javascript:update_MyApply(<?php echo $id;?>);">加入部落</a>
<?php endif;?>
    <?php }else if($status==4){;?>
    <?php if(isset($label_id) && $label_id):?>
      <a href="<?php echo site_url('Tribe/apply_view/'.$id.'/'.$label_id);?>">加入该商会部落</a>
  <?php else:?>
  		<a href="<?php echo site_url('Tribe/apply_view/'.$id.'/'.$label_id);?>">加入部落</a>
  <?php endif;?>
    <?php }else{
        if(!$mac_type){?>
             <a href="<?php echo site_url('Tribe/home/'.$id)?>">进入部落</a>
    <?php   }else{?>
            <a href="<#home#>tribe_id=<?php echo $id?>">进入部落</a>
    <?php   }?>
   
    <?php }?>
</div>
</span>

<script>
function update_MyApply(id){
	$.ajax({
		url: '<?php echo  site_url("Tribe/update_apply");?>',
		type: 'POST',
		data:{'id':id},
		dataType: 'json',
		success: function(data){
			$(".black_feds").text(data.Message).show();
			setTimeout("prompt();", 2000);
			<?php if($label_id){ ?>
			setTimeout(function(){
				window.location.href = "<?php echo site_url("Commerce/index").'/'.$label_id;?>";
				}, 2300);
			<?php }else{?>
			setTimeout(function(){
				window.location.reload();
				}, 2300);
			<?php }?>
			
		},
    error:function(){
		$(".black_feds").text("网络出错，请重试！").show();
		setTimeout("prompt();", 2000);
		return;
	}
});
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
<?php if(!empty($status) && $status == 1 || !empty($status) && $status==4 ){ //审核状态执行刷新页面 ?>
     setInterval(function(){
         <?php if($label_id){?>
         window.location.href = " <?php echo site_url("Tribe/tribe_detail/{$tribe['id']}/$label_id").'?refresh='.date('YmdHis');?>";
         <?php }else{ ?>
         window.location.href = " <?php echo site_url("Tribe/tribe_detail/{$tribe['id']}").'?refresh='.date('YmdHis');?>";
         <?php }?>
         },10000);
<?php }?>

	
})

</script>