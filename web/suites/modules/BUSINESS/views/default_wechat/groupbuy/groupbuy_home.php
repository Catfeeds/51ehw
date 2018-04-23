
<style type="text/css">
.groupbuy-home-text {display: -webkit-box;overflow: hidden;font-size: 15px!important;text-align: left;height: 30px;-webkit-line-clamp: 1;-webkit-box-orient: vertical;border-bottom: 1px solid #fff;margin:10px;}

</style>
<!-- 拼团主页 开始 -->
<div style="margin-top: 50px;">
<?php 
if(isset($groupbuy_list) && count($groupbuy_list) != 0){
    foreach($groupbuy_list as $v):
?>
	<div style="margin-bottom: 20px;position: relative;">
		<div>
			<a href="<?php echo site_url("goods/detail/".$v['id']."/0/groupbuy")?>"><img class="groupbuy_img" src="<?php echo IMAGE_URL.$v['file']?>" alt="<?php echo $v['image_name']?>" onerror="this.src='images/default_img_s.jpg'"></a>
		</div>
	<div style="position: absolute;bottom:0;background:rgba(0,0,0,0.5);width:100%;color:#fff;">
		<div style="" class="groupbuy-home-text">
			<span style="font-size: 15px; display: block;padding-top: 10px;"><?php echo $v['name']?></span>
		</div>
		<div>
			<span style="display: inline-block; padding-left: 10px; padding-top: 10px;padding-bottom: 10px;">
			<span style="border: 1px solid #ccc; display: inline-block; margin-right: 10px; padding: 1px 4px;"><?php echo $v['menber_num']?>人团</span>
			<span style="font-size: 14px;"><?php echo $v['groupbuy_price']?></span>提货权</span>
			
			<?php if( date('Y-m-d H:m:s') > $v['groupbuy_end_at']  ):?>
			<a href="<?php echo site_url("goods/detail/".$v['id']."/0/groupbuy")?>" style="display: inline-block; width: 105px; line-height: 35px; text-align: center; background: #D5D5D5; font-size: 18px; color: #262626; position: absolute; right: 0;opacity:0.5;">
			团购已结束
			</a>
			
			<?php else:?>
			
			<a href="<?php echo site_url("goods/detail/".$v['id']."/0/groupbuy")?>" style="display: inline-block; width: 105px; line-height: 35px; text-align: center; background: #FECF0A; font-size: 18px; color: #262626; position: absolute; right: 0;">
			去开团
			</a>
			<?php endif;?>
		</div>
	</div>	
	</div>
<?php
    endforeach;
}else{
?>
    <div style="margin-top: 100px; text-align:center;">
		<span>----------暂无团购，敬请期待----------</span>
	</div>
<?php 
}
?>
	<!-- 列表1 -->
	<div style="margin-bottom: 20px;" hidden>
		<div>
			<img src="images/pintuan01.png" alt="">
		</div>
		<div style="background: #F3F3F3;">
			<span
				style="font-size: 15px; color: #383838; padding: 10px; display: block;">三头客厅吊灯现代简约LED饭厅吧台创意个性欧式黄
				蓝绿三色长方底盘</span>
		</div>
		<div>
			<span
				style="display: inline-block; padding-left: 10px; padding-top: 20px;"><span
				style="font-size: 14px;">599.00</span>提货权</span> <span
				style="border: 1px solid #ccc; display: inline-block; margin-left: 10px; padding: 1px 4px;">2人团</span>
			<a href="javacript:void(0);"
				style="display: inline-block; width: 120px; line-height: 48px; text-align: center; background: #FECF0A; font-size: 18px; color: #262626; position: absolute; right: 0;">去开团</a>
		</div>
	</div>
</div>
<!-- 拼团主页 结束 -->

<!-- 底部 距离 -->
<div style="margin-bottom: 50px;">
	<span style="opacity: 0;">防止底部导航栏遮住内容</span>
</div>
<!-- 图片大小宽度按比例显示script -->
<script>
//设置宽度、高度为75*42比例
$(document).ready(function(){
    var width = $(window).width();
        $(".groupbuy_img").css("height",64/(64/width));
        $(".groupbuy_img").css("width","100%");
	})
</script>