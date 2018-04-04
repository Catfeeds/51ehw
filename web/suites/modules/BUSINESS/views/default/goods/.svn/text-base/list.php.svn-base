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
				<li><a href="<?php //echo site_url('goods/search/'.$cate['cate_id'].'/'.$keyword);?>" class="ssCurrent"><?php //echo $cate['cate_name'];?></a></li>
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
	<!--<ul class="liaobiaoye" id="liaobiaoye">
		<!--<li>综合排序</li>
            <li><a href="javascript:demand_search(1);" id="sort1">综合</a></li>
            <li><a href="javascript:demand_search(2);" id="sort2">数量 <span id="sort02" ></span></a></li>
            <li> <a href="javascript:demand_search(3);" id="sort3">需求总价 <span id="sort03"></span></a></li>
            <li> <a href="javascript:demand_search(4);" id="sort4">发布时间 <span id="sort04"></span></a></li>-->
		<!--<li><a class="ccCurrent">综合排序</a></li>
		<li ><a >销量<b id="sort1" class="icon-arrowup"></b><i id="sort01" class="icon-arrowdown"></i></a></li>
		<li><a >评价<b id="sort2" class="icon-arrowup"></b><i id="sort02" class="icon-arrowdown"></i></a></li>
        <li><a >价格<b id="sort3" class="icon-arrowup"></b><i id="sort03" class="icon-arrowdown"></i></a></li>
	</ul>
    <label style="width:auto;"><input type="button" value="发货地" id="city" class="icon-select"/><b style="font-size:23px; color:#b8b8b8; vertical-align:middle" class="icon-select"></b></label>
    <label><input type="checkbox" name="new" value="1"><em>包邮</em></label>-->
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
    						<img src="<?php echo 'http://www.test51ehw.com/uploads/B/'.$product['goods_thumb'];//base_url($product['image_name']."_270".$product['file_ext']);?>"
    						width="228" height="228" alt="<?php echo $product['name'];?>" />
						<?php }else{ ?>
						    <img src="<?php echo IMAGE_URL.$product['goods_thumb'];//base_url($product['image_name']."_270".$product['file_ext']);?>"
						width="228" height="228" alt="<?php echo $product['name'];?>" />
						<?php }?>
						
					</a>
				</div>
				<p><?php  echo $product['name'];?></p>
				<p style="color: #fea33b; font-size: 16px">易货价: <?php echo number_format($product['vip_price'],2);?> 货豆 <span><a><img src="images/ml_contact22.png" width="20" height="20" alt=""/></a></span></p>
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
 <script src="js/Popt.js"></script>
    <script src="js/cityJson.js"></script>
    <script src="js/citySet.js"></script>
<script>
    $("#city").click(function (e) {
        SelCity(this,e);
    });
</script>

<script>
  /* $(function(){
  $("#liaobiaoye li").click(function(){
    $("#liaobiaoye li a ").eq($(this).index()).addClass("ccCurrent").siblings().removeClass("ccCurrent");
	  $(this).parent().find("b").addClass("icon-huidaodingbu");
  })
})  
*/
$("#liaobiaoye li a").click(function(){
       $(this).addClass("ccCurrent").parent().siblings().find("a").removeAttr("class");
		$(this).parent().find("b").toggleClass("ccCurrent1");
		
   });
</script>