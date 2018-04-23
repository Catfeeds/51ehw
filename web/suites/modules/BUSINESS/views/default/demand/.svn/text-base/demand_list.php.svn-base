<!--添加导航 预加载-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<style type="text/css">
    /*弹窗*/

 .dingdan4_4_btn01 {
    margin-left: 339px;
}
 .dingdan4_4_tanchuang_top2 {
    height: 500px;
    line-height: 30px;
    font-size: 14px;
    text-align: center;
    border-bottom: 1px solid #efeeee;
    overflow: scroll;
    padding: 0px 21px 50px 21px;
}
.selectCategoryDiv {
    position: relative;
    float: left;
    background: #FFF;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    /*border-left: 1px solid #e1e1e1;
    border-right: 1px solid #e1e1e1;
    border-bottom: 1px solid #e1e1e1;
    box-shadow: 0 1px 0 0 rgba(0, 0, 0, 0.04);*/
    margin: 5px 7px;
}


.category-search {
    background: #fff;
    /*box-shadow: 0 2px 2px rgba(0, 0, 0, .1);*/
    position: relative;
}

.category-search i {
    position: absolute;
    top: 8px;
    left: 8px;
}

.category-search input {
    margin-bottom: 0;
    padding-top: 0;
    padding-bottom: 0;
    text-indent: 30px;
    width: 215px;
    height: 30px;
    border: 1px solid #e1e1e1;
}

.categorySet {
    overflow-x: hidden;
    overflow-y: auto;
    height: 390px;
    border: 1px solid #e1e1e1;
    margin-top: 5px;
}

.categoryItem {
    width: 215px;
    height: 30px;
    line-height: 30px;
    text-align: left;
    font-size: 14px;
}

.categoryItem:hover {
    width: 215px;
    height: 30px;
    line-height: 30px;
    background-color: #fca643;
    cursor: pointer;
    color: #fff;
}

.categoryItemClick {
    width: 215px;
    height: 30px;
    line-height: 30px;
    background-color: #fca643;
    cursor: pointer;
    color: #fff;
}

.categoryItem span {
    display: inline-block;
    margin-left: 10px;
    white-space: nowrap;
    max-width: 177px;
    text-overflow: ellipsis;
    overflow: hidden;
}

.hasSubCategory {
    float: right;
    margin-right: 20px;
    font-size: 12px;
    height: 30px;
    line-height: 30px;
}
#search{
    margin: 0px;
    padding: 0px;
    overflow: auto;
    
}
.needs_list_table ul li span {padding-top: 0px!important;}
.dingdan4_4_tanchuang_con {margin:-319.5px 0 0 -480px;}
.needs_list_main_header{height:48px; line-height:48px;background:#eeeeee; padding-bottom:0;border-top: 1px solid #D9D9D9;}
.cpage{background: #72c312;}
</style>
<script>
//顶部菜单
//站点菜单
    // alert(<?php //echo $cateid;?>);
    (function($){
        $(document).ready(function(){
          if( "undefined" !== typeof <?php echo $cateid;?>){
            switch(<?php echo $cateid;?>){

                case 189:
                    $("#restaurant").addClass("header_left_active");
                       // console.log(1);return false;
                    break;
                case 1696:
                   $("#hotel").addClass("header_left_active");
                   // console.log(2);return false;
                    break;
                case 99999:
                  $("#tuijian").addClass("header_left_active");
                  
                  break;
                default:
                    $("#new").addClass("header_left_active");
                    break;

            }
          }
            var example = $('#sf-menu').superfish({
            });
        });
    })(jQuery);
</script>
<?php
//$json_string = file_get_contents(base_url("data/category.json"));
//?>

<!--<script>
$(function(){
    //类目菜单
    ko.applyBindings(<?php //echo $json_string?>);
})

</script>

 <script>
<?php
    //$json_string = file_get_contents(base_url("data/category.json"));
?>
     var viewModel = <?php //echo $json_string;?>;
</script>
 <script>
$(document).ready(function(){
    //类目菜单
    ko.applyBindings(viewModel);
});

</script>-->
<!--导航 开始-->
<div class="eh_navbar clearfix">
    <div class="macth_xv_navlist">
        <div class="macth_xv_menu">
            <!--左侧导航 start-->
            <div class="macth_xv_categorys">
                <div class="macth_xv_needs_title" style="background:#ff8800;line-height: 34px;">
                    <h2><a href="javascript:void(0);">需求池</a></h2>
                </div>
            </div>
            <!--左侧导航 end-->
           
            <div class="macth_xv_login">
                <div class="macth_xvlogin_list scroll_top">
                    <div class="scroll_title">新闻热点</div>
                    <ul class="infoList"> 
                        <?php if(isset($notice) && count($notice)>0): ?>
                        <?php foreach ($notice as $n): ?>
                            <li>
                            <a href="<?php echo site_url('notice'); ?>"><?php echo $n['title'] ?></a>
                            </li>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <li>
                            <a href="javascritp:;">暂无公告！</a>
                            </li>
                        <?php endif; ?>
                        <!-- <li>
                            <a href="">51易货网内测阶段，欢迎关注！</a>
                        </li>
                        <li>
                            <a href="">51易货网即将上线，敬请期待！</a>
                        </li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--导航 结束-->

<div class="content_company clearfix">
    <!-- 发布需求 开始 -->
    <div class="needs_list_publish">
        <div class="needs_list_publish_title">
            <em></em><span>发布需求:</span>
        </div>
        <div class="needs_list_publish_tu">
            <!-- 餐饮企业 -->
            <div class="needs_list01" style="background:url(images/needs_list01.png)">
                <div class="needs_list_text">
                    <div class="needs_list_text01">
                        <span>餐饮企业</span><br>
                        <span>restaurant</span>
                    </div>
                </div>
                <div>
                    <a href="javascript:add_list();" class="needs_list_button" style="display: none;"><span>发布该需求</span></a>
                </div>
                <div class="needs_list_footer">
                    <span>需求总金额 
                    <?php
                    if(isset($restaurant_money)){
                        if($restaurant_money >= 10000){
                            echo sprintf("%.2f", $restaurant_money/10000).'万';
                        }else{
                            echo  $restaurant_money;
                        }
                    }else{
                        echo 0;
                    }
                    ?>
                     提货权</span>
                </div>
            </div>
            <!-- 酒店娱乐 -->
           <div class="needs_list01" style="background:url(images/needs_list02.png)">
                <div class="needs_list_text">
                    <div class="needs_list_text01">
                        <span>酒店娱乐</span><br>
                        <span>hotel entertainment</span>
                    </div>
                </div> 
                <div>
                   <a href="javascript:add_list();" class="needs_list_button" style="display: none;"><span>发布该需求</span></a>
                </div> 
                <div class="needs_list_footer">
                   <span>需求总金额 
                    <?php
                    if(isset($hotel_money)){
                        if($hotel_money >= 10000){
                            echo sprintf("%.2f", $hotel_money/10000).'万';
                        }else{
                            echo  $hotel_money;
                        }
                    }else{
                        echo 0;
                    }
                    ?>
                    提货权</span>
                </div>
           </div>
           <!-- 其他 -->
           <div class="needs_list01 needs_list03 " style="background:url(images/needs_list03.png)">
                <div class="needs_list_text">
                    <div class="needs_list_text01">
                        <span>其他</span><br>
                        <span>others</span>
                    </div>
                </div>
                <div>
                    <a href="javascript:add_list();" class="needs_list_button" style="display: none;"><span>发布该需求</span></a>
                </div>
                <div class="needs_list_footer">
                    <span>需求总金额 
                    <?php
                    if(isset($other_money)){
                        if($other_money >= 10000){
                            echo sprintf("%.2f", $other_money/10000).'万';
                        }else{
                            echo  $other_money;
                        }
                    }else{
                        echo 0;
                    }
                    ?>
                     提货权</span>
                </div>
           </div>

        </div>


    </div>
    <!-- 发布需求 结束 -->


    <!-- 需求列表 开始 -->
    <div class="needs_list_main">
         <div class="needs_list_publish_title">
            <em></em><span>需求列表:</span>
        </div>
        <script type="text/javascript">
          // var cate_id = $(".categoryItem").attr('id') ? $(".categoryItem").attr('id') : 0;
        </script>
        <div class="needs_list_header">
            <div class="needs_list_header_left">  
            <?php  if ($this->session->userdata ( 'user_in' )):?>
              <a href="javascript:calssify('99999');" id="tuijian"><li >精选推荐</li></a>
            <?php endif;?>   
                    
                    <a href="javascript:calssify('0');" id="new"><li >最新需求</li></a>
                    <a href="javascript:calssify('189');" id="restaurant"><li>餐饮企业</li></a>
                    <a href="javascript:calssify('1696');" id="hotel"><li>酒店娱乐</li></a>
            </div>
            <div class="needs_list_header_right">
                <a href="javascript:void(0);">分类筛选<span class="icon-select"></span></a>
                <div class="needs_right_search">
                  <input type="text" name="keyword" class="search_btn" placeholder="搜索内容" value="<?php echo $keyword;?>">
                  <span class="icon-find" onclick="lookup()"></span> 
                </div>
            </div> 
           
        </div>
         <!-- 分类筛选 后显现 -->
         <div class="needs_list_screening">
             <span><span class="needs_list_screening_name"><?php echo $catename?$catename:'全部';?></span>的需求总金额为：<span class="needs_list_screening_money">


             <?php

             // if(isset($classify_money)){
             //     if($classify_money >= 10000){
             //         echo sprintf("%.2f", $classify_money/10000).'万';
             //     }else{
             //         echo  $classify_money;
             //     }
             // }else{
             //     echo 0;
             // }
              if($cateid == 99999){
                if($tuijian_money >= 10000){
                    echo sprintf("%.2f", $tuijian_money/10000).'万';
                }else{
                    echo  $tuijian_money;
                }
             }else{
                if(isset($classify_money)){
                    if($classify_money >= 10000){
                        echo sprintf("%.2f", $classify_money/10000).'万';
                    }else{
                        echo  $classify_money;
                    }
                }else{
                    echo 0;
                }
             }
                    
             ?> 提货权</span></span>
         </div>
         <!-- 内容 -->
        <div class="needs_list_main_header">
           <a href="javascript:demand_search(1);" id="sort1">综合</a>
           <a href="javascript:demand_search(2);" id="sort2">数量 <span id="sort02" ></span></a>
           <a href="javascript:demand_search(3);" id="sort3">需求总价 <span id="sort03"></span></a>

           <!-- 判断用户是否登录 -->

         
           <div class="guanzhu_dianj">+您关注的</div>
<!--            <a href="javascript:demand_search(4);" id="sort4">发布时间 <span id="sort04"></span></a> -->
       </div>

       <div class="needs_list_table">
           <ul style="height: 42px;line-height: 42px;background:#f6f6f6;">
               <li class="needs_list_table_li01">分类</li>
               <li class="needs_list_table_li02">需要产品</li>
               <li class="needs_list_table_li03">需求企业</li>
               <li class="needs_list_table_li04">联系方式</li>
               <li class="needs_list_table_li05">需求数量</li>
               <li class="needs_list_table_li06">需求总价</li>
               <li class="needs_list_table_li07">收货地区</li>
<!--                <li class="needs_list_table_li08">发布时间</li> -->
               <li class="needs_list_table_li09">&nbsp;</li>
           </ul>
           <?php 
              // echo '<pre>';
              //     var_dump($list);
              // echo '</pre>';
           ?>
            <?php if($list):?>
             <?php foreach ($list as $v){?>
           <ul class="needs_list_table_ul" style="line-height: 90px;">
               <li class="needs_list_table_li01" style="line-height: 15px;"><span style="display: block;margin-top: 35px;"><?php echo $v['name'];?></span></li>
               <li class="needs_list_table_li02" style="line-height: 15px;"><span style="display: block;margin-top: 35px;" id="<?php echo 'title_'.$v['id']?>"><?php echo $v['title'];?></span></li>
               <li class="needs_list_table_li03" style="line-height: 15px;"><span style="display: block;margin-top: 35px;"> <?php  echo $v['status']?mb_substr($v['corporation_name'],0,1).'*****'.mb_substr($v['corporation_name'],-1):"个人需求"; ?> </span></li>
               <li class="needs_list_table_li04"><span><?php echo substr($v['mobile'],0,4).'***'.substr($v['mobile'],-3);?></span></li>
               <li class="needs_list_table_li05"><span id="<?php echo 'p_count_'.$v['id']?>"><?php echo $v['p_count'];?><?php echo $v['unit'];?></span></li>
               <li class="needs_list_table_li06" style="line-height: 15px;"><span style="display: block;margin-top: 35px;" id="<?php echo 'price_'.$v['id']?>"><?php echo $v['total_price'];?>提货权</span></li>
               <li class="needs_list_table_li07" style="line-height: 15px;"><span style="display: block;margin-top: 35px;" id="<?php echo 'shippingaddress_'.$v['id']?>"><?php echo $v['province'].$v['city'].$v['district'];?></span></li>
<!--                <li class="needs_list_table_li08"><span> -->
               <?php 
//                $time = ceil((strtotime(date("Y-m-d H:i:s"))-strtotime($v['create_at']))/3600);
//                if($time<24){
//                    echo  $time."小时前";
//                }else if(($time/24)<30){
//                    echo ceil($time/24)."天前";
//                }else if(($time/24)>30){
//                    echo ceil(($time/24)/30)."个月前";
//                };?>
<!--                    </span></li> -->
               <li class="needs_list_table_li09" style="line-height: 15px;">

                   <a href="<?php echo site_url('member/demand/demand_detail').'/'.$v['id'];?>" class="needs_list_xiangqing01" target="_blank">查看详情</a>
                   <a href="javascript:barter(<?php echo $v['id']?>);" class="needs_list_xiangqing02"><span>我要换</span></a>
               </li>
           </ul>

           <?php };?>
           <div class="needs_list_table_num" style="height:96px;margin:0 auto;">
             <?php echo $page;?>
           </div>
           <?php else:?>
               <ul class="needs_list_table_ul" style="line-height: 90px;margin:0 auto;text-align:center">暂无数据</ul>
           <?php endif;?>

            <!-- <div class="needs_list_table_num"  style="height: 96px;">      
              <a href="javascript:void(0);" class="needs_list_table_num_active"><span>1</span></a>
              <a href="javascript:void(0);"><span>2</span></a>
              <a href="javascript:void(0);"><span>3</span></a>
              <a href="javascript:void(0);"><span>4</span></a>
              <a href="javascript:void(0);"><span>5</span></a>
              <a href="javascript:void(0);"><span>6</span></a>
              <a href="javascript:void(0);"><span>7</span></a>
              <a href="javascript:void(0);"><span>8</span></a>
              <a href="javascript:void(0);"><span>9</span></a>
              <a style="width: 58px;"><span>下一页</span></a> 
              <a style="width:43px;"><span>未页</span></a> 
              <a style="width:54px;border: none;margin-left: 0px;"><span>共100页</span></a>  -->
              
       </div>
       </div>
        
       <!-- 猜你喜欢 -->
        <div class="needs_list_youlove" hidden>
            <div class="needs_list_publish_title">
              <em></em><span>猜你喜欢:</span>
           </div>
           <div class="needs_list_youlove_main">
               <ul>
                   <li><a href="javascript:void(0);"><img src="images/needs_love01.png" alt="">
                     <span>尊荣外景特惠套餐High Fashion 定制造…</span>
                    </a>
                    <span class="needs_list_jiage">易货价:<span>50,000.00</span>提货权</span>  
                   </li>
                   <li style="padding-left: 15px;"><a href="javascript:void(0);"><img src="images/needs_love02.png" alt=""><span>
                      那片森林 咥水果 精品A套餐 绿色食品
                   </span></a>
                   <span class="needs_list_jiage">易货价:<span>298.00</span>提货权</span></li>
                   <li style="padding-left: 15px;"><a href="javascript:void(0);"><img src="images/needs_love03.png" alt=""><span>
                      西安冠杰广告媒体 21城电梯广告
                   </span></a>
                   <span class="needs_list_jiage">易货价:<span>8,000.00</span>提货权</span></li>
                   <li style="padding-left: 15px;"><a href="javascript:void(0);"><img src="images/needs_love04.png" alt=""><span>
                       杭州深林小座品牌餐厅
                   </span></a>
                   <span class="needs_list_jiage">易货价:<span>68.00</span>提货权</span></li>
               </ul>
           </div>
        </div> 
      

    </div><!-- 需求列表 结束 -->    

    <!-- 弹窗 -->
<div class="dingdan4_3_tanchuang" id="dingdan4_3_tanchuang03" style=" display:none;">
  <div class="dingdan4_4_tanchuang_con">
    <div class="dingdan4_4_tanchuang_top">商品分类<a href="javascript:calssify_off();" class="icon-guanbi" style="float:right;margin-top: 22px;margin-right: 25px;font-size: 20px;color:#999;"></a></div>
    <div class="dingdan4_4_tanchuang_top2">
      <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con">
            <div id="cate_1">
                        
                        <div id="selectCategoryDiv1" class="selectCategoryDiv"
                            style="height: 420px;margin-left: 4px;">
                            <div class="category-search">
                                <i><img src="images/search.png" width="17" height="17"></i> <input
                                    type="text" placeholder="输入名称" onkeyup="searchItem(this,1)">
                            </div>
                            <div class="categorySet">
                                <div id="0" class="categoryItem" onclick="getCategory(0)">
                                    <span>全部</span>
                                </div>
                                <?php foreach($categorys as $cates){?>
                                <div id="<?php echo $cates['id']?>" class="categoryItem" onclick="getCategory('<?php echo $cates["id"]?>',1,event)">
                                    <span><?php echo $cates['name']?></span>
                                    <?php if($cates["attr_set_id"] == 0){?>
                                    <div class="fa fa-angle-right hasSubCategory">></div>
                                    <?php }?>
                                  </div>
                                 <?php }?>
                            </div>
                        </div>
                        
                        <input type="hidden" name="cate_id" value="<?php echo $cateid?$cateid:0;?>"><!-- 分类id -->
                  
            </div>
       
          </div>
        </div>
           <div class="dingdan4_4_tanchuang_btn">
      <div class="dingdan4_4_btn01" style="background:#ccc;"><a href="javascript:calssify_off();">取消</a></div>
      <div class="dingdan4_4_btn02"><a href="javascript:calssify();" >确认</a></div>
      <input type="hidden" value="1" id="unbarter"><!-- 防止多次提交 -->
    </div>
      </div>
    </div>


     <!-- 弹窗 -->
    <div class="dingdan4_3_tanchuang " id="dingdan4_3_tanchuang02" style=" display:none;">
        <div class="dingdan4_4_tanchuang_con" style="margin:-349px 0 0 -480px;">
            <div class="dingdan4_4_tanchuang_top">我要换货<a href="javascript:barter_off();" class="icon-guanbi" style="float:right;margin-top: 22px;margin-right: 25px;font-size: 20px;color:#999;"></a></div>
                <div class="dingdan4_4_tanchuang_top2">
                  <div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con">
                        <div id="cate_1">
                            <div class="needs_tanchuang">需求产品： <span id="title_">法国拉菲传奇2014波尔多红葡萄酒750ml（双瓶装）</span></div><br>
                            <div class="needs_tanchuang">需求数量： <span id="p_count_">100件</span></div><br>
                            <div class="needs_tanchuang">需求总价： <span id="price_">1000～200000提货权</span></div><br>
                            <div class="needs_tanchuang">收货地区： <span id="shippingaddress_">广东广州</span></div><br>
                            <div class="needs_tanchuang">联系方式： <input type="text" value="" name="contactuser"> </div><br>
                            <div class="needs_tanchuang"><em style="opacity: 0;">测试</em>备注:  <textarea style="height:200px;width:430px;border: 1px solid #A2A2A2;outline: none;" name ="remark" ></textarea> </div> 
                
                             <div class="needs_tanchuang_dianhua">
                               <div class="needs_tanchuang_dianhua_text01">联系平台即有客服急速为您匹配换货商</div>
                               <div class="needs_tanchuang_dianhua_text02">客服电话：<span class="needs_tanchuang_dianhua_text03">400-0029-777</span></div>
                            </div> 
                        </div>
                
                
                   
                    </div>
                </div>
                <div class="dingdan4_4_tanchuang_btn">
                  <div class="dingdan4_4_btn01" style="background:#ccc;"><a href="javascript:barter_off();">取消</a></div>
                  <div class="dingdan4_4_btn02"><a id='tijiao'>确认</a></div>
                </div>
        </div>
    </div>

    <!--通用操作 弹窗start-->
    <div class="dingdan4_3_tanchuang"  style='display:none'; id="authentication">
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">温馨提示</div>
          <div class="dingdan4_3_tanchuang_top2">
              <p id='prompt'>您的账户未通过企业认证，企业认证能够更好的帮助您</p>
              <p>找到想要的产品</p>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01" style="background:#ccc;margin-left: 200px;"><a href="<?php echo site_url('member/demand/add_list');?>">继续发布</a></div>
              <div class="dingdan4_3_btn02"><a href="<?php echo site_url('customer/save_step2');?>" id="sure">前去认证</a></div>       
          </div>
      </div>
    </div>
    <!--通用操作 弹窗end-->

</div>



 <!--关注弹窗-->
        <div class="follow_bg">
            <div class="follow_top">
              <div class="follow_nei">
               <h5>添加关注</h5>
              <div class="follow_nei_li">
               <div class="follow_nei_li_left">
                 <div class="follow_nei_li_input">
                <i class="icon-find"></i>
               <input type="text" oninput="search_label(this)" name="keyword" class="follow_input" id="follow_input_keyword" placeholder="请输入您想关注的标签" value="">
               </div> 
               
               </div>
               <script type="text/javascript">

                 //  $customer_label_id
                  var customer_label_id = new Array();
                  <?php foreach($customer_label_id as $val):?>
                    customer_label_id.push('<?php echo $val;?>');
                  <?php endforeach;?>
              
                   

                  // function label_dianji(e)
                  // {

                  //   $(e).toggleClass("follow_bottom_ul_d");  
                  //   var labelid =  $(e).attr("value");
                  //       var index = $.inArray(labelid,label);
                  //       if(index >=0){
                  //         label.splice(index,1);
                  //       }else{
                  //           label.push(labelid);
                  //       }
                  //       // console.log(label);
                  // } 
               </script>
               <div class="follow_bottom">
                <h6>关注标签</h6> 
              
               
               <ul class="follow_bottom_ul">
                <?php foreach($label as $val):?>
                  <li value="<?=$val['id']?>" class="<?php if(in_array($val['id'],$customer_label_id)) echo 'follow_bottom_ul_d' ?>"><?php echo $val['name'];?></li>
                <?php endforeach;?>
                 <!-- <li>食品</li>
                 <li>食品</li>
                 <li>食品</li>
                 <li>食品</li>
                 <li>食品</li>
                 <li>食品</li>
                 <li>食品</li>
                 <li>食品</li>
                 <li>食品</li> -->
               </ul>
               <div class="follow_bottom_di">
                 <a class="follow_bottom_di_left" type="button" href="javascript:();" onclick="ehw_demand_submit()">确认</a>
                 <a class="follow_bottom_di_figth" href="javascript:();" onclick="ehw_demand_reset()">取消</a>
               </div>
               </div>
              </div>
              </div>
            </div>
        </div>
<script type="text/javascript">

     //标签搜索
    function search_label(obj)
    {
        var val = $.trim($(obj).val());
        
        if( val != "" )
        {
            $('ul.follow_bottom_ul').find("li").each(function(){
                if($(this).html().toLowerCase().indexOf(val.toLowerCase())>-1)
                {
                    $(this).show();
                }else
                {
                    $(this).hide();
                }
            });
        }else
        {
          $('ul.follow_bottom_ul').find("li").show();
        }
    }

    var label = new Array(); //记录选中的标签ID-节点操作记录。

    $(".follow_bottom_ul  li").on('click',function(){
      var label_id = $(this).attr('value');
      var index = $.inArray(label_id,label);

      if(index >=0){
          label.splice(index,1);
      }else{
          if(label.length < 3){

              label.push(label_id);
          }else{
              return false;
          }
          
      }
          // console.log(label);
            
    });

  // 取消
  function ehw_demand_reset()
  {   
   
      $("#follow_input_keyword").val(" ");

      $('ul.follow_bottom_ul').find("li").show();

      // 清空已经选中标签
      label = [];

      // 清空选中状态样式
      $('ul.follow_bottom_ul').find("li").each(function(){
          $(this).removeClass("follow_bottom_ul_d");
      });

      // 恢复已经关注样式状态
      $('ul.follow_bottom_ul').find("li").each(function(){
          if($.inArray($(this).attr("value"), customer_label_id) > -1){
              $(this).addClass("follow_bottom_ul_d");
          }
      });


      $(".follow_bg").hide();
  }


  //确认添加
  function ehw_demand_submit()
  {   
	   
     console.log(label);
      var label_list_id = label;
     
      var html = '';

      var length = label_list_id.length;
      label_list_id = JSON.stringify(label_list_id);

      if(length  > 0){
        $.post(
          "<?php echo site_url('member/demand/add_customer_label');?>",
          {label_id:label_list_id},function(data){
            // console.log(data);
         
          },
        
        'json');


      }
     
      window.location.reload();
      $(".follow_bg").hide();  
      
  }
</script>
<!--<script src="js/jquery.min.js"></script>-->
<script>
    $pages = $(".pages").children().children("a");
    $pages.mouseover(function(){
       $(this).children().css("background","#ffedd9");
    }).mouseout(function(){
       $(this).children().css("background","#fff");
    })
    $link = $(".footer_link").children("ul").children();
    $link.mouseover(function(){
       $data = $(this).children().html();
        $(this).children().html("<u>"+$data+"</ul>");
    }).mouseout(function(){
         $(this).children().html($data);
    })
</script>

<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>

<!-- 鼠标触摸发布需求 -->
<script>
$(function () {
    var navLi=$(".needs_list_publish_tu .needs_list01");
    navLi.mouseover(function () {
        $(this).find(".needs_list_button").css("display","block"); 
        $(this).find(".needs_list_text").css("margin-top","35px")
    })
    navLi.mouseleave(function(){
        $(this).find(".needs_list_button").css("display","none");  
        $(this).find(".needs_list_text").css("margin-top","63px")
    })

    <?php if(!empty($sort)){?>
        switch(<?php echo $sort;?>){
            case 1:
                $("#sort1").attr('href',"javascript:demand_search(5)").addClass("needs_list_main_active");
                break;
            case 2:
            	$("#sort2").attr('href',"javascript:demand_search(6)").addClass("needs_list_main_active");
            	 $("#sort02").addClass("icon-xiangxiajiantou1");
                break;
            case 3:
            	$("#sort3").attr('href',"javascript:demand_search(7)").addClass("needs_list_main_active");
            	 $("#sort03").addClass("icon-xiangxiajiantou1");
                break;
            case 4:
            	$("#sort4").attr('href',"javascript:demand_search(8)").addClass("needs_list_main_active");
            	 $("#sort04").addClass("icon-xiangxiajiantou1");
                break;
            case 5:
            	$("#sort1").addClass("needs_list_main_active");
                break;
            case 6:
            	$("#sort2").addClass("needs_list_main_active");
            	$("#sort02").addClass("icon-xiangshang");
                break;
            case 7:
            	$("#sort3").addClass("needs_list_main_active");
            	$("#sort03").addClass("icon-xiangshang");
                break;
            case 8:
            	$("#sort4").addClass("needs_list_main_active");
            	$("#sort04").addClass("icon-xiangshang");
                break;
        }
    <?php }else{?>
    	$("#sort1").attr('href',"javascript:demand_search(5)").addClass("needs_list_main_active");
    <?php };?>

  
    // calssify(<?php //echo $cateid;?>);
    <?php if(isset($cateid)){?>
      
      switch(<?php echo $cateid;?>){

          case 189:
              $("#restaurant").addClass("header_left_active");
                 // console.log(1);return false;
              break;
          case 1696:
          	 $("#hotel").addClass("header_left_active");
             // console.log(2);return false;
              break;
          case 99999:
            $("#tuijian").addClass("header_left_active");
            
            break;
          default:
              $("#new").addClass("header_left_active");
              break;

      }
    <?php }else{?>

      <?php if($this->session->userdata('user_id')):?>
        $("#tuijian").addClass("header_left_active");
        <?php if(isset($offset) && $offset != 0):?>
        calssify('99999');
        <?php endif;?>
      <?php else:?>
        $("#new").addClass("header_left_active");
        <?php if(isset($offset) && $offset != 0):?>
        calssify('0');
        <?php endif;?>
      <?php endif;?>
    <?php };?>
    
})
</script>


<script type="text/javascript">
    // 页数切换
      $(".needs_list_table_num a").on("click", function() {
        var index = $(this).index();
        $(this).addClass("needs_list_table_num_active").siblings().removeClass("needs_list_table_num_active");
    })
    // 弹窗
    $(".needs_list_header_right a").on("click",function(){
       $("#dingdan4_3_tanchuang03").show();
    })


 $(".follow_bg").hide();
$(".guanzhu_dianj ").on("click",function(){
  var userid = "<?php echo $this->session->userdata ('user_in')?>";
  
  if(!userid){
    window.location.href="<?php echo site_url('customer/login');?>";
    return false;
  }

    $(".follow_bg").show();
	  $(".follow_bg").css("opacity","1");
  });
<!--点击弹窗列表-->
 var values = $(".follow_bottom_ul_d").length;
     // $(".follow_bottom_di_left").css("background", "grey");
     // $(".follow_bottom_di_left").attr("onclick","");
  $(".follow_bottom_ul li").on("click",function(){
    $(this).toggleClass("follow_bottom_ul_d");
 
       var values = $(".follow_bottom_ul_d").length;

       $(".follow_bottom_di_left").css("background", "#72c312");
       $(".follow_bottom_di_left").attr("onclick","ehw_demand_submit()");

       // if(values < 1){
       //     // $(".follow_bottom_di_left").css("background", "grey"); 
       //     // $(".follow_bottom_di_left").attr("onclick","");
       // }else{
       //     $(".follow_bottom_di_left").css("background", "#72c312");
       //     $(".follow_bottom_di_left").attr("onclick","ehw_demand_submit()");
       // }
      
   
  })
   
</script>

<script>
var navTxtArray = new Array();
var navIDArray = new Array();
function getCategory(id,level,event)
{  
	
    //去掉样式
    if (event instanceof jQuery == false) {
        event = event ? event : window.event;
        var eventSrc = event.srcElement ? event.srcElement : event.target;
        var $eventSrc = $(eventSrc);
        if ($eventSrc.attr("class") == "hasSubCategory" || $eventSrc[0].tagName == 'SPAN') {
            $eventSrc = $eventSrc.parent();
        }
    } else {
        $eventSrc = event;
    }

    $eventSrc.siblings().removeClass("categoryItemClick");
    $eventSrc.addClass("categoryItemClick");
    
    
    navTxtArray[level-1] = $.trim($eventSrc.text());
    navIDArray[level-1] = $eventSrc.attr("id");
	//alert(navTxtArray.length);

	for(var i=level;i<navIDArray.length;i++)
	{
		//alert(navTxtArray[i]+"88888");
		//alert(navIDArray[i]+"^^^^^");
		navTxtArray.splice(i,1);
		navIDArray.splice(i,1);
	}

	//alert(navTxtArray);
	var s = "";
	$('#navigation').find('li').remove();
	for(var i=0;i<navTxtArray.length;i++)
	{
		$('#navigation').append('<li>'+navTxtArray[i]+'</li>');
	}
	
    //全部
    if(id==0){
    	$("input[name=cate_id]").val(0);
    	return;
	    }
    
	//处理数据
	if(level<=5)
	{
		
		for(var i=level+1;i<=5;i++)
		{
			$('#cate_'+i).remove();
		}
	
	$.post('<?php echo site_url('member/demand/getChildCategory')?>',{"id":id},function(data){
		
		for(var i=level+1;i<=5;i++)
		{
			$('#cate_'+i).remove();
		}
		if(data.length>2)
		{ 
			
			var result = JSON.parse(data);
			var str = '<div  id="cate_'+(level+1)+'"><div id="selectCategoryDiv1" class="selectCategoryDiv" style="height: 420px;"><div class="category-search"><i class="icon-search-tabao  fa fa-search"></i><input type="text" placeholder="输入名称"  onkeyup="searchItem(this,'+(level+1)+')"></div>'+
				'<div class="categorySet" >';
				for(var i=0;i<result.length;i++)
				{
					str = str+'<div id="'+result[i]["id"]+'" class="categoryItem" onclick=getCategory('+result[i]["id"]+','+(level+1)+',event)>'+
						'<span>'+result[i]["name"]+'</span>';
					if(result[i]["attr_set_id"] ==0)
					{
						str = str+'<div class="fa fa-angle-right hasSubCategory"></div>';
					}
						str = str+'</div>';
				}
				
			
			str = str+'</div></div></div>';
			$('#cate_'+level).after(str);
		}


		$("input[name=cate_id]").val(id);
		
	} );
	}
}



//分类搜索
function searchItem(obj,item)
{
	var val = $.trim($(obj).val());
	if( val != "" )
	{
		$('#cate_'+item).find("span").each(function(){
			if($(this).html().indexOf(val)>-1){
				$(this).parent("div").show();
			}else
			{
				$(this).parent("div").hide();
			}
		});
	}else
	{
		$('#cate_'+item).find("span").each(function(){
			$(this).parent("div").show();
		});
	}
}
</script>
	
<script type="text/javascript">

//筛选分类
function calssify(cateid){

    if(cateid){
 	   $("input[name=cate_id]").val(cateid);
    }else{
 	   cateid =$("input[name=cate_id]").val();
    }
    if(!cateid){
        alert('请选择分类');
        return ;
    }
    keyword = $("input[name=keyword]").val("");
    demand_search(1);
}

//取消筛选分类
function calssify_off(){
    $("#dingdan4_3_tanchuang03").hide();
    }

//搜索
function lookup(){

	keyword = $("input[name=keyword]").val();
    if(!keyword || keyword==""){
    	alert('请输入搜索内容');
    	return ;
    }
    demand_search(1);
}

//执行搜索并且筛选分类
function demand_search(sort){
	cateid =$("input[name=cate_id]").val();
	keyword = $("input[name=keyword]").val();
	window.location.href="<?php echo site_url('member/demand/demand_list?cateid=');?>"+cateid+'&'+'keyword='+keyword+'&sort='+sort;
    }

//换货弹窗
function barter(id){
	url = 'member/demand/demand_list';
	//判断登录
	$.post("<?php echo site_url('member/demand/check_login');?>",{url:url},function(data){
		if(data){
		    $("#title_").html($("#title_"+id).text());
		    $("#p_count_").html($("#p_count_"+id).text());
		    $("#price_").html($("#price_"+id).text());
		    $("#shippingaddress_").html($("#shippingaddress_"+id).text());
		    $("#tijiao").attr("href","javascript:barter_sure("+id+")");
		    $("#dingdan4_3_tanchuang02").css("display","block");
			}else{
				window.location.href="<?php echo site_url('customer/login');?>";
				}
		});
    }

//确认换货
function barter_sure(id){
	url = 'member/demand/demand_list';
	//判断登录
	if($("#unbarter").val()=='1'){
	$("#unbarter").val(0);
	$.post("<?php echo site_url('member/demand/check_login');?>",{url:url},function(data){
		if(data){
    			remark = $("textarea[name=remark]").val();
    			contactuser = $("input[name=contactuser]").val();
    			if(contactuser.search(/^1[34578]\d{9}$/)==-1){
    				if(contactuser.search(/^([0-9]{3,4}-)?[0-9]{7,8}$/)==-1){
    		        	alert('请输入正确的联系方式');
    		        	$("#unbarter").val(1);
    		            return false;
    		            }
    		    }
    
    		    $.post("<?php echo site_url('member/demand/barter');?>",{remark:remark,contactuser:contactuser,requirement_id:id},function(data){
    		        alert(data);
    		        barter_off();
    		        })
			}else{
				window.location.href="<?php echo site_url('customer/login');?>";
				}
		});
	}

}

//取消换货
function barter_off(){
	$("#unbarter").val(1);
	$("#dingdan4_3_tanchuang02").css("display","none");
    }

//发布需求
function add_list(){
	url = 'member/demand/demand_list';
	//判断登录
	$.post("<?php echo site_url('member/demand/check_login');?>",{url:url},function(data){
    		if(data){
    			corp_id = "<?php echo $this->session->userdata('corporation_id');?>";
    			if(corp_id != 0){
    				window.location.href="<?php echo site_url('member/demand/add_list');?>";
    			}else{
    				$("#authentication").show();
    			}
    		    
    		}else{
    			window.location.href="<?php echo site_url('customer/login');?>";
    		}
		});
}



</script>

	





