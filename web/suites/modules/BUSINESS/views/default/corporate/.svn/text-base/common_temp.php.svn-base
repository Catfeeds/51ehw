
<div class="top"></div>

<!--默认头部 开始-->
<div class="preterm_top">
	<div class="preterm_con">
    	<div class="preterm_logo"><a href="javascript:void(0);" target="_blank" title="51易货网"><img alt="51易货网" src="<?php echo isset($corporation['img_url'])&&$corporation['img_url']!=''?IMAGE_URL.$corporation['img_url']:'images/preterm_logo.png' ?>" width="100"></a></div>
        <div class="preterm_title">
        	<h1><?php echo isset($corporation['corporation_name'])?$corporation['corporation_name']:"" ?></h1>
            <h4>
            <?php 
            switch ($corporation["grade"]){
                case 1 :
                    echo '易货店会员';
                    break;
                case 2 :
                    echo '专卖店会员';
                    break;
                case 3 :
                    echo '旗舰店会员';
                    break;
            }
            ?>
            </h4>
        </div>
        <?php //echo'<pre>';var_dump($corporation);exit;?>
        <div class="preterm_contact">
        	<div><img alt="" src="images/preterm_t.png"><p><span><?php echo isset($corporation['contact_name'])?$corporation['contact_name']:"" ?></span><span style="margin-left:20px;"><?php echo substr($corporation['contact_mobile'],0,4).'****'.substr($corporation['contact_mobile'],-3);?></span></p></div>
            <div><img alt="" src="images/preterm_e.png"><p><span><?php echo substr($corporation['email'],0,1).'****'.substr($corporation['email'],strrpos($corporation['email'],'@')-1);?></span></p></div>
            <div> <a target="_blank" href="<?php echo "http://api.map.baidu.com/geocoder?address=".$corporation['province'].$corporation['city'].($corporation['district']?$corporation['district']:"").$corporation['address']."&output=html&src=yourCompanyName|yourAppName";?>"><img alt="" src="images/preterm_a.png"><p style="line-height:16px;"><span style="color:#ffb470"><?php echo $corporation['province'].$corporation['city'].($corporation['district']?$corporation['district']:"").$corporation['address']?></span></a></p></div>
        </div>
    </div>
</div>
<!--默认头部 结束-->

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

				<?php
    $i = 0;
    foreach ($productList as $product):
        if ($i % 5 == 0) {
            ?>
				  <ul class="clearfix"><?php }?>   
           	  <li>
				<div class="con_img">
					<a href="<?php echo site_url('goods/detail/'.$product['id']);?>"
						title="<?php echo $product['name'];?>"> <img
						src="<?php echo IMAGE_URL.$product['goods_thumb'];//$product['image_name']."_270".$product['file_ext'];?>"
						width="228" height="228" alt="<?php echo $product['name'];?>" />
					</a>
				</div>
				<p><?php  echo $product['name'];?></p>
				<p style="color: #c32d05; font-size: 16px">易货价: <?php echo $product['vip_price'];?> 货豆</p>
				<!-- <p style="color: #fea33b">(0人)评价</p>  -->
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


	<div class="showpage">
				<?php echo $pagination;?>

            </div>
</div>


