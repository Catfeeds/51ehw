<style type="text/css">
  .recommended_tribe_top li {border-top: none;border-bottom: 5px solid #d6d6d6;}
  .recommended_tribe {padding-top: 20px;}
</style>
<div>
  <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
  <a href="<?php echo site_url('Tribe')?>" class="tribe_index_nav_home"><span class="icon-icon_hone_off" style="font-size: 20px;color:#fff;"></span></a>
</div>
    <div class="container">
      <!--推荐部落开始-->
       <div class="recommended_tribe">
         <ul class="recommended_tribe_top">
         <?php foreach ( $hot_list as $v ){?>
         <li>
             <a href="<?php echo site_url('Tribe/tribe_detail/'.$v['id']) ?>">
                <i><img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/default_img_s.jpg'"></i> 
               <div class="recommended_tribe_rigth">
                 <h2><?php echo $v['name'] ?></h2>
                 <div class="tribe_tuijian_box">
                 	<?php echo $v['content'] ?>
                 </div>
               </div>
             </a>
         </li>
         <?php } ?>
         </ul>
       </div>
     <!--推荐部落结束-->
    </div>