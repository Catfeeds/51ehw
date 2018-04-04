<div class="container">
    <div class="header" name="top">
        <a href="javascript:history.back()" target="_self" class="icon-back"></a>
        <p class="title">我的家族</p>
    </div>
	<!--header end-->
<div class="page clearfix">
	<div class="my_family_box">

		<div class="tabBox">
			<div class="bd">
				<ul>
					<!--月排行 开始-->
					<div class="my_family_head">
						<ul class="right_note clearfix">
							<li class="notice_word_big">家族成员<p class="red_font"><?php echo count($result);?></p></li>
							<li class="notice_word_big">营业额<p class="red_font">￥<?php echo number_format($total_price, 2);?></p></li>
						</ul>
					</div>
					<?php 
					$i = 0;
				foreach ($result as $v):?>
					<div class="my_family clearfix">
						<span class="fn-16"><?php echo ++$i;?></span> <span class="fn-right"><span
							class="mr-10 c9"><em class="c9">￥:</em><?php echo number_format($v['total_price'], 2);?></span><span
							class="c9"><em class="c9">|</em><?php echo $v['count_order'] == NULL?0:$v['count_order'];?></span></span><img
							src="<?php echo $v['img_avatar']==NULL?"images/default_img_logo.jpg":$v['img_avatar'];?>" alt="<?php echo $v['nick_name'];?>" style="display: inline-block;">
						<?php echo $v['nick_name'];?>
					</div>
					<?php endforeach;?>

				</ul>
				<!--月排行 结束-->
                <!--年排行 开始-->
				<ul>		
					<div class="my_family_head">
						<ul class="right_note clearfix">
							<li class="notice_word_big">家族成员 <p class="red_font"><?php echo count($result_y);?></p></li>
							<li class="notice_word_big">营业额  <p class="red_font">￥<?php echo number_format($total_price_y, 2);?></p></li>
						</ul>
					</div>
					<?php 
					$i = 0;
				foreach ($result_y as $v):?>
					<div class="my_family clearfix">
						<span class="fn-16"><?php echo ++$i;?></span> <span class="fn-right"><span
							class="mr-10 c9"><em class="c9">￥:</em><?php echo number_format($v['total_price'], 2);?></span><span
							class="c9"><em class="c9">|</em><?php echo $v['count_order'] == NULL?0:$v['count_order'];?></span></span><img
							src="<?php echo $v['img_avatar']==NULL?"images/default_img_logo.jpg":$v['img_avatar'];?>" alt="<?php echo $v['nick_name'];?>" style="display: inline-block;">
						<?php echo $v['nick_name'];?>
					</div>
					<?php endforeach;?>



					
				</ul>
				<!--年排行 结束-->
			</div>
		</div>
	</div>
	<!--member-box end-->

    


</div>
<!--page end-->

<div class="footer tabBox">
	<div class="hd my_family_change">
		<ul>		
			<li><a>月排行榜</a></li>
			<li><a>年排行榜</a></li>
		</ul>
	</div>
</div>
<!--footer end-->

<script type="text/javascript">
    //数量、套餐切换
    TouchSlide({
        slideCell: "#leftTabBox"
    });
</script>
