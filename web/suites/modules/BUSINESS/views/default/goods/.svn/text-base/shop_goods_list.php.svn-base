
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

	<!--页头 结束-->
	<!--店铺头部 开始-->
    <?php if(isset($list['top']) && count($list['top']) > 0):?>
	<div class="store_top storeLess_top"
	style="background: #fff; margin: 0;">
	<div class="store_top_con">
		<img src="<?php echo IMAGE_URL.$list['top'][0]['img_path']?>" width="1920"
			height="100" alt="" />
	</div>
	</div>
    <?php endif;?>
    <!--店铺头部 结束-->
	<!--头部导航条 开始-->
	<div class="eh_navbar clearfix" style=" <?php echo isset($list['column-color']['0']['desc']) ? 'background:'.$list['column-color']['0']['desc'] : '' ?>">
		<div class="macth_xv_navlist" >
			<div class="macth_xv_menu" style=" <?php echo isset($list['column-color']['0']['desc']) ? 'background:'.$list['column-color']['0']['desc'] : '' ?>">
				<!--左侧导航 start-->
				<div class="macth_xv_categorys" style=" <?php echo isset($list['column-color']['0']['desc']) ? 'background:'.$list['column-color']['0']['desc'] : '' ?>">
					<div class="macth_xv_cat_title">
						<h2 class="macth_cat_name">
							<a href="">全部分类<b class="icon-select"></b></a>
						</h2>
					</div>

					<div class="macth_xv_cat_catlist ">
						<ul class="macth-dropdown-menu" data-bind="foreach:navData">
                            <?php if(isset($menu_list) && count($menu_list) > 0):?>
                                <?php foreach($menu_list as $v):?>
                                    <li class="macth_xvitem"
								data-bind="attr:{'data-submenu-id':$data.id}"
								data-submenu-id="speedMenu517">
								<h3>
									<span></span><span class="macth_xvh3_a">
									 <?php if(!isset( $status ) ):?>
									     <a href="<?php echo site_url('goods/shop_goods/'.$v['id'].'/'.$tem_id)?>" data-bind="text:$data.title"lass=""><?php echo $v['section_name']?></a>
								    <?php else:?>
										 <a	href="<?php echo site_url('goods/shop_class/'.$v['id'].'/'.$corp_id.'/'.$tem_id)?>" data-bind="text:$data.title"lass=""><?php echo $v['section_name']?></a>
									 <?php endif;?>
										</span><s
										style="display: block;"></s>
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
					<li class="macth_liactive"><a href="<?php echo site_url('home/GoToShop/'.$corp_id)?>" style=" <?php echo isset($list['column-color']['0']['desc']) ? 'background:'.$list['column-color']['0']['desc'] : '' ?>">首页</a></li>
                        <?php if( isset($list['railing-title']) ):?>
                            <?php foreach ($list['railing-title'] as $v):?>
                                <?php if(!isset( $status ) ):?>
                                    <li><a href="<?php echo site_url('goods/shop_goods/'.$v['link_path'].'/'.$tem_id)?>"><?php echo $v['desc']?></a></li>
                                <?php else:?>
                                    <li><a href="<?php echo site_url('goods/shop_class/'.$v['link_path'].'/'.$corp_id.'/'.$tem_id)?>"><?php echo $v['desc']?></a></li>
                             
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                </ul>
				<!--中间导航 end-->
			</div>
		</div>
	</div>
	<!--<div class="select" style="margin-top:20px;">
<!-- 	<div class="select_top">商品筛选 （ 1个商品）</div> -->
	<!-- 	<div class="select_con_01"> -->
	<!-- 		<div class="select_con_001">分类：</div> -->
	<!-- 		<div class="select_con_002"> -->
	<!-- 			<ul class="clearfix"> -->
	<!-- 							<li><a href="http://localhost/51yhw/web/index.php/goods/search/1314/的" class="ssCurrent">红茶</a></li> -->
	<!-- 							</ul> -->
	<!-- 		</div> -->
	<!-- 	</div> -->
	<!-- 	</div> -->
	<div class="con_top">
		<ul>
			<li>综合排序</li>
			<!--<li><a class="ccCurrent">综合排序</a></li>
		<li><a >销量</a></li>
		<li><a >价格</a></li>
		<li><a >评论数</a></li>
<!-- 		<li><a >新品</a></li>-->
		</ul>
	</div>
	<div class="con_con preterm_p clearfix">
        <?php if(isset( $shop_goods_list) && count($shop_goods_list) > 0):?>
    		<ul class="clearfix">
    		
    		<?php foreach ($shop_goods_list as $k => $v):?>
    			<li <?php echo $k%5==4?'style="margin-right:0"':"" ?>>
    				<div class="con_img">
    					<a href=<?php echo site_url('goods/detail/'.$v['id']);?>
    						title="<?php echo $v['name']?>"> <img
    						src="<?php echo IMAGE_URL.$v['goods_img']?>"
    						alt="<?php echo $v['name']?>" height="228" width="228">
    					</a>
    				</div>
    				<p><?php echo $v['name']?></p>
    				<p style="color: #fea33b; font-size: 16px">易货价: <?php echo $v['vip_price']?> 货豆</p>
    				<p style="color: #aaaaaa">(0人)评价</p> <!--<div class="con_btn01">
    					<a
    						href="javascript:add_to_cart(337,this);"
    						title="加到购物车" class="product-add-btn">加入购物车</a>
    				</div>
    				<div class="con_btn02">
    					<a href="#" title="收藏" class="product-btn product-favorite">收藏</a>
    				</div>-->
    			</li>
    	    <?php endforeach;?>  
    	   </ul>
    	   <!-- 此处是分页 start -->
    	   <ul>
        	   <div class="pingjia_showpage clearfix" style="margin-right:0; ">
                	<?php echo $page;?>
               </div>
           </ul>
           <!-- 此处是分页 end -->
       <?php else:?>
		<div class="goods_none">没有您想要搜索的商品</div>
		<?php endif;?>
    <!--<div class="showpage">
				
            </div>-->
	</div>

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

