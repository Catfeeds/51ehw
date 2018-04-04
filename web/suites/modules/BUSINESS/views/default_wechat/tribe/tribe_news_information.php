<style type="text/css">
  .my_activities {}
  .my_activities_top li {border-bottom: 4px solid #f6f6f6;}
  .tribe_index_nav_left {left: 10px;}
</style>
<div>
  <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);margin-top:8px;font-size: 24px;color:#fff;"></span></a>
  <!-- <a href="<?php echo site_url('Tribe')?>" class="tribe_index_nav_home"  <?php  echo $label_id ? "style='display:none;'":"";?>><span class="icon-icon_hone_off" style="font-size: 20px;color:#fff;"></span></a> -->
</div>

<!-- 活动tab -->
<!-- <div class="tribe_active_nav">
  <a href="javascript:void(0);" class="tribe_active_nav_active">普通活动</a>
  <a href="javascript:void(0);">投票活动</a>
</div>
<div class="activities_nei_li" style="border-bottom: 4px solid #f6f6f6;">
                <div class="activities_nei_li_top"> 
                    <a href="javascript:;"><i><img src="images/tmp_logo.jpg" onerror="this.src='images/tmp_logo.jpg'"></i></a>
               
                    <div class="activities_nei_li_xia">
                        <a href="javascript:;">
                        <h2>五一易货网</h2>
                        <p><span>2019-10-13 11:31:08</span></p>
                        </a>
                    </div>
              </div>
              <div class="activities_neirong">
                    <a href="javascript:void(0);">
                        <div class="tirbe_vote_title"><span>投票选出2018届工会主席［投票］</span></div>
                        <div class="tirbe_vote_img"><img src="images/vote/Group.png" alt=""></div>
                    </a>  
              </div>
</div> -->


<?php if( $list ){?>
<!--我的活动开始-->
<div class="my_activities">
    <ul class="my_activities_top">
    <?php foreach ( $list as $v ){?>
        <li>
            <div class="activities_nei_li">
                <div class="activities_nei_li_top"> 
                    <a href="<?php echo $v['tribe_id'] != -1 ? site_url('Tribe/home/'.$v['tribe_id']) : 'javascript:;'?>"><i><img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/tmp_logo.jpg'"></i></a>
               
                    <div class="activities_nei_li_xia">
                        <a href="<?php echo $v['tribe_id'] != -1 ? site_url('Tribe/home/'.$v['tribe_id']) : 'javascript:;'?>">
                        <h2><?php echo $v['tribe_id'] != -1 ? $v['tr_name'] : '五一易货网'?></h2>
                        <p><span><?php echo $v['update_at']?></span></p>
                        </a>
                    </div>
            	</div>
            	<div class="activities_neirong">
                    <a href="<?php echo site_url('Tribe/news_information_detail/'.$v['id']);?>">
                        <div class="activities_neirong_xia">
                        	<p><?php echo $v['name']?></p> 
                        	<img src="<?php echo IMAGE_URL.$v['banner_img']?>"/>  
                        </div>
                    </a>  
            	</div>
            </div>
        </li>
  	<?php }?>
	</ul>
</div>
<!--我的活动结束-->
<?php }else{?>

	<div>
		<div style="margin-top: 20px;">
			<center>暂无更多数据</center>
		</div>
	</div>

<?php }?>



  <script type="text/javascript">
  	 $(".dianzan-icon").on("click",function(){
   	 $(this).toggleClass('icon-fabulous_off');
   	 $(this).parents('.dianzan-text').toggleClass('dianzan-color');
   })

    $('.tribe_active_nav a').on('click',function(){
      $(this).addClass('tribe_active_nav_active');
      $(this).siblings('a').removeClass('tribe_active_nav_active');
    })
  
  
  </script>





