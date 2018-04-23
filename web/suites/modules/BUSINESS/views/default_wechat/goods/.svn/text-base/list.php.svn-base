 <script type="text/javascript" src="js/jquery.mmenu.min.js"></script>
 <script type="text/javascript" src="iscroll.js"></script>
 <script type="text/javascript" src="iscrollAssist.js"></script>
    <script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>

<style>
/****** 下拉刷新、上拉加载更多的样式********/
#pulldown, #pullup {
	background:#fff;
	height:40px;
	line-height:40px;
	padding:5px 10px;
	border-bottom:1px solid #ccc;
	font-weight:bold;
	font-size:14px;
	color:#888;
}

#pulldown .pulldown-icon, #pullup .pullup-icon  {
	display:block; float:left;
	width:40px; height:40px;
	background:url(images/pull-icon@2x.png) 0 0 no-repeat;
	-webkit-background-size:40px 80px; background-size:40px 80px;
	-webkit-transition-property:-webkit-transform;
	-webkit-transition-duration:250ms;
}

#pulldown .pulldown-icon {
	-webkit-transform:rotate(0deg) translateZ(0);
}

#pullup .pullup-icon  {
	-webkit-transform:rotate(-180deg) translateZ(0);
}

#pulldown.flip .pulldown-icon {
	-webkit-transform:rotate(-180deg) translateZ(0);
}

#pullup.flip .pullup-icon {
	-webkit-transform:rotate(0deg) translateZ(0);
}

#pulldown.loading .pulldown-icon, #pullup.loading .pullup-icon {
	background-position:0 100%;
	-webkit-transform:rotate(0deg) translateZ(0);
	-webkit-transition-duration:0ms;

	-webkit-animation-name:loading;
	-webkit-animation-duration:2s;
	-webkit-animation-iteration-count:infinite;
	-webkit-animation-timing-function:linear;
}



@-webkit-keyframes loading {
	from { -webkit-transform:rotate(0deg) translateZ(0); }
	to { -webkit-transform:rotate(360deg) translateZ(0); }
}
dd{
	border-bottom:1px solid #ccc;
	height:50px;
	line-height:50px;
	margin-left: 0px;
	text-align:center;
}
</style>
	<div class="container"  id="leftTabBox">
		<div class="header" name="top">
		<a href="javascript:history.back()" target="_self" class="icon-back"></a>
		<!-- <a href="#menu" target="_self" class="icon-fenlei"></a>
		<a href="<?php echo site_url("home");?>" target="_self" class="icon-homefill fn-right "></a>-->
		<p class="title"><?php echo isset($title)?$title:$this->session->userdata('app_info')['app_name'];?></p>
		</div><!--header end-->
<!--header end-->
        <div class="page clearfix">
            <!-- <ul class="goods-nav">
                    <li class="nav-item  focus">
                        最新
                        <span class="sort">
                            <i class="down icon-unfold cur" style="top:-3px;"></i>
                        </span>
                    </li>
                    <li class="nav-item  ">
                        价格
                        <span class="sort">
                            <i class="up icon-fold cur"></i>
                            <i class="down icon-unfold"></i>
                        </span>
                    </li>
                    <li class="nav-item">
                        筛选
                        <span class="sort">
                            <i class="down icon-unfold cur"  style="top:-3px;"></i>
                        </span>
                    </li>
                </ul>goods-nav end-->

                <div class="goods-container clearfix">
                   <?php
				   foreach($productList as $prod):?>
					<div class="goods-info">
                       <div class="right-margin-div">
                            <div class="goods-detail-img maximg_365">
                                <a href="<?php echo site_url('goods/detail').'/'.$prod['id'];?>"><img src="<?php echo base_url($prod['image_name']."_290".$prod["file_ext"]);?>" onerror="this.src='images/default_img_s.jpg'"></a>
                            </div>
                            <a class="title" href="<?php echo site_url('goods/detail').'/'.$prod['id'];?>"><?php echo $prod["name"]?></a>
                            <p class="goods-price">
                                <!--<del>¥359.00</del>-->

                                <span>易货价: <?php echo number_format($prod["vip_price"],2)?> 提货权</span>

                            </p>
                        </div>
                    </div>
                    <?php endforeach;?>


                </div><!--goods-container end-->
           <nav id="menu">
			<ul>
				<?php
				$level = 1;
				$flaglevel = 0;
				foreach($sections as $key=>$section):
				    $dept = substr_count($section["fpath"], ",") / 2 + 1;
					if($dept > $level)
					{
						$level = $dept;
						$flaglevel ++;
				?>
						<ul>

				<?php }
					else if($dept<$level){

					for($i=$dept;$i<$level;$i++)
					{
						$flaglevel --;
					?>
					 </li>
					</ul>
				  </li>
				<?php }
						$level = $dept;
					}else{
					if($key>0)
						{
					?>
					</li>
					<?php }}?>
					<li>
					<?php if($key+1<count($sections) && substr_count($sections[$key+1]["fpath"], ",") / 2 + 1 > $level){?>
					<span><?php echo $section["section_name"]?></span>
					<?php }else {?>
					<a href="<?php echo site_url('goods/getList').($type==""?"":"/".$type).'?section_id='.$section["id"]?>"><span><?php echo $section["section_name"]?></span></a>
					<?php }?>

				<?php endforeach;?>
				<?php for($i=0;$i<$flaglevel;$i++){?>
					</li>
					</ul>
				<?php }?>

			</ul>
		</nav>



