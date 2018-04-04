<div class="cmLeft manage_new_cmLeft">
	<div class="downTittle manage_new_downTittle menu_manage_downTittle">商品管理</div>
	<div class="cmLeft_down"> 
		<ul>
			<li><a href="<?php echo site_url("corporate/product/create");?>" <?php if(isset($types)&&$types=='create_product')echo 'class="houtai_zijin_current1"'; ?>>发布商品</a></li>
			<li><a href="<?php echo site_url('corporate/product/get_list');?>"<?php if(empty($types))echo 'class="houtai_zijin_current1"'; ?>>全部商品(<?php echo isset($all_count)?$all_count:'' ?>)</a></li>
			<li><a
				href="<?php $type = 'sale'; echo site_url('corporate/product/get_list/'.$type) ?>"<?php if(isset($types)&&$types=='sale')echo 'class="houtai_zijin_current1"'; ?>>销售中(<?php echo isset($sale)?$sale:'' ?>)</a></li>
			<li><a
				href="<?php $type = 'notsale'; echo site_url('corporate/product/get_list/'.$type) ?>"<?php if(isset($types)&&$types=='notsale')echo 'class="houtai_zijin_current1"'; ?>>待发布(<?php echo isset($notsale)?$notsale:'' ?>)</a></li>
			<li><a
				href="<?php $type = 'not'; echo site_url('corporate/product/get_list/'.$type) ?>"<?php if(isset($types)&&$types=='not')echo 'class="houtai_zijin_current1"'; ?>>已售罄(<?php echo isset($not)?$not:'' ?>)</a></li>
			<li><a href="<?php echo site_url('corporate/section/get_list');?>" <?php if(isset($types)&&$types=='cat')echo 'class="houtai_zijin_current1"'; ?>>分类管理</a></li>
            <li><a href="<?php echo site_url('corporate/tribe_product');?>" <?php if(isset($types)&&$types=='tribe_discount')echo 'class="houtai_zijin_current1"'; ?>>部落优惠商品</a></li>
		</ul>
	</div>
</div>