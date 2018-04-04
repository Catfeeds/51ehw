<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="css/fancymain.css">
<link rel="stylesheet" type="text/css" href="css/fancybox.css">
<link href="css/style_v2.css" rel="stylesheet" type="text/css">
<link href="css/guanjie_tem.css" rel="stylesheet" type="text/css">
<link href="css/store.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/jquery.easie.js"></script>
<script type="text/javascript" src="js/my.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.1.pack.js"></script>
<script src="js/ajaxfileupload.js" type="text/javascript"></script>

<!-- 中层轮播 -->
<script type="text/javascript" src="js/slick.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<link rel="stylesheet" type="text/css" href="css/slick.css"/>

<style>
/* 店铺模版－多产品－Banner轮播图 */
.carousel{ width:100%;}
.bd { margin-left:-960px;}
.carousel ul.imageslist{width:7680px;}



</style>
<title>51易货网</title>
</head>
<body>
    <!--页头编辑 开始-->
    <div class="store_headEdit">
    	<div class="store_headEdit_con">
        	<div class="headEdit_btnLeft">
            	<ul>
   
        			
                    
        			<li><a href="javascript:;" onclick="add_temp()" class="btn_pageEdit">添加楼层</a><li>
        			<?php  if($this->session->userdata['corporation_id'] == 157 ):?>
        			    <li><a href="<?php echo site_url('flagship/flagship_two_temp');?>" class="btn_pageEdit ">旗舰店模板二</a></li>
        			<?php endif;?>
    			    <?php  if($this->session->userdata['corporation_id'] == 150 ):?>
                       <li><a href="<?php echo site_url('flagship/flagship_three_temp');?>" class="btn_pageEdit ">旗舰店模板三</a></li>
                    <?php endif;?>
        			<li><a href="<?php echo site_url('corporate/myshop/renovate');?>" class="btn_pageEdit">模板一</a><li>
        			<li><a href="<?php echo site_url('corporate/myshop/select_goods_temp');?>" class="btn_pageEdit">模板二</a><li>
                    <li><a href="<?php echo site_url('corporate/myshop/select_three_temp');?>" class="btn_pageEdit">模板三</a><li>
                            
                    
                           
                </ul>
            </div>
            <div class="headEdit_btnRight" style="margin-right: -100px;width:270px;   ">
            	<ul>
            		<li><a href="<?php echo site_url('flagship/flagship_temp')?>" class="btn_pagePreview">预览</a></li>
                	<li><a href="javascript:;" onclick="javascript:publishTemp()" class="btn_pageRelease">发布</a></li>
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
	<div class="guanjie_top  hover_it" style="position:relative;background:<?php echo isset($list['top-color']['desc']) ? $list['top-color']['desc'] :''?>" id="top-color">
    	<div class="store_top_con"><a href='' id='top'><img src="<?php echo isset($list['top']) ? IMAGE_URL.$list['top']['img_path']: 'images/store_topBanner.png';?>" width="1920" height="100" alt=""/></a></div>
        <!--编辑区 开始-->
        <div class="editCon">
            <div class="editBtnCon clearfix">
                <a href="javascript:;" class="editBtn" onclick="edit('top')">编辑</a>
                <a href="javascript:;" class="addFloorBtn" onclick="edit_color('top-color')">编辑背景颜色</a>
            </div>
        </div>
        <!--编辑区 结束-->
	</div>
    <!--店铺头部 结束-->
	<!--头部导航条 开始--><!-- 冠杰头部变底色 guanjie_tem.css -->
    <div class="eh_navbar clearfix hover_it" style="position:relative;">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu" style="background:#000000; z-index:99;">
                <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="javascript:;">全部分类<b class="icon-select"></b></a></h2>
                    </div>
                    
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu517">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">精品上衣</a></span><s style="display: block;"></s>
                                </h3> 
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu496">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">保暖裤装</a></span><s style="display: block;"></s>
                                </h3>
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu141">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">百搭外套</a></span><s style="display: block;"></s>
                                </h3>
                            </li>
                        
                            <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu931">
                                <h3>
                                    <span></span><span class="macth_xvh3_a"><a href="javascript:void(0)" data-bind="text:$data.title" class="">新品围巾</a></span><s style="display: block;"></s>
                                </h3>
                                </li>
                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                <ul class="macth_xv_nav">
                    <li id='home' class="macth_liactive"><a href="<?php echo site_url('flagship/select_flagship_temp')?>">首页</a></li>
                    <span id='top_shop_classify'><!-- <li><a href="javascript:;">媒体广告</a> --></li></span>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>
		<!--编辑区 开始-->
        
        <!--编辑区 结束-->
    </div>
	<!--头部导航条 结束-->
    
    <!--Banner内容 开始-->
    <div class="carousel hover_it" style="position:relative;">
         <div class="bd">
        <ul class="imageslist">
           <?php for($i=1; $i<5; $i++):?>
                <li id="<?php echo 'carousel-img_'.$i?>"><a href="<?php echo isset($list["carousel-img_$i"]) ? $list["carousel-img_$i"]['link_path']: ''?>"><img width="" height="" src="<?php echo isset($list["carousel-img_$i"]) ? IMAGE_URL.$list["carousel-img_$i"]['img_path']: 'images/store_banner1920.png'?>" /></a></li>
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
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img_1')">编辑轮播图一</a></div>
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img_2')">编辑轮播图二</a></div>
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img_3')">编辑轮播图三</a></div>
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('carousel-img_4')">编辑轮播图四</a></div>
        </div>
        <!--编辑区 结束-->
   
     </div>
    <script type="text/javascript" src="js/chuantong.js"></script>
    <script type="text/javascript">
        chuantong(300,4000,1920);
    </script>
    <!--Banner内容 结束--> 
    
	<!--冠杰店铺 midBanner 开始
    <div class="guanjie_midBanner">
    	<div class="guanjie_midBanner_con">
    		<img src="images/guanjie_midBanner.png" width="1200" alt=""/>
        </div>
    </div>-->
    <!--冠杰店铺 midBanner 结束-->
    <!--冠杰店铺 classify 开始-->
    <div class="guango">
               <img src="images/gg.jpg"/>           
             </div>
             <div class="clear"></div>
    <div class="guanjie_classify hover_it" style="position:relative;background:<?php echo isset($list['mid-color']['desc']) ? $list['mid-color']['desc'] :''?>" id="mid-color">
    	<div class="guanjie_classify_con clearfix" >
            <ul>
                <?php for($i=1; $i<5; $i++):?>
                    <li id="<?php echo 'central-img_'.$i?>"><a href=""><img src="<?php echo isset($list["central-img_$i"]) ? IMAGE_URL.$list["central-img_$i"]['img_path'] :"images/RankingTop_x01.png"?>" width="300" height="129" alt=""/></a></li>
                <?php endfor;?>
            </ul>
        </div>
        <!--编辑区 开始-->
        <div class="editCon">
            <div class="editBtnCon clearfix">
            	<a href="javascript:;" class="editBtn" onclick="edit('central-img_1')">编辑图片一</a>
            	<a href="javascript:;" class="addFloorBtn" onclick="edit_color('mid-color')">编辑背景颜色</a>
            </div>
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('central-img_2')">编辑图片二</a></div>
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('central-img_3')">编辑图片三</a></div>
            <div class="editBtnCon clearfix"><a href="javascript:;" class="editBtn" onclick="edit('central-img_4')">编辑图片四</a></div>
            
        </div>
        <!--编辑区 结束-->
    </div>
    <!--冠杰店铺 classify 结束-->
    <div id="page_body">
    <!--冠杰店铺 goodsBanner 开始-->  

     <div class="guanjie_goodsBanner" style="background:<?php echo isset($list['first-layer-color']['desc']) ? $list['first-layer-color']['desc'] :''?>" id="first-layer-color"><!--第一层-->
            	<div class="guanjie_goodsBanner_con clearfix">
                	<ul>
                    	<li class=" hover_it" style="position:relative;" id="first_layer">
                        	<a href=""><img src="<?php echo isset($list['first_layer']) ? IMAGE_URL.$list['first_layer']['img_path']: 'images/storeSingle_pic01.png' ?>" width="1200" height="830"alt=""/></a>
                            <!--编辑区 开始-->
                            <div class="editCon">
                                <div class="editBtnCon clearfix">
                                    <a href="javascript:;" class="editBtn" onclick="edit('first_layer')">编辑</a>
                                    <a href="javascript:;" class="addFloorBtn" onclick="edit_color('first-layer-color')">编辑背景颜色</a>
                                </div>
                            </div>
                            <!--编辑区 结束-->
                        </li>
                    </ul>
                </div>
           </div>
    <?php if(isset($floor) && count($floor) > 0):?>
    
        <?php foreach ( $floor as $v):?>
            <div class="guanjie_goodsBanner" id="layer-color_<?php echo $v['id']?>" style="background:<?php echo isset($list["layer-color_$v[id]"]['desc']) ? $list["layer-color_$v[id]"]['desc'] :''?>"><!--清除浮动－使得尾部导航不浮动-->
            	<div class="guanjie_goodsBanner_con clearfix" id="floor_<?php echo $v['id']?>">
                	<ul>
                    	<li class=" hover_it" style="position:relative;" >
                        	<a href=""><img src="<?php echo !empty($v['img_path']) ? IMAGE_URL.$v['img_path'] : 'images/storeSingle_pic01.png'?>" width="1200" height="830"alt=""/></a>
                            <!--编辑区 开始-->
                            <div class="editCon">
                                <div class="editBtnCon clearfix">
                                    <a href="javascript:;" class="addFloorBtn" onclick="edit_color('<?php echo 'layer-color_'.$v['id']?>')">编辑背景颜色</a>
                                    <a href="javascript:;" class="editBtn" onclick="edit('<?php echo 'floor_'.$v['id']?>')">编辑</a>
                                    <a href="javascript:;" class="deleteBtn" onclick="show_del(<?php echo $v['id']?>)">删除</a>
                                </div>
                            </div>
                            <!--编辑区 结束-->
                        </li>
                    </ul>
                </div>
           </div>
       <?php endforeach;?>
  <?php endif;?>
    <!--冠杰店铺 goodsBanner 结束-->
    </div>
    <!--冠杰店铺 goods 开始-->
    <div class="guanjie_goods" style="background:<?php echo isset($list['foot-body-color']['desc']) ? $list['foot-body-color']['desc'] :''?>" id="foot-body-color">
    	<div class="guanjie_goods_con clearfix">
        	<!--冠杰店铺 goods 搜索开始-
            <div class="guanjie_goods_search">
            	<div class="guanjie_search_box">
                	<input class="guanjie_input" type="text" placeholder="搜索内容">
                    <a href="" class="guanjie_search_btn">搜索</a>
                    <span>热门搜索：</span>
                    <span><a href="" class="guanjie_search_hot">二环内</a></span>
                    <span><a href="">三环内</a></span>
                    <span><a href="">高速路</a></span>
                    <span><a href="">机场</a></span>
                    <span><a href="">楼宇</a></span>
                    </span>
                </div>
            </div>
            冠杰店铺 goods 搜索结束-->
            <!--冠杰店铺 recommend 推荐开始-->
            <div class="guanjie_recommend clearfix">
              <h2 class="guanjie_recommend_top hover_it" style="position:relative;" id="end-title"><span><?php echo isset($list['end-title']) ? $list['end-title']['desc']: '点击编辑标题';?></span>
              	<div class="editCon">
                    <div class="editBtnCon clearfix">
                        <a href="javascript:;"onclick="edit_title('end-title')" class="editBtn">编辑</a>
                    </div>
                </div>
              </h2>
          <section id="features" class="blue hover_it" style="position:relative;">
			<div class="content">
				<div class="slider autoplay">
                    <?php for($i=1; $i<9; $i++):?>
					<div id="<?php echo 'end-img_'.$i?>" >
                        <h3>
                            <div class="image" >
                                <img src="<?php echo isset($list["end-img_$i"]) ? IMAGE_URL.$list["end-img_$i"]['img_path'] : 'images/storeSingle_pic01.png'?>" width="280" height="280" alt=""/> 
                            </div>
                            <span class="recommend_ul_left">
                            <h4><?php echo isset($list["end-img_$i"]) ? $list["end-img_$i"]['desc'] : '商品名称'?></h4>
                            <em><?php echo isset($list["end-img_$i"]) ? $list["end-img_$i"]['vip_price'] : '0.00'?></em>
                            </span>
                            <span class="recommend_ul_right">
                                <a href="javascript:;"></a>
                            </span>
                        </h3>
                    </div>
                    <?php endfor;?>
                    
			</div>
			<!--编辑区 开始-->
               <div class="editCon">
                    <div class="editBtnCon clearfix">
                        <a href="javascript:;" class="editBtn" onclick="edit_goods('end-img_1')">编辑图片一</a>
                    </div>
                    <div class="editBtnCon clearfix">
                        <a href="javascript:;" class="editBtn" onclick="edit_goods('end-img_2')">编辑图片二</a>
                    </div>
                    <div class="editBtnCon clearfix">
                        <a href="javascript:;" class="editBtn" onclick="edit_goods('end-img_3')">编辑图片三</a>
                    </div>
                    <div class="editBtnCon clearfix">
                        <a href="javascript:;" class="editBtn" onclick="edit_goods('end-img_4')">编辑图片四</a>
                    </div>
                     <div class="editBtnCon clearfix">
                        <a href="javascript:;" class="editBtn" onclick="edit_goods('end-img_5')">编辑图片五</a>
                    </div>
                     <div class="editBtnCon clearfix">
                        <a href="javascript:;" class="editBtn" onclick="edit_goods('end-img_6')">编辑图片六</a>
                    </div>
                     <div class="editBtnCon clearfix">
                        <a href="javascript:;" class="editBtn" onclick="edit_goods('end-img_7')">编辑图片七</a>
                    </div>
                     <div class="editBtnCon clearfix">
                        <a href="javascript:;" class="editBtn" onclick="edit_goods('end-img_8')">编辑图片八</a>
                    </div>
                     <div class="editBtnCon clearfix">
                    <a href="javascript:;" class="addFloorBtn" onclick="edit_color('foot-body-color')">编辑背景颜色</a>
                    </div>      
                </div>
                <!--编辑区 结束-->
		</section>
		
               
              </div></div>
              <!--冠杰店铺 recommend 推荐结束-->
              
            <!-- 商品部分 --> 
             
              <!--冠杰店铺 所有媒体 开始-->
              <div class="guanjie_media clearfix" id="guanjie_media">
                <h2 class="guanjie_recommend_top">商品
<!--                   <ul class="guanjie_media_ul"> -->
<!--                             <li><a href="javascript:;">销量</a></li> -->
<!--                             <li><a href="javascript:;">价格</a></li> -->
<!--                             <li><a href="javascript:;" class="guanjie_media_liCurrent">好评度</a></li> -->
<!--                             <li><a href="javascript:;">上架时间</a></li> -->
<!--                         </ul> -->
                 </h2><!--所有媒体头部 结束-->
                 <ul class="guanjie_media_goods clearfix" id='guanjie_media_goods' >

                 </ul><!--多媒体商品 结束-->
                 <!--多媒体分页 开始-->
                 <div class="media_showpage">
<!--                     <span>共171条纪录</span> -->
<!--                     &nbsp;<a class="cpage">1</a>&nbsp;<a href="javascript:;">2</a>&nbsp;<a href="javascript:;">3</a>&nbsp;<a href="javascript:;">4</a>&nbsp;<a href="javascript:;" class="lPage">下一页</a>&nbsp;&nbsp;<a href="javascript:;">&gt;&gt;</a>  -->
                </div><!--多媒体分页 结束-->
                </div>
                <!--冠杰店铺 所有媒体 结束-->
        </div>
    </div>
    <!--冠杰店铺 goods 开始-->
    </div>
    
	
        
    <!--弹出层 fancybox-top 编辑仅图片 头部banner开始-->
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
                        <ul id="biaoshi">
                            <li><!-- <a href="javascrip:;" class="fancybox-update">选择图片</a>--> <input type="file" id="file" name="file"><span class="">图片尺寸：1920X100 </span></li>
                            <li><input class="fancybox-input" type="text" name="link_path" placeholder="链接须以http://开头,不允许添加51易货网外的链接">
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
    <!--弹出层 fancybox-top 编辑仅图片 头部banner结束--> 

	<!--弹出层 fancybox0 编辑轮播图banner 开始-->
    
    <!--弹出层 fancybox0 编辑轮播图banner 结束-->
    
    <!--弹出层 fancybox1 编辑分类图片 开始-->
    
    <!--弹出层 fancybox1 编辑分类图片 结束-->
    
    <!--弹出层 fancybox2 编辑楼层图片 开始-->
    
    <!--弹出层 fancybox2 编辑楼层图片 结束-->
    
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
    
    <!--弹出层 fancybox3 编辑产品标题 开始-->
    <div class="fancybox3" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left: 50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">编辑标题</div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div style="width:auto;height:auto;overflow: auto;position:relative;">
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <div class="fancybox-editCon-left">
                        <ul>
                            <li>编辑标题：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_3">
                            <li><input class="fancybox-input" type="text" placeholder="例子:产品推荐" name="edit_title"></li>
                            <li><input class="fancybox-input" type="hidden"  name="tem_key"></li>
                    </div>
                </div>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn">
                        <a href="javascript:;" class="fancybox_back fancybox_back3">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="on_edit_title()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox3 编辑产品标题 结束-->
    
    <!--弹出层 fancybox4 编辑 开始-->
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
                            <li>上传商品图片：</li>
                            <li>编辑商品标题：</li>
                            <li>编辑商品价格：</li>
                            <li>商品链接地址：</li>
                        </ul>
                    </div>
                    <div class="fancybox-editCon-right">
                        <ul id="biaoshi_2">
                            <li><!-- <a href="javascrip:;" class="fancybox-update">选择图片</a>--> <input type="file" id="file2" name="file"><span class="">图片尺寸：280X280 </span></li>
                            <li><input class="fancybox-input" type="text" name= 'desc' value=''placeholder="商品标题"></li>
                            <li><input class="fancybox-input" type="text" name= 'pic' placeholder="0.00" value=''></li>
                            <li><input class="fancybox-input" type="text" name= 'link_path' placeholder="链接须以http://开头,不允许添加51易货网外的链接" value=''></li>
                            <li><input class="fancybox-input" type="hidden" name= 'tem_key' value=''></li>
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
                        <a href="javascript:;" class="fancybox_back fancybox_back4">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick="sub_goods()">确定</a>
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    <!--弹出层 fancybox4 编辑 结束--> 
    <!--弹出层 fancybox5 编辑删除 开始-->
    <div class="fancybox5" style="display:none"> 
        <div id="fancybox-loading" style="display: none;"><div></div></div>
        <div id="fancybox-overlay" style="opacity: 0.3; display: block; background-color: rgb(102, 102, 102);"></div>
        <div id="fancybox-wrap" class="fancybox-wrap1" style="width: 1100px; height: auto; position:fixed; top: 50px; left:50%; margin-left:-550px; display: block;">
            <!--弹窗头部 开始-->
            <div class="fancybox-head">温馨提示</div>
            <!--弹窗头部 结束-->
            <div id="fancybox-outer">
              <div id="fancybox-content" class="fancybox_con">
              <div style="width:auto;height:auto;overflow: auto;position:relative;">
              <div id="inline1" class="fancybox-inline1" >
                <div class="fancybox-editCon clearfix">
                    <p class="fancybox-delete">您真的要删除此内容吗？可以在新建楼层处重新添加喔！</p>
              </div></div></div>
              <!--弹窗尾部 开始-->
              <div id="fancybox-title" class="fancybox-title-inside">
                  <div id="fancybox-title-inside">
                    <div class="fancybox-btn" id="level_del">
                        <a href="javascript:;" class="fancybox_back fancybox_back5" onclick="hide_del()">取消</a>
                        <a href="javascript:;" class="fancybox_okay" onclick = "deleted();">确定</a>
                        <input type="hidden" name="del_id" value="">
                    </div>
                  </div>
              </div>
              <!--弹窗尾部 结束-->
          </div>
        </div>
    </div>
    </div>
<!--弹出层 fancybox5 删除 结束--> 
</body>


<script>
    $('.int_left').click(function(){
        $arr = $('.guanjie_reccommend_ul').children().length;
        $ther = $('.guanjie_reccommend_ul');
        $counts = ($arr - 4) * -300;
        if(parseInt($ther.css('left'))==0){
            $str = 0;
        }
        var i =0;
        i = parseInt($str)-300;
        $ther.attr('ok',i)
        $str = $ther.attr('ok');
        alert($count);
        if($str==$counts){
            $ther.attr('ok',parseInt($str))
            $('.int_left').hide();
            $('.guanjie_reccommend_ul').animate({left:"-=300px"},500);
            return false;
        }
        if($str<0){
            $('.int_right').show();
        }else{
            $('.int_right').hide();
        }
        $('.guanjie_reccommend_ul').animate({left:"-=300px"},500);
    })
    $('.int_right').click(function(){
        $son = $('.guanjie_reccommend_ul').attr('ok');
        $counts = ($arr - 4) * -300;
        var i =0;
        i = parseInt($son)+300;
        $ther.attr('ok',i)
        $str = $ther.attr('ok');
        if($str==0){
        	
            $('.int_right').hide();
            $('.guanjie_reccommend_ul').animate({left:"+=300px"},500);
            return false;
        }
        if($son!=$counts){
            $('.int_left').show();
        }else{
            $('.int_left').hide();
        }
        $('.guanjie_reccommend_ul').animate({left:"+=300px"},500);
    })
	
	//点击编辑按钮－js
	
	function edit(key){ 
    	arr=key.split('_');
     	duibi = arr[0];
     	
    	if(duibi == 'top'){ 
        	$('#biaoshi li span').text('图片尺寸：1920X100');
        }else if(duibi == 'central-img'){ 
        	$('#biaoshi li span').text('图片尺寸：300X129');
        }else if(duibi == 'carousel-img'){ 
        	$('#biaoshi li span').text('图片尺寸：1920X500');
        }else{ 
        	$('#biaoshi li span').text('图片尺寸：1200X830');
        }
    	$('#biaoshi input[name=tem_key]').val(key);
    	$('.fancybox-top').show();
    }
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back-top').click(function(){
		$('.fancybox-top').hide();
	});
	
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back1').click(function(){
		$('.fancybox1').hide();
	});
	//点击分类图片 编辑背景颜色按钮，弹出层内容
// 	$('.guanjie_classify .addFloorBtn').click(function(){
// 		$('.fancybox_color').show();
// 	});
	function edit_color( key ){ 
		$('#bgckground_color input[name=tem_key]').val(key);
		$('.fancybox_color').show();
		
    }
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back_color').click(function(){
		$('.fancybox_color').hide();
	});
	
	//点击楼层图片编辑按钮，弹出层内容
	$('.guanjie_goodsBanner_con .editBtn').click(function(){
		$('.fancybox2').show();
	});
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back2').click(function(){
		$('.fancybox2').hide();
	});
	
	//点击产品标题 编辑按钮，弹出层内容
	function edit_title(key){
		$('#biaoshi_3 li input[name=tem_key]').val(key);
		$('.fancybox3').show();
	}

	function on_edit_title(){ 
		var key = $('#biaoshi_3 li input[name=tem_key]').val();
		var desc = $('#biaoshi_3 li input[name=edit_title]').val();
		_edit(desc, key)
		
	}
// 	$('.guanjie_recommend_top .editBtn').click(function(){
		
// 		$('.fancybox3').show();
// 	});

    //删除  
    function show_del(id){$('.fancybox5').show(); $('input[name=del_id]').val(id) }
	//隐藏
	function hide_del(){ $('.fancybox5').hide(); }
	
	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back3').click(function(){
		$('.fancybox3').hide();
	});
	
	//点击产品带价格 编辑按钮，弹出层内容
	function edit_goods(key){ 
		$('#biaoshi_2 li input[name=tem_key]').val(key);
		$('.fancybox4').show();
	}

	//点击取消fancybox_back按钮，弹出层内容消失
	$('.fancybox_back4').click(function(){
		$('.fancybox4').hide();
	});

    function deleted(){
        
    	var id = $('input[name=del_id]').val();
    	$.ajax({
    	    url:"<?php echo site_url('corporate/myshop/deleted_temp') ?>",
    	    type:"post",
    	    data:{id:id},
    	    success:function(data){
    	        if(data){
    	           alert('删除成功');
    	           $('#floor_'+id).remove();
    	           $('.fancybox5').hide();
        	    }
        	}
        });
    }

	function add_temp(){ 
		$.ajax({ 
			url:"<?php echo site_url('flagship/add_template')?>",
			type:'post',
			dataType:'json',
			success:function(data){
				if(data){
					var url = 'floor_'+data;
					var color = 'layer-color_'+data;
        		    var html = '<div class="guanjie_goodsBanner" id="layer-color_'+data+'">'+
        				'<div class="guanjie_goodsBanner_con clearfix" id="floor_'+data+'">'+
                    	'<ul>'+
                        '<li class=" hover_it" style="position:relative;">'+
                        '<a href=""><img src="images/storeSingle_pic01.png" width="1200" height="830"alt=""/></a>'+
                        '<div class="editCon">'+
                        '<div class="editBtnCon clearfix">'+
                        '<a href="javascript:;" class="addFloorBtn" onclick='+"edit_color('"+color+"')"+'>编辑背景颜色</a>'+
                        '<a href="javascript:;" class="editBtn" onclick='+"edit('"+url+"')"+'>编辑</a>'+
                        '<a href="javascript:;" class="deleteBtn" onclick='+"show_del('"+data+"')"+'>删除</a>'+
                        '</div>'+
                        '</div>'+
                        '</li>'+
                        '</ul>'+
                        '</div>'+
                        '</div>';
                    alert('添加成功');
        		    $('#page_body').append(html);
				}
			}
	    })
    }
    
    function on_sub(){ 
        var link_path = $('#biaoshi input[name=link_path]').val();
        var tem_key   = $('#biaoshi input[name=tem_key]').val();
        
        _upload('','',link_path,tem_key,'file');
    }

    function sub_goods(){ 
   	 var link_path = $('#biaoshi_2 li input[name=link_path]').val();
     var tem_key   = $('#biaoshi_2 li input[name=tem_key]').val();
     var desc   = $('#biaoshi_2 li input[name=desc]').val();
     var pic  = $('#biaoshi_2 li input[name=pic]').val();
     if( !(/^\d+(\.\d{1,2})?$/).test(pic) ) { 
         alert('价格请输入正确的数字');
         return;
     }
     _upload(desc,pic,link_path,tem_key,'file2');
    }
    
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
	                data:{link_path:url,temp_key:key,desc:desc,pic:pic,tem:4},
	                dataType: 'json', //返回值类型 一般设置为json
	                success: function (data, status)  //服务器成功响应处理函数
	                {
	                	
		                if(data){
		                	$('#'+key).find('span').find('h4').text(desc);
		                	if(pic.indexOf(".") > 0 )
    	                	{
		                		$('#'+key).find('span').find('em').text(pic);
    	                	}else{
    	                		$('#'+key).find('span').find('em').text(pic+'.00');
    	                	}
    	                	
		                	
//   	                	$('#'+key).find('span').eq(1).text('M '+pic+'.00');
//   	            		$('#'+key).find('a').eq(0).attr("href",url);
		                }
		                
		                if(data.img_path) $('#'+key).find('img').attr("src", data.img_path);
		                
// 	            		if(data.img_path) $('#'+key).find('img').attr("src", data.img_path);
	                	
	                	//alert($('#'+key).find('img').attr('src'));
	                	
	                	$('.fancybox-top').hide();
	                	$('.fancybox4').hide();
	                },
	                error: function (data, status, e)//服务器响应失败处理函数
	                {
	                    alert(e);
	                }
	            }
	        )
    }
    function bg_color(){ 
        var bg = $('input[name=bg_color]').val();
        var key = $('#bgckground_color input[name=tem_key]').val();
        $.ajax({ 
			url:"<?php echo site_url('corporate/myshop/edit_temp_title')?>",
			data:{desc:bg,tem:4,temp_key:key},
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

    function _edit(desc, key){ 
        $.ajax({ 
            url:'<?php echo site_url('corporate/myshop/edit_temp_title')?>',
            type:'post',
            data:{desc:desc,temp_key:key,tem:4},
            dataType:'json',
            success:function(data){
                if(data){ 
                	$('.fancybox3').hide();
                    $('#'+key+' span').text(desc);
                }
            },
            error:function(){}
        })
    }

    //关注商品
	function add_to_fav(pid)
	{
		<?php if(!$this->session->userdata('user_in')):?>
		alert('您还未登录，请先登录。');
		<?php else:?>
		$.ajax({
		      url: base_url+'/member/fav/ajax_add',
		      type: 'POST',
		      data:{'pid':pid},
		      dataType: 'html',
		      success: function(data){
					alert(data);
		      	}
		    });
	    <?php endif;?>
	}
	
    function publishTemp()
	{
		$.post("<?php echo site_url('flagship/issue_flagship_temp')?>","",function(data){
		
			if(data) alert('ok');
		});
	}
	
    var corp = "<?php echo $corp?>"
   	 $(function (){
   	   	 
	        var html = '';
	        var classify = '';
	        var top_classify= '';
	        var page = '';
	    	$.post('<?php echo site_url('flagship');?>',{corp:corp},function(data){
	    	    data = jQuery.parseJSON(data);
	    	   
	    	    //商品
	    	    for(var i=0;i<data['produtList'].length;i++){
	        	    if(i%5==4){
	                    html += '<li style="margin-right:0;">';
	        	    }else{
	        	    	html += '<li>';
	            	    }
	                    html += '<a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/'+data['corp_id']+'">';
	                    html += '<img src="<?php echo IMAGE_URL;?>/../'+data['produtList'][i]['image_name']+'_270'+data['produtList'][i]['file_ext']+'" width="206" height="206" alt=""/>' ;
	                    html += '<p id="name">'+data['produtList'][i]['name']+'</p>';
	                    html +='<span class="media_goods_pirce">¥'+data['produtList'][i]['vip_price']+'</span>';
//	                     html +='<span class="media_goods_recommend">已有1人评价<em class="media_goods_em">100%好评</em></span>';
	                    html +='</a>';
	                    html +='<ul class="media_goods_btn">';
	                    html +='<li class="media_goods_btnBuy"><a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/'+data['corp_id']+'">购买</a></li>';
	                    html +='<li class="media_goods_attention"><a href="javascript:void(0);" onclick="add_to_fav('+data['produtList'][i]['id']+')">关注</a></li>';
//	                     html +='<li><a href="javascript:;">对比</a></li>';
	                    html +='</ul>';
	                    html +='</li>';
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

	    //分类
		function top_shop_classify(section_id,corporation_id,obj){
			location.hash = 'guanjie_media';
			var html = '';
			$('.macth_liactive').removeClass('macth_liactive');
			$(obj).addClass('macth_liactive');
			$('.guanjie_midBanner').hide();
			$('.guanjie_classify').hide();
			$('.guanjie_goodsBanner').hide();
			$('.guanjie_recommend').hide();
			$('.guango').hide();
			$('#page').hide();
			$.post("<?php echo site_url('flagship/top_shop_classify');?>",{section_id:section_id,corporation_id:corporation_id},function(data){
				data = jQuery.parseJSON(data);
	    	    //商品
	    	    if(data['produtList'].length>0){
	        	    for(var i=0;i<data['produtList'].length;i++){
	            	    if(i%5==4){
	                        html += '<li style="margin-right:0;">';
	            	    }else{
	            	    	html += '<li>';
	                	    }
	                        html += '<a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/'+data['corp_id']+'">';
	                        html += '<img src="<?php echo IMAGE_URL?>/../'+data['produtList'][i]['goods_thumb']+'" width="206" height="206" alt=""/>' ;
	                        html += '<p id="name">'+data['produtList'][i]['name']+'</p>';
	                        html +='<span class="media_goods_pirce">M '+data['produtList'][i]['vip_price']+'</span>';
	    //                     html +='<span class="media_goods_recommend">已有1人评价<em class="media_goods_em">100%好评</em></span>';
	                        html +='</a>';
	                        html +='<ul class="media_goods_btn">';
	                        html +='<li class="media_goods_btnBuy"><a href="<?php echo site_url("goods/detail");?>/'+data['produtList'][i]['id']+'/'+data['corp_id']+'">购买</a></li>';
	                        html +='<li class="media_goods_attention"><a href="javascript:void(0);" onclick="add_to_fav('+data['produtList'][i]['id']+')">关注</a></li>';
	    //                     html +='<li><a href="javascript:;">对比</a></li>';
	                        html +='</ul>';
	                        html +='</li>';
	            	    }
	        	    $('#guanjie_media_goods').html(html);
	        	    }else{
	            	    
	            	    html +='<li class="result_none" style=" width: 1180px;padding-bottom: 20px;background:none;">暂无商品</li>';
	        	    	$('#guanjie_media_goods').html(html);
	            	    }
				});
			}

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
			$.post('<?php echo site_url('flagship/pagination');?>',{page:page,corp:corp},function(data){
			    data = jQuery.parseJSON(data);
			    
	    			    for(var i=0;i<data.length;i++){
	                	    if(i%5==4){
	                            html += '<li style="margin-right:0;">';
	                	    }else{
	                	    	html += '<li>';
	                    	    }
	                            html += '<a href="<?php echo site_url("goods/detail");?>/'+data[i]['id']+'/'+corp+'">';
	                            html += '<img src="<?php echo IMAGE_URL?>/../'+data[i]['goods_thumb']+'" width="206" height="206" alt=""/>' ;
	                            html += '<p id="name">'+data[i]['name']+'</p>';
	                            html +='<span class="media_goods_pirce">¥'+data[i]['vip_price']+'</span>';
	        //                     html +='<span class="media_goods_recommend">已有1人评价<em class="media_goods_em">100%好评</em></span>';
	                            html +='</a>';
	                            html +='<ul class="media_goods_btn">';
	                            html +='<li class="media_goods_btnBuy"><a href="<?php echo site_url("goods/detail");?>/'+data[i]['id']+'/'+corp+'">购买</a></li>';
	                            html +='<li class="media_goods_attention"><a href="javascript:void(0);" onclick="add_to_fav('+data[i]['id']+')">关注</a></li>';
	        //                     html +='<li><a href="javascript:;">对比</a></li>';
	                            html +='</ul>';
	                            html +='</li>';
	                            }
	    			    $('#guanjie_media_goods').html(html);
				});
			$('.cpage').css('background','');
			$('#page_'+page).css('background','#ccc');
			}
</script>
</html>
