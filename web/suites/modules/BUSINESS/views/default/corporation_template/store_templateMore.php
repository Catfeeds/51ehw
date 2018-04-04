<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="css/swiper3.08.min.css" rel="stylesheet" type="text/css">
<link href="css/style_v2.css" rel="stylesheet" type="text/css">
<link href="css/store.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/jquery.easie.js"></script>

<title>51易货网</title>
</head>

<body>
    <!--排行榜Top6切换js 开始-->	
    <script type="text/javascript">
    	$(function(){
			$('.rankingTop_left li a').hover(function(e) {
                var indexNum = parseInt($(this).attr("order"));
				var topNum = indexNum*-686;//'+topNum+'
				$('.rankingTop_mid ul').stop().animate({'top':''+topNum+'px'},300)
				$(this).parent('li').stop().animate({'opacity':'1'},300)
            },function(){
				$(this).parent('li').stop().animate({'opacity':'0.5'},300)
			});
			$('.rankingTop_right li a').hover(function(e) {
                var indexNum = parseInt($(this).attr("order"));
				var topNum = indexNum*-686;//'+topNum+'
				$('.rankingTop_mid ul').stop().animate({'top':''+topNum+'px'},300)
				$(this).parent('li').stop().animate({'opacity':'1'},300)
            },function(){
				$(this).parent('li').stop().animate({'opacity':'0.5'},300)
			});	
		});
    </script>
	<!--排行榜Top6切换js 结束-->
 	<!--页头开始-->
    <div class="store_head">
      <div class="store_head_con">
        	<a href="javascript:;" class="logo_set" title="51易货网"><img alt="51易货网" src="images/eh_logo.jpg"></a>       
        	<span class="store_head_span">店铺名称</span>
<!--         	<span>旗舰店会员</span> -->
        	<div class="store_head_search clearfix">
                <div class="store_head_search01">
                    <input class="store_head_input" type="text" placeholder="搜索内容">
                    <a class="search_total_station">搜全站</a>
                </div>
<!--                 <div class="store_head_search02"><a href="">搜本店</a></div> -->
            </div>
      </div>
    </div>
	<!--页头 结束-->
    
    <!--店铺头部 开始-->
    <?php if(isset($list['top']) && count($list['top']) > 0):?>
    	<div class="store_top" style="background:#fff;margin:0;">
        	<div class="store_top_con"><img src="<?php echo IMAGE_URL.$list['top'][0]['img_path']?>" width="1920" height="100" alt=""/></div>
    	</div>
    <?php endif;?>
    <!--店铺头部 结束-->
    
	<!--头部导航条 开始-->
    <div class="eh_navbar clearfix">
        <div class="macth_xv_navlist">
            <div class="macth_xv_menu">
               <!--左侧导航 start-->
                <div class="macth_xv_categorys">
                    <div class="macth_xv_cat_title">
                        <h2 class="macth_cat_name"><a href="javascript:void(0)">全部分类<b class="icon-select"></b></a></h2>
                    </div>
                    
                    <div class="macth_xv_cat_catlist ">
                        <ul class="macth-dropdown-menu" data-bind="foreach:navData">
                           <?php if(isset($menu_list) && count($menu_list) > 0):?>
                                <?php foreach($menu_list as $v):?>
                                    <li class="macth_xvitem" data-bind="attr:{'data-submenu-id':$data.id}" data-submenu-id="speedMenu517">
                                        <h3>
                                            <span></span><span class="macth_xvh3_a"><a href="<?php echo site_url('goods/shop_goods/'.$v['id'].'/3')?>" data-bind="text:$data.title" class=""><?php echo $v['section_name']?></a></span><s style="display: block;"></s>
                                        </h3> 
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </div>
                </div>
                <!--左侧导航 end-->
                <!--中间导航 start-->
                <ul class="macth_xv_nav">
                    <li class="macth_liactive"><a>首页</a></li>
                    <?php if( isset($list['railing-title']) ):?>
                        <?php foreach ($list['railing-title'] as $v):?>
                            <li><a href="<?php echo site_url('goods/shop_goods/'.$v['link_path'].'/3')?>"><?php echo $v['desc']?></a></li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
                <!--中间导航 end-->
            </div>
        </div>
    </div> 
	<!--头部导航条 结束-->
    
    <!--清除浮动 开始-->
    <div class="clearfix">
        <!--Banner内容 开始-->
        <div class="carousel">
            <?php if(isset($list['carousel-img'] ) ):?>
             <div class="bd">
                <ul class="imageslist">
                    <?php foreach ($list['carousel-img'] as $v):?>
                        <li><a href="<?php echo $v['link_path']?>"><img  src="<?php echo IMAGE_URL.$v['img_path']?>"/></a></li>
                    <?php endforeach;?>	 
                </ul>
                </div>
            <?php else:?>
                 <div class="bd">
                <ul class="imageslist">
                    <li><a href="#"><img src="images/store_banner.png" /></a></li>
                    <li><a href="#"><img src="images/store_banner.png" /></a></li>
                    <li><a href="#"><img src="images/store_banner.png" /></a></li>
                    <li><a href="#"><img src="images/store_banner.png" /></a></li>	 
                </ul>
                </div>
            <?php endif;?>
                <div class="buttons">
                    <a class="leftBtn"></a>
                    <a class="rightBtn"></a>
                </div>
            <div class="bg"></div>
            <?php if(isset($list['carousel-img'] ) ):?>
                <div class="num">
                    <?php for ($i = 0; $i<count( $list['carousel-img']); $i++ ):?>
                        <span <?php if($i == 0) echo "class='cur';"?>></span>
                    <?php endfor;?>
                </div>
            <?php else:;?>
                <div class="num">
                    <span class="cur"></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            <?php endif;?>
        </div>
        <script type="text/javascript" src="js/chuantong.js"></script>
        <script type="text/javascript">
            chuantong(300,4000,1200);
        </script>
        <!--Banner内容 结束-->
        
        <!--热门专区内容 开始-->
        <div class="store_hotzone clearfix">
            <h2 class="store_h2"><?php echo isset($list['one'][0]['desc']) ? $list['one'][0]['desc'] : '';?></h2>
            <?php if(isset($list['one-left-menu']) && count($list['one-left-menu'] > 0)):?>
                <div class="hotzone_left">
                    <ul>
                        <?php foreach ($list['one-left-menu'] as $v):?>
                            <li><a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="328" height="478" alt=""/></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            <?php endif;?>
            <?php if(isset($list['one-right-menu']) && count($list['one-right-menu'] > 0)) :?>    
                <div class="hotzone_right">
                    <ul>
                        <?php foreach ($list['one-right-menu'] as $v):?>
                        <li><a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="516" height="232" alt=""/></a></li>
                         <?php endforeach;?>
                    </ul>
                </div>
            <?php endif;?>
        </div>
        <!--热门专区内容 结束-->
        
        <!--新品上市内容 结束-->
        <div class="store_newarrival clearfix">
          <h2 class="store_h2"><?php echo isset($list['two'][0]['desc']) ? $list['two'][0]['desc'] : '';?></h2>
          <?php if(isset($list['two-menu']) && count($list['two-menu'] > 0)):?>
              <ul>
                  <?php foreach( $list['two-menu'] as $k => $v):?>
                  
                      <li <?php if($k == 3 || $k == 7) echo "style = 'margin-right:0'; "?>>
                      	<a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="283" height="283" alt=""/></a>
                        <p><a href="<?php echo $v['link_path']?>"><?php echo $v['desc']?></a></p>
                      	<span>M <?php echo $v['vip_price']?></span>
                      </li>
                  <?php endforeach;?>
              </ul>
          <?php endif;?>
        </div>
        <!--新品上市内容 结束-->
        
        <!--页面banner 开始-->
         <?php if(isset($list['mid']) && count($list['mid']) > 0):?>
          	<div class="store_midBanner">
            	<div class="store_midBanner_con"><a href="<?php echo $list['mid'][0]['link_path']?>"><img src="<?php echo IMAGE_URL.$list['mid'][0]['img_path']?>" width="1920" height="190" alt=""/></a></div>
          	</div>
         <?php endif;?>
        <!--页面banner 结束-->
        <!--页面搜索 开始-->
        <?php if(isset($list['search']) ):?>
            <div class="store_storesearch">
            	<span>本店搜索：</span>
                <div class="storesearch_input01_bg">
                	<input class="storesearch_input01" type="text" placeholder="输入关键字">
                </div>
                <div class="storesearch_input02_bg">
                	<input class="storesearch_input02" type="text" placeholder="¥">
                </div>
                <span class="storesearch_span">—</span>
                <div class="storesearch_input02_bg">
                	<input class="storesearch_input02" type="text" placeholder="¥">
                </div>
                <div class="storesearch_btn"><a href="">搜索</a></div>
            </div>
        <?php endif;?>
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
                        <li id="sales"><a >销售量</a></li>
                    </ul>
                </div>
                <div class="rankingList_con" id="rankingList_one">
                	<?php if( count($product_fav) > 0 ):?>
                	<ul>
                    	<?php foreach($product_fav as $v):?>
                        	<li>
                            	<a href="<?php echo site_url('goods/detail/'.$v['id'])?>" class="rankingList_img"><img src="<?php if(!empty($v['goods_img'] ) ) echo IMAGE_URL.$v['goods_img']; else echo 'images/rankingList_pic01.png';?>" width="60" height="60" alt=""/></a>
                                <span class="rankingList_title"><a href="<?php echo site_url('goods/detail/'.$v['id'])?>"><?php echo $v['name']?></a></span><br>
                                <span class="rankingList_price"><a href="<?php echo site_url('goods/detail/'.$v['id'])?>">M <?php echo $v['m_price']?></a></span><br>
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
                            <span class="rankingList_price"><a href="<?php echo site_url('goods/detail/'.$v['id'])?>">M <?php echo $v['m_price']?></a></span><br>
                            <span class="rankingList_number">已售出<i> <?php echo $v['sales_count']?> </i>笔</span>
                        </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
<!--                     <span class="rankingList_more"><a href="">查看更多产品</a></span> -->
                </div>
            </div>
            <!--排行榜 结束-->
            
            <!--推荐 开始-->
          <div class="productfloor_left_recommend">
          	  <div class="rankingList_head">推荐</div>
              <div class="recommend_con">
                  <?php if( isset( $list['left-menu'] ) && count( $list['left-menu'] > 0 ) ):?>
                     <ul>
                         <?php foreach ($list['left-menu'] as $v):?>   
                              <li>
                                  <a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="200" height="172" alt=""/></a>
                                  <span class="rankingList_title"><a href="<?php echo $v['link_path']?>"><?php echo $v['desc']?></a></span><br>
                                  <span class="rankingList_price"><a href="<?php echo $v['link_path']?>">M <?php echo $v['vip_price']?></a></span>
                              </li>
                          <?php endforeach;?>
                         
                      </ul>
                  <?php endif;?>
<!--                   <span class="rankingList_more"><a href="">查看更多产品</a></span> -->
              </div>
              </div>
            <!--推荐 结束-->
            
        </div>
        <!--产品楼层左边内容 结束-->
        
        <!--产品楼层右边内容 开始-->
        <div class="productfloor_right">
        	<!--热卖爆款 开始-->
        	<div class="productfloor_right_hotSale">
            	<h3 class="productfloor_right_title"><?php echo isset($list['three'][0]['desc']) ? $list['three'][0]['desc'] : '';?></h3>
                <ul>
                	<?php if( isset( $list['three-menu'] )  && count( $list['three-menu'] > 0 ) ):?>
                    	<?php foreach( $list['three-menu'] as $k => $v ):?>
                    	
                        	<li <?php if($k == 2 || $k == 5 ) echo "style = 'margin-right:0'; "?>>
                            	<a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="304" height="304" alt=""/></a>
                                <span class="hotSale_title"><a href=""><?php echo $v['desc']?></a></span><br>
                                <span class="hotSale_price"><a href="">M <?php echo $v['vip_price']?></a></span>
                            </li>
                            
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
            <!--热卖爆款 结束-->
            <!--F1 开始-->
        	<div class="productfloor_right_hotSale" style="margin-top:20px">
            	<h3 class="productfloor_right_title"><?php echo isset($list['four'][0]['desc']) ? $list['four'][0]['desc'] : '';?></h3>
                <?php if( isset( $list['four-menu'] )  && count( $list['four-menu'] > 0 ) ):?>
                    <ul>
                        <?php foreach( $list['four-menu'] as $k => $v ):?>
                        	<li <?php if($k == 2 || $k == 5 ) echo "style = 'margin-right:0'; "?>>
                            	<a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="304" height="304" alt=""/></a>
                                <span class="hotSale_title"><a href=""><?php echo $v['desc']?></a></span><br>
                                <span class="hotSale_price"><a href="">M <?php echo $v['vip_price']?></a></span>
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
            </div>
            <!--F1 结束-->
            <!--F2 开始-->
        	<div class="productfloor_right_hotSale" style="margin-top:20px">
            	<h3 class="productfloor_right_title"><?php echo isset($list['five'][0]['desc']) ? $list['five'][0]['desc'] : '';?></h3>
            	<?php if( isset( $list['five-menu'] )  && count( $list['five-menu'] > 0 ) ):?>
                    <ul>
                        <?php foreach( $list['five-menu'] as $k => $v ):?>
                        	<li <?php if($k == 2 || $k == 5 ) echo "style = 'margin-right:0'; "?>>
                            	<a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="304" height="304" alt=""/></a>
                                <span class="hotSale_title"><a href=""><?php echo $v['desc']?></a></span><br>
                                <span class="hotSale_price"><a href="">M <?php echo $v['vip_price']?></a></span>
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
            </div>
            <!--F2 结束-->
            <!--F3 开始-->
        	<div class="productfloor_right_hotSale" style="margin-top:20px">
            	<h3 class="productfloor_right_title"><?php echo isset($list['six'][0]['desc']) ? $list['six'][0]['desc'] : '';?></h3>
                    <?php if( isset($list['six-menu']) && count($list['six-menu'] > 0) ):?>
                        <ul>
                        	<?php foreach( $list['six-menu'] as $k => $v ):?>
                                	<li <?php if($k == 2 || $k == 5 ) echo "style = 'margin-right:0'; "?>>
                                    	<a href="<?php echo $v['link_path']?>"><img src="<?php echo IMAGE_URL.$v['img_path']?>" width="304" height="304" alt=""/></a>
                                        <span class="hotSale_title"><a href=""><?php echo $v['desc']?></a></span><br>
                                        <span class="hotSale_price"><a href="">M <?php echo $v['vip_price']?></a></span>
                                    </li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;?>
            </div>
            <!--F3 结束--> 
        </div>
        <!--产品楼层右边内容 结束-->
        </div>
        </div>
        <!--产品楼层 结束-->
    </div>
    <!--清除浮动 结束-->
    <!--页尾banner 开始-->
   
    <?php if(isset($list['end']) && count($list['end']) > 0):?>
        <div class="store_endBanner">
        	<div class="store_endBanner_con"><a href="<?php echo $list['end'][0]['link_path']?>"><img src="<?php echo IMAGE_URL.$list['end'][0]['img_path']?>" width="" height="190" alt=""/></a></div>
        </div>
    <?php endif;?>
    <!--页尾banner 结束-->
    <!-- 结尾开始 -->
    
    <!-- 结尾结束 -->

    
</body>
<script type="text/javascript" src="js/jquery.min.js"></script>
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
</script>
</html>
