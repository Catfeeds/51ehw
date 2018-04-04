<style>
 body{background-color:#fff}
 .tribal_avatar_top h3 {padding-bottom: 15px;}
 .tribal_avatar_top h5 {font-size: 15px;color: #333333;}
</style>
<?php 
$mac_type = $this->session->userdata("mac_type");
if(isset($mac_type) && $mac_type =='APP' ){ ?>
   <!-- 头部 -->
<div class="search-header-top">
  <a href="javascript:void(history.back())" class="icon-right"></a><span>审核情况</span>
</div>
<?php }?>
<!-- 创建部落 -->
  <div class="container container_topd">
     <div class="tribal_avatar">
        <!--创建部落审核中-->
        <div class="tribal_avatar_top">
            <h3><?php echo $tribe["status"] == 1?"创建部落审核中":"审核不通过";?></h3>
            <h5><?php echo $tribe["status"] == 1? "客服将会在24小时内处理，请耐心等待" : "您的部落申请审核不通过";?></h5>
            <?php if($tribe["status"] == 3){;?>
                <span class="circle_set_result_tishi"><?php echo "不通过原因：".$tribe["reject_reason"];?></span>
            <?php };?>
         </div>
      </div>
   </div>

        <div class="tribal_avatar_bottom">
          <ul class="tribal_avatar_bottom_ul">
            <?php if($tribe["status"] == 1){;?>
            <li><a class="tribal_avatar_top_a" href="<?php echo site_url('tribe/managementTribe');?>">我知道了</a></li>
            <?php }else if($tribe["status"] == 3){;?><!--审核不通过-->
            <li><a class="tribal_avatar_top_a" href="javascript:history.back();">我知道了</a></li>
            <li><a class="tribal_avatar_bottom_a" href="<?php echo site_url("tribe/add_view/{$tribe["id"]}");?>">重新填写</a></li>
            <?php };?>
          </ul>
        </div>
     </div>
  </div>  


