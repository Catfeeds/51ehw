
<style type="text/css">
.container {background: #d6d6d6;}
.tribe_my_share {margin: 0;padding-top: 0;}
.tribal_share_details_prize {position: relative;padding: 10px 15px;border-bottom: 1px solid #ddd;}
.tribe_choice_icon {position: absolute;right: -5px;top: 50%;width: 18px;height: 18px;border: 1px solid #999999;background-color: #fff;border-radius: 100%;margin-top: -9px;}
.icon-choose {color: #fed602;font-size: 18px;border: 0!important;}
.tribe_my_share_list {border-radius: 0;}
.tribal_share_details_prize {margin-top: auto;}
</style>

<!-- 分享详情 -->
<div class="tribe_my_share">
    <div class="tribe_my_share_list">

         <!-- 奖品 -->
         <div class="tribal_share_details_prize">
           <em data-value="1" class="icon-choose tribe_choice_icon"></em>
           <div class="tribe_prize_sku">
                <div class="prize_sku_box">
                    <div class="prize_sku_box_text">
                        <span>迪比斯门票专用包</span>
                        <span>价值158元的迪比斯门票1张</span>
                    </div>
                    <i>免费</i>
                </div>
                <p>有效期至2017年9月30日</p>
           </div>
         </div>

          <!-- 奖品 -->
         <div class="tribal_share_details_prize">
           <em data-value="1" class="tribe_choice_icon"></em>
           <div class="tribe_prize_sku">
                <div class="prize_sku_box">
                    <div class="prize_sku_box_text">
                        <span>迪比斯门票专用包</span>
                        <span>价值158元的迪比斯门票1张</span>
                    </div>
                    <i>免费</i>
                </div>
                <p>有效期至2017年9月30日</p>
           </div>
         </div>

         <!-- 奖品 -->
         <div class="tribal_share_details_prize">
           <em data-value="1" class="tribe_choice_icon"></em>
           <div class="tribe_prize_sku">
                <div class="prize_sku_box">
                    <div class="prize_sku_box_text">
                        <span>迪比斯门票专用包</span>
                        <span>价值158元的迪比斯门票1张</span>
                    </div>
                    <i>免费</i>
                </div>
                <p>有效期至2017年9月30日</p>
           </div>
         </div>

    </div>   









</div>



<script type="text/javascript">
   $(".tribal_share_details_prize").on("click",function(){
      $(this).children('em').addClass('icon-choose');
      $(this).siblings('.tribal_share_details_prize').children('em').removeClass('icon-choose');
   })
</script>

