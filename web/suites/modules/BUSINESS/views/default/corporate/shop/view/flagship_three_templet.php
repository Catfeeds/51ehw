<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="css/fancymain.css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">
<link href="css/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/style_v2.css" rel="stylesheet" type="text/css">
<link href="css/store.css" rel="stylesheet" type="text/css">
<link href="css/guanjie_tem.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script><!--日期插件-->
<script type="text/javascript" src="js/jquery.easie.js"></script>
<script type="text/javascript" src="js/my.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.1.pack.js"></script>
<script src="js/ajaxfileupload.js" type="text/javascript"></script>
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--banner图片切换-->
<title>51易货网</title>
</head>

<style>
.eh_banner{}
.banner{ height:435px;margin:0px auto; overflow:hidden;}
/* fullSlide */
.fullSlide{width:100%;position:relative;height:435px;}
.bd {left: 0px!important;}
.fullSlide .bd{margin:0 auto;position:relative;z-index:0;overflow:hidden;}
.fullSlide .bd ul{width:100% !important;}
.fullSlide .bd li{width:100% !important;height:435px;overflow:hidden;text-align:center;background:#fff center 0 no-repeat;}
.fullSlide .bd li a{display:block;height:435px;}
.fullSlide .hd1{width:100%;position:absolute;z-index:1;bottom:0;left:0;height:30px;line-height:30px;}
.fullSlide .hd1 ul{text-align:center;}
.fullSlide .hd1 ul li{cursor:pointer; display:inline-flex;zoom:1;width:10px;height:10px;margin:1px;overflow:hidden;background:#fff; border-radius:10px;line-height:999px;}
.fullSlide .hd1 ul .on{border:2px solid #fff;background:none; line-height:999px;}
.fullSlide .prev,.fullSlide .next{display:block;position:absolute;z-index:1;top:50%;margin-top:-30px;left:10%;z-index:1;width:40px;height:60px;background:url(images/culture/slider-arrow.png) -126px -137px #000 no-repeat;cursor:pointer;filter:alpha(opacity=50);opacity:0.5;display:none;}
.fullSlide .next{left:auto;right:10%;background-position:-6px -137px;}
.vertisement1{ width:1200px; margin:30px auto; height:60px; }

/*21城市旗舰店*/
.city_header {  width: 100%;height: 45px;}
.header_nav {border-bottom: 1px solid #EAEAEA;margin: 0px auto;height: 45px;background-color: white;width: 1200px;border: 1px solid white;}
.header_nav a {position: relative;display: inline-block;font-size: 14px;color: #000000;width: 150px;border-bottom: 1px solid #EAEAEA;text-align: center;padding-bottom: 12px;}
.nav_active {color: red!important;border-bottom-color: red!important;}
.flagship_store_main01 {margin: 30px auto;background-color: white;width: 1200px;border: 1px solid white;}
.city_flagship_nav ul li {float:left;}
.flagship_guanggao_right {color: #606060;margin-top: 8px;font-size: 14px;}
.flagship_time {width:26px;height:36px;border:1px solid #313131;background-color:#313131;border-radius: 2px;color: white;margin-left: 5px; }
.flagship_store_main02 {background-color: #CCE6EC;width: 100%;}
.flagship_store_dayday {margin: 0px auto;width: 1200px;}
.flagship_store_main03 {margin: 30px auto;background-color: white;width: 1200px;border: 1px solid white;}
.flagship_store_main03 ul {overflow: hidden;}
.flagship_store_main03 ul li {float:left;}
.flagship_store_main04 {background-color: #FBEDD5;width: 100%;}
.flagship_store_shangou {margin: 00px auto;width: 1200px;}
.flagship_store_shangou ul {overflow: hidden;}
.flagship_store_shangou ul li {float:left;}

/*21城模版*/
.content-one {margin: 40px auto;width: 1200px;}
.liebiao-left2 ul{ overflow: hidden; margin-left: -28px;}
.liebiao-left2 ul li{ float: left; margin-left: 29px;}
.content-one-liebiao ul li { display: inline-block;}
.content-one-liebiao ul li img {border: 1px solid #D8D8D8;}
.content-one-liebiao ul li span {text-align: center;color: #434343;}
.liebiao-left {margin-left: 25px;}
.monery-num {display: inline-block!important;color: #D1332A!important;position: absolute;}
.liebiao-text {font-size: 16px;color: #000000!important;padding-top: 10px;width: 278px;display:block;overflow:hidden;word-break:keep-all;white-space:nowrap;text-overflow:ellipsis;}
.liebiao-text1 {text-align: center;position: relative;}
.liebiao-text2 {width: 120px;display:inline-block;overflow:hidden;word-break:keep-all;white-space:nowrap;text-overflow:ellipsis;margin-left: -48px;}
.content-line1 {display: inline-block;border: 1px solid #707070;width: 515px;}
.line-text {font-size: 16px;display: inline-block;padding: 0 50px;color: #D84D44;}
.liebiao2-left {margin-left: 56px;}
.liebiao3-left {margin-left:29px;float: left;}
.content-two-liebiao ul li {position: relative;}
.content-state {position: absolute;top: 50%;right: 2px;margin-top: -197.5px;width: 290px;height: 295px;background:rgba(255,255,255,0.8);}
.content-state span {display: block;text-align: left!important;margin-left: 64px;}
.content-state-text1 {margin-top: 60px;font-size: 18px;color: #4F4F50!important;}
.content-state-text2 {font-size: 24px;color: #000000;}
.content-state-num {margin-top: 10px;font-size: 30px;color: #D1332A!important;}
.content-state-but {font-weight: bold;width: 142px;height: 50px;line-height: 50px;display: block;text-align: center;margin-left: 60px;margin-top: 5px;font-size: 28px;background: #FEE612;color: #D1332A;}
.content-state a:hover {color: #D1332A;}
.content-three-liebiao ul li img {border: 1px solid #D8D8D8;}
.content-three-liebiao-text {width: 278px;border: 1px solid #D1352D;line-height: 37px;height: 37px;text-align: center;font-size: 19px;color: #D1352D;overflow:hidden;word-break:keep-all;white-space:nowrap;text-overflow:ellipsis;}
.content-one img {border: 1px solid #D8D8D8;}
.new-goods-liebiao ul li {display: inline-block;}
.new-goods-title {font-size: 18px;color: #D1352D;font-weight: bold;}
.new-goods-liebiao-left {margin-left: 16px;}
.new-goods-text {font-size: 15px;width: 285px;display: -webkit-box;overflow: hidden;text-align: left;line-height: 19px;-webkit-line-clamp: 2;-webkit-box-orient: vertical;color: #000000;margin-top: 5px;}
.new-goods-num {display: block;margin-top: 10px;color: #D70619;}
.city_header2 {margin: 0px auto;height: 100px;background-color: white;width: 1920px;border: 1px solid white;position: relative;left: 50%;margin-left: -960px;}
.nav_active .nav-icon {position: absolute;top: 20px;left: 50%;margin-left: -11px;display: block!important;font-size: 23px;}
.headEdit_btnLeft{height:60px;}
.headEdit_btnRight{height:60px;}
.new-goods-top {margin-top: 20px;}

.macth_xv_nav li.macth_liactive a {background-color: #fff;color: #D1332A;}



</style>

</head>

<body>


<!--页头编辑 开始-->
    <div class="store_headEdit" style="position:relative;">
      <div class="store_headEdit_con">
          <div class="headEdit_btnLeft">
              <ul>
              <?php  if($this->session->userdata['corporation_id'] == 157 ):?>
                  <li><a href="<?php echo site_url('flagship/select_flagship_temp');?>" class="btn_pageEdit ">旗舰店模板</a></li>
              <?php endif;?>
              <li><a href="<?php echo site_url('corporate/myshop/renovate');?>" class="btn_pageEdit">模板一</a><li>
              <li><a href="<?php echo site_url('corporate/myshop/select_goods_temp');?>" class="btn_pageEdit">模板二</a><li>
                    <li><a href="<?php echo site_url('corporate/myshop/select_three_temp');?>" class="btn_pageEdit">模板三</a><li>
                            
                    
                           
                </ul>
            </div>
            <div class="headEdit_btnRight" style="margin-right: -100px">
              <ul>
                  <li><a onclick="javascript:resetTemplate()" class="btn_pageSave">重置</a></li>
                <li><a href="<?php echo site_url('flagship/inspect_flagship_three_temp')?>" class="btn_pagePreview">预览</a></li>
                  <li><a href="javascript:;" onclick="javascript:publishTemp()" class="btn_pageRelease">发布</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--页头编辑 结束-->
   <!-- 头部开始 -->


     <div class="city_header2 hover_it" id="top">
         <a href='<?php echo isset($list["top"]) ? $list["top"]['link_path'] : ''?>'><img src="<?php echo isset($list['top']['img_path']) ? IMAGE_URL.$list['top']['img_path']: 'images/culture/21top.png';?>" width='1920' height='100' alt=""/></a>
        
           <div class="editCon">
            <div class="editBtnCon clearfix">
              <a href="javascript:;" class="editBtn" onclick="edit('top')">编辑</a>
            </div>
        </div>
        <!--编辑区 结束-->
      </div>
   
        
         <!--头部导航条 开始--><!-- 冠杰头部变底色 guanjie_tem.css -->
    <div class="eh_navbar1 clearfix hover_it column-color" style="position: relative;  <?php echo isset($list['column-color']['desc']) ? 'background:'.$list['column-color']['desc'] : '' ?>">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu" style=" background:none">
                <!--左侧导航 start-->
                <div class="macth_xv_categorys column-color" style="background:<?php echo isset($list['column-color']['desc']) ? $list['column-color']['desc'] : '#D1332A' ?>">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="javascript:;">本店所有商品<b class="icon-select"></b></a></h2>
                    </div>
                    
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu517">
<!--                                 <h3> -->
                                    <!-- <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">精品上衣</a></span><s style="display: block;"></s> -->
<!--                                 </h3>  -->
                            </li>

                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                 <ul class="macth_xv_nav">
                    <li ><a href="javascript:void(0);">首页</a></li>
                    <?php for($i=0; $i<5; $i++):?>
                    <li><a href=""><?php echo isset($list["railing-title_$i"]) ? $list["railing-title_$i"]['desc']: '分类'?></a></li><!--默认五个分类-->
                    <?php endfor;?>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>

         <!--编辑区 开始-->
        <div class="editCon">
        
            <div class="editBtnCon clearfix"> 
                <a href="javascript:;" class="addFloorBtn" onclick="edit_color('column-color')" style="margin-bottom:20px;">编辑背景颜色</a>
                <a href="javascript:;" class="editBtn" onclick="$('.fancybox1').show()" style="margin-bottom:20px;">编辑分类</a>
            </div>
        </div>
        <!--编辑区 结束-->
    </div> 




                   
           
    </div><!-- 头部结束 -->
   <!-- 广告图开始 -->
    <div class="fullSlide hover_it">
    <div class="painting_banner1">
    <div class="bd">
    <ul>
      <?php for($i=1;$i<5; $i++):?>
      <li _src="url(<?php echo isset($list["carousel-img_$i"]['img_path']) ? IMAGE_URL.$list["carousel-img_$i"]['img_path'] : 'images/culture/21banner.png'?>)" id="carousel-img_<?php echo $i?>" id="carousel-img_<?php echo $i?>"><a href=""></a></li>
      <?php endfor;?>
    </ul>
   </div>
   <div class="hd1"><ul style="height: 30px;"></ul></div>
    <span class="prev"></span>
    <span class="next"></span>
   </div>

 <!--编辑区 开始-->
        <div class="editCon">
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img_1')">编辑轮播图一</a></div>
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img_2')">编辑轮播图二</a></div> 
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img_3')">编辑轮播图三</a></div> 
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img_4')">编辑轮播图四</a></div>        
        </div>
        <!--编辑区 结束-->

   </div>  <!-- 广告图结束 --> 

   <!-- 内容列表一 开始 -->
  <div class="content-one">
     <div class="content-one-liebiao liebiao-left2">
        <ul>
            <?php for($i = 1; $i<5; $i++):?>
            <li class="<?php echo $i != 1 ? 'liebiao-left':''?> hover_it" style="position: relative" id="one-product_<?php echo $i;?>">
                <a href="<?php echo isset($list["one-product_$i"]['link_path']) ? $list["one-product_$i"]['link_path'] : ''?>">
                    <img src="<?php echo isset($list["one-product_$i"]['img_path']) ? IMAGE_URL.$list["one-product_$i"]['img_path'] : 'images/culture/21pic01.png'?>" width="276" height="368">
                    <span class="liebiao-text"><?php echo isset($list["one-product_$i"]['desc']) ? $list["one-product_$i"]['desc'] : '商品名称'?></span>
                    <div class="liebiao-text1">
                        <span class="liebiao-text2"><?php echo isset($list["one-product_$i"]['brief_statement']) ? $list["one-product_$i"]['brief_statement'] : '商品描述'?></span>
                        <span class="monery-num">M <?php echo isset($list["one-product_$i"]['vip_price']) ? $list["one-product_$i"]['vip_price'] : '0.00'?></span>
                    </div>
                </a>
                   <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="menu('one-product_<?php echo $i?>')">编辑</a>
                    </div>
                   <!--编辑区 结束-->
            </li>
            <?php endfor;?>  
        </ul>

        
     </div>
  </div>
   <!-- 内容列表一 结束 -->

   <!-- 新款上市 -->
   <div class="content-one">
     <div class="hover_it" style="position: relative" id="menu-product">
       <span class="content-line1" ></span><span class="line-text" id="title-one"><?php echo isset($list['title-one']['desc']) ? $list['title-one']['desc'] : '编辑标题'?></span><span class="content-line1"></span>
          <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="biaoti('title-one')">编辑</a>
                    </div>
                   <!--编辑区 结束-->
     </div>
   </div>

   <!-- 内容列表二 开始 -->
   <div class="content-one">
      <div class="content-one-liebiao content-two-liebiao">
        <ul>
        <?php for($i = 1; $i<3; $i++):?>
            <li class="<?php echo $i==2 ? 'liebiao2-left':''?> hover_it" style="position: relative" id="two-product_<?php echo $i;?>">
            <a href="<?php echo isset($list["two-product_$i"]['link_path']) ? $list["two-product_$i"]['link_path'] : ''?>">
            <img src="<?php echo isset($list["two-product_$i"]['img_path']) ? IMAGE_URL.$list["two-product_$i"]['img_path'] :'images/culture/21pic02.png'?>" width="568px"; height="768px";>
                <div class="content-state">
                    <span class="content-state-text2"><?php echo isset($list["two-product_$i"]['desc']) ? $list["two-product_$i"]['desc'] : '商品名称'?></span>
                    <span class="content-state-text" style="font-size:18px;"><?php echo isset($list["two-product_$i"]['brief_statement']) ? $list["two-product_$i"]['brief_statement'] : '商品描述'?></span>
                    <span class="content-state-num">M <?php echo isset($list["two-product_$i"]['vip_price']) ? $list["two-product_$i"]['vip_price'] : '0.00'?></span>
                    <a href="#" class="content-state-but">立即购买</a>
                </div>
            </a>
                   <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="menu('two-product_<?php echo $i?>')">编辑</a>
                    </div>
                   <!--编辑区 结束-->

            </li>
        <?php endfor;?>
          
        </ul>
      </div>

   </div>
    <!-- 内容列表二 结束 -->

    <!-- 内容列表三 开始 -->
   <div class="content-one">
      <div class="content-one-liebiao content-three-liebiao">
        <ul style="margin-left: -30px;">
            <?php for($i=1;$i<5;$i++):?>
            <li class="<?php echo $i != 1 ? 'liebiao3-left' :''?> hover_it" id="three-product_<?php echo $i?>" style="position: relative;margin-left: 23px;">
            <a href="<?php echo isset($list["three-product_$i"]['link_path']) ? $list["three-product_$i"]['link_path'] : ''?>">
            <img src="<?php echo isset($list["three-product_$i"]['img_path']) ? IMAGE_URL.$list["three-product_$i"]['img_path'] : 'images/culture/21pic03.png'?> " width="278px;" height="278px;">
            
            <div class="content-three-liebiao-text"><span style="color:#D1352D;"><?php echo isset($list["three-product_$i"]['desc']) ? $list["three-product_$i"]['desc'] : '商品名称'?></span></div>
            </a>
                <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="waitao('three-product_<?php echo $i?>')">编辑</a>
                    </div>
                   <!--编辑区 结束-->
            </li>
            <?php endfor;?>
        </ul>
      </div>

   </div>
    <!-- 内容列表三 结束 -->

    <!-- 广告图 开始 -->
    <div class="content-one hover_it" id="mid" style="position: relative">
      <a href='<?php echo isset($list["mid"]) ? $list["mid"]['link_path'] : ''?>'><img src="<?php echo isset($list['mid']['img_path']) ? IMAGE_URL.$list['mid']['img_path']: 'images/culture/21midbanner.png';?>" width='1200' height='250' alt=""/></a>
          <div class="editCon">
            <div class="editBtnCon clearfix">
              <a href="javascript:;" class="editBtn" onclick="edit('mid')">编辑</a>
            </div>
        </div>
        <!--编辑区 结束-->
    </div>
    <!-- 广告图 结束 -->

    <!-- 新品上市1 开始 -->
    <div class="content-one" style="margin-top:20px">
       <div class="new-goods-title hover_it"  style="position: relative; height:35px"><span id="title-two"><?php echo isset($list['title-two']['desc']) ? $list['title-two']['desc'] : '编辑标题'?></span>
                  <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="biaoti('title-two')" >编辑</a>
                    </div>
                   <!--编辑区 结束-->
     
     
       </div>
       <div class="new-goods-liebiao  new-goods-top">
         <ul>
             <?php for($i =1 ;$i<9; $i++):?>
             <li class="<?php  if($i !=1 && $i != 5){echo 'new-goods-liebiao-left';}?>  hover_it"  id="one-title-product_<?php echo $i?>" style=" position: relative">
             <a href="<?php echo isset($list["one-title-product_$i"]['link_path']) ? $list["one-title-product_$i"]['link_path']: '' ?>">
                 <img src="<?php echo isset($list["one-title-product_$i"]['img_path']) ? IMAGE_URL.$list["one-title-product_$i"]['img_path']: 'images/culture/21pic04.png' ?>" width="283px;" height="283px;">
                 <div class="new-goods-text"><span><?php echo isset($list["one-title-product_$i"]['desc']) ? $list["one-title-product_$i"]['desc']: '商品名称' ?></span></div>
                 <span class="new-goods-num">M <?php echo isset($list["one-title-product_$i"]['vip_price']) ? $list["one-title-product_$i"]['vip_price']: '0.00' ?></span>
             </a>
             <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="rexiao('one-title-product_<?php echo $i?>')">编辑</a>
                    </div>
                   <!--编辑区 结束-->

             </li>
             <?php endfor;?>
        </ul>
       </div>
    </div>
    <!-- 新品上市1 结束 -->

    <!-- 新品上市2 开始 -->
     <div class="content-one" style="margin-top:20px">
      <div class="new-goods-title hover_it" id="menu-product1" style="position: relative; height:35px"><span id="title-three"><?php echo isset($list['title-three']['desc']) ? $list['title-three']['desc'] : '编辑标题'?></span>
                  <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="biaoti('title-three')" >编辑</a>
                    </div>
                   <!--编辑区 结束-->
     
       </div>
       <div class="new-goods-liebiao  new-goods-top">
         <ul>
             <?php for($i =1 ;$i<9; $i++):?>
             <li class="<?php  if($i !=1 && $i != 5){echo 'new-goods-liebiao-left';}?>  hover_it"  id="two-title-product_<?php echo $i?>" style=" position: relative">
             <a href="<?php echo isset($list["two-title-product_$i"]['link_path']) ? $list["two-title-product_$i"]['link_path']: '' ?>">
                 <img src="<?php echo isset($list["two-title-product_$i"]['img_path']) ? IMAGE_URL.$list["two-title-product_$i"]['img_path']: 'images/culture/21pic04.png' ?>" width="283px;" height="283px;">
                 <div class="new-goods-text"><span><?php echo isset($list["two-title-product_$i"]['desc']) ? $list["two-title-product_$i"]['desc']: '商品名称' ?></span></div>
                 <span class="new-goods-num">M <?php echo isset($list["two-title-product_$i"]['vip_price']) ? $list["two-title-product_$i"]['vip_price']: '0.00' ?></span>
             </a>
             <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="rexiao('two-title-product_<?php echo $i?>')">编辑</a>
                    </div>
                   <!--编辑区 结束-->

             </li>
             <?php endfor;?>
         </ul>
       </div>
    </div>
    <!-- 新品上市2 结束 -->

    <!-- 新品上市3 开始 -->
     <div class="content-one" style="margin-top:20px">
       <div class="new-goods-title hover_it" id="menu-product1" style="position: relative; height:35px" id="title-four"><span id="title-four"><?php echo isset($list['title-four']['desc']) ? $list['title-four']['desc'] : '编辑标题'?></span>
                  <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="biaoti('title-four')" >编辑</a>
                    </div>
                   <!--编辑区 结束-->

     
       </div>
       <div class="new-goods-liebiao new-goods-top">
         <ul>
             <?php for($i =1 ;$i<9; $i++):?>
             <li class="<?php  if($i !=1 && $i != 5){echo 'new-goods-liebiao-left';}?>  hover_it"  id="three-title-product_<?php echo $i?>" style=" position: relative">
             <a href="<?php echo isset($list["three-title-product_$i"]['link_path']) ? $list["three-title-product_$i"]['link_path']: '' ?>">
                 <img src="<?php echo isset($list["three-title-product_$i"]['img_path']) ? IMAGE_URL.$list["three-title-product_$i"]['img_path']: 'images/culture/21pic04.png' ?>" width="283px;" height="283px;">
                 <div class="new-goods-text"><span><?php echo isset($list["three-title-product_$i"]['desc']) ? $list["three-title-product_$i"]['desc']: '商品名称' ?></span></div>
                 <span class="new-goods-num">M <?php echo isset($list["three-title-product_$i"]['vip_price']) ? $list["three-title-product_$i"]['vip_price']: '0.00' ?></span>
             </a>
             <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="rexiao('three-title-product_<?php echo $i?>')">编辑</a>
                    </div>
                   <!--编辑区 结束-->

             </li>
             <?php endfor;?>
         </ul>
       </div>
    </div>
    <!-- 新品上市3 结束 -->

    <!-- 新品上市4 开始 -->
     <div class="content-one" style="margin-top:20px">
       <div class="new-goods-title hover_it"id="menu-product1" style="position: relative; height:35px" ><span id="title-five"><?php echo isset($list['title-five']['desc']) ? $list['title-five']['desc'] : '编辑标题'?></span>
         <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="biaoti('title-five')" >编辑</a>
                    </div>
                   <!--编辑区 结束-->
     
       </div>
       <div class="new-goods-liebiao new-goods-top">
         <ul>
             <?php for($i =1 ;$i<9; $i++):?>
             <li class="<?php  if($i !=1 && $i != 5){echo 'new-goods-liebiao-left';}?>  hover_it"  id="four-title-product_<?php echo $i?>" style=" position: relative">
             <a href="<?php echo isset($list["four-title-product_$i"]['link_path']) ? $list["four-title-product_$i"]['link_path']: '' ?>">
                 <img src="<?php echo isset($list["four-title-product_$i"]['img_path']) ? IMAGE_URL.$list["four-title-product_$i"]['img_path']: 'images/culture/21pic04.png' ?>" width="283px;" height="283px;">
                 <div class="new-goods-text"><span><?php echo isset($list["four-title-product_$i"]['desc']) ? $list["four-title-product_$i"]['desc']: '商品名称' ?></span></div>
                 <span class="new-goods-num">M <?php echo isset($list["four-title-product_$i"]['vip_price']) ? $list["four-title-product_$i"]['vip_price']: '0.00' ?></span>
             </a>
             <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="rexiao('four-title-product_<?php echo $i?>')">编辑</a>
                    </div>
                   <!--编辑区 结束-->

             </li>
             <?php endfor;?>
         </ul>
       </div>
    </div>
    <!-- 新品上市4 结束 -->



    <!--弹出层 fancybox-top 编辑仅图片 开始-->
    <div class="fancybox-top" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑商品  <i class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i></div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div>
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>上传商品图片：</li>
                            <li>商品链接地址：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi">
                            <li><!-- <a href="javascrip:;" class="fancybox-update">选择图片</a>--> <input type="file" id="file" name="file"><span class="">图片尺寸：1920X181</span></li>
                                <li><input class="fancybox-input" type="text" name="link_path" placeholder="链接须以http://开头,不允许添加51易货网外的链接" value=''>
                                <input class="fancybox-input" type="hidden" name="tem_key" value="">
                            </li>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back-top">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="on_sub()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox-top 编辑仅图片 结束--> 



        <!--弹出层 fancybox-top 编辑仅图片 秋冬外套 开始-->
    <div class="fancybox-top1" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑商品  <i class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i></div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div>
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>上传商品图片：</li>
                            <li>商品描述：</li>
                            <li>商品链接地址：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_3">
                            <li><!-- <a href="javascrip:;" class="fancybox-update">选择图片</a>--> <input type="file" id="file3" name="file"><span class="">图片尺寸：278X278</span></li>
                            <li><input class="fancybox-input" type="text" name="desc" placeholder="商品名称" value=''>
                            <li><input class="fancybox-input" type="text" name="link_path" placeholder="链接须以http://开头,不允许添加51易货网外的链接" value=''>
                                <input class="fancybox-input" type="hidden" name="tem_key" value="">
                            </li>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back-top1">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="waitao_sub()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox-top 编辑仅图片秋冬外套 结束--> 


     <!--弹出层 fancybox-top 编辑仅图片 秋冬外套 开始-->
    <div class="fancybox-top2" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑商品  <i class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i></div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div>
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>上传商品图片：</li>
                            <li>商品名称：</li>
                            <li>商品价格：</li>
                            <li>商品链接地址：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_2">
                            <li><!-- <a href="javascrip:;" class="fancybox-update">选择图片</a>--> <input type="file" id="file4" name="file"><span class="">图片尺寸：278X278</span></li>
                            <li><input class="fancybox-input" type="text" name="desc" placeholder="商品名称" value=''></li>
                            <li><input class="fancybox-input" type="text" name="pic" placeholder="商品价格" value=''></li>       
                                <li><input class="fancybox-input" type="text" name="link_path" placeholder="链接须以http://开头,不允许添加51易货网外的链接" value=''>
                                <input class="fancybox-input" type="hidden" name="tem_key" value="">
                            </li>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back-top2">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="rexiao_sub()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox-top 编辑仅图片秋冬外套 结束--> 




     <!--弹出层 fancybox-top 编辑仅图片 秋冬外套 开始-->
    <div class="fancybox-51" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑商品  <i class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i></div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div>
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                          <li>编辑标题：</li>

                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="edit-title">
                            <li>
                                <input class="fancybox-input" type="text" name="desc" placeholder="编辑标题" value=''>
                                <input class="fancybox-input" type="hidden" name="tem_key" value=''>
                            </li>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back-51">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="edit_title()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox-top 编辑仅图片秋冬外套 结束--> 



<!--弹出层 fancybox_color 编辑背景颜色 开始-->
    <div class="fancybox_color" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑背景颜色</div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div style="width:auto;height:auto;overflow: auto;position:relative;">
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>编辑背景颜色：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="bgckground_color">
                            <li><input class="fancybox-input" type="text" name="bg_color"placeholder="例子:#FF4000">
                                <input class="fancybox-input" type="hidden" name="tem_key" >
                            </li>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back_color">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="bg_color()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox_color 编辑背景颜色 结束-->
<!--弹出层 fancybox1 编辑导航nav 开始-->
    <div class="fancybox1" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑导航</div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div style="width:auto;height:auto;overflow: auto;position:relative;">
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>选择导航分类1：</li>
                            <li>选择导航分类2：</li>
                            <li>选择导航分类3：</li>
                            <li>选择导航分类4：</li>
                            <li>选择导航分类5：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right clearfix" id="select_option">
                        <ul>
                        <?php for($i = 1; $i<6; $i++):?>
                            <li>
                            	<span class="fancybox_select">
                                    <span class="fancybox_selectBg"></span>
                                    <select class="fancybox_select01" id="<?php echo 'select_'.$i?>">
                                    <?php if(isset($menu_list) && count($menu_list) > 0):?>
                                        <?php foreach($menu_list as $v):?>
                                            <option value="<?php echo $v['id']?>"><?php echo $v['section_name']?></option>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                    </select>
                                </span>
                                <!--搜索-->
                            </li>
                        <?php endfor;?>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" onclick="$('.fancybox1').hide()" class="fancybox_back fancybox_back1">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="edit_menu()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox1 编辑导航nav 结束--> 


        <!--弹出层热门专区左边 fancybox-50 编辑 开始-->
    <div class="fancybox-50" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
           <div class="fancybox-head">编辑商品 <i class="icon-guanbi" style=" font-size: 26px;color: #555;float: right;line-height: 53px;margin-right: 20px; cursor:pointer;"></i></div>
            <!--弹窗头部 结束-->
           <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div>
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>上传商品图片：</li>
                            <li>商品名称：</li>
                            <li>商品描述：</li>
                            <li>商品价格：</li>
                            <li>商品链接地址：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_4">
                            <li><input type="file" id="file2" name="file"><span class="">图片尺寸：220X223 </span></li>
                            <li><input class="fancybox-input" type="text" name= 'desc' value=''></li>
                            <li><input class="fancybox-input" type="text" name= 'desc_name'  value=''></li>
                            <li><input class="fancybox-input" type="text" name= 'pic' value=''></li>
                            <li><input class="fancybox-input" type="text" name= 'url' placeholder="链接须以http://开头,不允许添加51易货网外的链接" value=''></li>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
             <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back-50">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="sub_product()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->







   <script type="text/javascript">
  $(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});

$(".painting_banner1").slide({

    titCell: ".hd1 ul",

    mainCell: ".bd ul",

    effect: "fold",

    autoPlay: true,

    autoPage: true,

    trigger: "click",

    startFun: function(i) {

        var curLi = jQuery(".painting_banner1 .bd li").eq(i);

        if ( !! curLi.attr("_src")) {

            curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")

        }

    }

});

</script>
<!-- 导航栏 -->
<script type="text/javascript">
  $(function(){
    $(".header_nav a").on("click",function(){
      var index = $(this).index();
        $(this).addClass("nav_active").siblings().removeClass("nav_active");
    })
  })



  //点击编辑按钮－js

  function edit(key){ 
      arr=key.split('_');
      duibi = arr[0];

      $('#biaoshi li input[name=link_path]').val($('#'+key).find('a').eq(0).attr("href"));
      
      if(duibi == 'top'){ 
          $('#biaoshi li span').text('图片尺寸：1920X100');
        }else if(duibi == 'mid'){ 
          $('#biaoshi li span').text('图片尺寸：1200X250');
        }else if(duibi == 'carousel-img'){ 
          $('#biaoshi li span').text('图片尺寸：1920X435');
        }else if(duibi == 'product-mid'){ 
          $('#biaoshi li span').text('图片尺寸：381x285');
        }
      $('#biaoshi input[name=tem_key]').val(key);
      $('.fancybox-top').show();
    }




    function menu(key){ 
      var val = $('#'+key).find('span').eq(2).text().substr(2);
      arr=val.split('.');
      arr = arr[0];
       $('#biaoshi_4 li input[name=url]').val($('#'+key).find('a').eq(0).attr("href"));
       $('#biaoshi_4 li input[name=desc]').val($('#'+key).find('span').eq(0).text());
       $('#biaoshi_4 li input[name=desc_name]').val($('#'+key).find('span').eq(1).text());
       $('#biaoshi_4 li input[name=pic]').val(arr);      
      arr=key.split('_');
      duibi = arr[0];
      if(duibi == 'one-product'){ 
        $('#biaoshi_4 li span').text('图片尺寸：276X368');
        }else if(duibi == 'two-product'){ 
          $('#biaoshi_4 li span').text('图片尺寸：568X728');
        }else{ 
          $('#biaoshi_4 li span').text('图片尺寸：349X223');
        }
      $('#biaoshi_4 li').eq(5).remove();
      $('#biaoshi_4').append("<li><input type='hidden' name='tem_key' value="+key+"></li>");
      $('.fancybox-50').show();
    }



function rexiao(key){ 
	  var pic = $('#'+key).find('span').eq(1).text().substr(2);
	  pic=pic.split('.');
	  pic = pic[0];
	  
      arr=key.split('_');
      duibi = arr[0];
      $('#biaoshi_2 li input[name=link_path]').val($('#'+key).find('a').eq(0).attr("href"));
      $('#biaoshi_2 li input[name=desc]').val($('#'+key).find('span').eq(0).text());
      $('#biaoshi_2 li input[name=pic]').val(pic);
      $('#biaoshi_2 input[name=tem_key]').val(key);
      $('.fancybox-top2').show();
    }



function biaoti(key){ 

      $('#edit-title li input[name=desc]').val($('#'+key).text());
      
      
      $('#edit-title input[name=tem_key]').val(key);
      $('.fancybox-51').show();
    }

function waitao(key){ 
    
      arr=key.split('_');
      duibi = arr[0];

      $('#biaoshi_3 li input[name=link_path]').val($('#'+key).find('a').eq(0).attr("href"));
      $('#biaoshi_3 li input[name=desc]').val($('#'+key).find('div').eq(0).text());
      
      if(duibi == 'three-product'){ 
          $('#biaoshi_3 li span').text('图片尺寸：278X278');
       
        }
      $('#biaoshi_3 input[name=tem_key]').val(key);
      $('.fancybox-top1').show();
    }


function edit_color( key ){ 
  $('#bgckground_color input[name=tem_key]').val(key);
  $('.fancybox_color').show();
  
}

$('.fancybox_back_color').click(function(){
  $('.fancybox_color').hide();
});


  //点击取消fancybox_back按钮，弹出层内容消失
  $('.fancybox_back-top').click(function(){
    $('.fancybox-top').hide();
  });


   //点击取消fancybox_back按钮，弹出层内容消失
  $('.fancybox_back-top1').click(function(){
    $('.fancybox-top1').hide();
  });


   //点击取消fancybox_back按钮，弹出层内容消失
  $('.fancybox_back-top2').click(function(){
    $('.fancybox-top2').hide();
  });

//点击取消fancybox_back-478按钮，弹出层内容消失
  $('.fancybox_back-50').click(function(){
    $('.fancybox-50').hide();
  });

//点击取消fancybox_back-478按钮，弹出层内容消失
  $('.fancybox_back-51').click(function(){
    $('.fancybox-51').hide();
  });

//点击取消fancybox_back按钮，弹出层内容消失
  $('.fancybox_back4').click(function(){
    $('.fancybox4').hide();
  });
    //点击弹出层取消fancybox_back按钮，弹出层内容消失
  $('.icon-guanbi').click(function(){
    $('.fancybox1').hide();
    $('.fancybox-478').hide();
    $('.fancybox-52').hide();
    $('.fancybox-50').hide();
    $('.fancybox-51').hide();
    $('.fancybox-top').hide();
    $('.fancybox-top1').hide();
   $('.fancybox-top2').hide();
    $('.fancybox4').hide();
    
  })
    function publishTemp()
	{
		$.post("<?php echo site_url('flagship/issue_flagship_three_temp/')?>","",function(data){
		    if(data) alert('ok');
		});
	}

  function _upload(desc, pic, url, key,file_id,desc_name){
		if(url != '')
        if(!(/^http:\/\/(.*?)51ehw.com(.*?)$/.test( url ))){
        	alert('请输入正确的链接地址');
         	  return;
     	}
		 $.ajaxFileUpload
	        (
	            {
	            	url:'<?php echo site_url('corporate/myshop/upload_goods_top')?>', //用于文件上传的服务器端请求地址 等待后台处理
	                type: 'post',
	                //data: { Id: '123', name: 'lunis' }, //此参数非常严谨，写错一个引号都不行
	                secureuri: false, //一般设置为false
	                fileElementId: file_id, //文件上传空间的id属性  <input type="file" id="file" name="file" />
	                data:{link_path:url,temp_key:key,desc:desc,pic:pic,tem:6,desc_name:desc_name},
	                dataType: 'json', //返回值类型 一般设置为json
	                success: function (data, status)  //服务器成功响应处理函数
	                {
		               
	                	 if(data){
//	                		 img_path = 'http://image.51ehw.com/images/gg.jpg'; 
	                		 var weizhi = 1;
	    	                	$('#'+key).find('span').eq(0).text(desc);
	    	                	if(desc_name){ 
		    	                	var weizhi = 2;
	    	                		$('#'+key).find('span').eq(1).text(desc_name);
		    	                }
	    	                	
	    	                	if(pic.indexOf(".") > 0 )
	    	                	{
	    	                		$('#'+key).find('span').eq(weizhi).text('M '+pic);
	    	                	}else{
	    	                		$('#'+key).find('span').eq(weizhi).text('M '+pic+'.00');
	    	                	}
	    	            		
	    	            		$('#'+key).find('a').eq(0).attr("href",url);

	    	            	    $('.fancybox-top2').hide();
	    	            		$('.fancybox-top').hide();
	    	                	$('.fancybox-top1').hide();
	    	                	$('.fancybox-50').hide();
			                }

	                	   img_key = key.substring(0,key.length-2);

	                	   if(img_key == 'carousel-img'){ 
	                		   if(data.img_path) $('#'+key).attr("_src",'url('+data.img_path+')');
			               }else{
	                	       if(data.img_path) $('#'+key).find('img').attr("src",data.img_path);
		                   }

			             if(key == 'time-one'){ 
			            	 time = desc;
			             }else if(key == 'time-two'){ 
			            	 time1 = desc;
				         }
					      
			             
	                },
	                error: function (data, status, e)//服务器响应失败处理函数
	                {
	                    alert(e);
	                }
	            }
	        )
	
}

    function on_sub(){ 
          var link_path = $('#biaoshi input[name=link_path]').val();
          var tem_key   = $('#biaoshi input[name=tem_key]').val();
          _upload('','',link_path,tem_key,'file');
    }
  

	function sub_product(){ 
		var desc = $('#biaoshi_4 li input[name=desc]').val();
	    var pic = $('#biaoshi_4 li input[name=pic]').val();
        var url = $('#biaoshi_4 li input[name=url]').val();
        var desc_name = $('#biaoshi_4 li input[name=desc_name]').val();
        var key = $('#biaoshi_4 li input[name=tem_key]').val();

        if( !(/^\d+(\.\d{1,2})?$/).test(pic) ) { 
            alert('价格请输入正确的数字');
            return;
        }
        
        _upload(desc, pic, url, key,'file2',desc_name);
    }

	function waitao_sub(){  
		 var link_path = $('#biaoshi_3 input[name=link_path]').val();
		 var desc = $('#biaoshi_3 input[name=desc]').val();
         var tem_key   = $('#biaoshi_3 input[name=tem_key]').val();
         _upload(desc,'',link_path,tem_key,'file3');
	}

	
	function rexiao_sub(){ 
		var desc = $('#biaoshi_2 li input[name=desc]').val();
	    var pic = $('#biaoshi_2 li input[name=pic]').val();
        var url = $('#biaoshi_2 li input[name=link_path]').val();
        var key = $('#biaoshi_2 li input[name=tem_key]').val();
       
        if( !(/^\d+(\.\d{1,2})?$/).test(pic) ) { 
            alert('价格请输入正确的数字');
            return;
        }
        _upload(desc,pic,url,key,'file4');
    }

	function edit_menu(){ 

		var array = new Array();
		$('select :selected').each(function(i) {
            array[i] = $(this).val();
            array[i] += ';railing-title_'+i;
            array[i] += ';'+ $(this).text();
            
            
            });
		 $.ajax({ 
	            url:'<?php echo site_url('corporate/myshop/add_menu_list')?>',
	            type:'post',
	            data:{array:array,tem:6},
	            dataType:'json',
	            success:function(data){
	                
	               
	            	   location.reload();
	            },
	        })
	        $('.fancybox1').hide();
    }


	function edit_title(){
		var desc = $('#edit-title li input[name=desc]').val();
	    var key = $('#edit-title li input[name=tem_key]').val();
		_edit(desc,key);
	}
	
   function _edit(desc, key){ 
        $.ajax({ 
            url:'<?php echo site_url('corporate/myshop/edit_temp_title')?>',
            type:'post',
            data:{desc:desc,temp_key:key,tem:6},
            dataType:'json',
            success:function(data){
                if(data){ 
                	$('.fancybox-51').hide();
                    $('#'+key).text(desc);
                }
            },
            error:function(){}
        })
   }

    function bg_color(){ 
        var bg = $('input[name=bg_color]').val();
        var key = $('#bgckground_color input[name=tem_key]').val();
        $.ajax({ 
			url:"<?php echo site_url('corporate/myshop/edit_temp_title')?>",
			data:{desc:bg,tem:6,temp_key:key},
			type:'post',
			dataType:'json',
			success:function(data){ 
				if(data){ 
					$('.'+key).css('background',bg);
					$('.fancybox_color').hide();
				}
			}
	    })
    }

    function resetTemplate()
	{
		if(confirm("是否重置该模板?重置后,所有内容将会掉失!!"))
		{
			window.location = "<?php echo site_url('corporate/myshop/ResetTemplate/6')?>";
		}
	}
</script>
    


</body>
</html>



