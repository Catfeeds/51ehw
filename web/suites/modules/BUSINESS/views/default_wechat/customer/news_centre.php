<style type="text/css">
	.container {background: #f6f6f6;}
</style>
<!-- 头部 -->
<!-- 消息中心 -->
<div class="news_centre">
          <ul>
            <?php 
            if(isset($label_id) && $label_id){?>
            <!-- 商会通知 -->
            <li>
              <a href="<?php echo site_url("Tribe/tribe_announcements_view/$label_id");?>">
                <span class="informations_icon" style="background:#478ED6 ;background:inherit">
                 <img src="images/xiaoxi5.png"/ width="50" height="50" style=" position:absolute">
                <i class="icon-horn" style="font-size: 28px">
                <?php if($announcement['count'] > 0 ){ 
                      if($announcement['count'] > 99 ){?>
                          <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1">99+</span>
                      <?php  }else{?>
                          <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1"><?php echo $announcement['count']; ?></span>
                <?php }}?>
                </i></span>
                <span class="informations_title"><i>商会通知</i><i><?php if($announcement['count'] == 0 && empty($announcement['content'])){ echo '暂无消息'; }else{echo $announcement['content'];}?></i></span>
                <span class="informations_time icon-right"></span> 
              </a>
            </li>
             <!-- 商会活动 -->
            <li>
              <a href="<?php echo site_url("Tribe/activity_list").'/'.$label_id;?>">
                <span class="informations_icon" style="background:#FFB13A;background:inherit">
                 <img src="images/xiaoxi6.png"/ width="50" height="50" style=" position:absolute">
                <i class="icon-huodong1" style="font-size: 28px">
                <?php if($activity['count'] > 0 ){ 
                      if($activity['count'] > 99 ){?>
                          <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1">99+</span>
                      <?php  }else{?>
                          <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1"><?php echo $activity['count']; ?></span>
                <?php }}?>
                </i></span>
                <span class="informations_title"><i>商会活动</i><i><?php if($activity['count'] == 0 && empty($activity['content'])){ echo '暂无消息'; }else{echo $activity['content'];}?></i></span>
                <span class="informations_time icon-right"></span> 
              </a>
            </li>

            <li>
              <a href="<?php echo site_url("Member/Message/Notification").'?type=4'?>">
                <span class="informations_icon" style="background:#a2c961;background:inherit">
                 <img src="images/xiaoxi4.png"/ width="50" height="50" style=" position:absolute">
                <i class="icon-pinglun1" style="font-size: 28px">
                <?php if($tribe['count'] > 0 ){ 
                      if($tribe['count'] > 99 ){?>
                          <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1">99+</span>
                      <?php  }else{?>
                          <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1"><?php echo $tribe['count']; ?></span>
                <?php }}?>
                </i></span>
                <span class="informations_title"><i><?php echo !empty($label_id) ? '商会消息' : '部落消息';?></i><i><?php if($tribe['count'] == 0 && empty($tribe['content'])){ echo '暂无消息'; }else{echo $tribe['content'];}?></i></span>
                <span class="informations_time icon-right"></span> 
              </a>
            </li>
            <?php }?>

              <li style="border-bottom: 6px solid #f6f6f6;">
                <a href="<?php echo site_url("Member/Message/Notification").'?type=1'?>">
                  <?php if(!empty($label_id)){ 
                     echo  '<span class="informations_icon" style="background:#72acce;background:inherit">';
                     echo  '<img src="images/xiaoxi1.png"/ width="50" height="50" style=" position:absolute">';
                  }else {
                      echo  '<span class="informations_icon">';
                      echo ' <i class="icon-tongzhi"></i>';
                  }?>
                   <?php if($system['count'] > 0 ){ 
                        if($system['count'] > 99 ){?>
                            <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1">99+</span>
                        <?php  }else{?>
                       	    <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1"><?php echo $system['count']; ?></span>
                  <?php }}?>
                  </span>
                  <span class="informations_title"><i>系统通知</i><i><?php if($system['count'] == 0 && empty($system['content'])){ echo '暂无消息'; }else{echo $system['content'];}?></i></span>
                  <span class="informations_time icon-right"></span> 
                </a>
              </li>
              <li>
                <a href="<?php echo site_url("Member/Message/Notification").'?type=2'?>">
                  <?php if(!empty($label_id)){
                     echo  '<span class="informations_icon" style="background:#72acce;background:inherit">';
                     echo  '<img src="images/xiaoxi2.png"/ width="50" height="50" style=" position:absolute">';
                  }else {
                      echo  '<span class="informations_icon" style="background: #FF7C3A;">';
                      echo ' <i class="icon-dingdan"></i>';
                  }?>
                  <?php if($order['count'] > 0 ){ 
                        if($order['count'] > 99 ){?>
                            <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1">99+</span>
                        <?php  }else{?>
                       	    <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1"><?php echo $order['count']; ?></span>
                  <?php }}?>
                  </i></span>
                  <span class="informations_title"><i>订单通知</i><i><?php if($order['count'] == 0 && empty($order['content'])){ echo '暂无消息'; }else{echo $order['content'];}?></i></span>
                  <span class="informations_time icon-right"></span> 
                </a>
              </li>
              <li>
               <a href="<?php echo site_url("Member/Message/Notification").'?type=3'?>">
                  <?php if(!empty($label_id)){
                     echo  '<span class="informations_icon" style="background:#72acce;background:inherit">';
                     echo  '<img src="images/xiaoxi3.png"/ width="50" height="50" style=" position:absolute">';
                  }else {
                      echo  '<span class="informations_icon" style="background:#72CE8D;">';
                      echo ' <i class="icon-zichan" style="font-size: 25px;">';
                  }?>
                 <?php if($property['count'] > 0 ){ 
                        if($property['count'] > 99 ){?>
                            <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1">99+</span>
                        <?php  }else{?>
                       	    <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1"><?php echo $property['count']; ?></span>
                  <?php }}?>
                  </i></span>
                  <span class="informations_title"><i>我的资产</i><i><?php if($property['count'] == 0 && empty($property['content'])){ echo '暂无消息'; }else{echo $property['content'];}?></i></span>
                  <span class="informations_time icon-right"></span> 
                </a>
              </li>

              <?php if(empty($label_id)):?>
              <li>
                <a href="<?php echo site_url("Member/Message/Notification").'?type=4'?>">
                  <span class="informations_icon" " style="background:#61C9BC;">
                  <i class="icon-pinglun1" style="font-size: 28px">
                  <?php if($tribe['count'] > 0 ){ 
                        if($tribe['count'] > 99 ){?>
                            <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1">99+</span>
                        <?php  }else{?>
                       	    <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1"><?php echo $tribe['count']; ?></span>
                  <?php }}?>
                  </i></span>
                  <span class="informations_title"><i><?php echo !empty($label_id) ? '商会消息' : '部落消息';?></i><i><?php if($tribe['count'] == 0 && empty($tribe['content'])){ echo '暂无消息'; }else{echo $tribe['content'];}?></i></span>
                  <span class="informations_time icon-right"></span> 
                </a>
              </li>
            <?php endif;?>

            <li>
               <a href="<?php echo site_url("Webim/Control/Lists")?>">
                  <?php if(!empty($label_id)){
                     echo  '<span class="informations_icon" style="background:#72acce;background:inherit">';
                     echo  '<img src="images/xiaoxi4.png"/ width="50" height="50" style=" position:absolute">';
                  }else {
                      echo  '<span class="informations_icon" style="background:#4E9FFE;">'; 
                      echo ' <i class="icon-liaotianxinxi" style="font-size: 25px;"></i>';
                  }?>
                 <?php if($chat['count'] > 0 ){ 
                        if($chat['count'] > 99 ){?>
                            <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1">99+</span>
                        <?php  }else{?>
                            <span style="position: absolute;right: -6px;top: -5px;" class="cart_num1"><?php echo $chat['count']; ?></span>
                  <?php }}?>
                  </i></span>
                  <span class="informations_title"><i>聊天信息</i><i><?php if($chat['count'] == 0 && empty($chat['content'])){ echo '暂无消息'; }else{echo $chat['content'];}?></i></span>
                  <span class="informations_time icon-right"></span> 
                </a>
              </li>


          </ul>
</div>



<script type="text/javascript">
window.onpageshow = function(event){
if (event.persisted) {
window.location.reload();
}
}

</script>




