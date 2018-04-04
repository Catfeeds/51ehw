<style type="text/css">
   .container {background:#f4f4f4;}
   body {background:#f4f4f4;}
   .sousuo_text {position: absolute;right: 2%;color: #fff;font-size: 15px;top: 18px;}
</style>
<!-- 易货分类 -->

  <div class="search-header" name="" style="background-color: #1A1A1A;height:50px;width:100%;position:fixed;top:0;left:0;z-index: 999;">
    <a href="javascript:history.back()" target="_self" class="icon-right" style="-webkit-transform: rotate(180deg);;color:#fff;font-size:19px;float:left;margin-left:10px;margin-top:18px;"></a>
   <!-- 搜索框 -->
   
       <div class="nav_search" style="padding-top: 10px;margin-left:0px;">
          <p style="background-color: #fff;width:75%;border:1px solid #000;border-radius:3px;margin:-2px auto;padding-left:10px;"><a href="javascript:void(0);" class="icon-sousuo" style="color:#ACACAC;font-size:15px;"></a>
          <a href="<?php echo site_url('search/wechat_search');?>">
          <input type="text" class="search_input" name="keyword" value="" placeholder="搜索您想找的商品" style="width:85%;color#606060;height:34px;background-color: #fff;border: none;font-size: 15px;">
          </a>
          </p>
          <span class="sousuo_text">搜索</span> 
          <input type="hidden" value="" name="tribe_id"> 
          <input type="hidden" value="0" name="cate_id">   
       </div>
</div>

    <!-- 产品分类 开始 -->
    <div class="" style="position: fixed;width: 100%;height: 100%;top: 0;background: #f4f4f4;"></div>
  <div class="classify-main">
    
     <div class="classify-left">  
    <ul>
    <?php if(count($rank1) > 0){?>
    <?php foreach ($rank1 as $key =>$val){
        if($key == 0){?>
        <!-- id="classify_more" -->
        <li class="active" ><?php echo $val['name'];?></li>
     <?php   }else{?>
         <li><?php echo $val['name'];?></li>
     <?php } }?>
   <?php }?>
    </ul>
   </div>
   <div class="classify-right">
     <ul>
     <?php 
     if(count($rank1) > 0){
     foreach($rank1 as $key =>$val){?>
      <li  <?php if($key != 0 ){ echo 'style="display: none;"';}?> >
      <?php if($val['img_path']){?>
        <!-- 商品广告图 -->
            <div><a 
            <?php 
                if($val['type']){
                    if($val['cat_id']){
                        echo 'javascript:void(0); onclick="jump('.$val['cat_id'].');"';
                    }else{
                        echo 'href="javascript:void(0);"';
                    }
                }else{
                    if($val['link']){
                        echo 'href="'.$val['link'].'"';
                    }else{
                        echo 'href="javascript:void(0);"';
                    }
                }
           ?>>
            <?php 
             if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){ ?>
              	<img src="<?php echo 'http://www.test51ehw.com/uploads/B/'.$val['img_path']?>" onerror="this.src='images/discount_error.png'" alt=""></a>
              <?php }else{ ?>
                <img src="<?php echo IMAGE_URL.$val['img_path']?>" onerror="this.src='images/discount_error.png'" alt="">
                </a>
              <?php }?>
            </div>
     <?php } ?>     
     <?php 
     if(count($rank2) > 0){
         $sign = array();
         foreach ($rank2 as $key2 => $val2){
            if($val2['parent_id'] == $val['id'] ){
                if(count($val2) > 0){
                          if(count($rank3) > 0){
                               foreach ( $rank3 as $key3 =>$val3){
                                   if($val2['id'] == $val3['parent_id']){
                                       if(!in_array($val2['name'],$sign) && !empty($sign)){
                                           echo '</div>';
                                       }
                                       
                                       if(count($val3) > 0 && !in_array($val2['name'],$sign)){
                                          ?> 
                                            <a href="javascript:void(0);" class="classify-right-title"><?php echo  $val2['name'];?><span class="icon-next right-icon"></span></a>
                           					<div class="classify-right-picture">
                                          <?php 
                                          array_push($sign, $val2['name']);
                                       }
                                   ?>
                                   <a <?php echo  $val3['type'] ? 'javascript:void(0); onclick="jump('.$val3['cat_id'].');"':'href="'.$val3['link'].'"'?>">
                                    <?php 
                                     if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){ ?>
                                     	<img src="<?php echo 'http://www.test51ehw.com/uploads/B/'.$val3['img_path']?>" onerror="this.src='images/default_img_s.jpg'" alt="">
                                      <?php }else{ ?>
                                        <img src="<?php echo IMAGE_URL.$val3['img_path']?>" onerror="this.src='images/default_img_s.jpg'" alt="">
                                      <?php }?>
                                   
                                   
                                   <?php echo $val3['name'];?></a>
                    <?php
                             }
                        }
                    }
                 }
             }
          }
      }
         ?>
     </li>   
    <?php
        } 
       
     }?>
        
     </ul>
   </div>
  </div>
 <!-- 产品分类 结束 -->


<script type="text/javascript">
      $(function(){
        $(".classify-left").on("touchmove",function(){
          $(".classify-right").css("position","fixed");
          $(".classify-left").css("position","absolute");
          $(".classify-left").css("top","0");
        })
        $(".classify-right").on("touchmove",function(){
          $(".classify-left").css("position","fixed");
          $(".classify-right").css("position","absolute");
          $(".classify-left").css("top","50px");
        })
      })
    function jump(id){
        	  window.location.href="<?php echo site_url('Search/wechat_search_goods');?>?cate_id="+id;
           }
      // 点击全部
//       $("#classify_more").on("click",function(){
//         $(".classify-right li").show();
//       })


      // tab切换
      $(".classify-left li").on("click",function() {
        var index = $(this).index();
        // $(".classify-left").css("top",-(index * 50));
        // alert(index);
        $(this).addClass("active").siblings().removeClass("active");
        // $(".classify-fight li").eq(index).show().siblings().hide();
       $(this).parents(".classify-main").find(".classify-right li").eq(index).show().siblings().hide();
      })
        
  </script>













