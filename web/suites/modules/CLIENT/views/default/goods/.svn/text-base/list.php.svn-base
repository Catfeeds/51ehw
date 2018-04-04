<!--添加导航 预加载-->
<script type="text/javascript" src="js/hoverIntent.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/superfish.js"></script><!--顶部菜单带二级、三级子栏目-->
<script type="text/javascript" src="js/knockout.js"></script><!--类目展示-->
<script type="text/javascript" src="js/jquery.aimmenu.js"></script><!--轮播图-->
<script>
//顶部菜单
//站点菜单
    (function($){
        $(document).ready(function(){
            var example = $('#sf-menu').superfish({
            });
        });
    })(jQuery);
</script>

 
<?php $this->load->view('navigation_bar');?>
<!--
<div class="top"></div>
<div class="select" style="margin-top:20px;">
	<div class="select_top">商品筛选 （ <?php //echo $totalcount?>个商品）</div>
<?php //if(isset($key_cate) && count($key_cate) != 0):?>
	<div class="select_con_01">
		<div class="select_con_001">分类：</div>
		<div class="select_con_002">
			<ul class="clearfix">
			<?php //foreach ($key_cate as $cate):?>
				<li><a href="<?php //echo site_url('goods/search/'.$cate['cate_id'].'/'.$keyword);?>" class="ssCurrent"><?php echo $cate['cate_name'];?></a></li>
				<?php //endforeach;?>
			</ul>
		</div>
	</div>
	<?php //else:?>
	<div class="select_con_01">
		<div class="select_con_001">价格：</div>
		<!--<div class="select_con_002">
			<ul>
			    <li><a href="#" class="ssCurrent">不限</a></li>
				<li><a href="#">0-199</a></li>
				<li><a href="#">200-399</a></li>
				<li><a href="#">400-799</a></li>
				<li><a href="#">800-1999</a></li>
				<li><a href="#">2000-3999</a></li>
				<li><a href="#">4000以上</a></li>
			</ul>
			<div class="select_con_002_2">
				<input type="text" class="in_01"> <span> - </span> <input
					type="text" class="in_01">
				<div class="in_btn">
					<a href="#">确定</a>
				</div>
			</div>
		</div>

	</div>
	<?php //endif;?>
</div>-->

<div class="con_top">
	<ul>
		<li>综合排序</li>
		<!--<li><a class="ccCurrent">综合排序</a></li>
		<li><a >销量</a></li>
		<li><a >价格</a></li>
		<li><a >评论数</a></li>
		<li><a >新品</a></li>-->
	</ul>
</div>
<div class="con_con preterm_p">
<?php if(count($productList)>0): ?>
				<?php
    $i = 0;
    foreach ($productList as $product):
        if ($i % 5 == 0) {
            ?>
				  <ul class="clearfix"><?php }?>
           	  <li>
				<div class="con_img">
					<a href="<?php echo site_url('goods/detail/'.$product['id']);?>"
						title="<?php echo $product['name'];?>"> 
						<?php if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/'){?>
    						<img src="<?php echo 'http://www.test51ehw.com/uploads/C/'.$product['goods_thumb'];//base_url($product['image_name']."_270".$product['file_ext']);?>"
    						width="228" height="228" alt="<?php echo $product['name'];?>" />
						<?php }else{ ?>
						    <img src="<?php echo IMAGE_URL.$product['goods_thumb'];//base_url($product['image_name']."_270".$product['file_ext']);?>"
						width="228" height="228" alt="<?php echo $product['name'];?>" />
						<?php }?>
						
					</a>
				</div>
				<p><?php  echo $product['name'];?></p>
				<p style="color: #fe4101; font-size: 16px">易货价: <?php echo number_format($product['vip_price'],2);?> 货豆 <span><a><img src="images/ml_contact22.png" width="20" height="20" alt=""/></a></span></p>
				<!-- <p style="color: #aaaaaa">(<?php echo !empty($product['comment_total'])?$product['comment_total']:0;?>人)评价</p>  -->
				<!--<div class="con_btn01">
					<a
						href="javascript:add_to_cart(<?php echo $product['id'];?>,this);"
						title="加到购物车" class="product-add-btn">加入购物车</a>
				</div>
				<div class="con_btn02">
					<a href="#" title="收藏" class="product-btn product-favorite">收藏</a>
				</div>-->
			</li>
               <?php
        //echo $i % 5;
        if ($i % 5 == 4) {  
            ?>
							</ul>
		<!-- End .row -->
				<?php
        }
        ++ $i;
    endforeach;
    ?>
        <?php if ($i != 5): ?>
        	</ul>
        <?php endif;?>
    
    <?php else:?>
    <div class="goods_none">没有您想要搜索的商品</div>
    <?php endif;?>


	<div class="showpage">
				<?php echo $pagination;?>

            </div>
</div>

<!--添加导航 后加载-->
<script type="text/javascript" src="js/navbar.js"></script>


