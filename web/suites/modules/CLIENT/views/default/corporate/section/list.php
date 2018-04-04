    <div class="top2 manage_fenlei_top2">
    	<ul>
    		<li><a
    			href="<?php echo site_url('corporate/info');?>">首页</a></li>
    		<li  class="tCurrent"><a href="<?php echo site_url('corporate/product/get_list');?>">商品管理</a></li>
            <li><a href="<?php echo site_url('corporate/activity/get_list');?>">活动管理</a></li>
    		<li><a href="<?php echo site_url('corporate/order/get_list');?>">订单管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">客户管理</a></li>
    		<li><a href="<?php echo site_url('corporate/comment/get_list');?>">咨询评价</a></li>
    		<!--<li><a href="<?php echo site_url('corporate/finanial/get_list');?>">资金管理</a></li>
    		<li><a href="<?php echo site_url('corporate/customer/get_list');?>">会员管理</a></li>-->
    		<li><a href="<?php echo site_url('corporate/myshop/get_shop');?>">店铺管理</a></li>
            <li ><a href="<?php echo site_url('corporate/report/subordinate');?>">下线分成</a></li>
    	</ul>
    </div>
<div class="Box manage_new_Box clearfix">
	<div class="cmLeft manage_new_cmLeft">
		<div class="downTittle manage_new_downTittle menu_manage_downTittle">商品管理</div>
		<div class="cmLeft_down">
			<ul>
				<li><a href="<?php echo site_url("corporate/product/create");?>">发布商品</a></li>
				<li><a href="<?php echo site_url('corporate/product/get_list');?>">全部商品(<?php echo isset($all_count)?$all_count:'' ?>)</a></li>
				<li><a href="<?php $type = 'sale'; echo site_url('corporate/product/get_list/0/'.$type) ?>">销售中(<?php echo isset($sale)?$sale:'' ?>)</a></li>
				<li><a href="<?php $type = 'notsale'; echo site_url('corporate/product/get_list/0/'.$type) ?>">待发布(<?php echo isset($notsale)?$notsale:'' ?>)</a></li>
				<li><a href="<?php $type = 'not'; echo site_url('corporate/product/get_list/0/'.$type) ?>">已售罄(<?php echo isset($not)?$not:'' ?>)</a></li>
				<li class="houtai_zijin_current"><a href="<?php echo site_url('corporate/section/get_list');?>">分类管理</a></li>
				<!--<li><a href="#">售后管理</a></li>-->
			</ul>
		</div>
	</div>
	<div
		class="cmRight manage_new_cmRight  manage_a_cmRight manage_b_cmRight">
		<div class="cmRight_tittle">分类管理</div>
		<div class="cmRight_con manage_new_cmRight_con manage_a_cmRight_con manage_b_cmRight_con manage_fenlei_cmRight_con">
			<!--<div class="search_2 manage_fenlei_search_2">
				<div>
					<input type="text" class="search2_con manage_fenlei_search2_con">
				</div>
				<div class="search2_btn manage_fenlei_search2_btn">
					<a href="#">店内搜索</a>
				</div>
			</div>
			<div class="line"></div>-->
			<div class="select1" style="height:auto;">
				<!--<ul>
					<li><a href="#">全选</a></li>
					<li style="margin-right: 0"><a href="#">批量删除</a></li>
				</ul>-->
				<ul>
					<li><a href="<?php echo site_url('corporate/section/add');?>">添加新分类</a></li>
					<!--<li style="margin-right: 0"><a href="#">保存更改</a></li>-->
				</ul>

				
			</div>
			<table width="910" height="300" border="1" cellpadding="0"
					cellspacing="0" class="table1 manage_b_table1" style="width: 910px;margin: 0 auto;">
					<tr class="tr1 manage_b_tr1">
						<th width="34px"><input type="checkbox" name="id"></th>
						<th width="72px"></th>
						<th width="173px">商品分类</th>
						<th width="165px">所属分类</th>
						<th width="150px">分类属性</th>
						<th width="125px">排序</th>
						<th width="182px">操作</th>
					</tr>
					<?php foreach ($sections as $section):?>
					<tr>
						<th width="34px"></th>
						<th width="72px"></th>
						<th width="162px"><?php echo $section['section_name'];?></th>
						<th width="165px"></th>
						<th width="150px"></th>
						<th width="125px"><?php echo $section['sequence'];?></th>
						<th width="182px"><a href="<?php echo site_url('corporate/section/add/'.$section['id']);?>"
							style="color: #aeaeae; margin-right: 40px; text-decoration: underline">编辑</a>
							<a href="<?php echo site_url('corporate/section/delete/'.$section['id']);?>" style="color: #fca543; text-decoration: underline">垃圾箱</a></th>
					</tr>
					<?php endforeach;
					if (count($sections) == 0) {
						?>
						<tr>
						<td colspan="7">请添加频道</td>
						</tr>
						<?php 
					}?>
				</table>
		</div>
	</div>
</div>