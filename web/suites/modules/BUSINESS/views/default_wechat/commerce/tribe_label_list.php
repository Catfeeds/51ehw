<style type="text/css">
  .commerce_directory_search {padding: 20px 15px 20px 5px;}
</style>


<!-- 杰出商会 -->
 
<div class="commerce_index">
 		<div class="commerce_directory">
        <!-- 搜索会员 -->
       <div class="commerce_directory_search">
          <a href="javascript:history.back()" class="icon-back new_back_icon"></a>
          <label onclick="search();">
            <p><span class="icon-search"></span><input type="text" placeholder="请输入商会名称"></p>
          </label>
       </div>
       </div>
	<?php if( $tribe_info ){?>
    <!-- 杰出商会列表 -->
	<div class="recommended_tribe prominent_commerce_box">
		<ul class="recommended_tribe_top">
			<?php foreach ( $tribe_info as $v ){?>
			<li>
				<a href="<?php echo site_url('Tribe/Home/'.$v['id'].'/'.$label_id)?>"> <i><img src="<?php echo IMAGE_URL.$v['logo']?>" onerror="this.src='images/tmp_logo.jpg'"></i>
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
function search(){
	window.location.href="<?php echo site_url("Commerce/search_tribe/").'/'.$label_id; ?>";
}
</script>

<script type="text/javascript">



</script>