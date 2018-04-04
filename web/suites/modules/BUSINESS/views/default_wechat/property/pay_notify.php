  	<div class="container"   style="background-color:">
		  <div class="header new_index_nav" name="top"> <a href="<?php site_url('member/info');?>" target="_self" class="icon-"></a> 
    <p class="title">充值通知</p>
  </div>
  
  <!--header end-->
  <div class="purchase-finish-picture">
    <img src="<?php echo $code == 1 ? 'images/purchase-finish.png' : 'images/fail.png'?>" height="100" width="100" alt="">
    
  </div>
  <span class="purchase-finish-text"><?php echo $message;?><span id="amount"></span></span>
  <div class="purchase-finish_button">
   <button onclick="window.location = '<?php echo site_url('customer/fortune')?>'">完成</button>
  </div>
  </div>