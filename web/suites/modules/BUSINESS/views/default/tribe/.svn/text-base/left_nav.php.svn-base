<?php $this->load->helper("ps");?>
<div class="kehu_Left">
		<ul class="kehu_Left_ul">
			<li class="kehu_title"><a>部落管理</a></li>
			
			<?php if(CheckTribePower("/Tribe/Modifydata")):?>
				<li <?php if($nav_type == "lists"){ echo 'class="kehu_current"';}?>><a href="<?php echo site_url('tribe/lists')?>">部落信息</a></li>
			<?php endif;?>	

			<?php if(CheckTribePower("/Tribe/products")):?>
				<li <?php if($nav_type == "products"){ echo 'class="kehu_current"';}?>><a href="<?php echo site_url('tribe/products')?>">部落推荐商品</a></li>
			<?php endif;?>
			
			<?php if(CheckTribePower("/Tribe/apply_list")):?>
				<li <?php if($nav_type == "members"){ echo 'class="kehu_current"';}?>><a href="<?php echo site_url('tribe/members')?>">部落成员</a></li>
			<?php endif;?>
			
			
		</ul>
	</div>
