<style type="text/css">
  .commerce_index {padding-bottom: 10px;}
</style>


<!-- 杰出商会 -->

<div class="commerce_index">
    <a href="javascript:history.back()" class="tribe_index_nav_left"><span class="icon-right" style="-webkit-transform: rotate(180deg);font-size: 23px;color:#fff;"></span></a>
	<?php if( $commerce_list ){?> 
    <!-- 杰出商会列表 -->
	<div class="recommended_tribe prominent_commerce_box" style="border-top:0px;">
		<ul class="recommended_tribe_top">
			<?php foreach ( $commerce_list as $v ){?>
			<li>
				<a href="<?php echo site_url('Tribe/home/'.$v['id'].'/'.$label_id)?>"> <i><img src="<?php echo IMAGE_URL.$v['logo']?>" onerror="this.src='images/tmp_logo.jpg'"></i>
			        <div class="recommended_tribe_rigth">
						<div class="tribal_index_zhiding">
							<h2><?php echo $v['name']?></h2>
						</div>
						<div class="tribe_tuijian_box">
							<p><?php echo $v['content']?></p>
						</div>
					</div>
				</a>
			</li>
			<?php }?>
		</ul>
	</div>
	<?php }else{?>
	
		<span><center style="margin-top:20px;" >暂无数据</center></span>
		
	<?php }?>
</div>



<script type="text/javascript">



</script>