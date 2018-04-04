<div class="essay_share_details">
	<!-- 标题 -->
	<div class="essay_share_details_title">
		<span><?php echo $list['title'];?></span>
	</div>
	<!-- 时间／作者 -->
	<div class="essay_share_details_time">
		<span><?php echo $list['create_time'];?></span><a href="<?php echo site_url("home")?>" class="essay_details_use">善活精英</a>
	</div>
	<!-- 文章内容 -->
	<div class="essay_share_details_main">
		<?php 
		$content = str_replace("uploads/fck",base_url().'uploads/C/uploads/fck',$list['content']); 
		echo $content;
		?>
    </div>
</div>