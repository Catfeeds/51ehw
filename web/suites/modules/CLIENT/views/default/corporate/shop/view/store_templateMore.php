<!doctype html>
<html><head>
<meta charset="utf-8">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
<META HTTP-EQUIV="expires" CONTENT="Wed, 26 Feb 1997 08:21:57 GMT">
<title><?php echo $this->session->userdata('app_info')['app_name'];?> - 店铺装修</title>
<base href="<?php echo THEMEURL; ?>" />
<meta name="keyword"
	content="<?php echo $this->session->userdata('app_info')['seo_keyword'];?>">
<meta name="description"
	content="<?php echo $this->session->userdata('app_info')['seo_description'];?>">
<link rel="stylesheet" type="text/css" href="css/fancymain.css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">
<link href="css/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/style_v2.css" rel="stylesheet" type="text/css">
<link href="css/store.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/jquery.easie.js"></script>
<script type="text/javascript" src="js/my.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.1.pack.js"></script>
<script src="js/ajaxfileupload.js" type="text/javascript"></script>
<style>
.macth_xv_menu {    
    padding-left: 180px;  
}

</style>

<title>51易货网</title>
</head>

<body>
	<!--页头编辑 开始-->
    <div class="store_headEdit">
    	<div class="store_headEdit_con">
        	<div class="headEdit_btnLeft">
            	<ul>
                	<?php  if(isset($corporate['grade']) && $corporate['grade'] > 1 ):?>
                            <?php  if($this->session->userdata['corporation_id'] == 157 ):?>
                    <li><a href="<?php echo site_url('flagship/select_flagship_temp');?>" class="btn_pageEdit ">旗舰店模板</a></li>
                    <li><a href="<?php echo site_url('flagship/flagship_two_temp');?>" class="btn_pageEdit ">旗舰店模板二</a></li>
                            <?php endif;?>
                    <?php  if($this->session->userdata['corporation_id'] == 150 ):?>
                    <li><a href="<?php echo site_url('flagship/flagship_three_temp');?>" class="btn_pageEdit ">旗舰店模板三</a></li>
                    <?php endif;?>
        			<li><a href="<?php echo site_url('corporate/myshop/renovate');?>" class="btn_pageEdit">模板一</a><li>
        			<li><a href="<?php echo site_url('corporate/myshop/select_goods_temp');?>" class="btn_pageEdit">模板二</a><li>
        			
<!--             		<li><a href="#" class="btn_templateSelect">模版选择</a></li> -->
        			<?php endif;?>
                </ul>
            </div>
            <div class="headEdit_btnRight">
            	<ul>
            	    <li><a onclick="javascript:resetTemplate()" class="btn_pageSave">重置</a></li>
            		<li><a href="<?php echo site_url('corporate/myshop/select_three_shop')?>" class="btn_pagePreview">预览</a></li>
                	<li><a onclick="javascript:publishTemp()" class="btn_pageRelease">发布</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--页头编辑 结束-->
 	<!--页头开始-->
    <div class="store_head">
      <div class="store_head_con">
        	<a href="http://www.51ehw.com/index.php" class="logo_set" title="51易货网"><img alt="51易货网" src="images/eh_logo.jpg"></a>       
        	<span class="store_head_span">店铺名称</span>
<!--         	<span>旗舰店会员</span> -->
        	<div class="store_head_search clearfix">
                <div class="store_head_search01">
                    <input class="store_head_input" type="text" placeholder="搜索内容">
                    <a href="" class="search_total_station">搜全站</a>
                </div>
<!--                 <div class="store_head_search02"><a href="">搜本店</a></div> -->
            </div>
      </div>
    </div>
	<!--页头 结束-->
    <!--店铺头部 开始-->
    <div class="hover_it" style="position:relative;">
	<div class="store_top">
    	<div class="store_top_con" id="top"><a href='<?php echo isset($list["top"]) ? $list["top"]['link_path'] : ''?>'><img src="<?php echo isset($list['top']) ? IMAGE_URL.$list['top']['img_path']: 'images/store_topBanner.png';?>" width='1920' height='100'alt=""/></a></div>
        <!--编辑区 开始-->
        
        <div class="editCon">
            <div class="editBtnCon clearfix">
            	<a href="javascript:;" class="editBtn" onclick="header('top')">编辑</a>
            </div>
        </div>
        <!--编辑区 结束-->
	</div>
    </div>
    <!--店铺头部 结束-->
	<!--头部导航条 开始 编辑往里面加hover_it 和style样式即可-->
    <div class="eh_navbar clearfix hover_it" style="position: relative;">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu">
               <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="">全部分类<b class="icon-select"></b></a></h2>
                    </div>
                    
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu517">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">分类1</a></span><s style="display: block;"></s>
                                </h3> 
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu496">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">分类2</a></span><s style="display: block;"></s>
                                </h3>
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu141">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">分类3</a></span><s style="display: block;"></s>
                                </h3>
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu931">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">分类4</a></span><s style="display: block;"></s>
                                </h3>
                            </li>
                             <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu931">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">分类5</a></span><s style="display: block;"></s>
                                </h3>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                <ul class="macth_xv_nav">
                    <li class="macth_liactive"><a href="<?php echo site_url("home");?>">首页</a></li>
                    <?php for($i=0; $i<5; $i++):?>
                    <li><a href=""><?php echo isset($list["railing-title_$i"]) ? $list["railing-title_$i"]['desc']: '分类'?></a></li><!--默认五个分类-->
                    <?php endfor;?>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>
        <!--编辑区 开始-->
        <div class="editCon">
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" style="margin-top: 2px;">编辑</a></div>
        </div>
        <!--编辑区 结束-->
    </div> 
	<!--头部导航条 结束-->
    <!--清除浮动 开始-->
    <div class="clearfix">
        <!--Banner内容 开始-->
        <div class="carousel hover_it" style="position: relative;">
         <div class="bd">
            <ul class="imageslist">
            <?php for($i=1; $i<5; $i++):?>
                <li id="<?php echo 'carousel-img_'.$i?>"><a href="<?php echo isset($list["carousel-img_$i"]) ? $list["carousel-img_$i"]['link_path'] : ''?>"><img src="<?php echo isset($list["carousel-img_$i"]) ? IMAGE_URL.$list["carousel-img_$i"]['img_path']: 'images/store_banner.png'?>" /></a></li>
            <?php endfor;?>
            </ul>
            </div>
            <div class="buttons">
                <a class="leftBtn"></a>
                <a class="rightBtn"></a>
            </div>
            <div class="bg"></div>
            <div class="num">
                <span class="cur"></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <!--编辑区 开始-->
            <div class="editCon">
                <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="header('carousel-img_1')" >编辑轮播图一</a></div>
                <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="header('carousel-img_2')" >编辑轮播图二</a></div>
                <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="header('carousel-img_3')" >编辑轮播图三</a></div>
                <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="header('carousel-img_4')" >编辑轮播图四</a></div>
            </div>
            <!--编辑区 结束-->
        </div>
        <script type="text/javascript" src="js/chuantong.js"></script>
        <script type="text/javascript">
            chuantong(300,4000,1200);
        </script>
        <!--Banner内容 结束-->
        <!--热门专区内容 开始-->
        <div class="store_hotzone clearfix">
            <div class="hover_it" style="position:relative;">
                <h3 class="productfloor_right_title"><span id="one_title"><?php echo isset($list['one_title']) ? $list['one_title']['desc']: '标题一'?></span>
                    <div class="editCon">
                        <a href="javascript:;" class="editBtn_little" onclick="edit_title('one_title')">编辑</a>
                    </div>
                </h3>
            </div>
            <div class="hotzone_left">
                <ul>
                    <?php for($i = 1; $i<3; $i++):?>
                        <li class="hover_it" style="position: relative;" id="<?php echo 'one-left-menu_'.$i?>">
                        	<a href="<?php echo isset($list["one-left-menu_$i"]) ? $list["one-left-menu_$i"]['link_path'] : ''?>"><img src="<?php echo isset($list["one-left-menu_$i"]) ? IMAGE_URL.$list["one-left-menu_$i"]['img_path'] : 'images/store_hotzone01.png'?>" width="328" height="478" alt=""/></a>
                            <!--编辑区 开始-->
                            <div class="editCon">
                               	<a href="javascript:;" class="editBtn" onclick="menu(<?php echo "'one-left-menu_$i'"?>)">编辑</a>
                            </div>
                            <!--编辑区 结束-->
                        </li>
                    <?php endfor;?>
                </ul>
            </div>
            <div class="hotzone_right">
                <ul>
                <?php for($i = 1; $i<3; $i++):?>
                    <li class="hover_it" style="position: relative;" id="<?php echo 'one-right-menu_'.$i?>">
                    	<a href="<?php echo isset($list["one-right-menu_$i"]) ? $list["one-right-menu_$i"]['link_path'] : ''?>"><img src="<?php echo isset($list["one-right-menu_$i"]) ? IMAGE_URL.$list["one-right-menu_$i"]['img_path'] : 'images/store_hotzone02.png'?>" width="516" height="232" alt=""/></a>
                        <!--编辑区 开始-->
                        <div class="editCon">
                            <a href="javascript:;" class="editBtn" onclick="menu(<?php echo "'one-right-menu_$i'"?>)">编辑</a>
                        </div>
                        <!--编辑区 结束-->
                    </li>
                <?php endfor;?>
                </ul>
            </div>
        </div>
        <!--热门专区内容 结束--> 
        <!--新品上市内容 结束-->
        <div class="store_newarrival clearfix">
          <div class="hover_it" style="position:relative;">
                  <h3 class="productfloor_right_title"><span id="two_title" style=" font-size:20px; color:#fea33b; font-weight:bold;"><?php echo isset($list['two_title']) ? $list['two_title']['desc']: '标题二'?></span>
                      <div class="editCon">
                          <a href="javascript:;" class="editBtn_little" onclick="edit_title('two_title')">编辑</a>
                      </div>
                  </h3>
              </div>
           <ul>
           <?php for($i = 1; $i< 9; $i++):?>
               <li class="hover_it" style="position: relative; <?php if($i == 4 || $i == 8) echo 'margin-right:0'?>" id="<?php echo 'two-menu_'.$i?>">
                   <a href="<?php echo isset($list["two-menu_$i"]) ? $list["two-menu_$i"]['link_path']:''?>"><img src="<?php echo isset($list["two-menu_$i"]) ? IMAGE_URL.$list["two-menu_$i"]['img_path']:'images/store_newarrival01.png'?>" width="283" height="283" alt=""/></a>
                   <p>
                       <a href=""><span style="color: #555; font-size: 14px;margin-top: 10px;line-height: 20px;"><?php echo isset($list["two-menu_$i"]) ? $list["two-menu_$i"]['desc'] :'商品描述'?></span></a>
                   </p>
              	   <span><a style="color: #de1515">M <?php echo isset($list["two-menu_$i"]) ? $list["two-menu_$i"]['vip_price']: '0.00'?></a></span>
                   <!--编辑区 开始-->
                   <div class="editCon">
                       <a href="javascript:;" class="editBtn" onclick="menu(<?php echo "'two-menu_$i'"?>)">编辑</a>
                   </div>
                   <!--编辑区 结束-->
               </li>
           <?php endfor;?>
             
          </ul>
        </div>
        <!--新品上市内容 结束-->
        <!--页面banner 开始-->
        <div class="hover_it fancybox_midBanner" style="position: relative;">
      	<div class="store_midBanner">
        	<div class="store_midBanner_con" id="mid"><a href="<?php echo isset($list['mid']) ? $list['mid']['link_path']: ''?>"><img src="<?php echo isset($list['mid']) ? IMAGE_URL.$list['mid']['img_path']: 'images/store_midbanner.png'?>" width='1920' height='190' alt=""/></a></div>
            <!--编辑区 开始-->
            <div class="editCon">
                <div class="editBtnCon clearfix">
<!--                 	<a href="javascript:;" class="hideBtn">隐藏</a> -->
                    <a href="javascript:;" class="editBtn" onclick="header('mid')">编辑</a>
                </div>
            </div>
            <!--编辑区 结束-->
      	</div>
        </div>
        <!--页面banner 结束-->
        <!--页面搜索 开始-->
         <!--            <div class="store_storesearch hover_it" style="position: relative;">
<!--             	<span>本店搜索：</span> -->
<!--                 <div class="storesearch_input01_bg"> -->
<!--                 	<input class="storesearch_input01" type="text" placeholder="输入关键字"> -->
<!--                 </div> -->
<!--                 <div class="storesearch_input02_bg"> -->
<!--                 	<input class="storesearch_input02" type="text" placeholder="¥"> -->
<!--                 </div> -->
<!--                 <span class="storesearch_span">—</span> -->
<!--                 <div class="storesearch_input02_bg"> -->
<!--                 	<input class="storesearch_input02" type="text" placeholder="¥"> -->
<!--                 </div> -->
<!--                 <div class="storesearch_btn"><a href="">搜索</a></div> -->
                <!--编辑区 开始-->
<!--                 <div class="editCon" id="search_on_off"> -->
                <?php // if( isset($list['search_frame']) ):?>
                  <!--  <div class="editBtnCon clearfix"><a href="javascript:;" class="hideBtn" onclick="hide('hide','search_frame',<?php //echo $list['search_frame']['id']?>)">隐藏</a></div>
                <?php // else:?>
                    <div class="editBtnCon clearfix"><a href="javascript:;" class="hideBtn" onclick="hide('show','search_frame')">显示</a></div>
                <?php // endif;?>
<!--                 </div> -->
                <!--编辑区 结束-->
<!--             </div> -->
        
        <!--页面搜索 结束-->
        <!--产品楼层 开始-->
        <div class="store_productfloor clearfix">
        <div class="clearfix">
        <!--产品楼层左边内容 开始-->
        <div class="productfloor_left">
          <!--排行榜 开始-->
          <div class="productfloor_left_rankingList">
              <div class="rankingList_head">排行榜</div>
              <div class="rankingList_top">
                  <ul>
                      <li class="rankingList_top_current"><a>收藏量</a></li>
                      <li id="sales"><a>销售量</a></li>
                  </ul>
              </div>
              <div class="rankingList_con" id="rankingList_one">
                  <?php if( count($product_fav) > 0 ):?>
                	<ul>
                    	<?php foreach($product_fav as $v):?>
                        	<li>
                            	<a href="<?php echo site_url('goods/detail/'.$v['id'])?>" class="rankingList_img"><img src="<?php if(!empty($v['goods_img'] ) ) echo IMAGE_URL.$v['goods_img']; else echo 'images/rankingList_pic01.png';?>" width="60" height="60" alt=""/></a>
                                <span class="rankingList_title"><a href="<?php echo site_url('goods/detail/'.$v['id'])?>"><?php echo $v['name']?></a></span><br>
                                <span class="rankingList_price"><a href="<?php echo site_url('goods/detail/'.$v['id'])?>">M <?php echo $v['vip_price']?></a></span><br>
                                <span class="rankingList_number">已售出<i> <?php echo $v['sales_count']?> </i>笔</span>
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>

<!--                     <span class="rankingList_more"><a href="">查看更多产品</a></span> -->

                </div>
                <div class="rankingList_con" id="rankingList_two" hidden>
                <?php if( count($product_sales) > 0 ):?>
                	<ul>
                	<?php foreach($product_sales as $v):?>
                        <li>
                        	<a href="<?php echo site_url('goods/detail/'.$v['id'])?>" class="rankingList_img"><img src="<?php if(!empty($v['goods_img'] ) ) echo IMAGE_URL.$v['goods_img']; else echo 'images/rankingList_pic01.png';?>" width="60" height="60" alt=""/></a>
                            <span class="rankingList_title"><a href="<?php echo site_url('goods/detail/'.$v['id'])?>"><?php echo $v['name']?></a></span><br>
                            <span class="rankingList_price"><a href="<?php echo site_url('goods/detail/'.$v['id'])?>">M <?php echo $v['vip_price']?></a></span><br>
                            <span class="rankingList_number">已售出<i> <?php echo $v['sales_count']?> </i>笔</span>
                        </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>

<!--                   <span class="rankingList_more"><a href="">查看更多产品</a></span> -->

              </div>
          </div>
          <!--排行榜 结束-->  
          <!--推荐 开始-->
          <div class="productfloor_left_recommend">
            <div class="rankingList_head">推荐</div>
            <div class="recommend_con">
                <ul>
                    <?php for($i=1; $i<5; $i++):?>
                        <li class="hover_it" style="position:relative;" id="<?php echo 'left-menu_'.$i?>">
                            <a href="<?php echo isset($list["left-menu_$i"]) ? $list["left-menu_$i"]['link_path']:''?>"><img src="<?php echo isset($list["left-menu_$i"]) ? IMAGE_URL.$list["left-menu_$i"]['img_path'] : 'images/recommend_pic01.png'?>" width="200" height="172" alt=""/></a>
                            <span class="rankingList_title"><a href=""><?php echo isset($list["left-menu_$i"]) ? $list["left-menu_$i"]['desc'] : '商品描述'?></a></span><br>
                            <span class="rankingList_price"><a href="">M <?php echo isset($list["left-menu_$i"]) ? $list["left-menu_$i"]['vip_price'] : '0.00'?></a></span>
                            <!--编辑区 开始-->
                            <div class="editCon">
                                <a href="javascript:;" class="editBtn_little" onclick="menu(<?php echo "'left-menu_$i'"?>)">编辑</a>
                            </div>
                            <!--编辑区 结束-->
                        </li>
                    <?php endfor;?>
                </ul>

<!--                 <span class="rankingList_more"><a href="">查看更多产品</a></span> -->

            </div>
            <!--编辑区 开始-->
            <div class="editCon">
                <a href="javascript:;" class="editBtn">编辑</a>
            </div>
            <!--编辑区 结束-->
            </div>
          <!--推荐 结束-->    
        </div>
        <!--产品楼层左边内容 结束-->
        <!--产品楼层右边内容 开始-->
        <div class="productfloor_right">
        	<!--热卖爆款 开始-->
        	<div class="productfloor_right_hotSale productfloor00">
                <div class="hover_it" style="position:relative;">
                    <h3 class="productfloor_right_title"><span id="three_title"><?php echo isset($list['three_title']) ? $list['three_title']['desc']: '标题三'?></span>
                        <div class="editCon">
                            <a href="javascript:;" class="editBtn_little" onclick="edit_title('three_title')">编辑</a>
                        </div>
                    </h3>
                </div>
                <ul>
                    <?php for($i = 1; $i<7; $i++):?>
                    	<li class="hover_it" style="position:relative; <?php if($i == 3 || $i == 6) echo 'margin-right:0'?>" id="<?php echo 'three-menu_'.$i?>">
                        	<a href="<?php echo isset($list["three-menu_$i"]) ? $list["three-menu_$i"]['link_path']:''?>"><img src="<?php echo isset($list["three-menu_$i"]) ? IMAGE_URL.$list["three-menu_$i"]['img_path'] : 'images/hotSale_pic1.png'?>" width="304" height="304" alt=""/></a>
                            <span class="hotSale_title"><a href=""><?php echo isset($list["three-menu_$i"]) ? $list["three-menu_$i"]['desc'] : '商品描述'?></a></span><br>
                            <span class="hotSale_price"><a href="">M <?php echo isset($list["three-menu_$i"]) ? $list["three-menu_$i"]['vip_price'] : '0.00'?></a></span>
                            <!--编辑区 开始-->
                            <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="menu(<?php echo "'three-menu_$i'"?>)">编辑</a>
                            </div>
                            <!--编辑区 结束-->
                        </li>
                    <?php endfor;?>
                   
                </ul>
            <!--编辑区 开始-->
            <!--<div class="editCon">
                <a href="javascript:;" class="editBtn">编辑</a>
                <a href="javascript:;" class="deleteBtn">删除</a>
            </div>-->
            <!--编辑区 结束-->
            </div>
            <!--热卖爆款 结束-->
            <!--F1 开始-->
        	<div class="productfloor_right_hotSale">
            	<div class="hover_it" style="position:relative;">
                    <h3 class="productfloor_right_title"><span id="four_title"><?php echo isset($list['four_title']) ? $list['four_title']['desc']: '标题四'?></span>
                        <div class="editCon">
                            <a href="javascript:;" class="editBtn_little" onclick="edit_title('four_title')">编辑</a>
                        </div>
                    </h3>
                </div>
                <ul>
                    <?php for($i = 1; $i<7; $i++):?>
                  
                    	<li class="hover_it" style="position:relative; <?php if($i == 3 || $i== 6 ) echo 'margin-right:0'?>" id="<?php echo 'four-menu_'.$i?>">
                        	<a href="<?php echo isset($list["four-menu_$i"]) ? $list["four-menu_$i"]['link_path']:''?>"><img src="<?php echo isset($list["four-menu_$i"]) ? IMAGE_URL.$list["four-menu_$i"]['img_path'] : 'images/hotSale_pic1.png'?>" width="304" height="304" alt=""/></a>
                            <span class="hotSale_title"><a href=""><?php echo isset($list["four-menu_$i"]) ? $list["four-menu_$i"]['desc'] : '商品描述'?></a></span><br>
                            <span class="hotSale_price"><a href="">M <?php echo isset($list["four-menu_$i"]) ? $list["four-menu_$i"]['vip_price'] : '0.00'?></a></span>
                            <!--编辑区 开始-->
                            <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="menu(<?php echo "'four-menu_$i'"?>)">编辑</a>
                            </div>
                            <!--编辑区 结束-->
                        </li>
                    <?php endfor;?>
                </ul>
                <!--编辑区 开始-->
                <!--<div class="editCon">
                    <a href="javascript:;" class="editBtn">编辑</a>
                    <a href="javascript:;" class="deleteBtn">删除</a>
                </div>-->
                <!--编辑区 结束-->
            </div>
            <!--F1 结束-->
            <!--F2 开始-->
        	<div class="productfloor_right_hotSale">
            	<div class="hover_it" style="position:relative;">
                    <h3 class="productfloor_right_title"><span id="five_title"><?php echo isset($list['five_title']) ? $list['five_title']['desc']: '标题五'?></span>
                        <div class="editCon">
                            <a href="javascript:;" class="editBtn_little" onclick="edit_title('five_title')">编辑</a>
                        </div>
                    </h3>
                </div>
                <ul>
                    <?php for($i = 1; $i<7; $i++):?>
                    	<li class="hover_it" style="position:relative; <?php if($i == 3 || $i== 6 ) echo 'margin-right:0'?>" id="<?php echo 'five-menu_'.$i?>">
                        	<a href="<?php echo isset($list["five-menu_$i"]) ? $list["five-menu_$i"]['link_path']:''?>"><img src="<?php echo isset($list["five-menu_$i"]) ? IMAGE_URL.$list["five-menu_$i"]['img_path'] : 'images/hotSale_pic1.png'?>" width="304" height="304" alt=""/></a>
                            <span class="hotSale_title"><a href=""><?php echo isset($list["five-menu_$i"]) ? $list["five-menu_$i"]['desc'] : '商品描述'?></a></span><br>
                            <span class="hotSale_price"><a href="">M <?php echo isset($list["five-menu_$i"]) ? $list["five-menu_$i"]['vip_price'] : '0.00'?></a></span>
                            <!--编辑区 开始-->
                            <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="menu(<?php echo "'five-menu_$i'"?>)">编辑</a>
                            </div>
                            <!--编辑区 结束-->
                        </li>
                    <?php endfor;?>
                </ul>
                <!--编辑区 开始-->
                <!--<div class="editCon">
                    <a href="javascript:;" class="editBtn">编辑</a>
                    <a href="javascript:;" class="deleteBtn">删除</a>
                </div>-->
                <!--编辑区 结束-->
            </div>
            <!--F2 结束-->
            <!--F3 开始-->
        	<div class="productfloor_right_hotSale productfloor_f1">
            	<div class="hover_it" style="position:relative;">
                    <h3 class="productfloor_right_title"><span id="six_title"><?php echo isset($list['six_title']) ? $list['six_title']['desc']: '标题六'?></span>
                        <div class="editCon">
                            <a href="javascript:;" class="editBtn_little" onclick="edit_title('six_title')">编辑</a>
                        </div>
                    </h3>
                </div>
                <ul>
                	<?php for($i = 1; $i<7; $i++):?>
                    	<li class="hover_it" style="position:relative; <?php if($i == 3 || $i== 6 ) echo 'margin-right:0'?>" id="<?php echo 'six-menu_'.$i?>">
                        	<a href="<?php echo isset($list["six-menu_$i"]) ? $list["six-menu_$i"]['link_path']:''?>"><img src="<?php echo isset($list["six-menu_$i"]) ? IMAGE_URL.$list["six-menu_$i"]['img_path'] : 'images/hotSale_pic1.png'?>" width="304" height="304" alt=""/></a>
                            <span class="hotSale_title"><a href=""><?php echo isset($list["six-menu_$i"]) ? $list["six-menu_$i"]['desc'] : '商品描述'?></a></span><br>
                            <span class="hotSale_price"><a>M <?php echo isset($list["six-menu_$i"]) ? $list["six-menu_$i"]['vip_price'] : '0.00'?></a></span>
                            <!--编辑区 开始-->
                            <div class="editCon">
                                <a href="javascript:;" class="editBtn" onclick="menu(<?php echo "'six-menu_$i'"?>)">编辑</a>
                            </div>
                            <!--编辑区 结束-->
                        </li>
                    <?php endfor;?>
                </ul>
            </div>
            <!--F3 结束--> 
        </div>
        <!--产品楼层右边内容 结束-->
        </div>
        <!--<div class="productfloor_addBtn"><a href="">添加楼层</a></div>--><!--此处点击后可以新增楼层-->
        </div>
        <!--产品楼层 结束-->
    </div>
    <!--清除浮动 结束-->
    <!--页尾banner 开始-->
    <div class="hover_it" style="position:relative">
        <div class="store_endBanner">
            <div class="store_endBanner_con" id="end"><a href="<?php echo isset($list['end']) ? $list['end']['link_path']: ''?>"><img src="<?php echo isset($list['end']) ? IMAGE_URL.$list['end']['img_path']: 'images/store_midbanner.png'?>" width='1920' height='250' alt=""/></a></div>
            <!--编辑区 开始-->
            <div class="editCon">
                <div class="editBtnCon clearfix">
<!--                     <a href="javascript:;" class="hideBtn">隐藏</a> -->
                    <a href="javascript:;" class="editBtn" onclick="header('end')">编辑</a>
                </div>
            </div>
            <!--编辑区 结束-->
        </div>
    </div>
    <!--页尾banner 结束-->
    
 	<!--弹出层 fancybox0 编辑轮播图banner 开始-->
    
    <!--弹出层 fancybox0 编辑轮播图banner 结束-->
    
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
                    <div class="fancybox-editCon-right clearfix">
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
                        <a href="javascript:;" class="fancybox_back fancybox_back1">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="edit_menu()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox1 编辑导航nav 结束--> 
    
    <!--弹出层 fancybox-304 编辑 开始-->
    
    <!--弹出层 fancybox-304 编辑 结束--> 
    
    <!--弹出层热门专区左边 fancybox-478 编辑 开始-->
    <div class="fancybox-478" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑商品</div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div style="width:auto;height:auto;overflow: auto;position:relative;">
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>上传商品图片：</li>
                            <li>编辑商品标题：</li>
                            <li>编辑商品价格：</li>
                            <li>商品链接地址：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_2">
                            <li><!-- <a href="javascrip:;" class="fancybox-update">选择图片</a>--> <input type="file" id="file2" name="file"><span class="">图片尺寸：328X478 </span></li>
                            <li><input class="fancybox-input" type="text" name= 'desc' value=''placeholder="商品标题"></li>
                            <li><input class="fancybox-input" type="text" name= 'pic' placeholder="0.00" value=''></li>
                            <li><input class="fancybox-input" type="text" name= 'url' placeholder="链接须以http://开头,不允许添加51易货网外的链接" value=''></li>
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
                        <a href="javascript:;" class="fancybox_okay" onclick="edit()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层热门专区左边 fancybox-478 编辑 结束--> 
    
    <!--弹出层 fancybox-283 编辑 开始-->
    
    <!--弹出层 fancybox-283 编辑 结束--> 
    
    <!--弹出层热门专区右边 fancybox-232 编辑 开始-->
    
    <!--弹出层热门专区右边 fancybox-232 编辑 结束--> 
    
    <!--弹出层 fancybox-200 编辑 开始-->
    
    <!--弹出层 fancybox-200 编辑 结束-->
    
    <!--弹出层 fancybox-top 编辑仅图片 开始-->
    <div class="fancybox-top" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑商品</div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div style="width:auto;height:auto;overflow: auto;position:relative;">
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>上传商品图片：</li>
                            <li>商品链接地址：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_1">
                        <li><!-- <a href="javascrip:;" class="fancybox-update">选择图片</a>--> <input type="file" id="file1" name="file"><span class="">图片尺寸：1920X100</span></li>
                            <li><input class="fancybox-input" type="text" name="url" placeholder="链接须以http://开头,不允许添加51易货网外的链接" value=''></li>
                        </ul>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back-top">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="touwei()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox-top 编辑仅图片 结束--> 
    
    <!--弹出层 fancybox-mid 编辑仅图片 开始-->
    
    <!--弹出层 fancybox-mid 编辑仅图片 结束--> 
    
    <!--弹出层 fancybox-end 编辑仅图片 开始-->
    
    <!--弹出层 fancybox-end 编辑仅图片 结束--> 
    
    <!--弹出层 fancybox4 编辑仅标题 开始-->
    <div class="fancybox4" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑商品</div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div style="width:auto;height:auto;overflow: auto;position:relative;">
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>分类标题：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_3">
                            <li><input class="fancybox-input" type="text" placeholder="热卖爆款"></li>
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
</body>

<script>
	//收藏量与销售量切换内容js
	$(".rankingList_top_current").mouseover(function(){
		$(".rankingList_top_current").css("background","#ccc");
		$("#sales").css("background","#fff");
		$("#rankingList_one").show();
		$("#rankingList_two").hide();
	})
	$("#sales").mouseover(function(){
		$("#sales").css("background","#ccc");
		$(".rankingList_top_current").css("background","#fff");
		$("#rankingList_two").show();$("#rankingList_one").hide();
	})
	$(function(){
		$('.hover_it').hover(function(e) {
            $(this).children('div.editCon').show();
        },function(){
			$(this).children('div.editCon').hide();
		});
	});


	//点击头部banner编辑按钮，弹出层仅编辑图片内容
	function header(key){ 
		arr=key.split('_');
     	duibi = arr[0];
		$('#biaoshi_1 li input[name=url]').val($('#'+key).find('a').eq(0).attr("href"));
		
		if(duibi == 'top'){ 
			$('#biaoshi_1 li span').text('图片尺寸：1920x100');
	    }else if(duibi == 'mid'){ 
	    	$('#biaoshi_1 li span').text('图片尺寸：1920x190');
		}else if(duibi == 'carousel-img'){ 
			$('#biaoshi_1 li span').text('图片尺寸：1200X500');
	    }else{ 
			$('#biaoshi_1 li span').text('图片尺寸：1920x250');
	    }
		$('#biaoshi_1 li').eq(2).remove();
		$('#biaoshi_1').append("<li><input type='hidden' name='temp_key' value="+key+"></li>");
		$('.fancybox-top').show();
    }

    function menu(key){ 
    	var val = $('#'+key).find('span').eq(1).text().substr(2);
    	arr=val.split('.');
    	arr = arr[0];
    	 $('#biaoshi_2 li input[name=desc]').val($('#'+key).find('span').eq(0).text());
         $('#biaoshi_2 li input[name=pic]').val(arr);
         $('#biaoshi_2 li input[name=url]').val($('#'+key).find('a').eq(0).attr("href"));
        
    	arr=key.split('_');
     	duibi = arr[0];
     	if(duibi == 'one-left-menu'){ 
     		$('#biaoshi_2 li span').text('图片尺寸：328X478');
        }else if(duibi == 'one-right-menu'){
        	$('#biaoshi_2 li span').text('图片尺寸：516X232');
        }else if(duibi == 'two-menu'){ 
        	$('#biaoshi_2 li span').text('图片尺寸：283X283');
        }else if(duibi == 'left-menu'){ 
        	$('#biaoshi_2 li span').text('图片尺寸：200X172');
        }else{ 
        	$('#biaoshi_2 li span').text('图片尺寸：304X304');
        }
    	$('#biaoshi_2 li').eq(4).remove();
        $('#biaoshi_2').append("<li><input type='hidden' name='temp_key' value="+key+"></li>");
    	$('.fancybox-478').show();
    }

    function edit_title(key){
    	var text = $('#'+key).text();
		$('#biaoshi_3 li input').eq(0).val(text);
    	$('#biaoshi_3 li').eq(1).remove();
        $('#biaoshi_3').append("<li><input type='hidden' name='temp_key' value="+key+"></li>"); 
    	$('.fancybox4').show();
    }

	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back-top').click(function(){
		$('.fancybox-top').hide();
	});
	

	//点击取消fancybox_back-mid按钮，弹出层内容消失
	$('.fancybox_back-mid').click(function(){
		$('.fancybox-mid').hide();
	});

	//点击取消fancybox_back-mid按钮，弹出层内容消失
	$('.fancybox_back-end').click(function(){
		$('.fancybox-end').hide();
	});
	
	
	//点击导航nav编辑按钮，弹出层仅编辑导航分类内容
	$('.eh_navbar .editBtn').click(function(){
		$('.fancybox1').show();
	});
	//点击弹出层取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back1').click(function(){
		$('.fancybox1').hide();
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
	
	function _upload(desc, pic, url, key,file_id){
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
	                data:{link_path:url,temp_key:key,desc:desc,pic:pic,tem:3},
	                dataType: 'json', //返回值类型 一般设置为json
	                success: function (data, status)  //服务器成功响应处理函数
	                {
		               // alert(data);
	                	 if(data){
				                
	    	                	$('#'+key).find('span').eq(0).text(desc);
	    	                	if(pic.indexOf(".") > 0 )
	    	                	{
	    	                		$('#'+key).find('span').eq(1).find('a').eq(0).text('M '+pic);
	    	                	}else{
	    	                		$('#'+key).find('span').eq(1).find('a').eq(0).text('M '+pic+'.00');
	    	                	}
	    	            		
	    	            		$('#'+key).find('a').eq(0).attr("href",url);
			                }
			                
	 	            	 if(data.img_path) $('#'+key).find('img').attr("src", data.img_path);
	                },
	                error: function (data, status, e)//服务器响应失败处理函数
	                {
	                    alert(e);
	                }
	            }
	        )
	
  }
    function edit(){ 
    	var desc =  $('#biaoshi_2 li input[name=desc]').val();
        var pic  =  $('#biaoshi_2 li input[name=pic]').val();
        var url  =  $('#biaoshi_2 li input[name=url]').val();
        var key  =  $('#biaoshi_2 li input[name=temp_key]').val();
        if( !(/^\d+(\.\d{1,2})?$/).test(pic) ) { 
            alert('价格请输入正确的数字');
            return;
        }
        $('.fancybox-478').hide();
        _upload(desc,pic,url,key,'file2');
    }
    function touwei(){ 
    	
        var url = $('#biaoshi_1 li input[name=url]').val();
        var key =  $('#biaoshi_1 li input[name=temp_key]').val();
        $('.fancybox-top').hide();
        _upload('','',url,key,'file1');
    }

    function carry_out(){
        var key = $('#biaoshi_3').find('input').eq(1).val();
        var desc = $('#biaoshi_3').find('input').eq(0).val();
        
        _edit(desc, key);
    }
    
    function _edit(desc, key){ 
        $.ajax({ 
            url:'<?php echo site_url('corporate/myshop/edit_temp_title')?>',
            type:'post',
            data:{desc:desc,temp_key:key,tem:3},
            dataType:'json',
            success:function(data){
                if(data){ 
                 	$('.fancybox4').hide();
                    $('#'+key).text(desc);
                }
            },
            error:function(){}
        })
    }

    /**
    隐藏栏目
    */
    function hide( status,key, id){ 
        $.ajax({ 
            url:'<?php echo site_url('corporate/myshop/hidden_menu')?>',
            type:'post',
            data:{status:status,key:key,tem:3,id:id},
            dataType:'json',
            success:function(data){
                if(data)
                    $('#search_on_off').empty();
                 if(data[0] == 'hide'){ 
                    $('#search_on_off').append( '<div class="editBtnCon clearfix"><a href="javascript:;" class="hideBtn" onclick='+"hide('show','search_frame')"+'>显示</a></div>');
                }else if(data[0] == 'show'){ 
                    $('#search_on_off').append( '<div class="editBtnCon clearfix"><a href="javascript:;" class="hideBtn" onclick='+"hide('hide','search_frame','"+data[1]+"')"+'>隐藏</a></div>');
                }
            },
        })
    }

    function resetTemplate()
	{
		if(confirm("是否重置该模板?重置后,所有内容将会掉失!!"))
		{
			window.location = "<?php echo site_url('corporate/myshop/ResetTemplate/3')?>";
		}
	}
    function publishTemp()
	{
		$.post("<?php echo site_url('corporate/myshop/issue_tem_three/')?>","",function(data){
		
			alert(data);
		});
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
	            data:{array:array,tem:3},
	            dataType:'json',
	            success:function(data){
	                
	               
	            	   location.reload();
	            },
	        })
	        $('.fancybox1').hide();
    }
</script>
</html>
