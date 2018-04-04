<style type="text/css">
	.container {background: #F6F6F6;}
	.bianhongse{ color:#fff !important; font-size:13px !important; top:31px}
	.tribe_manage_lists_box ul li{ padding-right:10px; position:relative;}
</style>
<!-- 部落管理列表 -->
<div class="tribe_manage_lists">
   
   <div class="tribe_manage_lists_box">
   	 <ul>
   	 	 <?php foreach($passtribe as $v){;?>
   	     <li style="margin-bottom: 2px;" <?php echo (end($passtribe)["id"] == $v["id"])?"class='lists_box'":null; ?>>
   	     	<a href="<?php echo site_url("tribe/managingtribes/{$v['id']}");?>">
   	     		<div class="tribe_manage_img"><img src="<?php echo $v["logo"]?IMAGE_URL.$v["logo"]:"images/default_img_logo.jpg";?>"></div>
   	     		<div class="tribe_manage_name">
                 <span><?php echo $v["name"];?></span>
                 <?php echo !empty($v['total'])? "<span class='bianhongse'>".(($v['total']>99)? "99+" : $v['total'])."</span>" : "" ?>
                </div>
   	     		<div class="tribe_manage_status"><span></span>
   	     		<em class="icon-right" style="color:#999;"></em>
   	     		</div>
   	     	</a>
   	     </li>
   	     <?php };?>
   	     
   	     <?php foreach($audittribe as $v){;?>
 	     <li style="margin-bottom: 2px;" >
   	     	<a href="<?php if($v["status"] == 2){ echo site_url("tribe/managingtribes/{$v['id']}"); }else if($v["status"] == 3){echo site_url("tribe/tribe_Inaudit/{$v['id']}");}else{ echo site_url('Tribe/tribe_Inaudit').'/'.$v['id'];};?>">
   	     		<div class="tribe_manage_img"><img src="<?php echo $v["logo"]?IMAGE_URL.$v["logo"]:"images/default_img_logo.jpg";?>"></div>
   	     		<div class="tribe_manage_name"><span><?php echo $v["name"];?></span></div>
   	     		<div class="tribe_manage_status"><span></span>
   	     		<?php if($v["status"] == 1){echo '<span>审核中</span><em class="icon-right" style="color:#999;"></em>';}else if($v["status"] == 3){ echo '<span style="color: #CF2727;">审核不通过</span><em class="icon-right" style="color:#999;"></em>';}else{echo '<em class="icon-right" style="color:#999;"></em>';};?>
   	     		</div>
   	     	</a>
   	     </li>
   	     <?php };?>
   	 </ul>
   </div>	

  <!-- 创建部落 -->
  <a href="<?php echo site_url("tribe/add_view");?>" class="circle_publish_jia custom_button">创建部落</a>
</div>