
<script language="JavaScript">

// 无数据隐藏头部
$(function(){
	if(<?php echo count($lists)?>==0){
		$(".header").hide();
	}
})

// 确认框绑定事件
$("#widget_submit").on("touchstart",function(){
	$(".color-bg").toggle();
	$(".h5-forget").toggle();
})

// 确认按钮绑定事件
$("#sure_submit").on("touchstart",function(){
	$(".black_feds").text("正在清空浏览记录...").show();
	$(".color-bg").toggle();
	$(".h5-forget").toggle();
    $.ajax({
        url:"<?php echo site_url('member/browsing_history/ajax_delete')?>",
        type: 'POST',
        //data:{'product_id':product_id},
        dataType: 'json',
        success: function(data){
            if(data['Result']){
            	$(".black_feds").text("清空成功").show();
            	setTimeout("prompt();", 2000);
            	window.location.reload();
            }else{
            	$(".black_feds").text("网络错误，请重新操作").show();
            	setTimeout("prompt();", 2000);
            }
        }
    });
})

</script>

<div class="page clearfix">

	<div class="collection">
		<ul class="goods_collect_list">
			<!--商品收藏 开始-->
			<?php if($lists){?>
			<?php foreach ($lists as $k=>$v):?>
			<li>
				<div class="brand_col_img">
					<a href="<?php echo site_url('goods/detail/'.$v['product_id']);?>">
						<img alt="" src="<?php echo IMAGE_URL.$v['goods_thumb']; ?>" onerror="this.src='images/default_img_b.jpg'">
					</a>
				</div>

				<div class="brand_col_info">
					<p><?php echo $v['product_name'];?></p>
					<div class="fn-left">
						<p class="order_price">
							<span class="text_red">¥<?php echo $v['price'];?></span>
						</p>
					</div>
				</div>
			</li>
			<!--商品收藏 结束-->
			<?php endforeach;?>
			<?php }else{ ?>
			<span style="display: block;color: #535353;font-size: 15px;text-align: center;width:150px;height:150px;background:#ddd;border-radius: 50%;margin:40% auto 0 auto;"><em class="icon-liulan" style="font-size: 90px;line-height: 160px;color:#fff;"></em></span>
			<span style="display: block;color: #535353;font-size: 15px;text-align: center;margin-top: 10px">暂无浏览记录</span>
			<a href="<?php echo site_url('/home');?>" class="yellow-but yellow-but-width">去逛逛</a>
			<?php };?>
		</ul>
        <!-- 暂无收藏 -->

	</div>
	<!--collection end-->

</div>
<!--page end-->

