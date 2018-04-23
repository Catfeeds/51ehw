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
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/jquery.easie.js"></script>
<script type="text/javascript" src="js/my.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.1.pack.js"></script>
<script src="js/ajaxfileupload.js" type="text/javascript"></script>
<script type="text/javascript" src="js/superslide.2.1.js"></script><!--banner图片切换-->


<style>

.banner{ height:435px;margin:0px auto; overflow:hidden;}
/* fullSlide */
.fullSlide{width:100%;position:relative;height:435px; overflow:hidden;} 
.fullSlide .bd{margin:0 auto;position: absolute;z-index:0;overflow:hidden; margin-left:-960px; left:50%;}
.fullSlide .bd ul{width:100% !important;}
.fullSlide .bd li{width:100% !important;height:435px;overflow:hidden;text-align:center;background:#fff center 0 no-repeat;}
.fullSlide .bd li a{display:block;height:435px;}
.fullSlide .hd1{width:100%;position:absolute;z-index:1;bottom:0;left:0;height:30px;line-height:30px;}
.fullSlide .hd1 ul{text-align:center;}
.fullSlide .hd1 ul li{cursor:pointer; display:inline-flex;zoom:1;width:10px;height:10px;margin:1px;overflow:hidden;background:#fff; border-radius:10px;line-height:999px;}
.fullSlide .hd1 ul .on{border:2px solid #fff;background:none; line-height:999px;}
.fullSlide .prev,.fullSlide .next{display:block;position:absolute;z-index:1;top:50%;margin-top:-30px;left:10%;z-index:1;width:40px;height:60px;background:url(../../images/slider-arrow.png) -126px -137px #000 no-repeat;cursor:pointer;filter:alpha(opacity=50);opacity:0.5;display:none;}
.fullSlide .next{left:auto;right:10%;background-position:-6px -137px;}
.vertisement1{ width:1200px; margin:30px auto; height:60px; }
.macth_xv_categorys{ background:none;}
.macth_xv_nav li.macth_liactive a{ background:none;}
/*.macth_xv_nav li a{ background:url(images/culture/biao.png) no-repeat left; display:block}*/
.macth_xv_categorys .macth_xv_cat_title .macth_cat_name a .icon-arrowdown { position: absolute; font-size: 19px; top: 8px; right:0;}
.icon-arrowdown{position: absolute;font-size: 26px; /*top: 2px;*/ right:0; z-index:88;  font-weight:normal !important;transform:rotate(90deg); float: right;}
/*店铺模版_多产品－头部*/
.store_head{ width:100%; min-width:1200px; height:122px; }
.store_head_con{ width:1200px; height:122px; margin:0 auto;}
.store_head_con span{ display:inline-block;  margin:50px 0 0 50px; font-size:16px; color:#555; float:left; }
.store_head_span{ margin-right:50px;}
.store_head_con a.logo_set{float: left; height: 64px; width: 160px; margin-top:20px;}
.store_head_search{ width:555px; height:37px; float:right; margin-right:6px; margin-top:38px;}
.store_head_search01{ width:460px; height:37px; background:#fea33b; position:relative; float:left;}
.store_head_input{ width:370px; height:33px; border:none; outline:none; text-indent:5px; top:2px; left:2px; position:absolute; font-size:14px;}
.search_total_station{background:＃fea33b; width:88px; height:33px; display:inline-block; position:absolute; right:0; top:2px; text-align:center; line-height:33px; color:#fff; font-size:16px;}
.search_total_station:hover{ color:#fff;}
.store_head_search02{ font-size:16px; width:90px; height:37px; background:#252525; float:right; text-align:center; line-height:37px;}
.store_head_search02 a{ color:#fff;}
.store_head_search02 a:hover{ color:#fff;}
.store_top{ width:100%;  height:100px; }
.store_top_con{height:100px; position:absolute; left:50%; margin-left:-960px; overflow:hidden;} 
.store_top_con img{ width:100%;}
.store_nav{ width:100%; min-width:1200px; height:36px; line-height:36px; background:#fea33b;}
.media_top_nei_zhong_t em{ margin-left:0px;}
.media_top_nei_zhong_t2 em{ margin-left:4px;}
.media_top_nei_zhong_t1 em{ margin-left:4px;}
#_my97DP{ position:fixed !important; z-index:999999 !important; top:321px !important;}
.headEdit_btnLeft{height:60px;}
.headEdit_btnRight{height:60px;}
.guanjie_top{ height:auto; overflow:hidden;}
</style>

</head>

<body>

 
 
  <!--页头编辑 开始-->
    <div class="store_headEdit" style="position:relative;">
    	<div class="store_headEdit_con">
        	<div class="headEdit_btnLeft">
            	<ul>
   
        			
                    
        			<li><a href="javascript:;" onclick="add_temp()" class="btn_pageEdit">添加楼层</a><li>
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
            		<li><a href="<?php echo site_url('flagship/inspect_flagship_two_temp')?>" class="btn_pagePreview">预览</a></li>
                	<li><a href="javascript:;" onclick="javascript:publishTemp()" class="btn_pageRelease">发布</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--页头编辑 结束-->
 
 
<!--导航 开始-->
	<!--店铺头部 开始-->
	<div class="guanjie_top" >
    	<div class="guanjie_top_nei hover_it" style="position:relative;" id="top">
          <div class="guanjie_top_nei_top">
        <a href='<?php echo isset($list["top"]) ? $list["top"]['link_path'] : ''?>'><img src="<?php echo isset($list['top']['img_path']) ? IMAGE_URL.$list['top']['img_path']: 'images/store_topBanner.png';?>" width='1920' height='181' alt=""/></a>
          </div>
            <div class="guanjie_top_neit1">
<!--           <p><a href="javascript:;"><i class="icon-yixihuan"></i>收藏本店</a></p> -->
          </div>
          
           <div class="editCon">
            <div class="editBtnCon clearfix">
            	<a href="javascript:;" class="editBtn" onclick="edit('top')">编辑</a>
            </div>
        </div>
        <!--编辑区 结束-->
        </div>
	
    <!--店铺头部 结束-->
	<!--头部导航条 开始--><!-- 冠杰头部变底色 guanjie_tem.css -->
    <div class="eh_navbar1 clearfix hover_it" style="position: relative;<?php echo isset($list['column-color']['desc']) ? 'background:'.$list['column-color']['desc'] : '' ?>" id="column-color">
        <div class="macth_xv_navlist" style=" background:none">
              <div class="macth_xv_menu" style=" background:none">
                <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="javascript:;">本店所有商品<b class="icon-select"></b></a></h2>
                    </div>
                    
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            
                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                <ul class="macth_xv_nav">
                    <li id='home' class="macth_liactive"><a href="<?php echo site_url('flagship/flagship_two_temp')?>">首页</a></li>
                    <span id='top_shop_classify'><!-- <li><a href="javascript:;">媒体广告</a> --></li></span>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>
        <!--编辑区 开始-->
        <div class="editCon">
        
            <div class="editBtnCon clearfix"> <a href="javascript:;" class="addFloorBtn" onclick="edit_color('column-color')" style="margin-bottom:20px;">编辑背景颜色</a></div>
        </div>
        <!--编辑区 结束-->
    </div> 
    
    <!--轮播图-->
        <div class="fullSlide hover_it">
    <div class="painting_banner1">
    <div class="bd" id="carousel-img">
    
        <a href="<?php echo isset($list["carousel-img"]) ? $list["carousel-img"]['link_path'] : ''?>" >
            <img src="<?php echo isset($list["carousel-img"]['img_path']) ? IMAGE_URL.$list["carousel-img"]['img_path'] : 'images/store_banner1920.png'  ?>" height="435" width="1920">
        </a>
    
   </div>
   </div>
   
        <!--编辑区 开始-->
            <div class="editCon">
                <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img')" >编辑</a></div>
               
            </div>
            <!--编辑区 结束-->
   
   </div>
    <div class="guanjie_top_conx ">
      <div class="guanjie_top_conx_l">
      <div class="bianjie hover_it" style=" height:891px">
      <div id="background-img-one">
          <img src="<?php echo isset($list['background-img-one']['img_path']) ? IMAGE_URL.$list['background-img-one']['img_path']: '';?>"width='1920' height='891'alt=""/> 
      </div>
        <div class="guanjie_top_conx_b1" style="position:absolute; top:0px; left:50%; margin-left:-600px;">
          <ul>
           <li class="hover_it" id="time-one">
           <a  class="dingwei4"href="<?php echo isset($list['time-one']['link_path']) ? $list['time-one']['link_path']: '';?>">
           <img src="<?php echo isset($list['time-one']['img_path']) ? IMAGE_URL.$list['time-one']['img_path']: 'images/store_banner1200.png';?>" width="1200" height='436'/></a>
            <p></p>
           <div class="guanjie_top_conx_b1_n dingwei">
             <div id="countbox1" class="countbox">
            <div id="days1">0
            </div>
            <div class="days_text1"></div>
            <div id="hours1">0
            </div> 
            <div class="hours_text1"></div>
            <div id="mins1">0
            </div>
             <div class="mins_text1"></div>
            <div id="secs1">0
            </div> 
            <div class="secs_text1"></div>
          </div>
          <!--  
             <p>古丽兰 18K金钻石戒指</p>
             <p class="juan4"><em><span class="juan">11495</span><samp class="juan1">提货权</samp></em><em style="margin-top:5px;"><span class="juan3">11495</span><samp class="juan2">提货权</samp></em></p>
             <h6><a href="http://www.51ehw.com/goods/detail/1181">立即购买</a></h6>
             -->
           </div>
           
            <!--编辑区 开始-->
                        <div class="editCon">
                            <a href="javascript:;" class="editBtn" onclick="zhong('time-one')">编辑</a>
                        </div>
                        <!--编辑区 结束-->
           </li>
             <li class="hover_it" id="time-two">
             <a  class="" href="<?php echo isset($list['time-two']['link_path']) ? $list['time-two']['link_path']: '';?>">
          <img src="<?php echo isset($list['time-two']['img_path']) ? IMAGE_URL.$list['time-two']['img_path']: 'images/store_banner1200.png';?>" width="1200" height='436'/></a>
           
           <div class="guanjie_top_conx_b1_n dingwei1">
             <div id="countbox2" class="countbox">
    <div id="days2">0
    </div> 
    <div class="days_text1"></div>
    <div id="hours2">0
    </div>
      <div class="hours_text1"></div>
    <div id="mins2">0
    </div>
     <div class="mins_text1"></div>
    <div id="secs2">0
    </div>
     <div class="secs_text1"></div>
  </div>
             
             <!--<h6 style="margin-top:25px;"><a href="http://www.51ehw.com/goods/detail/363">立即购买</a></h6>-->
           </div>
           
            <!--编辑区 开始-->
                        <div class="editCon">
                            <a href="javascript:;" class="editBtn" onclick="zhong('time-two')">编辑</a>
                        </div>
                        <!--编辑区 结束-->
           </li>
          </ul>
        </div> 
          <!--编辑区 开始-->
           <div class="editCon" style="z-index:0">
            	<a href="javascript:;" class="editBtn" onclick="edit_title('background-img-one')" style=" background:#fea33b;">编辑背景图片</a>
              </div>
        <!--编辑区 结束-->
        </div>
        
      <div class="bianjie hover_it" style="position: relative ;height:2450px">
           <div id="background-img-two">
             <img src="<?php echo isset($list['background-img-two']['img_path']) ? IMAGE_URL.$list['background-img-two']['img_path']: '';?>"width='1920' height='2450'alt=""/> 
           </div>
      <div class="media_top" style="position:absolute; left:50%; top:0; margin-left:-600px;">
      <div class="media_top_nei">
         <ul>
          <?php for ($i = 1 ;$i<3; $i++):?>
          <li class="media_top_to hover_it" style="position:relative;" id="<?php echo 'product_'.$i?>"><a href="<?php echo isset($list['product_'.$i]['link_path']) ? $list['product_'.$i]['link_path']: '' ?>"> <img src="<?php echo isset($list['product_'.$i]['img_path']) ? IMAGE_URL.$list['product_'.$i]['img_path']: 'images/storeSingle_pic01.png' ?>"/ width="582px" height="358px"></a>
              <!--编辑区 开始-->
           <div class="editCon">
            	<a href="javascript:;" class="editBtn" onclick="edit('product_<?php echo $i?>')">编辑</a>
              </div>
        <!--编辑区 结束-->
          </li>
          <?php endfor;?>
          
          
          <?php for ($i = 1 ;$i<4; $i++):?>
          <li class="media_top_to1 hover_it" style="position:relative;" id="<?php echo 'product-mid_'.$i?>"><a href="<?php echo isset($list['product-mid_'.$i]['link_path']) ? $list['product-mid_'.$i]['link_path']: '' ?>"> <img src="<?php echo isset($list['product-mid_'.$i]['img_path']) ? IMAGE_URL.$list['product-mid_'.$i]['img_path']: 'images/hotSale_pic1.png' ?>"/width="381px" height="285px"></a>
                     <!--编辑区 开始-->
              <div class="editCon">
                  <a href="javascript:;" class="editBtn" onclick="edit('product-mid_<?php echo $i?>')">编辑</a>
              </div>
                   <!--编辑区 结束-->
          </li>
          <?php endfor?>
         </ul>
         
        </div>
        
        
        <div class="media_top_nei_zhong">
          <h5 class="hover_it" style="position:relative" id="title-img-one"> <img src="<?php echo isset($list['title-img-one']['img_path']) ? IMAGE_URL.$list['title-img-one']['img_path']: 'images/guanjie_biaoti.jpg';?>" height="100px" width="1200px"/>
                <!--编辑区 开始-->
                     <div class="editCon">
                       <a href="javascript:;" class="editBtn" onclick="edit_title('title-img-one')">编辑</a>
                     </div>
                   <!--编辑区 结束-->
          </h5>
            <ul>
                <?php for($i=1; $i<5; $i++):?>
                    <li class="hover_it" style="position:relative;" id="<?php echo 'mid-product_'.$i;?>">
                        <span><a href="<?php echo isset($list['mid-product_'.$i]['link_path']) ? $list['mid-product_'.$i]['link_path']: '' ?>"><img src="<?php echo isset($list['mid-product_'.$i]['img_path']) ? IMAGE_URL.$list['mid-product_'.$i]['img_path']: 'images/hotSale_pic1.png' ?>"/></a></span>
                        <p class="zhong_t1"><?php echo isset($list['mid-product_'.$i]['desc']) ? $list['mid-product_'.$i]['desc']: '商品名称' ?></p>
                        <div class="media_top_nei_zhong_t">
                            <h6><?php echo isset($list['mid-product_'.$i]['brief_statement']) ? $list['mid-product_'.$i]['brief_statement']: '商品描述' ?></h6> 
                            <em>狂欢价：<samp>M <?php echo isset($list['mid-product_'.$i]['vip_price']) ? $list['mid-product_'.$i]['vip_price']: '0.00' ?></samp></em>
                            <p class="zhong_t2"> <a href="<?php echo isset($list['mid-product_'.$i]['link_path']) ? $list['mid-product_'.$i]['link_path']: '' ?>">加入购物车></a></p>
                        </div>
                    
                        <!--编辑区 开始-->
                         <div class="editCon">
                           <a href="javascript:;" class="editBtn" onclick="menu('mid-product_<?php echo $i;?>')">编辑</a>
                         </div>
                        <!--编辑区 结束-->
                    </li>
                <?php endfor;?>
            </ul>
        </div>
        
        <div class="media_top_nei_zhong2">
          <h5 class="hover_it" style="position:relative;" id="title-img-two"> <img src="<?php echo isset($list['title-img-two']['img_path']) ? IMAGE_URL.$list['title-img-two']['img_path']: 'images/guanjie_biaoti.jpg';?>" height="100px" width="1200px"/>
            <!--编辑区 开始-->
                     <div class="editCon">
                       <a href="javascript:;" class="editBtn" onclick="edit_title('title-img-two')">编辑</a>
                     </div>
                   <!--编辑区 结束-->
          </h5>
          
            <ul>
                <?php for($i=1; $i<6; $i++):?>
                <li class="hover_it" style="position:relative;" id="<?php echo 'menu-product_'.$i?>">
                    <span><a href="<?php echo isset($list['menu-product_'.$i]['link_path']) ? $list['menu-product_'.$i]['link_path']: '' ?>"><img src="<?php echo isset($list['menu-product_'.$i]['img_path']) ? IMAGE_URL.$list['menu-product_'.$i]['img_path']: 'images/hotSale_pic1.png' ?>"/></a></span>
                    <p class="zhong_t1"><?php echo isset($list['menu-product_'.$i]['desc']) ? $list['menu-product_'.$i]['desc']: '商品名称' ?></p>
                    <div class="media_top_nei_zhong_t2">
                        <h6><?php echo isset($list['menu-product_'.$i]['brief_statement']) ? $list['menu-product_'.$i]['brief_statement']: '商品描述' ?></h6> 
                        <em>狂欢价：<samp>M <?php echo isset($list['menu-product_'.$i]['vip_price']) ? $list['menu-product_'.$i]['vip_price']: '0.00' ?></samp></em>
                        <p class="zhong_t2"> <a href="<?php echo isset($list['menu-product_'.$i]['link_path']) ? $list['menu-product_'.$i]['link_path']: '' ?>">加入购物车></a></p>
                    </div>
                   <!--编辑区 开始-->
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn" onclick="menu('menu-product_<?php echo $i?>')">编辑</a>
                    </div>
                   <!--编辑区 结束-->
                </li>
                <?php endfor;?>
            </ul>
        </div>
        
        <div class="media_top_nei_zhong1">
          <h5 class="hover_it" style="position:relative;" id="title-img-three"> <img src="<?php echo isset($list['title-img-three']['img_path']) ? IMAGE_URL.$list['title-img-three']['img_path']: 'images/guanjie_biaoti.jpg';?>" height="100px" width="1200px"/>
              <!--编辑区 开始-->
                     <div class="editCon">
                       <a href="javascript:;" class="editBtn" onclick="edit_title('title-img-three')">编辑</a>
                     </div>
                   <!--编辑区 结束-->
          </h5>
            <ul>
                <?php for($i = 1; $i<4; $i++):?>
                <li class="hover_it" style="position:relative;" id="<?php echo 'end-product_'.$i;?>">
                    <span><a href="<?php echo isset($list['end-product_'.$i]['link_path']) ? $list['end-product_'.$i]['link_path']: '' ?>"><img src="<?php echo isset($list['end-product_'.$i]['img_path']) ? IMAGE_URL.$list['end-product_'.$i]['img_path']: 'images/hotSale_pic1.png' ?>"/></a></span>
                    <p class="zhong_t1"><?php echo isset($list['end-product_'.$i]['desc']) ? $list['end-product_'.$i]['desc']: '商品名称' ?></p>
                    <div class="media_top_nei_zhong_t1">
                         <h6><?php echo isset($list['end-product_'.$i]['brief_statement']) ? $list['end-product_'.$i]['brief_statement']: '商品描述' ?></h6> 
                         <em>周五狂欢价：<samp>M <?php echo isset($list['end-product_'.$i]['vip_price']) ? $list['end-product_'.$i]['vip_price']: '0.00' ?></samp></em>
                    <p class="zhong_t2"> <a href="<?php echo isset($list['end-product_'.$i]['link_path']) ? $list['end-product_'.$i]['link_path']: '' ?>">加入购物车></a></p>
                    </div>
                       <!--编辑区 开始-->
                         <div class="editCon">
                             <a href="javascript:;" class="editBtn" onclick="menu('end-product_<?php echo $i;?>')">编辑</a>
                         </div>
                       <!--编辑区 结束-->
                </li>
                <?php endfor;?>
            </ul>
        </div>
      </div>
             <!--编辑区 开始-->
           <div class="editCon" style="z-index:0">
            	<a href="javascript:;" class="editBtn" onclick="edit_title('background-img-two')" style=" background:#fea33b;">编辑背景图片</a>
              </div>
        <!--编辑区 结束-->
      </div>

        <div class="bianjie hover_it" style="position: relative;height:1550px"> 
            <div id="background-img-three">
                <img src="<?php echo isset($list['background-img-three']['img_path']) ? IMAGE_URL.$list['background-img-three']['img_path']: '';?>"width='1920' height='1550'alt=""/> 
            </div>
       <div class="media_bottom" style="position:absolute; left:50%; top:0; margin-left:-600px;">

         <div class="lib_Tab">
          <div class="lib_Tab_top">
            <h5>所有商品</h5>
            
          </div>
         </div>  
         <div class="lib_Contentbox"> 
           <div class="lib_Contentbox_to">
           
          <dl id="guanjie_media_goods" >
            <dd>
              <div class="lib_Contentbox_nei">
                <span><a href="#"><img src="images/culture/culture_top14.jpg"></a></span>
                <h5><samp>省政府前</samp><samp class="samp_1"></samp><samp>新城广场青少年宫LED</samp></h5>
                <p>¥5000.00</p>
                 <ul>
                   <li>
                    <a class="nei_top"href="#">购买</a>
                   </li>
                    <li>
                    <a class="nei_top1"href="#">关注</a>
                   </li>
                 </ul>
              </div>
            </dd>
           
          </dl>
       
         </div>
         </div>

         
          <div class="media_showpage"></div> </div>  <!--编辑区 开始-->
           <div class="editCon" style="z-index:0">
            	<a href="javascript:;" class="editBtn" onclick="edit_title('background-img-three')" style=" background:#fea33b;">编辑背景颜色</a>
              </div>
        <!--编辑区 结束-->

            </div>
       </div>
     </div>      
    </div>
  
 
    </div>
    

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
                           </ul>
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
         </div>
        </div>
    </div>
    <!--弹出层热门专区左边 fancybox-50 编辑 结束--> 
    
    
    
    <!--弹出层热门专区左边 fancybox-478 编辑 开始-->
    <div class="fancybox-478" style="display:none"> 
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
                            <li>商品链接地址：</li> 
                            <li>特价结束时间：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_1">
                            <li><!-- <a href="javascrip:;" class="fancybox-update">选择图片</a>--> <input type="file" id="file1" name="file"><span class="">图片尺寸：1200*436 </span></li>
                            <li><input class="fancybox-input" type="text" name= 'link_path' placeholder="链接须以http://开头,不允许添加51易货网外的链接" value=''></li>
                            <li><input class="fancybox-input" type="text"placeholder="请选择"  name="desc" onClick="WdatePicker({startDate:'%y-%M-01 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})" readonly></li>
                            <li><input type='hidden' name='tem_key' value=""></li>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--<a id="fancybox-close" style="display: inline;"></a>
              <a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>
              <a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>-->
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back-478">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="on_product_sub()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层热门专区左边 fancybox-479 编辑 结束--> 
    
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
    
    

    
   
    <!--弹出层 fancybox4 编辑仅标题 开始-->
    <div class="fancybox4" style="display:none"> 
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
                            <li>图片：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_3">
                             <li><input type="file" id="file3" name="file"><span class="">图片尺寸：1200X不限</span></li>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back4">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="carry_out()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox4 编辑仅标题 结束--> 
    
    <!--弹出层 fancybox5 编辑删除 开始-->
   
    <!--弹出层 fancybox5 删除 结束--> 
    
    <!-- 结尾开始 -->
    
    <!-- 结尾结束 -->  
<!--导航 结束-->

</body>
</html>

<!--添加导航 后加载-->
<!----banner图片轮播------>
<script type="text/javascript">
$(".fullSlide").hover(function(){
    $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
},
function(){
    $(this).find(".prev,.next").fadeOut()
});

$(".painting_banner1").slide({

    titCell: ".hd ul",

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

<script type="text/javascript">

function edit_color( key ){ 
	$('#bgckground_color input[name=tem_key]').val(key);
	$('.fancybox_color').show();
	
}

$('.fancybox_back_color').click(function(){
	$('.fancybox_color').hide();
});
    time = "<?php echo isset($list['time-one']['desc']) ? str_replace('-','/',$list['time-one']['desc']): '';?>"
    function getRTime(){
    	
        var EndTime= new Date(time);
        var NowTime = new Date();
        var t =EndTime.getTime() - NowTime.getTime();
    

        var d=Math.floor(t/1000/60/60/24);
        var h=Math.floor(t/1000/60/60%24);
        var m=Math.floor(t/1000/60%60);
        var s=Math.floor(t/1000%60);

        document.getElementById("days1").innerHTML = d + "";
        document.getElementById("hours1").innerHTML = h + "";
        document.getElementById("mins1").innerHTML = m + "";
        document.getElementById("secs1").innerHTML = s + "";
    }
    setInterval(getRTime,1000);
	
	
    time1 = "<?php echo isset($list['time-two']['desc']) ? str_replace('-','/',$list['time-two']['desc']): '';?>"
    
	function getRTime1(){
		var EndTime= new Date(time1);
        var NowTime = new Date();
        var t =EndTime.getTime() - NowTime.getTime();
    

        var d=Math.floor(t/1000/60/60/24);
        var h=Math.floor(t/1000/60/60%24);
        var m=Math.floor(t/1000/60%60);
        var s=Math.floor(t/1000%60);

		document.getElementById("days2").innerHTML = d + "";
        document.getElementById("hours2").innerHTML = h + "";
        document.getElementById("mins2").innerHTML = m + "";
        document.getElementById("secs2").innerHTML = s + "";
    }
    setInterval(getRTime1,1000);
	
	
	
	function setTab(name,cursel,n){
 for(i=1;i<=n;i++){
  var menu=document.getElementById(name+i);
  var con=document.getElementById("con_"+name+"_"+i);
  menu.className=i==cursel?"hover":"";
  con.style.display=i==cursel?"block":"none";
 }
}
    </script>
    
    
    <script>


    //点击头部banner编辑按钮，弹出层仅编辑图片内容
	function zhong(key){ 
		$('#biaoshi_1 li input[name=link_path]').val($('#'+key).find('a').eq(0).attr("href"));
		$('#biaoshi_1 input[name=tem_key]').val(key);
		$('.fancybox-478').show();
    }

	
    function menu(key){ 
    	var val = $('#'+key).find('samp').text().substr(2);
    	arr=val.split('.');
    	arr = arr[0];
    	 $('#biaoshi_4 li input[name=url]').val($('#'+key).find('a').eq(0).attr("href"));
    	 $('#biaoshi_4 li input[name=desc]').val($('#'+key).find('p').eq(0).text());
    	 $('#biaoshi_4 li input[name=desc_name]').val($('#'+key).find('h6').text());
    	 $('#biaoshi_4 li input[name=pic]').val(arr);

    	 
        
    	arr=key.split('_');
     	duibi = arr[0];
     	if(duibi == 'mid-product'){ 
     		$('#biaoshi_4 li span').text('图片尺寸：280X223');
        }else if(duibi == 'menu-product'){ 
        	$('#biaoshi_4 li span').text('图片尺寸：220X223');
        }else{ 
        	$('#biaoshi_4 li span').text('图片尺寸：349X223');
        }
    	$('#biaoshi_4 li').eq(5).remove();
        $('#biaoshi_4').append("<li><input type='hidden' name='tem_key' value="+key+"></li>");
    	$('.fancybox-50').show();
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
	
	
	

    function edit_title(key){
    	
        if(key == 'background-img-one'){ 
        	$('#biaoshi_3 li span').text('图片尺寸：1920x891');
        }else if(key == 'background-img-two'){ 
        	$('#biaoshi_3 li span').text('图片尺寸：1920x2450');
        }else if(key == 'background-img-three'){ 
        	$('#biaoshi_3 li span').text('图片尺寸：1920x1550');
        }else{
	    	$('#biaoshi_3 li span').text('图片尺寸：1200x100');
	    }
	    $('#biaoshi_3 li').eq(1).remove();
        $('#biaoshi_3').append("<li><input type='hidden' name='temp_key' value="+key+"></li>"); 
    	$('.fancybox4').show();
    }

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
		

	//点击取消fancybox_back-mid按钮，弹出层内容消失
	$('.fancybox_back-mid').click(function(){
		$('.fancybox-mid').hide();
	});

	//点击取消fancybox_back-mid按钮，弹出层内容消失
	$('.fancybox_back-end').click(function(){
		$('.fancybox-end').hide();
	});
	
	
	//点击弹出层取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back1').click(function(){
		$('.fancybox1').hide();
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
		
		
	});
	
	//点击轮播图banner编辑按钮，弹出层编辑轮播图内容
	$('.carousel .editBtn').click(function(){
		$('.fancybox0').show();
	});
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back0').click(function(){
		$('.fancybox0').hide();
	});


	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back-304').click(function(){
		$('.fancybox-304').hide();
	});
	
	//点击取消fancybox_back-478按钮，弹出层内容消失
	$('.fancybox_back-478').click(function(){
		$('.fancybox-478').hide();
	});
	
	//点击取消fancybox_back-478按钮，弹出层内容消失
	$('.fancybox_back-50').click(function(){
		$('.fancybox-50').hide();
	});
	
	//点击取消fancybox_back-478按钮，弹出层内容消失
	$('.fancybox_back-51').click(function(){
		$('.fancybox-51').hide();
	});
	
	//点击取消fancybox_back-478按钮，弹出层内容消失
	$('.fancybox_back-52').click(function(){
		$('.fancybox-52').hide();
	});
	
	//点击取消fancybox_back-478按钮，弹出层内容消失
	$('.fancybox_back-479').click(function(){
		$('.fancybox-479').hide();
	});
	

	//点击取消fancybox_back-232按钮，弹出层内容消失
	$('.fancybox_back-232').click(function(){
		$('.fancybox-232').hide();
	});
	

	//点击取消fancybox_back-283按钮，弹出层内容消失
	$('.fancybox_back-283').click(function(){
		$('.fancybox-283').hide();
	});

	

	//点击取消fancybox_back-370按钮，弹出层内容消失
	$('.fancybox_back-200').click(function(){
		$('.fancybox-200').hide();
	});
	
	
	//点击右侧删除按钮，弹出层删除温馨提示内容
	$('.productfloor_right .deleteBtn').click(function(){
		$('.fancybox5').show();
	});
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back5').click(function(){
		$('.fancybox5').hide();
	});
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back4').click(function(){
		$('.fancybox4').hide();
	});
	
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
	                data:{link_path:url,temp_key:key,desc:desc,pic:pic,tem:5,desc_name:desc_name},
	                dataType: 'json', //返回值类型 一般设置为json
	                success: function (data, status)  //服务器成功响应处理函数
	                {
		               
	                	 if(data){
// 	                		 img_path = 'http://image.51ehw.com/images/gg.jpg'; 
				              
	    	                	$('#'+key).find('p').eq(0).text(desc);
	    	                	if(desc_name) $('#'+key).find('h6').text(desc_name);
	    	                	
	    	                	if(pic.indexOf(".") > 0 )
	    	                	{
	    	                		$('#'+key).find('samp').text('M '+pic);
	    	                	}else{
	    	                		$('#'+key).find('samp').text('M '+pic+'.00');
	    	                	}
	    	            		
	    	            		$('#'+key).find('a').eq(0).attr("href",url);

	    	            	    $('.fancybox-478').hide();
	    	            		$('.fancybox-top').hide();
	    	                	$('.fancybox4').hide();
	    	                	$('.fancybox-50').hide();
			                }

			             
			                 if(data.img_path) $('#'+key).find('img').attr("src",data.img_path);
			             

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
//点击编辑按钮－js

	function edit(key){ 
		
    	arr=key.split('_');
     	duibi = arr[0];

     	$('#biaoshi li input[name=link_path]').val($('#'+key).find('a').eq(0).attr("href"));
     	
    	if(duibi == 'top'){ 
        	$('#biaoshi li span').text('图片尺寸：1920X181');
        }else if(duibi == 'product'){ 
        	$('#biaoshi li span').text('图片尺寸：582x358');
        }else if(duibi == 'carousel-img'){ 
        	$('#biaoshi li span').text('图片尺寸：1920X435');
        }else if(duibi == 'product-mid'){ 
        	$('#biaoshi li span').text('图片尺寸：381x285');
        }
    	$('#biaoshi input[name=tem_key]').val(key);
    	$('.fancybox-top').show();
    }
    
   function on_sub(){ 
        var link_path = $('#biaoshi input[name=link_path]').val();
        var tem_key   = $('#biaoshi input[name=tem_key]').val();
        
        _upload('','',link_path,tem_key,'file');
   }

   function on_product_sub(){ 
       var link_path = $('#biaoshi_1 input[name=link_path]').val();
       var tem_key   = $('#biaoshi_1 input[name=tem_key]').val();
       var desc = $('#biaoshi_1 input[name=desc]').val();
      
       _upload(desc,'',link_path,tem_key,'file1');
  }
   

    function carry_out(){
        var key = $('#biaoshi_3').find('input').eq(1).val();
        _upload('', '', '', key,'file3');
    }
    

    function publishTemp()
	{
		$.post("<?php echo site_url('flagship/issue_flagship_two_temp/')?>","",function(data){
		if(data) alert('ok');
			
		});
	}



    $(function (){

    	
        var html = '';
        var classify = '';
        var top_classify= '';
        var page = '';
    	$.post('<?php echo site_url('flagship');?>',{corp:<?php echo $corp;?>},function(data){
    	    data = jQuery.parseJSON(data);
    	   
    	    //商品
    	    for(var i=0;i<data['produtList'].length;i++){
        	    
                    html += '<dd>';
        	   
        	    	html += '<div class="lib_Contentbox_nei">';
            	    
                    html += '<span><a href="#"><img src="<?php echo IMAGE_URL?>/../'+data['produtList'][i]['goods_thumb']+'"></a></span>';
                    html += '<h5><samp>'+data['produtList'][i]['name']+'</samp></h5>' ;
                    html += '<p>M '+data['produtList'][i]['vip_price']+'</p>';
                    html +='<ul>';

                    html +='<li>';
                    html +='<a class="nei_top"href="#">购买</a>';
                    html +='</li><li>';
//                     html +='<a class="nei_top1"href="#">关注</a></li>';
//                     html +='<li><a href="javascript:;">对比</a></li>';
                    html +=' </ul> </div>';
                    html +='</dd>';
        	    }
    	    //全部分类
    	    for(var i=0;i<data['shop_classify'].length;i++){
                classify += '<li class="macth_xvitem" data-bind="attr:{data-submenu-id:$data.id}" data-submenu-id="speedMenu517">';
                classify += '<h3>'
                classify += '<span></span><span class="macth_xvh3_a"><a href="javascript:;" onclick="top_shop_classify('+data['shop_classify'][i]['id']+','+data['corp_id']+')" class="">'+data['shop_classify'][i]['section_name']+'</a></span><s style="display: block;"></s>'
                classify += '</h3>' 
                classify += '</li>'
    	    }

      	  //顶级分类
    	    for(var i=0;i<data['top_shop_classify'].length;i++){
                top_classify += '<li onclick="top_shop_classify('+data['top_shop_classify'][i]['id']+','+data['corp_id']+',this)"><a href="javascript:;" >'+data['top_shop_classify'][i]['section_name']+'</a></li>';
    	    }
    	   //分页显示
      	    page += '<span id="page">';
    	    page +='<span>共'+data['total_rows']+'条纪录</span>&nbsp';
    	    var pageNum = Math.ceil(data['total_rows']/20);//页数
    	    if(pageNum !== 1){
    	    page +='<a href="javascript:void(0);" class="lPage" id="previous" >上一页</a>&nbsp;';
    	    }
    	    for(var i=1;i<=pageNum;i++){
    	        page +='<a id=page_'+i+' href="javascript:void(0);" class="cpage" onclick="pagination('+i+','+pageNum+',1);">'+i+'</a>&nbsp;';
    	    }
    	    if(pageNum !== 1){
           	page +='<a href="javascript:void(0);" class="lPage" id="next" onclick="pagination(2,'+pageNum+',2);">下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    	    }
           	page += '</span>';
           	
            $('.media_showpage').html(page);   
    	    $('#top_shop_classify').html(top_classify);
    	    $('.macth-dropdown-menu').html(classify);
    	    $('#guanjie_media_goods').html(html);
        	});

        	
    });

    		//ajax 分页
		//status 0上一页1选择页2下一页
		function pagination(page,total,status){
			$('#next').show();
	    	$('#previous').show();
			switch(status){
			case 0:
				$('#next').show();
				$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2)');
				if(page==1){
					 $('#previous').hide();
					 break;
					}
				$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0)');
				break;
			case 1:
		 		if(total==page){
					 $('#next').hide();
					 $('#previous').show();
					}else if(page==1){
						$('#previous').hide();
						$('#next').show();
						}
		 		$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0)');
		 		$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2)');
				break;
			case 2:
				$('#previous').show();
				$('#previous').attr('onclick','pagination('+(page*1-1*1)+','+total+',0)');
		 		if(total==page){
				 $('#next').hide();
				 break;
				}
				$('#next').attr('onclick','pagination('+(page*1+1*1)+','+total+',2)');
				break;
			}

			var html = '';
			$.post('<?php echo site_url('flagship/pagination');?>',{page:page,corp:<?php echo $corp;?>},function(data){
			    data = jQuery.parseJSON(data);
			    
	    			    for(var i=0;i<data.length;i++){
	                	    
	    			    	 html += '<dd>';
	    		        	   
	    	        	    	html += '<div class="lib_Contentbox_nei">';
	    	            	    
	    	                    html += '<span><a href="#"><img src="<?php echo IMAGE_URL?>/../'+data[i]['goods_thumb']+'"></a></span>';
	    	                    html += '<h5><samp>'+data[i]['name']+'</samp></h5>' ;
	    	                    html += '<p>M '+data[i]['vip_price']+'</p>';
	    	                    html +='<ul>';

	    	                    html +='<li>';
	    	                    html +='<a class="nei_top"href="#">购买</a>';
	    	                    html +='</li><li>';
// 	    	                    html +='<a class="nei_top1"href="#">关注</a></li>';
//	    	                     html +='<li><a href="javascript:;">对比</a></li>';
	    	                    html +=' </ul> </div>';
	    	                    html +='</dd>';
	                            }
	    			    $('#guanjie_media_goods').html(html);
				});
			$('.cpage').css('background','');
			$('#page_'+page).css('background','#ccc');
			}

	    function bg_color(){ 
	        var bg = $('input[name=bg_color]').val();
	        var key = $('#bgckground_color input[name=tem_key]').val();
	        $.ajax({ 
				url:"<?php echo site_url('corporate/myshop/edit_temp_title')?>",
				data:{desc:bg,tem:5,temp_key:key},
				type:'post',
				dataType:'json',
				success:function(data){ 
					if(data){ 
						$('#'+key).css('background',bg);
						$('.fancybox_color').hide();
					}
				}
		    })
	    }

	    function resetTemplate()
		{
			if(confirm("是否重置该模板?重置后,所有内容将会掉失!!"))
			{
				window.location = "<?php echo site_url('corporate/myshop/ResetTemplate/5')?>";
			}
		}
</script>