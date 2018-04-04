  <style type="text/css">
    .tribal_proclamation {padding-top: 20px;}
  </style>  
<div>
  <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 24px;color:#fff;"></span></a>
  <a href="<?php echo site_url('Tribe')?>" class="tribe_index_nav_home"><span class="icon-icon_hone_off" style="font-size: 20px;color:#fff;"></span></a>
</div>
  <!--部落公告开始-->
     <div class="tribal_proclamation">
        <ul class="proclamation_top">
        <?php foreach ( $announcement_list as $v ) { ?>
          <li>
          
          	 
               <a href="<?php echo site_url('Tribe/announcement_detaile/'.$v['id'].'/'. ( $v['tribe_id'] > 0 ? $v['tribe_id'] : '') )?>">
            
             	
               <i><img src="<?php echo IMAGE_URL.$v["title_img"];?>" onerror="this.src='images/default_img_s.jpg'"></i> 
               <div class="proclamation_top_rigth">
                  <h2><?php echo $v['title']?></h2>
                  <p><span><?php echo $v['last_updated_time']?></span></p>
               </div>
             </a>
          </li>
          <?php }?>
        </ul>
     </div>
