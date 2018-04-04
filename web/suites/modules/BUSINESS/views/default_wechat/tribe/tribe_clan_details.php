<style type="text/css">
    .container {background:#f6f6f6;font-family:PingFangSC-Regular;}
	.tribe_people_guarantee span {border: 1px solid #8632DA;padding:2px 10px 1px 10px;font-size: 13px;border-radius: 15px;color: #fff;background: #8632db;margin-left: 5px;margin-bottom: 2px;display: inline-block;}
	.tribe_people_guarantee {position: absolute;
    bottom: 20px;
    left: 28%;;width: 50%!important;text-align: left;}
	.tribe_people_credit span {border: 1px solid #8632DA;padding: 5px 20px;font-size: 13px;border-radius: 15px;color: #fff;background: #8632db;}
	.color_bg_green {background: #67b221!important;border: #67b221!important;}
	@media screen and (max-width:320px) {
     .tribe_clan_name {padding-top: 1%;}
     .tribe_people_guarantee span {font-size: 12px;}
     .tribe_clan_name span {font-size: 12px!important;}
    }
   .tribe_people_guarantee {padding-top: 5%;}
   .tribe_clan_name {padding-top: 0%!important;width: 40%!important;display: -webkit-box;overflow: hidden;text-align: left;height: 35px;line-height: 19px;-webkit-line-clamp: 2;-webkit-box-orient: vertical;}
   .tribe_clan_details_ul {position: relative;}
   .tribe_clan_details {width: 100%;}
   .tribe_go {position: relative;padding-right: 10px;background: rgba(0,0,0,0.5);float: right;width: 80px;height: 21px;line-height: 22px;font-family: PingFangSC-Regular;font-size: 12px;color: #ffffff;border-radius: 50px;margin-top: 6%;}
   .tribe_go img {position: absolute;top: 6px;right:8px;}
   .tribe_shop_head_clan {text-align: center;position: relative;height: 150px;overflow: hidden;}
</style>

<!-- 部落顶部按钮 -->
<div>
  <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 20px;color:#fff;"></span></a>
  <a href="<?php echo site_url('Tribe')?>" class="tribe_index_nav_home"><span class="icon-icon_hone_off" style="font-size: 20px;color:#fff;"></span></a>
</div>
<!-- 族员详情页 -->
 <!-- 头部 -->
  <div class="tribe_shop_head_clan">
        <img src="images/tribe_clan_details.png" alt="">

        <div class="tribe_clan_details">
          <ul class="tribe_clan_details_ul">
             <li><img src="<?php echo IMAGE_URL.$user_info['logo']?>" alt="" onerror="this.src='images/member_defult.png'"></li>
             <li class="tribe_clan_name">
               <span class="fn-16"><?php echo $user_info['member_name']?><i class="tribe_clan_zuyuan"><?php echo $user_info['duties']?></i></span>
               <span><?php echo $user_info['corp_name']?></span></li>
             <li class="tribe_people_guarantee">
                <span><?php echo $user_info['role_name']?>
                </span><span class="color_bg_green"><?php echo !empty($user_info['corp_id']) ? '企业会员' : '普通会员'?></span>
             </li>
             <?php if(  !empty($user_info['corp_id']) ){?>
             <a href="<?php echo site_url('home/GetShopGoods/'.$user_info['corp_id']);?>" class="tribe_go">进入店铺<img src="images/tribe_right_icon.png" width="9px" alt=""> </a>
           	 <?php }?>
           </ul>
        </div>
  </div>

  <div class="tribe_clan_details_list"> 
  	<ul>
        <li>
          <span class="fn-14"><?php echo $user_info['guarantee_ceiling']  /10000 ?>万货豆</span>
          <span class="tribe_edu">每笔担保额</span>
        </li>
        <li>
          <span class="fn-14"><?php echo $user_info['remain_guarantee_price'] /10000?>万货豆</span>
          <span class="tribe_edu">可担保额</span>
        </li>
        <li>
          <span class="fn-14"><?php echo $user_info['guarantee_from_ceiling'] /10000?>万货豆</span>
          <span class="tribe_edu">担保上限</span>
        </li>
     </ul>
  </div>

  <!-- 担保说明 -->
  <div class="guarantee_explain">
  	<div class="guarantee_explain_title"><span>担保说明</span></div>
  	<p>担保获得易呗额度是51易货网为了增加企业会员易呗额度的新方式，担保是基于部落内部会员之间基于互帮互助的原则，通过部落内熟人之间的互相担保，快速获得易呗额度的一种方法。同时担保方也会在担保的过程中获得相应的担保收益；担保是部落会员之间在互相帮助的基础上，还能够获取相应收益的新模式。</p>
  </div>
  <div style="height: 50px;opacity: 0;"></div>
  <!-- 申请担保 -->
  <div class="tribe_join">
    <a href="<?php echo site_url('Credit/Choose_guarantee/'.$user_info['tribe_id'])?>" style="color: #fff;">申请担保</a>
  </div>
