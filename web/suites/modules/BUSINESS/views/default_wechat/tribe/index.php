
<style type="text/css">
  .my_tirbe_list ul li img {border: 5px solid #ddd;padding: 8px;border-radius: 50%;width: 70px;height: 70px;}
  .my_tirbe_list ul li {margin: 0 10px;list-style: none;text-align: center;}
  .my_tirbe_list ul {padding-top: 0;}
  .tribal_notice_xia {padding: 0 10px 0 0;}
  .message_a {float:left; margin-right:3px;text-decoration:underline;}
  .container {background: #d6d6d6;}
  .new_nav_search {margin-left: 5%;}
  .new_nav_search p {width: 90%;}
  .recommended_tribe_top li {border-bottom: 1px solid #d6d6d6;border-top: none;}
  .index_look_more {text-align: center;font-size: 15px;margin: 10px 0;}
  .activities_nei_li_xia h2 {color: #005752;}
  .order_inform_text {font-size: 12px;color: #999;}
  .my_activities_top li {border-bottom: none; position:relative}
  .tribe_new_main01 {display: inline-block;}
  .tribe_new_main02 {display: inline-block;width: 100%;}
  .activities_neirong_xia {margin-right: 0;}
  .activities_neirong {padding-top: 5px;}
  .tribe_new_main04 {margin: 0 0.25rem;overflow: hidden;}
  .tribe_new_main04 ul {white-space: normal;width: auto;font-size: inherit;}
  .tribe_new_main04 ul li {float: left;margin-right: 0px;width: 3rem;height: 3rem;margin-top: 0.25rem;}
  .tribe_new_main04 ul li img {width: 100%;height: 100%;vertical-align: middle;object-fit: cover;margin: 0;border: 1px solid #ddd;}
  .tribe_new_main04 ul li:nth-child(3n-1) {margin-left: 0.25rem;margin-right: 0.25rem;}
  .tribe_new_main03 p {font-size: 13px;color: #333333;padding: 5px 10px 0 10px;}
  .circle_zhong_dl {background: #fff;margin-top: 0;}
  .dianzan_name {background: #fff;margin-left: 0;padding-left: 7%;}
  .tribe_new_main05 {display: block;}
  #box a {font-size: 15px;color: #333333;padding: 5px 0;}
  #box span {display: block;color: #69719e;font-size: 15px;}
  .hot_circle_study_gun li:nth-child(3n+1) {margin-left: 0.13rem;margin-right: 0.13rem;}
  .hot_circle_study_gun li:nth-child(3n+2) {margin-right: 0.13rem;}
  .hot_circle_study_gun li {margin-right: 0px;width: 3.16rem;height: 3.16rem;float: left;margin-bottom: 0.13rem;}
  .hot_circle_study_top {margin-left: 0;}
  .hot_circle_study_gun {white-space: normal;width: auto;font-size: inherit;}
  .tribe_new_gonggao_text span p {line-height: 16px;-webkit-line-clamp: 2;}
  .quanzi_tribal_name {float: right;margin-right: 0!important;text-align: center;width:auto; max-width:100%;padding:0 5px; border-radius:2px;overflow: hidden;word-break: keep-all;white-space: nowrap;text-overflow: ellipsis; color:#aaaaaa; border:1px solid #aaaaaa; display:block; }
  .dingwei_right{right:10px; top:15px; width:30%;position:absolute;}
/*  @media screen and (max-width:320px) {
  .quanzi_tribal_name {width: 40%;}}*/
  .circle_zhong_ul_xia h2{ max-width:100%; width:100%;display: inline;}
  .circle_zhong_ul_xia h2 span{display: inline-block; float: left; overflow: hidden;text-overflow: ellipsis; white-space: nowrap; max-width: 40%; padding-right:10px; margin-right:0}
  .circle_zhong_ul_xia h2 samp{display: inline-block;overflow: hidden;text-overflow: ellipsis; white-space: nowrap; max-width: 60%;}
  .circle_zhong_ul_li{padding: 0 0;}
  .circle_zhong_ul_a{ margin:15px 30% 15px 10px; display:block;}
  .circle_zhong_ul_xia p span{ margin-right:5px;}
  .guanliyuan_xuanze ul li input {width: 21px;height: 21px;border: 1px solid #bbb;border-radius: 100%;font-size: 20px;margin-top: 5px;}
  .guanliyuan_xuanze ul li {height: auto;}
  .guanliyuan_xuanze_a {padding: 15px 20px 8px 20px;}
  .guanliyuan_xuanze_a a {border-radius: 5px;}
  .guanliyuan_xuanze {max-height: 300px;}
</style>

 <script type="text/javascript" src="js/format_time.js"></script><!-- 时间函数 -->
  <!-- 搜索部落 -->
  <div class="new_search-header">
    <a href="javascript:Goback()" target="_self" class="icon-right new_search_back_icon"></a>
   <!-- 搜索框 -->
   <form id="form_search">
       <div class="new_nav_search">
          <p>
          <a href="<?php echo site_url('Tribe/tribe_search')?>" class="icon-sousuo" style="color:#ACACAC;font-size:15px;">
          <input type="text" class="search_input" name="keyword" value="" placeholder="输入部落名称" required="">
          </a>
         <!--  <a href="javascript:apply_tribe()" target="_self" class="icon-tianjiabula tribe-icon-hone"></a> -->
          </p>
<!--           <a href="javascript:void(0);" target="_self" class="icon-scan tribe-icon-scan"></a> -->
          <input type="hidden" value="3" name="tribe_id">    
          <input type="hidden" value="0" name="cateid">   
       </div>
   </form>
  </div>
  <div style="height:50px;"></div>

     <!-- 通知／活动／推荐 -->
     <div class="notice_biank" style="border-bottom: none;">
        <!--Recommend-->
        <div class="recommend_top">
          <ul>
            <li class="action">
            <?php if(!$mac_type){ ?>
            <a href="<?php echo site_url('Member/Message/MessageCenter')?>">
            <?php }else{?>
                <a href="<#enterNewsCenter#>">
            <?php  }?>
              <p><span class="icon-notice1"><?php echo ($not_read_message > 0)?"<i>".$not_read_message."</i>":"" ?></span></p>
              <h6>通知</h6>
             </a> 
            </li>
             <li>
              <a href="<?php echo site_url('Tribe/activity_list')?>">
              <p><span class="icon-activity"><!--  <i>55</i>--></span></p>
              <h6>活动</h6>
              </a>
            </li>
             <li>
              <a href="<?php echo $flag?site_url("tribe/ManagementTribe"):site_url("tribe/add_view");?>">
              <p><span class="icon-recommend"><?php echo ($count_unaudited_tribe > 0)? "<i>".(($count_unaudited_tribe > 99)? '99+' : $count_unaudited_tribe)."</i>":''?></span></p>
              <h6><?php echo $flag?"部落管理":"创建部落";?></h6>
              </a>
            </li>
          </ul>
        
        </div>
      <!--部落公告-->
      <?php if ( !empty( $announcement_list) ) {?>
      <div class="tribal_notice">
          <div class="tribal_notice_top tribal_notice_bian">
              <a href="<?php echo site_url('Tribe/announcement')?>">
                  <h4>部落公告：</h4>
                  <div id="tribal_notice_top_nei">
                      <ul class="tribal_notice_xia">
                      <?php foreach ( $announcement_list as $v ){?>
                          <li><span>NEW</span><?php echo $v['title']?></li> 
                      <?php }?>
                      </ul>
                  </div>
                  <h6 class="icon-more1"></h6>
              </a>
          </div>
      </div>
      <?php } ?>
      
      <!--我的部落-->
      
      <div class="my_tribe">
         <div class="gray-text">
           <span>我</span><span>的</span><span>部</span><span>落</span><span><i><?php echo count( $mytribe ) ?></i></span>
         </div>
         <p>My Tribe</p>
      </div>
      <?php if( !empty( $mytribe ) ){ $mytribe_info = [];?>
      <div class="my_tirbe_list" hidden>
        <ul>
          <?php //foreach ( $mytribe as $v ){?>
                <a href="<?php //echo site_url("Tribe/home/".$v['id']);?>">
                    <li>
                      <img src="<?php //echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/tmp_logo.jpg'">
                      <span><?php //echo $v['name']?></span>
                    </li>
                </a>
            <?php //}?>
        
        </ul>
      </div>
      
      <!-- 我的部落 new -->
      <div class="recommended_tribe">
         <ul class="recommended_tribe_top">
         <?php foreach ( $mytribe as $k=>$v ){ $mytribe_info[$v['id']] = $v;?>
             <li <?php echo $k >=3 ? 'hidden' : ''?>>
                 <a href="<?php echo site_url("Tribe/home/".$v['id']);?>">
                    <i><img src="<?php echo IMAGE_URL.$v["logo"];?>" onerror="this.src='images/tmp_logo.jpg'"></i> 
                   <div class="recommended_tribe_rigth">
                     <div class="tribal_index_zhiding"><h2><?php echo $v['name']?></h2><input class="divcss" data='<?php echo $v['id'];?>' value="<?php echo $v['sort'] ? '取消置顶':'置顶';?>" type="button"></div>
                     <div class="tribe_tuijian_box">
                      <p><?php echo strip_tags($v['content'])?></p>
                     </div>
                   </div>
                 </a>
             </li>
         <?php }?>
         </ul>
       </div>

       <!-- 查看更多 -->
       <?php if( count( $mytribe ) > 3 ){?>
       <div class="index_look_more"><i class="icon-gengduo"></i><span>查看更多</span></div>
     <?php }?>

     <?php }else{?>
     
          <a href="<?php echo site_url('Tribe/recommended_tribe')?>"><div style="  text-align: center;font-size: 12px; margin: 30px 0 70px 0; "><span>赶快加入部落吧！</span></div></a>
      
       <?php }?>
  </div>
  
  
  
<?php if( $activities ){?>

<!-- 热门活动 -->
<div class="tribe_head_more"><a href="<?php echo site_url('Tribe/activity_list')?>"><em class="icon-remen" style="color: #FF0000;"></em><span>热门活动</span><i class="icon-right"></i><span style='float: right;font-size: 13px;color: #999;'>更多</span></a></div>
  
<ul class="my_activities_top" style="display: back;width: 100%;">
  <li>
        <div class="activities_nei_li">
            <div class="activities_nei_li_top"> 
                <a href="<?php echo $activities['tribe_id'] > 0 ? site_url('Tribe/home/'.$activities['tribe_id']) : 'javascript:;'?>"><i><img src="<?php echo IMAGE_URL.$activities["logo"];?>" onerror="this.src='images/tmp_logo.jpg'"></i></a>
                <div class="activities_nei_li_xia">
                    <a href="<?php echo $activities['tribe_id'] > 0 ? site_url('Tribe/home/'.$activities['tribe_id']) : 'javascript:;'?>">
                    <h2><?php echo $activities['tribe_id'] > 0 ? $activities['tr_name'] : '五一易货网'?></h2>
                    <p><span><?php echo $activities['update_at']?></span></p>
                    </a>
                </div>
            </div>
            <div class="activities_neirong">
                <a href="<?php echo site_url('Tribe/activity_detaile/'.$activities['id']);?>">
                <div class="activities_neirong_xia">
                    <p><?php echo $activities['name']?></p> 
                    <img src="<?php echo IMAGE_URL.$activities['banner_img']?>"/>  
                </div>
                </a>  
            </div>
        </div>
    </li>

</ul>
<?php } ?> 




<?php if( $new_message ){?>
<!-- 消息提示 -->
<div class="tribe_head_more"><a href="<?php echo site_url('Member/Message/Notification?type=4')?>"><em class="icon-xiaoxi1" style="color: #8FCFE3;font-size: 16px;"></em><span>消息提示</span><i class="icon-right"></i><span style='float: right;font-size: 13px;color: #999;'>更多</span></a></div>
  <ul class="my_activities_top" style="display: back;width: 100%;">
    <li>
        <div class="activities_nei_li">
            <a href="<?php echo $new_message['tribe_id'] > 0 ? site_url('Tribe/home/'.$new_message['tribe_id']) : 'javascript:;'?>">
              <div class="activities_nei_li_top"> 
                <div class="tribe_new_main01"><i><img src="<?php echo IMAGE_URL.$new_message["logo"];?>" onerror="this.src='images/tmp_logo.jpg'"></i></div>
                <div class="activities_nei_li_xia">
                    <div class="tribe_new_main02">
                    <h2><?php echo $new_message['tribe_id'] > 0  ? $new_message['name'] : '五一易货网'?></h2>
                    <p><span><?php echo $new_message['created_at']?></span></p>
                    </div>
                </div>
            </div>
            </a>
            <div class="activities_neirong">
                <a href="javascript:void(0);">
                <div class="activities_neirong_xia">
                    <p  style="border-bottom: 1px solid #ddd;padding-bottom: 5px; display:none;" hidden>已加入西北狼联盟</p> 
                    <div class="order_inform_text"><span><?php echo $new_message['message']?></span></div>
                </div>
                </a>  
            </div>
        </div>
    </li>
</ul>

    
<?php }?>


<?php if( $new_announcement ){ ?>


<!-- 部落公告 -->
<div class="tribe_head_more"><a href="<?php echo site_url('Tribe/announcement')?>"><em class="icon-gonggao" style="color: #FDBA0B;"></em><span>部落公告</span><i class="icon-right"></i><span style='float: right;font-size: 13px;color: #999;'>更多</span></a></div>
<ul class="my_activities_top" style="display: back;width: 100%;">
    <li>
        <div class="activities_nei_li">
           <a href="<?php echo $new_announcement['tribe_id'] > 0 ? site_url('Tribe/home/'.$new_announcement['tribe_id']) : 'javascript:;'?>">
              <div class="activities_nei_li_top"> 
                <div class="tribe_new_main01"><i><img src="<?php echo IMAGE_URL.$new_announcement['logo']?>" onerror="this.src='images/tmp_logo.jpg'"></i></div>
                <div class="activities_nei_li_xia">
                    <div class="tribe_new_main02">
                    <h2><?php echo $new_announcement['tribe_id'] > 0 ? $new_announcement['tr_name'] : '五一易货网'?></h2>
                    <p><span><?php echo $new_announcement['last_updated_time']?></span></p>
                    </div>
                </div>
            </div>
            </a>
            <div class="activities_neirong">
                <?php if( $new_announcement['tribe_id'] > 0 ){?>
              <a href="<?php echo site_url('Tribe/announcement_detaile/'.$new_announcement['id'].'/'.$new_announcement['tribe_id']);?>">
              <?php }else{?>
              <a href="<?php echo site_url('Tribe/announcement_detaile/'.$new_announcement['id']);?>">
              <?php }?>
                  <div class="activities_neirong_xia">
                    <div class="tribe_new_gonggao">
                      <div class="tribe_new_gonggao_img"><img src="<?php echo IMAGE_URL.$new_announcement['title_img']?>" onerror="this.src='images/default_img_s.jpg'"></div>
                      <div class="tribe_new_gonggao_text"><span><?php echo $new_announcement['title']?></span><span><?php echo $new_announcement['last_updated_time']?></span></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </li>
</ul>



<?php }?>

<?php if( !empty( $topic_detaile ) ) { ?>
<!-- 圈子动态 -->
<div class="tribe_head_more"><a href=<?php echo site_url('Tribe/topict')?>><em class="icon-zhinan" style="color: #8DDDAF;"></em><span>圈子动态<i class="icon-right"></i></span><span style='float: right;font-size: 13px;color: #999;'>更多</span></a></div>
<ul class="my_activities_top" style="display: back;width: 100%;">
    <li>
        <div class="dingwei_right">
        <a href="<?php echo site_url('Circles/index/?tribe_id='.$topic_detaile['tribe_id'])?>" class="quanzi_tribal_name"><?php echo !empty( $mytribe_info[$topic_detaile['tribe_id']] ) ? $mytribe_info[$topic_detaile['tribe_id']]['name'] : ''?></a>
        </div>
      <a class="circle_zhong_ul_a" href="<?php echo site_url('Circles/Topic_Detaile/'.$topic_detaile['id'].'/?tribe_id='.$topic_detaile['tribe_id'])?>">
            <div class="circle_zhong_ul_li">
              <div class="circle_zhong_ul_top"> 
                  <!--<a href="<?php echo site_url('Circles/Topic_Detaile/'.$topic_detaile['id'].'/?tribe_id='.$topic_detaile['tribe_id'])?>">--><i><img src="<?php echo $topic_detaile['brief_avatar'] ? IMAGE_URL.$topic_detaile['brief_avatar']:$topic_detaile['wechat_avatar']?>" onerror="this.src='images/member_defult.png'"></i><!--</a>-->
                  <div class="circle_zhong_ul_xia">
                  
                  <div class="circle_zhong_dd">
                   <h2><span><?php echo $topic_detaile['real_name'] ? $topic_detaile['real_name'] : $topic_detaile['member_name']?></span><samp><?php echo $topic_detaile['corporation_name']?></samp></h2>
                   <!--<span class="zhidingd">已顶置</span>-->

                  </div>
                   <p>
                   <span id="create_time"><?php echo format_time($topic_detaile['created_at'])?></span>
                   <?php if($topic_detaile['corp_id']){ ?>
                   
                       <span class="quanzi_shop"><em class="icon-shop2"></em>店铺</span>
                      
                   <?php }?>
                   </p>
                  <!-- </a>-->
                   </div>
               </div>
               <div class="circle_zhong_ul_neirong" id="box">
                  <p id="zhankai_text"><?php echo $topic_detaile['content']?></p>
                  
               </div>
            </div>  
            </a>
            <?php if( $topic_detaile['images'] ){ 
                
                
                $img = explode(';', trim($topic_detaile['images'],';') );
               
                if( count($img) > 0 ){
                ?>
            <div  class="hot_circle_study_top <?php echo count($img) <= 1 ? 'hot_circle_study_qian' : ''?>">
              <a href="<?php echo site_url('Circles/Topic_Detaile/'.$topic_detaile['id'].'/?tribe_id='.$topic_detaile['tribe_id'])?>">
              <ul data-am-widget="gallery" class="hot_circle_study_gun am-no-layout" data-am-gallery="{ pureview: true }">
              <?php foreach ( $img as $v ):?>
               <li>
               
                 <img src="<?php echo IMAGE_URL.$v?>">
              
               </li>
               <?php endforeach;?>
               
             </ul>  
             </a>
          </div>  


          
          <?php } } ?> 
         <a href="<?php echo site_url('Circles/Topic_Detaile/'.$topic_detaile['id'].'/?tribe_id='.$topic_detaile['tribe_id'])?>">
             <dl class="circle_zhong_dl">
              <dd><span><i id="dianzan_<?php echo $topic_detaile['id']?>"class="icon-not_praise <?php echo $topic_detaile['my_upvote'] ? 'icon-already_praised1 bounceIn' : ''?>" onclick="upvote(<?php echo $topic_detaile['id']?>)" ><span class="zan_num"><?php echo $topic_detaile['upvote_num']? $topic_detaile['upvote_num']:"赞" ?></span></i></span></dd>
              <dd><span><i class="icon-comment1" style="vertical-align: text-bottom;"></i><span  class="comment_num" ><?php echo $topic_detaile['comment_num']? $topic_detaile['comment_num']:"评论"?></span></span></dd>
               <dd><span><i class="icon-jubao"></i>举报</span></dd>
               <?php if($this->session->userdata("user_id") == $topic_detaile['customer_id'] ){?>
                  <dd><a href="<?php echo site_url('Circles/Topic_Detaile/'.$topic_detaile['id'].'/?tribe_id='.$topic_detaile['tribe_id']) ?>"><span><i class="icon-delete"></i>删除</span></a></dd>
              <?php }?>
             </dl>
             <div class="dianzan_name" <?php if(count($topic_detaile['upvote_info']) <= 0){ echo "style='display:none;'";}?>>
             <i class="icon-not_praise icon-already_praised1 circles_dianzan"></i>
             <?php if(count($topic_detaile['upvote_info']) > 0){
                 
                    foreach ($topic_detaile['upvote_info'] as $key =>$val){
                        if($key == count($topic_detaile['upvote_info'])-1){ ?>
                              <span id="upvote_<?php echo $val['customer_id'];?>"><?php echo $val['real_name'] ? $val['real_name'] : $val['member_name'];?></span><span class="douhao" style="display:none">,</span>
              <?php       }else{ ?>
                              <span id="upvote_<?php echo $val['customer_id'];?>"><?php echo $val['real_name'] ? $val['real_name'] : $val['member_name'];?></span><span class="douhao">,</span>
              <?php      }
                        ?>
             <?php }
             }?>
             </div>
         </a>
          </li>
</ul>


<?php }?>

<!-- 推荐加入部落 -->
<div class="tuichu_ball xuanze_ball" style="display:none">
   <div class="tuichu_ball_box">
      <div class="tuichu_ball_main">
         <div class="xuanze_ball_title"><span>推荐加入部落</span><em class="icon-close close_ball"></em></div>
         <div class="guanliyuan_xuanze">
            <ul>
              <?php if(isset($tribe_staff_list)):?>
                <?php foreach($tribe_staff_list as $val):?>
                  <li>
                <label>
                <div class="recommend_box">
                  <div class="recommend_box_img"><img src="<?php echo IMAGE_URL.$val["logo"];?>" onerror="this.src='images/51_logo.png'" alt=""></div>
                  <p><span ><?php echo $val['name'];?></span><span>族员：<?php echo $val['sub_satff_member'];?>人</span></p>
                  <input tribe_id="<?php echo $val['id'];?>" type="checkbox" class="">
                </div>
                </label>
                 </li>
              <?php endforeach;?>
             <?php endif;?>
              <!-- <li> -->
            <!--     <label>
                <div class="recommend_box">
                  <div class="recommend_box_img"><img src="images/51_logo.png" alt=""></div>
                  <p><span>旗舰店会员</span><span>族员：120人</span></p>
                  <input type="checkbox" class="">
                </div>
                </label>
              </li>
              <li>
                 <label>
                <div class="recommend_box">
                  <div class="recommend_box_img"><img src="images/51_logo.png" alt=""></div>
                  <p><span>旗舰店会员</span><span>族员：120人</span></p>
                  <input type="checkbox" class="">
                </div>
                </label>
              </li>
              <li>
                <label>
                <div class="recommend_box">
                  <div class="recommend_box_img"><img src="images/51_logo.png" alt=""></div>
                  <p><span>旗舰店会员</span><span>族员：120人</span></p>
                  <input type="checkbox" class="">
                </div>
                </label>
              </li> -->
            </ul>
         </div>  
         <div class="recommend_all_choice"><label><span>全选</span><input type="checkbox" class="" id="all_choice"></a></div>
         <div class="guanliyuan_xuanze_a"><a style="background:#666666" href="javascript:void(0);" id="tribe_submit" >加入部落<span id="tribe_num">(0)<span></a></div>
         <a href="javascript:void(0);" class="recommend_tishi"><label><input type="checkbox" class="icon-yixuan1 icon-weixuan1"><span>不再显示该消息</span></label></a> 
      </div>
   </div>
 </div>

<script>

  $("input[type='checkbox']").next().text();

  $(".divcss").click(function () {
    var id =$(this).attr('data');
    $.ajax({
      url: '<?php echo  site_url("Tribe/sort_tribe");?>',
      type: 'POST',
      data:{'id':id},
      dataType: 'json',
      success: function(data){
        $(".black_feds").text(data.message).show();
        setTimeout("prompt();", 2000);
        setTimeout(function(){
          window.location.href ="<?php echo site_url("Tribe").'?rf_id='.rand(1000,9999);?>";
          }, 2200);
      },
        error:function(){
        $(".black_feds").text("网络出错，请重试！").show();
        setTimeout("prompt();", 2000);
        return;
      }
       });
      return false;
    });
  function Goback(){
    <?php if(!$mac_type){ ?>
    window.location.href = '<?php echo site_url("Home")?>';
  //    if(window.history.length >1){
  //    window.history.back();
  //    }else{
      
  //      }
    <?php }else{?>
    window.location.href="<#returnBackController#>";
    <?php }?>
    
  }

  function reload(){//APP
     window.location.reload();
  }

  function AutoScroll(obj){ 
  $(obj).find("ul:first").animate({ 
  marginTop:"-24px" 
  },500,function(){ 
  $(this).css({marginTop:"0px"}).find("li:first").appendTo(this); 
  }); 
  } 
  $(document).ready(function(){ 
  setInterval('AutoScroll("#tribal_notice_top_nei")',3000); 
  }); 
</script>
<script>


$(function(){
    
    $(".recommend_top li").click(function(){
      $(this).css({
      background: "#906603",
      }).siblings().css({
        background: "#b59d78",
      });
    });         
            
    $(".recommend_top li").click(function(){
     $(this).addClass("action").siblings().removeClass("action");
    var index = $(this).index();
    //$("#contentop li").eq(index).css("display","block").siblings().css("display","none");
    });
    });
</script>


<script type="text/javascript">
   var width = $(".my_tirbe_list ul a").width();
   var mytribe_total = $(".my_tirbe_list ul a").length;
   $(".my_tirbe_list ul").width(width*mytribe_total);


   $(".dianzan-icon").on("click",function(){
     $(this).toggleClass('icon-fabulous_off');
     $(this).parents('.dianzan-text').toggleClass('dianzan-color');
   })



// 点击查看更多
$(".index_look_more").on("click",function(){
  
      if($(this).children('span').text() == '查看更多')
      {
        $(".index_look_more span").text("收起");
        $('.recommended_tribe_top li:gt(2)').show();
      }else{
        $('.recommended_tribe_top li:gt(2)').hide();
        $(".index_look_more span").text("查看更多");
      }
})


var JM = function(){
    //设置rem单位
    var html = document.documentElement;
    html.style.width = 100+"%";
    html.style.height = 100+"%";
    html.style.overflowX = "hidden";
    function xX(){
        var screenW = html.clientWidth;
        html.style.fontSize = 0.1 * screenW + "px";
    }
    window.onresize = function(){
        xX();
    };
    xX();
}();



// <!--超出字显示查看更多-->
var box = document.getElementById("box");  

 
var newBox = document.createElement("a"); 
<?php if(isset($topic_detaile)){ ?>
  var zhankai_text = document.getElementById("zhankai_text");
  var text = zhankai_text.innerHTML;
  newBox.href = "<?php echo site_url('Circles/Topic_Detaile/'.$topic_detaile['id'].'/?tribe_id='.$topic_detaile['tribe_id'])?>";
  var btn = document.createElement("span"); 
  newBox.innerHTML = text.substring(0,50); 
  btn.innerHTML = text.length > 50 ? "展开" : ""; 
  // btn.href = "javascript:;"; 
  btn.onclick = function(){ 
  if (btn.innerHTML == "展开"){ 
  btn.innerHTML = "收起"; 
  newBox.innerHTML = text; 
  }else{ 
  btn.innerHTML = "展开"; 
  newBox.innerHTML = text.substring(0,50); 
  } 
  } 
  box.innerHTML = ""; 
  box.appendChild(newBox); 
  box.appendChild(btn); 
<?php } ?>






// 点击关闭弹窗
$('.close_ball').on('click',function(){
  $('.tuichu_ball').hide();
});


// 不再显示该消息
$('.recommend_tishi label input').on('click',function(){
  if(this.checked){    
    $(this).removeClass('icon-weixuan1');   
    $(this).addClass('recommend_tishi_active');   
  }else{     
    $(this).addClass('icon-weixuan1');   
    $(this).removeClass('recommend_tishi_active');    
  }  
});
// 选择部落

var chknum = '';
$('.guanliyuan_xuanze :checkbox').on('click',function(){
    chknum = $(".guanliyuan_xuanze :checkbox").size();//选项总个数 

    // console.log(chknum);
    var chk = 0;
    var text = $("#tribe_submit").find("#tribe_num").text();
    $(this).toggleClass('icon-yixuan');
    $(this).toggleClass('recommend_tishi_active');
    $(".guanliyuan_xuanze :checkbox").each(function () {   
            if($(this).hasClass('icon-yixuan')){ 
            chk++; 
           } 
         });

        if(chknum==chk){//全选 
          $("#tribe_submit").removeAttr("onclick");
          $("#tribe_submit").attr("onclick", "tribe_submit(this)");
          $("#tribe_submit").css("background", "#FFD600");
          $("#tribe_num").text("("+chknum+")");
          $("#all_choice").addClass('icon-yixuan');
          $("#all_choice").addClass('recommend_tishi_active');
          text = $("#tribe_submit").find("#tribe_num").text();
          
        }else{

          $("#tribe_submit").removeAttr("onclick");
          $("#tribe_submit").css("background", "#FFD600");
          $("#tribe_submit").attr("onclick", "tribe_submit(this)");
          $("#tribe_num").text(" ")
          $("#tribe_num").text("("+chk+")")
          $("#all_choice").removeClass('icon-yixuan');
          $("#all_choice").removeClass('recommend_tishi_active');
           text = $("#tribe_submit").find("#tribe_num").text();
    
        } 

        if(text == "(0)"){
          $("#tribe_submit").removeAttr("onclick");
          $("#tribe_submit").css("background", "#666666");
        }    
})
// 点击全选
$('.recommend_all_choice label input').on('click',function(){ 
    chknum = $(".guanliyuan_xuanze :checkbox").size();//选项总个数 
    $("#tribe_submit").removeAttr("onclick");
    $("#tribe_submit").attr("onclick", "tribe_submit(this)");
    $("#tribe_submit").css("background", "#FFD600");
    $(this).toggleClass('icon-yixuan');
    $(this).toggleClass('recommend_tishi_active');
    if($(this).hasClass('icon-yixuan')){   
       $(".guanliyuan_xuanze :checkbox").addClass('icon-yixuan');   
       $(".guanliyuan_xuanze :checkbox").addClass('recommend_tishi_active'); 
       $("#tribe_num").text(" ");
       $("#tribe_num").text("("+chknum+")");

    }else{   
      $("#tribe_submit").removeAttr("onclick");
      $("#tribe_submit").css("background", "#666666");
       $("#tribe_num").text(" "); 
       $("#tribe_num").text("(0)");
       $(".guanliyuan_xuanze :checkbox").removeClass('icon-yixuan');   
       $(".guanliyuan_xuanze :checkbox").removeClass('recommend_tishi_active');  
   }    
});

function tribe_submit(e)
{
  var tribe = [];
  // if($(e).find("span").text() == "(0)"){
  //   $(".black_feds").text("添加失败").show();
  //   setTimeout("prompt();", 500); 
  //   return false;
  // }
// #666666
  // $('.tuichu_ball').hide();
  // return false;
  $(".icon-yixuan ").each(function(){
    if($(this).attr("tribe_id")){
      tribe.push($(this).attr("tribe_id"));
    }
  });

  if(tribe.length > 0){
    tribe = JSON.stringify(tribe);
  }
  // 更新部落成员表
  $.post(
    "<?php echo site_url('tribe/update_staff');?>",
    {tribe:tribe},
    function(data){
      // console.log(data);
      if(data.status == 1){
        $(".black_feds").text("添加成功").show();
        // setTimeout("prompt();", 500); 
        $('.tuichu_ball').hide();
        setTimeout("prompt();", 500); 
        window.location.href = "<?php echo site_url('tribe/index');?>"+"?aff=confirm";
        // $.get(
        //   "<?php //echo site_url('tribe/ajax_mytribe');?>",
        //   function(data){
        //     console.log(data);
        //     var mytribe = data.data;
        //     var html = '';
        //     var hidden = '';
            
        //     // 异步更新我的部落
        //     if(data.status == 1){
        //       $.each(mytribe, function(index, v){
        //          hidden =  index >= 3?'hidden':'';
        //          html += '<li '+hidden+' >';
        //          html += '<a href='+'<?php //echo site_url("Tribe/home/");?>'+v['id']+'>';
        //          html += '<i><img src='+'<?php //echo IMAGE_URL;?>'+v["logo"] +' onerror="this.src="images/tmp_logo.jpg"></i> ';
        //          html += '<div class="recommended_tribe_rigth">';
        //          html += ' <div class="tribal_index_zhiding"><h2>'+v["name"]+'</h2><input class="divcss" data="'+v["id"]+'"'+ ' value="'+v["sort"]? "取消置顶":"置顶"+'"'+ ' type="button"></div>';

        //          html += '<div class="tribe_tuijian_box">';
        //          html += '<p>'+v["content"]+'</p>';
        //          html += '</div>';
        //          html += '</div>';
        //          html += '</a>';
        //          html += '</li>';

        //       });

        //       $(".recommended_tribe_top").html(html);

        //     }
        //   },
        //   'json'
        // );
  




      }else{
        $(".black_feds").text("添加失败").show();
        setTimeout("prompt();", 500); 
      }
    },
    'json'
  );

}

<?php //if(!strpos($urlshang, 'tribe/index')):?>

// 没有人邀请加入部落，关闭弹窗
<?php if(!isset($aff)):?>
  (function foo(){

    var pop_num = "<?php echo isset($pop_num)?$pop_num:0;?>";
    var tribe_exits = "<?php echo isset($is_exits)?$is_exits:'';?>";
    var tips = "<?php echo isset($tips['status'])?$tips['status']:'';?>";
    var status = "";

  
    if(tribe_exits == "not_exits" || pop_num > 2 ){
       $('.tuichu_ball').hide();
       return false;
    }

    <?php if(isset($tips) && $tips):?>
    // 状态 
    if(tips == 0){
      $('.tuichu_ball').hide();
      return false;
    }
    <?php endif;?>
   // console.log(1231);
   <?php if(isset($is_exits) && $is_exits== "exits"):?>
    $('.tuichu_ball').show();
    <?php endif;?>
    // 记录弹框弹出次数
    var tips = $(".tuichu_ball");
    var tips_num = 1;

    if(pop_num <4){
      $.post(
        "<?php echo site_url('tribe/record_tips');?>",
        {tips_num:tips_num},
        function(data){
          console.log(data);
        },
        'json'
      );
    }  
  }());

<?php endif;?>
<?php //endif;?>


$("a").find("input[type='checkbox']").click(function(){
  
  if($(this).hasClass('recommend_tishi_active')){
    $('.tuichu_ball').hide();
    var mobile = "<? echo $this->session->userdata('mobile');?>";
    var status = 0;
    $.post(
      "<?php echo site_url('tribe/show_page');?>",
      {status:status},
      function(data){
        console.log(data);
      },'json'
    );

  }
});



</script>






