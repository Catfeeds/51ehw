<style type="text/css">
 .prominent_commerce_box li a {padding: 15px 10px 15px 0!important;}
 .tribal_index_zhiding input {background: #61c3d0;color: #fff;border-radius: 4px;padding: 4px 0px;width: 67.5px;}
 .recommended_tribe_top li {border-top: none;margin-bottom: 0px;}
 .recommended_tribe_top li a i {width: 70px;height: 70px;border: 2px solid #ddd;border-radius: 50%;overflow: hidden;}
 .recommended_tribe_top li a {padding: 10px 15px 10px 15px;}
/*  .tribe_tuijian_box {margin-top: 5px;} */
 .commerce_directory_search {padding:10px 15px 10px 5px;background: #0f5d8a;}
 .commerce_directory_search label {background: #b7cfdc;}
 .commerce_directory_search label p span {color: #5789a6;}
 .new_back_icon {color: #5789a6;}
 .commerce_directory_search label p input::-webkit-input-placeholder {color: #5789a6;}
</style>


<!-- 商会名录 -->

<div class="commerce_index" style="padding-bottom:0px;">
    <div class="commerce_directory">
       <!-- 搜索会员 -->
       <?php if($label_id == 1){?>
       <div class="commerce_directory_search">
          <a href="javascript:history.back()" class="icon-back new_back_icon"></a>
          <label onclick="search();">
            <p><span class="icon-search"></span><input type="text" placeholder="请输入商会名称"></p>
          </label>
       </div>
       <?php };?>
    <?php if($label_id == 2){?><!-- 只有秦商商会才显示 -->
    <div class="commerce_directory_search">
          <a href="javascript:history.back()" class="icon-back new_back_icon"></a>
          <label onclick="search();">
            <p><span class="icon-search"></span><input type="text" placeholder="请输入商会名称"></p>
          </label>
    </div>
      <div class="commerce_name_logo">
        <div><img src="images/commerce/commerce_name_logo.png" alt=""></div>
      </div>

      <div class="commerce_name_img">
        <a href="http://www.51ehw.com/index.php/_BUSINESS/Commerce/tribe_label_list/42"><img src="images/commerce/commerce_name_img01.png" alt=""></a>
        <a href="http://www.51ehw.com/index.php/_BUSINESS/Commerce/tribe_label_list/18"><img src="images/commerce/commerce_name_img02.png" alt=""></a>
      </div>
      <?php };?>


     <?php if($label_id == 6){?>
     <style type="text/css">
         .commerce_directory_search label p input::-webkit-input-placeholder {color: #c0c0c0;}
         .new_back_icon {color:#c0c0c0;}
         .commerce_name_img a:nth-child(1) {margin-left: 2%;margin-right: 2%;}
         .commerce_name_img a {width: 47%;}
     </style>
    <div style="background:url(images/commerce/shanghui_logo_bg.png) no-repeat;background-size: 100% 100%;">
      <div class="commerce_directory_search" style="background:none;">
          <a href="javascript:history.back()" class="icon-back new_back_icon"></a>
          <label onclick="search();" style="background:#f3ede8;">
            <p><span class="icon-search" style="color:#c0c0c0;"></span><input type="text" placeholder="请输入商会名称"></p>
          </label>
    </div>
      <div class="commerce_name_logo" style="background:none;">
        <div><img src="images/commerce/shanghui_logo_01.png" alt="" style="width:30%;"></div>
      </div>
    </div>

      <div class="commerce_name_img">
        <a href="http://www.51ehw.com/index.php/_BUSINESS/Commerce/tribe_label_list/87"><img src="images/commerce/shanghui_img_01.png" alt=""></a>
        <a href="http://www.51ehw.com/index.php/_BUSINESS/Commerce/tribe_label_list/88"><img src="images/commerce/shanghui_img_02.png" alt=""></a>
      </div>
      <?php };?>


       <!-- 置顶 -->
       <div class="recommended_tribe">
         <ul class="recommended_tribe_top">
            <li>
            <a href="<?php echo site_url('Tribe/home/'.$tribe_info['id'].'/'.$label_id);?>" > 
            <i><img src="<?php echo  IMAGE_URL.$tribe_info['logo'];?>" onerror="this.src='images/tmp_logo.jpg'"></i>
            <div class="recommended_tribe_rigth">
              <div class="tribal_index_zhiding">
              <h2><?php echo $tribe_info['name'];?></h2>
             </div>
             <div class="tribe_tuijian_box">
              <p><?php echo $tribe_info['content'];?></p>
             </div>
            </div>
            </a>
           </li>
        </ul>
       </div>

 
       <!-- 地区列表 -->
       <div class="commerce_directory_list">
         <ul>
          <?php
            if(count($label_list) > 0){
                
                if( $label_id == 2 )
                { 
                  //如果是秦商部落做处理。
                  $label_list = array_column($label_list, null,'id');
                  unset($label_list[18]);
                  unset($label_list[42]);
                }
                if( $label_id == 6 )
                { 
                  //如果是秦商部落做处理。
                  $label_list = array_column($label_list, null,'id');
                  unset($label_list[87]);
                  unset($label_list[88]);
                }
                
                foreach ($label_list as $key =>$val){  ?>
                    <li>
                       <a href="<?php echo site_url("Commerce/tribe_label_list").'/'.$val['id'];?>">
                         <img src="<?php echo IMAGE_URL.$val['sec_img'];?>" onerror="this.src='images/commerce/commerce_directory_01.png'" alt="">
                         <!-- <div class="commerce_directory_text"><div><p><span><?php echo $val['sec_name'];?></span></p></div></div> -->
                       </a>
                     </li>
          <?php }
               }?>
         </ul>
       </div>



    </div>

    
       <!-- 底部导航 -->
<!--        <div class="commerce_footer_nav"> -->
<!--         <ul> -->
<!--             <li><a href="javascript:void(0);" ><img src="images/commerce/index_02.png"><span class="commerce_footer_active">首页</span></a></li> -->
<!--             <li><a href="javascript:void(0);"><img src="images/commerce/xiaoxi_01.png"><span>消息</span></a></li> -->
<!--             <li><a href="javascript:void(0);"><img src="images/commerce/fabu_01.png"><span>发布</span></a></li> -->
<!--             <li><a href="javascript:void(0);"><img src="images/commerce/renmai_01.png"><span>人脉</span></a></li> -->
<!--             <li><a href="javascript:void(0);"><img src="images/commerce/my_01.png"><span>我的</span></a></li> -->
<!--         </ul> -->
<!--       </div> -->

</div>



<script type="text/javascript">
function search(){
  window.location.href="<?php echo site_url("Commerce/search_tribe/").'/'.$label_id; ?>";
}
</script>