<style type="text/css">
  .container {background:#f6f6f6;}
  .tribe_details_head span {padding: 20px 0;display: inline-block;}
  .tribe_details_head {text-align: left;}
  .tribe_detail_explain {float: right;padding-top: 20px;font-size: 14px;color: #4a7cb1;}
</style>

<!-- 我的部落详情 -->
<div>
  <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
  <a href="<?php echo site_url('Tribe')?>" class="tribe_index_nav_home"><span class="icon-icon_hone_off" style="font-size: 20px;color:#fff;"></span></a>
</div>
<div class="tribe_details" >
  <!-- 我的担保 -->
  <div class="tribe_details_list" style="padding-top: 40px;">
  	<div class="tribe_details_head"><span>担保额度</span><a href="<?php echo site_url('Tribe/Description/Guarantee')?>" class="tribe_detail_explain">担保说明</a></div>
  	<ul>
  	    <li><span class="icon-square square-icon01"></span><span class="tribe_details_text01">被担保上限额</span><span class="tribe_details_num"><?php echo !empty($user_info['guarantee_to_ceiling']) ? $user_info['guarantee_to_ceiling'] / 10000 : 0?>万</span></li>
  	    <li><span class="icon-square square-icon02"></span><span class="tribe_details_text01">已获得担保</span><span class="tribe_details_num"><?php echo !empty($user_info['guarantee_total']) ? $user_info['guarantee_total'] / 10000 : 0?>万</span></li>
  	    <li><span class="icon-square square-icon03"></span><span class="tribe_details_text01">可获得担保</span><span class="tribe_details_num"><?php echo !empty($user_info['guarantee_to_ceiling']) ? ($user_info['guarantee_to_ceiling']-$user_info['guarantee_total']) / 10000 : 0?>万</span></li>
  	    <?php if( empty($user_info['guarantee_total']) || $user_info['guarantee_total'] < 0 ) :?>
  	    <li><a href="<?php echo site_url('Credit/Choose_tribe')?>" class="tribe_details_but">担保申请</a></li>
  	    <?php endif;?>
  	</ul>
  </div>

   <!-- 我的授信 -->
  <div class="tribe_details_list">
  	<div class="tribe_details_head"><span>授信额度</span><a href="<?php echo site_url('Tribe/Description/Credit')?>" class="tribe_detail_explain">易呗说明</a></div>
  	<ul>
  	    <li><span class="icon-square square-icon01"></span><span class="tribe_details_text01">授信上限额</span><span class="tribe_details_num"><?php echo 0//!empty($user_info['credit_ceiling']) ? $user_info['credit_ceiling'] / 10000 : 0?>万</span></li>
  	    <li><span class="icon-square square-icon02"></span><span class="tribe_details_text01">已授信额度</span><span class="tribe_details_num"><?php echo !empty($user_info['credit']) ? $user_info['credit']/10000 : 0;//!empty($user_info['actual_credit']) ? $user_info['actual_credit'] / 10000 : 0?>万</span></li>
  	    <li><span class="icon-square square-icon03"></span><span class="tribe_details_text01">可授信额度</span><span class="tribe_details_num"><?php echo 0//!empty($user_info['credit_ceiling']) ? ($user_info['credit_ceiling']-$user_info['actual_credit']) / 10000 : 0?>万</span></li>
  	    <li><a href="<?php echo site_url('Credit/index').'/'.$tribe_id?>" class="tribe_details_but">授信申请</a></li>
  	</ul>
  </div>



	




</div>
